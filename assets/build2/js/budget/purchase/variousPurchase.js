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
        var parchases = report.purchase_history;
        var chart_plot_purchase_data = [];
        $.each(parchases, function (key, parchase) {
            chart_plot_purchase_data.push([new Date(parchase['created_at']), parchase['price']]);
        });


        var min_xaxis=0;
        if(chart_plot_purchase_data[0]){
            min_xaxis= chart_plot_purchase_data[0][0];
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
            colors: ['#3F97EB', '#72c380', '#6f7a8a', '#f7cb38', '#5a8022', '#2c7282','#96CA59', '#FF7070',],
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
                max: chart_plot_purchase_data[20]
            }
        };


        $.plot($("#chart_plot_05"),
            [{
                label: history_lang,
                data: chart_plot_purchase_data,
                lines: {
                    fillColor: "rgba(150, 202, 89, 0.12)"
                },
                points: {
                    fillColor: "#fff"
                }
            }], chart_plot_05_settings);

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

    $("#chart_plot_05").bind("plothover", function (event, pos, item) {
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

});