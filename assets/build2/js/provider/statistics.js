var startDate;
var endDate;
var barOrders=null;
var barPayments=null;
var table;
var table_topay;
var agency= $("#agencies").val();
    function updateData(startDate,endDate) {
        myData = {'startDate': startDate, 'endDate': endDate};
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
                    // Bar chart
                    var report= data.report;

                    var ordersData=[];
                    var ordersLabels = [];
                      $.each(report.orders, function (key,order) {
                          ordersLabels.push(order.name);
                          ordersData.push(parseFloat(order.amount).toFixed(2));
                      });
                    var title= {
                        display: true,
                        text: top_providers_orders_lang
                    };
                    var datasets=[{
                            data: ordersData
                    }];
                    console.log(ordersData);
                    if(barOrders){
                        barOrders.destroy();
                    }
                    barOrders=barCart("bar-orders", ordersLabels, datasets,title);


                    var paymentData=[];
                    var paymentLabels = [];
                    paymentLabels.push(paid_lang);
                    paymentLabels.push(impaid_lang);
                    paymentLabels.push("A payer");
                    var impaid_amount=0;
                    var paid_amount=0;
                    var advance=0;

                    paid_amount=parseFloat(report.payment[0].amount).toFixed(2);
                    advance=parseFloat(report.payment[0].amount_advance).toFixed(2);
                    impaid_amount=parseFloat(report.payment[1].amount_impaid).toFixed(2);

                    paymentData.push(parseFloat(advance)+parseFloat(0));
                    paymentData.push(impaid_amount);
                    paymentData.push(report.ordersToPayAmount);
                    var paymentTitle= {
                        display: true,
                        text: paid_lang+'-'+impaid_lang
                    };
                    var datasets=[{
                            data: paymentData
                    }];
                    var backgroundColor = ["#3cba9f", "#c45850","#3e95ce"];
                    if (barPayments) {
                        barPayments.destroy();
                    }
                    barPayments=barCart("bar-ordersPayment", paymentLabels, datasets, paymentTitle, backgroundColor);

                    //update datatable
                    table.clear();
                    table.draw();
                    $.each(report.impaidOrders, function (key, impaidOrder) {
                        table.row.add({
                            "provider": "<a href='"+base_url+"admin/provider/show/"+impaidOrder.p_id+"'>"+ impaidOrder.name+"</a>",
                            "amount": impaidOrder.amount,
                        }).draw();
                    });

                    table_topay.clear();
                    table_topay.draw();
                    $.each(report.ordersToPay, function (key, orderToPay) {
                        console.log(orderToPay.amount);
                        table_topay.row.add({
                            "provider": "<a href='"+base_url+"admin/provider/show/"+orderToPay.p_id+"'>"+ orderToPay.name+"</a>",
                            "amount": orderToPay.amount,
                        }).draw();
                    });

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
        updateData(startDate,endDate);
    };


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
        format: 'DD/MM/YYYY',
        separator: ' to ',
        locale: {
            applyLabel: 'Envoyer',
            cancelLabel: 'Annuler',
            fromLabel: 'From',
            toLabel: 'To',
            customRangeLabel: 'Personnalier',
            daysOfWeek: ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa'],
            monthNames: ['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre'],
            firstDay: 1
        }

    };

    $('#reportrange span').html(moment().subtract(365, 'days').format('MMMM D, YYYY') + ' - ' + moment().format('MMMM D, YYYY'));
    startDate=moment().subtract(365, 'days').format('YYYY-MM-DD');
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

function init_datatable(){
    var handleDataTableButtons = function () {
        if ($("#datatable-impaid").length) {
            table = $("#datatable-impaid").DataTable({
                aaSorting: [[0, 'desc']],
                "bInfo": false,
                "columns": [
                    {"data": "provider"},
                    {"data": "amount"},
                ],
                "responsive": true,
                "language": {
                    "url": datatableFrench
            }
        });
        }

        if ($("#datatable-topay").length) {
            table_topay = $("#datatable-topay").DataTable({
                aaSorting: [[0, 'desc']],
                "bInfo": false,
                "columns": [
                    {"data": "provider"},
                    {"data": "amount"},
                ],
                "responsive": true,
                "language": {
                    "url": datatableFrench
            }
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
}
$(function () {
    init_daterangepicker();
    updateData();
    init_datatable();
    TableManageButtons.init();
});


