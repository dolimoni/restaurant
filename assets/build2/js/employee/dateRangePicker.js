function init_daterangepicker() {

    if (typeof ($.fn.daterangepicker) === 'undefined') {
        return;
    }
    console.log('init_daterangepicker');

    var cb = function (start, end, label) {
        console.log(start.toISOString(), end.toISOString(), label);
        $('#reportrange span').html(start.format('YYYY/MM/DD') + ' - ' + end.format('MMMM D, YYYY'));
        console.log(start.format('YYYY/MM/DD'));

        myData = {'startDate': start.format('YYYY/MM/DD'), 'endDate': end.format('YYYY/MM/DD')};
        $.ajax({
            url: rangeLink,
            type: "POST",
            dataType: "json",
            data: myData,
            success: function (data) {
                if (data.status === "success") {
                    $("tbody").empty();
                      $.each(data.report, function (key,department) {
                            var tr="<tr>" +
                                "<td>"+ department.name+"</td>" +
                                "<td>"+ department.count_employee+"</td>" +
                                "<td>"+ department.sum_salary+"</td>" +
                                "<td>"+ department.s_amount+"</td>" +
                                "<td>"+ department.salary_avg+"</td>" +
                                "<td>"+ department.sale_avg+"</td>" +
                                "</tr>";
                          $("tbody").append(tr);
                        });
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

});