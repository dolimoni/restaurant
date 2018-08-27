$(document).ready(function () {

    var quantityOverFlow=false;
    var brokenQuantityOverFlow=false;
    var notSoldQuantityOverFlow=false;


    $(document).on('change', '.productSelect,.productSelectNew', calulPrixTotal);

    function calulPrixTotal() {
        var panel = $(this).closest('.product');
        updateOptions(false);
    };

    function getMealStock(row){
        var quantityInMagazinInput = row.find('input[name="quantityInMagazin"]');
        var quantityInMagazin = 0;
        if(quantityInMagazinInput.val()){
            quantityInMagazin = parseFloat(quantityInMagazinInput.val().replace(',', '.'));
        }

        var quantityToSale = parseFloat(row.find('input[name="quantityToSale"]').val().replace(',', '.'));
        var quantityInMagazinNow = parseFloat(row.find('input[name="quantityInMagazinNow"]').val());
        var quantityToSaleNow = parseFloat(row.find('input[name="quantityToSaleNow"]').val());
        var brokenQuantityNow = parseFloat(row.find('input[name="brokenQuantityNow"]').val());
        var notSoldQuantityNow = parseFloat(row.find('input[name="notSoldQuantityNow"]').val());

        var brokenQuantity = parseFloat(row.find('input[name="brokenQuantity"]').val());
        var notSoldQuantity = parseFloat(row.find('input[name="notSoldQuantity"]').val());

        if (isNaN(brokenQuantity)) {
            brokenQuantity=0;
        }
        if (isNaN(notSoldQuantity)) {
            notSoldQuantity=0;
        }
        if (isNaN(quantityToSale)) {
            quantityToSale=0;
        }

        var quantity= quantityInMagazin+ quantityToSale;
        var id= row.find('select').find('option:selected').val();
        var mealName= row.find('select').find('option:selected').text();

         if(quantityToSale>quantityInMagazinNow || (quantityToSaleNow<Math.abs(quantityToSale) && quantityToSale<0)){
            console.log('quantityToSale',quantityToSale);
            console.log('quantityInMagazinNow',quantityInMagazinNow);
            notSoldQuantityOverFlow=true;
            swal({
                title: "Attention",
                text: "Quantité à mettre en vente est incorrecte",
                type: "warning",
                timer: 2000,
                showConfirmButton: false
            });
            return null;
        }
        else if(quantityInMagazinNow<brokenQuantity || (brokenQuantityNow<Math.abs(brokenQuantity) && brokenQuantity<0)){
            quantityOverFlow=true;
            var text="Quantité de casse est incorrecte";

            swal({
                title: "Attention",
                text: text,
                type: "warning",
                timer: 2000,
                showConfirmButton: false
            });
            return null;

        }
        else if(quantityToSaleNow<notSoldQuantity || (notSoldQuantityNow<Math.abs(notSoldQuantity) && notSoldQuantity<0)){
            quantityOverFlow=true;
            var text="Quantité non vendu est incorrecte";
            swal({
                title: "Attention",
                text: text,
                type: "warning",
                timer: 2000,
                showConfirmButton: false
            });
            return null;

        }
        if(quantityInMagazinNow<brokenQuantity){
            brokenQuantityOverFlow=true;
            swal({
                title: "Attention",
                text: "Quantité de casse incorrect",
                type: "warning",
                timer: 2000,
                showConfirmButton: false
            });
            return null;
        }else{
            quantityOverFlow=false;
            brokenQuantityOverFlow=false;
            notSoldQuantityOverFlow=false;
        }
        if (quantityInMagazin || quantityToSale || brokenQuantity || notSoldQuantity){
            var meal = {
                'id': id,
                'quantityInMagazin': quantityInMagazin,
                'quantityToSale': quantityToSale,
                //'quantity': quantity,
                'magazinQuantityType': row.find("input[name='MagazinQuantityType']").is(':checked'),
                'saleQuantityType': row.find("input[name='saleQuantityType']").is(':checked'),
                'brokenQuantity': brokenQuantity,
                'notSoldQuantity': notSoldQuantity,
            };
            return meal;
        }

        return null;
    }

    $('input[name="buttonSubmit"]').on('click', function () {
        var mealsList=[];
        var prixTotal=0;
        var name=$('input.mealName').val();
        for (var i = 1; i <= productsCount; i++) {
            var row = $('.product[data-id=' + i + ']');
            var meal = getMealStock(row);
            meal['quantity_id']=row.find('input[name=quantity_id]').val();
            console.log(row.find('input[name=quantity_id]').val());
            mealsList.push(meal);
        }

        var data={
            magazin:{
                'name':name,'id':magazin_id,'department':department_id,'mealsList': mealsList
            }
        };
        if(validate()){
            params={
                'swal':'true',
                'callable':false,
                'reload':false
            };
            apiRequest(editMagazin_url,data);
        }else{
            console.log("error");
            $('#loading').hide();
        }

    });


    $('#editMealHistoryModal button[name="edit"]').on('click', function () {

        var magazin_id=$("#editMealHistoryModal input[name=magazin_id]").val();
        var department_id=$("#editMealHistoryModal input[name=department_id]").val();
        var mealsList=[];

        var row = $('#editMealHistoryModal');
        var meal = getMealStock(row);
        meal['quantity_id']=$('#editMealHistoryModal input[name=quantity_id]').val();
        mealsList.push(meal);

        var data={
            magazin:{
                name:'','id':magazin_id,'department':department_id,'mealsList': mealsList
            }
        };
        if(validate()){
            params={
                'swal':'true',
                'callable':false,
                'reload':false
            };
            apiRequest(editMagazin_url,data);
        }else{
            console.log("error");
            $('#loading').hide();
        }

    });

    function validate() {
        var validate = true;
        if (quantityOverFlow) {
            validate = false;
        }else if(brokenQuantityOverFlow){
            validate = false;
        }else if(notSoldQuantityOverFlow){
            validate = false;
        }else{
            validate=true;
        }
        return validate;
    }


    var productSize=1;



    $('button[name="addMeal"]').on('click', addMeal);
    function addMeal(event) {
        var productModel = $('.productModel').clone().removeAttr('hidden');
        productModel.removeClass('productModel');
        productsCount++;
        productModel.attr('data-id',productsCount);
        $('.mealComposition').append(productModel);
        $('.productsCount').html(productsCount);
        if(productsCount>1){
            updateOptions(true);
        }
    }

    function updateOptions(newProduct) {

        var selectedProducts = [];
        for (var i = 1; i <= productsCount; i++) {
            var row = $('.product[data-id=' + i + ']');
            var l_panel = row.closest('.product');
            var optionValue = l_panel.find('select[name="product"] option:selected').val();
            var unit = l_panel.find('select[name="product"] option:selected').attr('data-unit');
            var price = l_panel.find('select[name="product"] option:selected').attr('data-price');
            var option = {
                'unit': unit,
                'price': price,
                'value': optionValue,
            }
            selectedProducts.push(option);
        }
        for (var i = 1; i <= productsCount; i++) {
            var row = $('.product[data-id=' + i + ']');
            var l_panel = row.closest('.product');
            l_panel.find('select[name="product"] option').removeAttr('hidden');
            for (var j = 0; j < selectedProducts.length; j++) {
                var val = selectedProducts[j]['value'];
                var actualVal = l_panel.find('select[name="product"] option:selected').val();
                if (productsCount === i && newProduct) {
                    l_panel.find('select[name="product"] option[value=' + val + ']').attr('hidden', 'hidden');
                    l_panel.find('select[name="product"] option').not('[hidden]').first().attr('selected', 'selected');
                } else {
                    l_panel.find('select[name="product"] option[value=' + val + ']').attr('hidden', 'hidden');
                }
            }
        }
    }

    if(false){
        updateOptions(false);
    }

    $(document).on('click','.editMeal',function () {

        let quantityInMagazinNow=parseFloat($(this).attr('data-quantityInMagazinNow')).toFixed(0);
        let quantityToSaleNow=parseFloat($(this).attr('data-quantityToSaleNow')).toFixed(0);
        let brokenQuantityNow=parseFloat($(this).attr('data-brokenQuantityNow')).toFixed(0);
        let notSoldQuantityNow=parseFloat($(this).attr('data-notSoldQuantityNow')).toFixed(0);

        $('#editMealHistoryModal input[name=quantity_id]').val($(this).attr('data-quantity-id'));
        $('#editMealHistoryModal input[name=meal_id]').val($(this).attr('data-id'));
        $('#editMealHistoryModal input[name=quantityInMagazinNow]').val(quantityInMagazinNow);
        $('#editMealHistoryModal input[name=quantityToSaleNow]').val(quantityToSaleNow);
        $('#editMealHistoryModal input[name=brokenQuantityNow]').val(brokenQuantityNow);
        $('#editMealHistoryModal input[name=notSoldQuantityNow]').val(notSoldQuantityNow);


        $('#editMealHistoryModal table tr').eq(1).find('td').eq(1).html(quantityToSaleNow);
        $('#editMealHistoryModal table tr').eq(1).find('td').eq(2).html(quantityInMagazinNow);
        $('#editMealHistoryModal table tr').eq(1).find('td').eq(3).html(-quantityToSaleNow);


        $('#editMealHistoryModal table tr').eq(2).find('td').eq(1).html(quantityInMagazinNow);
        $('#editMealHistoryModal table tr').eq(2).find('td').eq(2).html(quantityToSaleNow);
        $('#editMealHistoryModal table tr').eq(2).find('td').eq(3).html(-quantityInMagazinNow);


        $('#editMealHistoryModal table tr').eq(3).find('td').eq(1).html(brokenQuantityNow);
        $('#editMealHistoryModal table tr').eq(3).find('td').eq(2).html(quantityInMagazinNow);
        $('#editMealHistoryModal table tr').eq(3).find('td').eq(3).html(-brokenQuantityNow);


        $('#editMealHistoryModal table tr').eq(4).find('td').eq(1).html(notSoldQuantityNow);
        $('#editMealHistoryModal table tr').eq(4).find('td').eq(2).html(quantityToSaleNow);
        $('#editMealHistoryModal table tr').eq(4).find('td').eq(3).html(-notSoldQuantityNow);



    })


});
