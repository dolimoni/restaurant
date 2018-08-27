$(document).ready(function () {
    var table;
    var handleDataTableButtons = function () {
        if ($("#datatable-alertes").length) {
            table=$("#datatable-alertes").DataTable({
                /* aaSorting: [[0, 'desc']],*/
                responsive: true,
                "bPaginate": false,
                "bLengthChange": false,
                "bFilter": true,
                "bInfo": false,
                "columns": [
                    {"data": "name"},
                    {"data": "amount"},
                    {"data": "charge_date"},
                    {"data": "actions"},
                ],
                "bSort": false,
                "language": {
                    "url": datatable_fr_url
            }
        });
            $("#searchbox").on("keyup search input paste cut", function() {
                table.search(this.value).draw();
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

    $('#charge_date,#edit_charge_date').MonthPicker({
        i18n: {
            year: "année",
            prevYear: "l'année dernière",
            nextYear: "l'année prochaine",
            months: ["Jan", "Fév", "Mar", "Avr", "Mai", "Jui", "Jul", "Aou", "Sep", "Oct", "Nov", "Dec"]
        },
        Button: false
    });

    $('#search_charge_date').MonthPicker({
        i18n: {
            year: "année",
            prevYear: "l'année dernière",
            nextYear: "l'année prochaine",
            months: ["Jan", "Fév", "Mar", "Avr", "Mai", "Jui", "Jul", "Aou", "Sep", "Oct", "Nov", "Dec"]
        },
        Button: false,
        OnAfterChooseMonth: function (selectedDate) {
            var myData = {
                "startDate": formattedDate(selectedDate),
            };
            var params = {
                "swal": 'false',
                "callable":true
            };

            var response = apiRequest(search_charge_url,myData,params,handleData);
        }
    });

    function handleData(response) {
        table.clear().draw();
        $.each(response.fixed_charges, function (key,fixed_charge) {
            console.log(key);
            table.row.add({
                "name": fixed_charge.name,
                "amount": fixed_charge.amount,
                "charge_date": fixed_charge.charge_date,
                "actions": "",
            }).draw();
        });

        $('.breakEven').html(response.breakEven+" DH");
    }

    function formattedDate(d) {
        let month = String(d.getMonth() + 1);
        let day = String(d.getDate());
        const year = String(d.getFullYear());

        if (month.length < 2) month = '0' + month;
        if (day.length < 2) day = '0' + day;

        return `${year}-${month}-${day}`;
    }


    $('#addFixedCharge').on('submit', function (e) {
        e.preventDefault();
        var charge_date ='01/'+$("#charge_date").val();
        charge_date=convertDate(charge_date,"/","-",1);
        var data={
            'fixedCharge':{
                "name":$("input[name='name']").val(),
                "amount":$("input[name='amount']").val(),
                "charge_date": charge_date,
                'paid':false
            }
        };
        addFixedCharge(data);

    });

    $('#editFixedCharge').on('submit', function (e) {
        e.preventDefault();
        var charge_date =$("#edit_charge_date").val();
        if(charge_date.length==7){
             charge_date ='01/'+charge_date;
             charge_date=convertDate(charge_date,"/","-",1);
        }
        var data={
            'fixedCharge':{
                "name":$("#editFixedChargeForm input[name='name']").val(),
                "amount":$("#editFixedChargeForm input[name='amount']").val(),
                "charge_date": charge_date,
                'paid':false
            },
            'id':$("#editFixedChargeForm input[name='id']").val()
        };
        apiRequest(editCharge_url,data);
    });

    $('#editFixedChargeForm input[name=createEditFixedCharge]').on('click', function (e) {
        e.preventDefault();
        var charge_date =$("#edit_charge_date").val();
        if(charge_date.length==7){
            charge_date ='01/'+charge_date;
            charge_date=convertDate(charge_date,"/","-",1);
        }
        var data={
            'fixedCharge':{
                "name":$("#editFixedChargeForm input[name='name']").val(),
                "amount":$("#editFixedChargeForm input[name='amount']").val(),
                "charge_date": charge_date,
                'paid':false
            }
        };
        apiRequest(addCharge_url,data);
    });

    $(document).on('click','button.deleteFixedCharge', deleteFixedChargeEvent);

    function deleteFixedChargeEvent() {
        var data={
            'id':$(this).attr('data-id')
        };

        apiRequest(deleteCharge_url,data);
    }

    function addFixedCharge(data){
        $.ajax({
            url: addCharge_url,
            type: "POST",
            dataType: "json",
            data: data,
            beforeSend: function () {
                $('#loading').show();
            },
            complete: function () {
                $('#loading').hide();
            },
            success: function (data) {
                if (data.status === "success") {
                    swal({
                        title: "Success",
                        text: "Successs",
                        type: "success",
                        timer: 1500,
                        showConfirmButton: false
                    });
                    location.reload();
                } else {
                    swal({
                        title: "Erreur",
                        text: "Une erreur s'est produite",
                        type: "warning",
                        timer: 1500,
                        showConfirmButton: false
                    });
                }
            },
            error: function (data) {
                swal({
                    title: "Erreur",
                    text: "Une erreur s'est produite",
                    type: "warning",
                    timer: 1500,
                    showConfirmButton: false
                });
            }
        });
    }




    $(document).on('click','.editChargeFixe', editChargeFixeEvent);
    var l_id = -1;
    function editChargeFixeEvent() {
        if ($(this).attr('data-id') === l_id || l_id === -1) {
            $('#editFixedCharge').toggle('slow');
        }
        l_id = $(this).closest('tr').attr('data-id');
        var row = $(this).closest('tr');
        $('#editFixedChargeForm input[name="name"]').val(row.find("[data-name]").attr('data-name'));
        $('#editFixedChargeForm input[name="amount"]').val(row.find("[data-amount]").attr('data-amount'));
        $('#editFixedChargeForm #edit_charge_date').val(row.find("[data-charge-date]").attr('data-charge-date'));

        $('#editFixedChargeForm input[name="id"]').val(l_id);
    }


    TableManageButtons.init();
});