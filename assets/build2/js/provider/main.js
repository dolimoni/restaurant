var remainingPrice=getTotalPrice();

$('.newAvance').on('click',{create:true,selector:'#orderModal #advancesBody'},newAvance);
$('.newAvanceEdit').on('click',{create:false,selector:'#editOrderModal #advancesBody'},newAvance);

$("#advancesBody").on('keypress','div[data-type=amount]',function(e) {
    if (isNaN(String.fromCharCode(e.which)) && (e.which!==44 && e.which!==46)){
        e.preventDefault();
    }
});
function newAvance(event){
    calculateRemainingPrice(event.data.create);
    var advanceModel=$(event.data.selector).find(".advanceModel").clone().removeAttr("hidden");
    advanceModel.removeClass("advanceModel");
    advanceModel.addClass("invalidate");
    $(event.data.selector).append(advanceModel);
    $(advanceModel.find("div[data-type=amount]")).focus();
    $(advanceModel.find("div[data-type=remain]")).html(parseFloat(remainingPrice).toFixed(2));
    $(advanceModel.find("div[data-type=date]")).html(getCurrentDate());
    $('.datepick').each(function(){
        var datepick=$(this);
        datepick.daterangepicker({
            singleDatePicker: true,
            singleClasses: "picker_3"
        },function (start, end, label) {
            var startDate= start.format("YYYY-MM-DD");
            var endDate= startDate;
            var myData={
                "startDate":startDate,
                "endDate":endDate,
            };
            datepick.html(startDate);
        });
    });
}


//on change advance amount
$('#tab_advance_order').on('keyup', '.advanceAmount[contenteditable]', function() {
    calculateRemainingPrice();
});
$('#editOrderModal').on('keyup', '.advanceAmount[contenteditable]', function() {
    calculateRemainingPrice(false);
});

function calculateRemainingPrice(create=true) {
    var advances=getAdvances(create);
    var totalPrice=getTotalPrice(create);
    var selector='#orderModal tr.invalidate';
    if(!create){
        selector='#editOrderModal #advancesBody tr.invalidate';
    }
    $(selector).each(function (i, obj) {
        if(advances[i]){
            totalPrice-=advances[i]['amount'];
        }
        var tr = $(this);
        if(totalPrice>=0){
            tr.find('td div[data-type="remain"]').html(parseFloat(totalPrice).toFixed(2));
        }else{
            document.execCommand('undo', false, null);
            swal({
                title: "Attention",
                text: "Le montant des avances est supérieur au montant total de la commande",
                type: "warning",
                timer: 1500,
                showConfirmButton: false
            });
        }
    });
    if(totalPrice>=0){
        remainingPrice=totalPrice;
    }
}


function getAdvances(create=true) {
    var advances = [];
    var selector='#orderModal #advancesBody tr';
    if(!create){
        selector='#editOrderModal #advancesBody tr';
    }
    $(selector).each(function (i, obj) {
        var tr = $(this);
        var amount = parseFloat(tr.find('td div[data-type="amount"]').text());
        var date = tr.find('td div[data-type="date"]').text();
        var id = tr.find('td div[data-type="id"]').text();

        var advance = {
            'amount': amount,
            'date': date,
            'id': id,
        };

        if (amount) {
            advances.push(advance);
        }
    });
    return advances;
}
function getDeletedAdvances(create=true) {
    var advances = [];
    var selector='#editOrderModal #advancesBody tr';

    $(selector).each(function (i, obj) {
        var tr = $(this);
        var amount = parseFloat(tr.find('td div[data-type="amount"]').text());
        var date = tr.find('td div[data-type="date"]').text();
        var id = tr.find('td div[data-type="id"]').text();

        var advance = {
            'amount': amount,
            'date': date,
            'id': id,
        };

        if (amount===0) {
            advances.push(advance);
        }
    });
    return advances;
}

function getTotalPrice(create=true) {

    var selector=$("#orderModal");
    var productsCount = selector.find('#productsOrder > .row').length;
    if(!create){
        selector=$("#editOrderModal");
        productsCount = selector.find('#editProductsOrder > .row').length;
    }
    var underTotal = 0;
    var tva=selector.find('input[name=order_tva]').val();
    var discount=parseFloat(selector.find('input[name=discount]').val()).toFixed();
    for (var i = 0; i < productsCount; i++) {
        var row = selector.find('.product[data-index=' + i + ']');
        var quantity = parseFloat(row.find('input[name="quantity"]').val().replace(',', '.'));
        var unit_price = parseFloat(row.find('input[name="unit_price"]').val().replace(',', '.'));
        if (quantity > 0 && unit_price > 0) {
            underTotal += quantity * unit_price;
        }
    }
    var ttc=underTotal*(tva/100+1)-discount;
    ttc= parseFloat(ttc).toFixed(2);
    return ttc;
}