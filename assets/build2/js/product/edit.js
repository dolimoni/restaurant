
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

    $(".addInventory").on('click', function () {
        var m_unit_convert = $(this).attr('data-m_unit_convert');
        $('#addInventoryModal input[name=inventory_m_unit]').val(m_unit_convert);
    });

    $('input[name=inventory_quantity]').on('keyup',function () {
        var row=$(this).closest('.row');
        var mark_quantity=parseFloat($(this).val()).toFixed(2);

        if(isNaN(mark_quantity)){
            mark_quantity=0;
        }

        var inventory_m_unit=parseFloat($(this).attr('data-m_unit_convert')).toFixed(2);
        var finalMarkQuantityConvert=parseFloat(mark_quantity*inventory_m_unit).toFixed(2);
        var product_unit=$('select[name="unit"]').val();


        console.log(inventory_m_unit);
        $('span.finalQuantityConvert').html(calulateMarksQuantity()+' '+product_unit);
        row.find('.markQuantityLabled').html(mark_quantity);
        row.find('.markQuantityConvert').html(finalMarkQuantityConvert);
    });

    function calulateMarksQuantity(){
        var inputs=$('#addInventoryForm input');

        var finalQuantity=parseFloat(0);
        $.each(inputs, function (key,input) {
            var m_unit_convert=parseFloat($(this).attr('data-m_unit_convert')).toFixed(2);
            var quantity=parseFloat($(this).val()).toFixed(2);

            if(isNaN(m_unit_convert)){
                m_unit_convert=0;
            }
            if(isNaN(quantity)){
                quantity=0;
            }
            finalQuantity +=  + parseFloat(m_unit_convert*quantity).toFixed(2);
        });
        finalQuantity=parseFloat(finalQuantity).toFixed(2);
        return finalQuantity;
    }

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

    function formatDate(date) {
        var d = new Date(date),
            month = '' + (d.getMonth() + 1),
            day = '' + d.getDate(),
            year = d.getFullYear();

        if (month.length < 2) month = '0' + month;
        if (day.length < 2) day = '0' + day;

        return [year, month, day].join('-');
    }


    $('#addInventoryForm').submit(function (e) {
        e.preventDefault();  //prevent form from submitting
        var productsList = [];
        var id = $('input[name="id"]').val();
        var totalQuantity = $('input[name="totalQuantity"]').val();
        var initial_stock = parseFloat(totalQuantity);
        var inventory_m_unit_price=parseFloat($('#addInventoryModal input[name=inventory_m_unit_price]').val()).toFixed(2);
        var final_stock_convert=calulateMarksQuantity();
        var delta= final_stock_convert-initial_stock;
        var d = new Date();
        var product = {
            'product': id,
            'initial_stock': initial_stock,
            "final_stock": final_stock_convert,
            "delta":delta,
            "inventory_date": formatDate(d)
        };
        productsList.push(product);
        let data={"productsList": productsList};
        apiRequest(addInventory_url,data);
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
