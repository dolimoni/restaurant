$(document).on('change',"select[name=product]",function(){
    var vm=$(this);
    var m_unit_price=vm.find("option:selected").attr('data-mark-unit_price');

    // si c'est le 1er choix
    if(m_unit_price===undefined){
        var m_unit_price=vm.attr('data-price');
    }
    var row = $(this).closest('.row');
    var quantity   = parseFloat(row.find('input[name="quantity"]').val());
    row.find('input[name="unit_price"]').val(m_unit_price);
    var unit_price = m_unit_price;

    if(quantity>0){
        row.find('.productCost').html((quantity * unit_price).toFixed(2) + 'DH');
    }else{
        row.find('.productCost').html('0 DH');
    }
    calculateRemainingPrice();
    calculateRemainingPrice(false);
});


