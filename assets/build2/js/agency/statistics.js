var startDate;
var endDate;
var agency= $("#agencies").val();;
$("#agencies").on("change", changeAgencyEvent);
    function changeAgencyEvent() {
        agency = $("#agencies").val();
        myData = {'startDate': startDate, 'endDate': endDate,"agency_id":agency};
        $.ajax({
            url: statisticLink,
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
        myData = {'startDate': startDate , 'endDate': endDate,"agency_id":agency};
        $.ajax({
            url: statisticLink,
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
    startDate=moment().subtract(29, 'days').format('YYYY-MM-DD');
    endDate= moment().format('YYYY-MM-DD');
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



function update_history_graph(data) {
    var sales = data.report.sales_history;
    var charges = data.report.charges_history;

    var chart_plot_05_data = [];
    var chart_plot_charge_data = [];

    $.each(sales, function (key, sale) {
        chart_plot_05_data.push([new Date(sale['report_date']), sale['s_amount']]);
    });

    $.each(charges, function (key, charge) {
        chart_plot_charge_data.push([new Date(charge['paymentDate']), charge['price']]);
    });

    var allagencies = [];



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
        colors: ['#96CA59', '#FF7070','#3F97EB', '#72c380', '#6f7a8a', '#f7cb38', '#5a8022', '#2c7282'],
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
            label: sales_lang,
            data: chart_plot_05_data,
            lines: {
                fillColor: "rgba(150, 202, 89, 0.12)"
            },
            points: {
                fillColor: "#fff"
            }
        },{
            label: expense_lang,
            data: chart_plot_charge_data,
            lines: {
                fill: false,
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