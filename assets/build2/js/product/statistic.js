

$(document).ready(function () {

    var tableConsumptionMeal;
    var tableProductOrdres;
    var tableProductLosts;

    var handleDataTableButtons = function () {

        if ($("#datatable-consumption").length) {
            tableConsumptionMeal=$("#datatable-consumption").DataTable({
                responsive: true,
                "lengthMenu": [[25, 50, 200, -1], [25, 50, 200, "Tout"]],
                "bInfo": false,
                "language": {
                    "url": datatable_fr_ulr
                },
                "columns": [
                    {"data": "name"},
                    {"data": "quantity"},
                    {"data": "price"},
                ],
            });
        }

        if ($("#datatable-orders").length) {
            tableProductOrdres=$("#datatable-orders").DataTable({
                responsive: true,
                "lengthMenu": [[25, 50, 200, -1], [25, 50, 200, "Tout"]],
                "bInfo": false,
                "language": {
                    "url": datatable_fr_ulr
                },
                "columns": [
                    {"data": "quantity"},
                    {"data": "unit_price"},
                    {"data": "price"},
                    {"data": "provider"},
                    {"data": "orderDate"},
                ],
            });
        }

        if ($("#datatable-losts").length) {
            tableProductLosts=$("#datatable-losts").DataTable({
                responsive: true,
                "lengthMenu": [[25, 50, 200, -1], [25, 50, 200, "Tout"]],
                "bInfo": false,
                "language": {
                    "url": datatable_fr_ulr
                },
                "columns": [
                    {"data": "quantity"},
                    {"data": "type"}
                ],
            });
        }
    };

    TableManageButtons = function () {
        "use strict";
        return {

            init: function () {
                handleDataTableButtons();
            }
        };
    }();

    TableManageButtons.init();

    init_daterangepicker();


    function init_daterangepicker() {

        if (typeof ($.fn.daterangepicker) === 'undefined') {
            return;
        }
        console.log('init_daterangepicker');

        timeformat = "%d-%m-%y";
        if ($(document).width() <= 450) {
            timeformat = "%m-%y";
        }
        console.log(report);
        update_history_graph(report);

        var cb = function (start, end, label) {
            console.log(start.toISOString(), end.toISOString(), label);
            $('#reportrange span').html(start.format('YYYY/MM/DD') + ' - ' + end.format('MMMM D, YYYY'));
            console.log(start.format('YYYY/MM/DD'));

            myData = {'startDate': start.format('YYYY/MM/DD'), 'endDate': end.format('YYYY/MM/DD'),"id":product_id};
            $.ajax({
                url: base_url+"admin/product/apiStatistics",
                type: "POST",
                dataType: "json",
                data: myData,
                beforeSend: function () {
                    $('#loading').show();
                },
                complete: function () {
                    $('#loading').hide();
                },
                success: function (data) {
                    if (data.status === "success") {
                        if (data.status === "success") {
                            update_history_graph(data["report"]);
                            /*****************************CHANGE CONSOMMATION GRAPH****************************************************/
                            //empty quantity graph
                            $('.product-quantity .progress-bar').css({
                                'display': 'none',
                            });
                            $('.product-quantity .w_right span:nth-child(1)').html(0);
                            //price graph
                            var myDataPoints = [];
                            var mealConsumptionRateRange = data.report.productConsumptionRate;
                            inventory(data.report.productInventory);
                            var totalQuantity = 0;
                            console.log(mealConsumptionRateRange);
                            $.each(mealConsumptionRateRange, function (key, mealConsumptionRateProduct) {
                                totalQuantity += parseFloat(mealConsumptionRateProduct['sum_quantity']);
                                console.log(totalQuantity);
                                if (mealConsumptionRateProduct['avg_unit_price']) {
                                    var total = parseFloat(mealConsumptionRateProduct['avg_unit_price'] * mealConsumptionRateProduct['sum_quantity']);
                                    var point = {
                                        y: total,
                                        label: mealConsumptionRateProduct['name'],
                                        unit: 'DH',
                                        yRound: total.toFixed(2)
                                    };
                                    myDataPoints.push(point);
                                    if (!$('#quantity_' + mealConsumptionRateProduct['meal']).length) {
                                        var productModel = $(".product-quantity-model").clone().removeAttr("hidden");
                                        productModel.addClass("widget_summary");
                                        productModel.attr('id', 'quantity_' + mealConsumptionRateProduct['product']);
                                        productModel.removeClass("product-quantity-model");
                                        productModel.find(' .progress-bar').attr('style', 'width: ' + Math.round(mealConsumptionRateProduct['sum_quantity'] / mealConsumptionRateRange['totalQuantity'] * 100) + '%')
                                        productModel.find(' .w_right span:nth-child(1)').html(parseFloat(mealConsumptionRateProduct['sum_quantity']).toFixed(2));
                                        productModel.find(' .w_right span:nth-child(2)').html(" " + mealConsumptionRateProduct['unit']);
                                        productModel.find(".w_left.w_25").html(mealConsumptionRateProduct["name"]);
                                        $(".productsConsomationList").append(productModel);
                                        console.log(productModel);
                                    }
                                    //change quantity graph
                                    $('#quantity_' + mealConsumptionRateProduct['meal'] + ' .progress-bar').attr('style', 'width: ' + Math.round(mealConsumptionRateProduct['sum_quantity'] / data["report"]['totalConsumptionQuantity'] * 100) + '%')
                                    $('#quantity_' + mealConsumptionRateProduct['meal'] + ' .w_right span:nth-child(1)').html(parseFloat(mealConsumptionRateProduct['sum_quantity']).toFixed(2));
                                    console.log('width: ' + Math.round(mealConsumptionRateProduct['sum_quantity'] / mealConsumptionRateRange['totalQuantity'] * 100) + '%');
                                }
                            });
                            $(".product-quantity-total").find(' .w_right span:nth-child(1)').html(parseFloat(totalQuantity).toFixed(2));


                            var chart = new CanvasJS.Chart("chartContainer", {
                                animationEnabled: true,
                                data: [{
                                    type: "doughnut",
                                    startAngle: 60,
                                    //innerRadius: 60,
                                    indexLabelFontSize: 17,
                                    indexLabel: "{label} - #percent%",
                                    toolTipContent: "<b>{label}:</b> {yRound} (#percent%)",
                                    dataPoints: myDataPoints
                                }]
                            });
                            chart.render();
                            /*********************************************************************************/

                            tableConsumptionMeal.clear().draw();
                            $.each(data.report.productConsumptionRate, function (key,product ) {
                                if(key>=0){
                                    var row = tableConsumptionMeal.row.add({
                                        "name": product.name,
                                        "quantity": product['sum_quantity'],
                                        "price": parseFloat(product['avg_unit_price'] * product['sum_quantity']).toFixed(2)+'Dh',
                                    }).draw().node();
                                }
                            });

                            tableProductOrdres.clear().draw();
                            $.each(data.report.product_orders, function (key,product_order ) {
                                let totalOrderQuantity=product_order.quantity;
                                if(product_order.pack==='true'){
                                    totalOrderQuantity= parseFloat(product_order['quantity']).toFixed(2)+' pack de '+product_order['piecesByPack']+' pieces';
                                }
                                var row = tableProductOrdres.row.add({
                                    "quantity": totalOrderQuantity,
                                    "unit_price": parseFloat(product_order.od_price),
                                    "price": parseFloat(product_order.quantity*product_order.od_price).toFixed(2),
                                    "provider": product_order.name,
                                    "orderDate": product_order.orderDate,
                                }).draw().node();
                            });
                        }
                        else {
                            console.log('Error');
                        }
                    }
                    else {
                        console.log('Error');
                    }
                },
                error: function (data) {
                }
            });
        };


        function update_history_graph(report){
            var stocks = report.stock_history;
            var consumptions = report.consumption_history;
            var chart_plot_stock_data = [];
            var chart_plot_consumption_data = [];

            $.each(consumptions, function (key, consumption) {
                chart_plot_consumption_data.push([new Date(consumption['report_date']), parseFloat(consumption['s_quantity'])]);
            });


            console.log(stocks);
            $.each(stocks, function (key, stock) {
                chart_plot_stock_data.push([new Date(stock['orderDate']), parseFloat(stock['quantity'])]);
            });



            var min_xaxis=0;
            if(chart_plot_consumption_data[0]){
                min_xaxis= chart_plot_consumption_data[0][0];
            }

            var min_xaxis_stock=0;
            if(chart_plot_stock_data[0]){
                min_xaxis_stock= chart_plot_stock_data[0][0];
            }
            var chart_plot_05_settings = {
                grid: {
                    show: true,
                    aboveData: true,
                    color: "#3f3f3f",
                    labelMargin: 10,
                    axisMargin: 0,
                    borderWidth: 0,
                    borderColor: null,
                    minBorderMargin: 5,
                    clickable: true,
                    hoverable: true,
                    autoHighlight: true,
                    mouseActiveRadius: 100,
                },
                series: {
                    lines: {
                        show: true,
                        fill: false,
                        lineWidth: 2,
                        steps: false
                    },
                    points: {
                        show: true,
                        radius: 4.5,
                        symbol: "circle",
                        lineWidth: 3.0
                    }
                },
                legend: {
                    position: "ne",
                    margin: [0, -25],
                    noColumns: 0,
                    labelBoxBorderColor: null,
                    labelFormatter: function (label, series) {
                        return label + '&nbsp;&nbsp;';
                    },
                    width: 40,
                    height: 1
                },
                colors: ['#3F97EB', '#6f7a8a', '#f7cb38', '#5a8022', '#2c7282','#96CA59', '#FF7070','#72c380'],
                shadowSize: 0,
                tooltip: true,
                tooltipOpts: {
                    content: "%s: %y.0",
                    xDateFormat: "%d/%m",
                    shifts: {
                        x: -30,
                        y: -50
                    },
                    defaultTheme: false
                },
                yaxis: {
                    min: 0
                },
                xaxis: {
                    mode: "time",
                    minTickSize: [2, "day"],
                    timeformat: timeformat,
                    min: min_xaxis,
                    max: chart_plot_consumption_data[20]
                }
            };

            var chart_plot_07_settings = {
                grid: {
                    show: true,
                    aboveData: true,
                    color: "#3f3f3f",
                    labelMargin: 10,
                    axisMargin: 0,
                    borderWidth: 0,
                    borderColor: null,
                    minBorderMargin: 5,
                    clickable: true,
                    hoverable: true,
                    autoHighlight: true,
                    mouseActiveRadius: 100,
                },
                series: {
                    lines: {
                        show: true,
                        fill: false,
                        lineWidth: 2,
                        steps: false
                    },
                    points: {
                        show: true,
                        radius: 4.5,
                        symbol: "circle",
                        lineWidth: 3.0
                    }
                },
                legend: {
                    position: "ne",
                    margin: [0, -25],
                    noColumns: 0,
                    labelBoxBorderColor: null,
                    labelFormatter: function (label, series) {
                        return label + '&nbsp;&nbsp;';
                    },
                    width: 40,
                    height: 1
                },
                colors: ['#72c380','#3F97EB', '#6f7a8a', '#f7cb38', '#5a8022', '#2c7282','#96CA59', '#FF7070'],
                shadowSize: 0,
                tooltip: true,
                tooltipOpts: {
                    content: "%s: %y.0",
                    xDateFormat: "%d/%m",
                    shifts: {
                        x: -30,
                        y: -50
                    },
                    defaultTheme: false
                },
                yaxis: {
                    min: 0
                },
                xaxis: {
                    mode: "time",
                    minTickSize: [2, "day"],
                    timeformat: timeformat,
                    min: min_xaxis_stock,
                    max: chart_plot_stock_data[20]
                }
            };

            if(chart_plot_consumption_data.length>0){
                $(".chart_plot_05_panel").show();
                $.plot($("#chart_plot_05"),
                    [{
                        label: "Consommation",
                        data: chart_plot_consumption_data,
                        lines: {
                            fillColor: "rgba(150, 202, 89, 0.12)"
                        },
                        points: {
                            fillColor: "#fff"
                        }
                    }], chart_plot_05_settings);
            }else{
                //console.log('hide');
                $(".chart_plot_05_panel").fadeOut();
            }

            if(chart_plot_stock_data.length>0){
                $(".chart_plot_07_panel").show();
                $.plot($("#chart_plot_07"),
                    [{
                        label: "Stock",
                        data: chart_plot_stock_data,
                        lines: {
                            fillColor: "rgba(150, 202, 89, 0.12)"
                        },
                        points: {
                            fillColor: "#fff"
                        }
                    }], chart_plot_07_settings);
            }else{
                $(".chart_plot_07_panel").fadeOut();
            }


        }

        /************************Tooltip begin**************************/
        function showChartTooltip(x, y, contents) {
            $('<div id="charttooltip" class="chart-tooltip">' + contents + '<\/div>').css({
                    position: 'absolute',
                    display: 'none',
                    top: y - 25,
                    left: x - 25,
                    border: '1px solid #bfbfbf',
                    padding: '2px',
                    'background-color': '#ffffff',
                    opacity: 1
                }
            ).appendTo("body").fadeIn(200);
        }

        $("#chart_plot_05,#chart_plot_07").bind("plothover", function (event, pos, item) {
            $("#x").text(pos.x.toFixed(2));
            $("#y").text(pos.y.toFixed(2));
            if (item) {
                $("#charttooltip").remove();
                var x = item.datapoint[0].toFixed(2),
                    y = item.datapoint[1].toFixed(2);
                showChartTooltip(item.pageX, item.pageY, y);
            } else {
                $("#charttooltip").remove();
            }
        });
        /*************************Tooltip end******************************/


        var optionSet1 = {
            startDate: moment().subtract(365, 'days'),
            endDate: moment(),
            minDate: '01/01/2017',
            maxDate: '12/31/2027',
            dateLimit: {
                days: 365
            },
            showDropdowns: true,
            showWeekNumbers: true,
            timePicker: false,
            timePickerIncrement: 1,
            timePicker12Hour: true,
            ranges: {
                'Aujourd\'hui': [moment(), moment()],
                'Hier': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                'Dernier 7 jours': [moment().subtract(6, 'days'), moment()],
                'Dernier 30 jours': [moment().subtract(29, 'days'), moment()],
                'Ce mois': [moment().startOf('month'), moment().endOf('month')],
                'Mois précédent': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
            },
            opens: 'left',
            buttonClasses: ['btn btn-default'],
            applyClass: 'btn-small btn-primary',
            cancelClass: 'btn-small',
            format: 'MM/DD/YYYY',
            separator: ' to ',
            locale: {
                applyLabel: 'Envoyer',
                cancelLabel: 'Annuler',
                fromLabel: 'From',
                toLabel: 'To',
                customRangeLabel: 'Personnalisé',
                daysOfWeek: ['Lu', 'Ma', 'Me', 'Je', 'Ve', 'Sa', 'Di'],
                monthNames: ['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre'],
                firstDay: 1
            }
        };

        $('#reportrange span').html(moment().subtract(365, 'days').format('MMMM D, YYYY') + ' - ' + moment().format('MMMM D, YYYY'));
        $('#reportrange').daterangepicker(optionSet1, cb);

        $('#reportrange').on('show.daterangepicker', function () {
            console.log("show event firedd");
        });
        $('#reportrange').on('hide.daterangepicker', function () {
            console.log("hide event fired");
        });
        $('#reportrange').on('apply.daterangepicker', function (ev, picker) {
            console.log("apply event fired, start/end dates are " + picker.startDate.format('MMMM D, YYYY') + " to " + picker.endDate.format('MMMM D, YYYY'));
        });
        $('#reportrange').on('cancel.daterangepicker', function (ev, picker) {
            console.log("cancel event fired");
        });
        $('#options1').click(function () {
            $('#reportrange').data('daterangepicker').setOptions(optionSet1, cb);
        });
        $('#options2').click(function () {
            $('#reportrange').data('daterangepicker').setOptions(optionSet2, cb);
        });
        $('#destroy').click(function () {
            $('#reportrange').data('daterangepicker').remove();
        });

    }


});


