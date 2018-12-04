function init_daterangepicker() {

    if (typeof ($.fn.daterangepicker) === 'undefined') {
        return;
    }
    console.log('init_daterangepicker');

    var cb = function (start, end, label) {
        console.log(start.toISOString(), end.toISOString(), label);
        $('#reportrange span').html(start.format('YYYY/MM/DD') + ' - ' + end.format('MMMM D, YYYY'));
        console.log(start.format('YYYY/MM/DD'));

        myData = {'startDate': start.format('YYYY-MM-DD'), 'endDate': end.format('YYYY-MM-DD')};
        $.ajax({
            url: rangeLink,
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
                if (data.status === true) {
                    table_meals.rows()
                        .remove()
                        .draw();
                    console.log("cleaaar");
                    var total_turnover=parseFloat(0);
                    var total_cost=parseFloat(0);
                    var total_earning=parseFloat(0);
                    $.each(data.articles, function (key, article) {
                        var profit= article['s_amount'] - article['s_cost'];
                        if(parseFloat(article['s_amount']).toFixed(2)==="0.00") {
                            profit = 0;
                        }
                        total_turnover= parseFloat(total_turnover)+ parseFloat(article['s_amount']).toFixed(2);
                        total_cost= parseFloat(total_cost)+ parseFloat(article['s_cost']).toFixed(2);
                        total_earning= parseFloat(total_earning) + parseFloat(profit).toFixed(2);
                        table_meals.row.add({
                            "name": article['name'],
                            "quantity": article['s_quantity'],
                            "amount": parseFloat(article['s_amount']).toFixed(2),
                            "earnings": parseFloat(profit).toFixed(2),
                            "cost": parseFloat(article['s_cost']).toFixed(2),
                            "actions": '<button class="btn btn-success btn-xs action" onclick="window.location.href=\'' + mealReportLink + '/' + article['meal'] + '\'" data-type="delete" data-toggle="modal" data-target="#delete"> <span class= "fa fa-eye"></span></button>'
                        }).draw();
                    });

                    /*table_meals.row.add({
                        "name": "Total",
                        "quantity": "",
                        "amount": total_turnover,
                        "earnings": total_earning,
                        "cost": total_cost,
                        "actions":""
                    }).draw();*/
                }
                else {
                    console.log('Error');
                }
            },
            error: function (data) {
                table_meals.clear();
            }
        });
    };

    var optionSet1 = {
        startDate: moment().subtract(365, 'days'),
        endDate: moment(),
        minDate: '01/01/2017',
        maxDate: '12/31/2027',
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


$(document).ready(function () {

    init_daterangepicker();

});