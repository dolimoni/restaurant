
function init() {
    $('#addMarkForm').submit(function (e) {
        e.preventDefault();
       var name = $(this).find('input[name=m_name]').val();
       var m_weightByUnit = $(this).find('input[name=m_weightByUnit]').val();
       var m_unit_price = $(this).find('input[name=m_unit_price]').val();
       var m_unit = $(this).find('select[name=m_unit]').val();
       var id = $('input[name=id]').val();
       var mark={
           'name':name,
           'm_weightByUnit':m_weightByUnit,
           'm_unit_price':m_unit_price,
           'm_unit':m_unit,
           'product':id
       };
       var data={
          'mark': mark
       };
       apiRequest(addMark_url,data);
    });

    $(".deleteQuantity").on('click', deleteQuantityEvent);

    function deleteQuantityEvent(){
        var myData={
            'quantity':$(this).attr('data-id')
        }
        swal({
                title: "Attention ! ",
                text: swal_warning_delete_lang,
                type: "warning",
                showConfirmButton: true,
                showCancelButton: true,
                cancelButtonText: 'Non',
                confirmButtonText: 'Oui'
            },
            function () {
                apiRequest(deleteQuantity_url,myData);
            });
    }

    $(".deleteMark").on('click', deleteMarkEvent);

    function deleteMarkEvent(){
        var myData={
            'mark':{
                'id':$(this).attr('data-id')
            }
        };
        swal({
                title: "Attention ! ",
                text: swal_warning_delete_lang,
                type: "warning",
                showConfirmButton: true,
                showCancelButton: true,
                cancelButtonText: 'Non',
                confirmButtonText: 'Oui'
            },
            function () {
                apiRequest(deleteMark_url,myData);
            });
    }
    $(".editMak").on('click', function () {
        var id = $(this).attr('data-id');
        var name = $(this).attr('data-name');
        var m_unit = $(this).attr('data-m_unit');
        var m_unit_price = $(this).attr('data-m_unit_price');
        var m_weightByUnit = $(this).attr('data-m_weightByUnit');

        $('#editMarkModal input[name=name]').val(name);
        $('#editMarkModal select[name=m_unit]').val(m_unit);
        $('#editMarkModal input[name=m_unit_price]').val(m_unit_price);
        $('#editMarkModal input[name=m_weightByUnit]').val(m_weightByUnit);
        $('#editMarkModal input[name=id]').val(id);
    });

    $('#editMarkForm').submit(function (e) {
        e.preventDefault();
        var name = $(this).find('input[name=name]').val();
        var m_weightByUnit = $(this).find('input[name=m_weightByUnit]').val();
        var m_unit_price = $(this).find('input[name=m_unit_price]').val();
        var m_unit = $(this).find('select[name=m_unit]').val();
        var mark_id = $(this).find('input[name=id]').val();
        var id = $('input[name=id]').val();
        var mark={
            'name':name,
            'm_weightByUnit':m_weightByUnit,
            'm_unit_price':m_unit_price,
            'm_unit':m_unit,
            'product':id,
            'mark_id':mark_id
        };
        var data={
            'mark': mark
        };
        apiRequest(editMark_url,data);
    });


    $('#pack').on('change', function() {
        if(this.checked) {
            $('div.piecesByPack').fadeIn();
        }else{
            $('div.piecesByPack').fadeOut();
        }
    });

    $('select[name=unit]').on('change', function() {

        let unit=this.value;
        if(unit!=='pcs'){
            $('#pack').attr('disabled','true');
            $('div.piecesByPack').fadeOut();
            $('#pack').prop('checked', false); // Unchecks it
        }else{
            $('#pack').removeAttr('disabled');
        }

        if(unit==='kg'){
            $('label.lost_type').attr('data-tg-on','gr');
            $('input[name="lost_type"]').removeAttr('disabled');
        }else if(unit==='L'){
            $('label.lost_type').attr('data-tg-on','cl');
            $('input[name="lost_type"]').removeAttr('disabled');
        }else if(unit==='pcs'){
            $('label.lost_type').attr('data-tg-on','%');
            $('input[name="lost_type"]').attr('checked','checked')
            $('input[name="lost_type"]').attr('disabled','disabled');
        }

        console.log(unit);
    });

}


$(document).ready(function () {

    init();

});
