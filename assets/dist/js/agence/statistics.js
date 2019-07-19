var startDate;
var endDate;
var agency = {
    "name": $("#agencies").val()
};
$("#agencies").on("change", changeAgencyEvent);
    function changeAgencyEvent() {
        var agency = {
            "name": $(this).val()
        };
        if (agency["name"] == "1") {
            rangeAgencyLink = mainAgencyLink + '/admin/api/agency/apiStatistic';
        } else if (agency["name"] == "2") {
            rangeAgencyLink = agency1Link + '/admin/api/report/apiStatistic';
        }else if (agency["name"] == "all") {
            rangeAgencyLink = mainAgencyLink + '/admin/api/agency/apiAllAgenciesStatistics';
        }
        myData = {'startDate': startDate, 'endDate': endDate};
        $.ajax({
            url: rangeAgencyLink,
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
                $('#loading').hide();
                if (data.status === "success") {
                    update_global_data(data);
                    update_history_graph(data);
                    update_topConsomation_graph(data);
                }
                else {
                    console.log('Error');
                }
            },
            error: function (data) {
                $('#loading').hide();
            }
    });
}

function init_daterangepicker() {

    if (typeof ($.fn.daterangepicker) === 'undefined') {
        return;
    }
    console.log('init_daterangepicker');

    var cb = function (start, end, label) {
        $('#reportrange span').html(start.format('YYYY/MM/DD') + ' - ' + end.format('MMMM D, YYYY'));

        startDate= start.format('YYYY/MM/DD');
        endDate= end.format('YYYY/MM/DD');
        if (agency["name"] == "1") {
            rangeAgencyLink = mainAgencyLink + '/admin/report/apiStatistic';
        } else if (agency["name"] == "2") {
            rangeAgencyLink = agency1Link + '/admin/api/report/apiStatistic';
        }
        myData = {'startDate': startDate , 'endDate': endDate};
        $.ajax({
            url: rangeAgencyLink,
            type: "POST",
            dataType: "json",
            data: myData,
            success: function (data) {
                if (data.status === "success") {
                    //update global data
                    update_global_data(data);
                    update_history_graph(data);
                    update_topConsomation_graph(data);
                }
                else {
                    console.log('Error');
                }
            },
            error: function (data) {
            }
        });
    };


    var optionSet1 = {
        startDate: moment().subtract(29, 'days'),
        endDate: moment(),
        minDate: '01/01/2017',
        maxDate: '12/31/2027',
        dateLimit: {
            days: 60
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
            applyLabel: 'Submit',
            cancelLabel: 'Clear',
            fromLabel: 'From',
            toLabel: 'To',
            customRangeLabel: 'Custom',
            daysOfWeek: ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa'],
            monthNames: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
            firstDay: 1
        }

    };

    $('#reportrange span').html(moment().subtract(29, 'days').format('MMMM D, YYYY') + ' - ' + moment().format('MMMM D, YYYY'));
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


$(document).ready(function () {

    init_daterangepicker();

});{
    var products_cost = data.report.products_cost;
    var productModel = $('li.productModel').clone().removeAttr('hidden');
    productModel.removeClass("productModel");
    $("ul.list-unstyled.top_profiles.scroll-view").empty();
    $.each(products_cost, function (key, product) {
        var productModel = $('li.productModel').clone().removeAttr('hidden');
        productModel.removeClass("productModel");
        productModel.find("a").html(product["name"]);
        productModel.find("p strong").html(product["s_cost"]);
        productModel.find("p small").html("Nombre d'utilisations : " + product["s_meal"] + " fois");
        console.log(productModel);
        $('ul.list-unstyled.top_profiles.scroll-view').append(productModel);
    });
}

function update_global_data(data) {
    var consumption = data.report.consumption;
    var purchase = data.report.purchase;
    var repair = data.report.repair;
    var stock_history = data.report.stock_history;

    var g_cost = parseFloat(stock_history["price"] + repair["price"] + purchase["price"]).toFixed(2);
    var g_turnover = parseFloat(consumption["turnover"]).toFixed(2);
    var g_quantity = parseFloat(consumption["s_quantity"]).toFixed(0);
    $(".report_amount").html(g_turnover + " DH");
    $(".report_cost").html(g_cost + " DH");
    $(".report_profit").html((g_turnover - g_cost) + " DH");
    $(".report_products").html(g_quantity);
}

function update_history_graph(data) {
    var sales = data.report.sales_history;
    var chart_plot_05_data = [];
    $.each(sales, function (key, sale) {
        chart_plot_05_data.push([new Date(sale['report_date']), sale['s_amount']]);
    });

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
                fill: true,
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
        colors: ['#96CA59', '#3F97EB', '#72c380', '#6f7a8a', '#f7cb38', '#5a8022', '#2c7282'],
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
            min: chart_plot_05_data[0][0],
            max: chart_plot_05_data[20]
        }
    };


    $.plot($("#chart_plot_05"),
        [{
            label: "Historique",
            data: chart_plot_05_data,
            lines: {
                fillColor: "rgba(150, 202, 89, 0.12)"
            },
            points: {
                fillColor: "#fff"
            }
        }], chart_plot_05_settings);

}

function update_topConsomation_graph(data) {
    var products_cost = data.report.products_cost;
    var productModel = $('li.productModel').clone().removeAttr('hidden');
    productModel.removeClass("productModel");
    $("ul.list-unstyled.top_profiles.scroll-view").empty();
    $.each(products_cost, function (key, product) {
        var productModel = $('li.productModel').clone().removeAttr('hidden');
        productModel.removeClass("productModel");
        productModel.find("a").html(product["name"]);
        productModel.find("p strong").html(product["s_cost"]);
        productModel.find("p small").html("Nombre d'utilisations : " + product["s_meal"] + " fois");
        console.log(productModel);
        $('ul.list-unstyled.top_profiles.scroll-view').append(productModel);
    });
}