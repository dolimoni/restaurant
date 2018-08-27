function getOrder(event) {

    var data={
        'id': $(this).attr('data-id')
    };
    var  params={
        'swal':'false',
        'callable':true,
        'reload':false,
        'callbackdata':event
    };
    apiRequest(event.data.url,data,params,getOrderCallback);
}

function getOrderCallback(data,params) {

    $(".orderId").val(data.order['o_id']);
    $(".orderActualStatus").attr("data-status", data.order['status']);
    changeStatus("request",data.order['status']);

    //remove background from all quantity input
    $("#editOrderModal #editProductsOrder .product").find("input[name='quantity'],input[name='product'],input[name='unit_price']").removeClass("ordred");
    $("#editOrderModal #editProductsOrder .product").find("input[name='quantity']").val("");
    $("#editOrderModal #editProductsOrder .product").find('.productCost').html(' 0DH');

    $.each(data.order.productsList, function (key, product) {
        var l_productSelector= "#editOrderModal #editProductsOrder .product[data-id='" + product['id'] + "']";
        var l_product = $(l_productSelector);
        l_product.find('select').val(product.mark);
        l_product.find("input[name='quantity']").val(parseFloat(product['od_quatity']).toFixed(2));
        l_product.find("input[name='product']").val(product['product_name']);
        l_product.find("input[name='product']").attr("data-name",product['product_name']);

        l_product.find("select[name='product']").attr("data-pack-order",product['od_pack']);
        l_product.find("select[name='product']").attr("data-piecesByPack-order",product['od_piecesBypack']);

        // add background for ordred products
        l_product.find("input[name='quantity'],input[name='product'],input[name='unit_price']").addClass("ordred");
        l_product.find(".productCost").html((parseFloat(product['od_quatity']) * parseFloat(product['od_price'])).toFixed(2));
        l_product.find("input[name='unit_price']").val((parseFloat(product['od_price'])).toFixed(2));
    });
    //edit params
    $("#editOrderModal #tab_config_edit_order input[name=reference]").val(data.order['reference']);
    $("#editOrderModal #tab_config_edit_order input[name=order_tva]").val(data.order['tva']);
    $("#editOrderModal #tab_config_edit_order input[name=discount]").val(data.order['discount']);
    $("#editOrderModal #edit_order_date_field").val(convertDate(data.order['orderDate'],"-","/",3));
    $("#editOrderModal #edit_payment_date_field").val(convertDate(data.order['paymentDate'],"-","/",3));
    $("#editOrderModal #tab_config_edit_order select[name=paymentType]").val(data.order['paymentType']);

    if(data.order['status']==="received"){
        $("#editOrderModal #editProductsOrder .product input[name=quantity]").attr("disabled", "true");
        $("#editOrderModal #editProductsOrder .product input[name=unit_price]").attr("disabled", "true");
        $("#editOrderModal #editProductsOrder .product select[name=product]").attr("disabled", "true");
        $("#editOrderModal input[name=order_tva]").attr("disabled", "true");
    }else{
        $("#editOrderModal #editProductsOrder .product input[name=quantity]").removeAttr("disabled");
    }



    //adding advances
    $('#editOrderModal #advancesBody').find("tr:gt(0)").remove();
    $.each(data.order.advances, function (key, advance) {
        var advanceModel=$("#editOrderModal .advanceModel").clone().removeAttr("hidden");
        advanceModel.removeClass("advanceModel");
        advanceModel.addClass("invalidate");
        $("#editOrderModal #advancesBody").append(advanceModel);
        $(advanceModel.find("div[data-type=amount]")).html(parseFloat(advance.amount).toFixed(2));
        $(advanceModel.find("div[data-type=date]")).html(advance.paymentDate);
        $(advanceModel.find("div[data-type=id]")).html(advance.id);
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
    });

    let totalPrice=getTotalPrice(false);
    calculateRemainingPrice(false);
    let advances=totalPrice-remainingPrice;
    if (data.order['paid'] === "false") {
        $("#editOrderModal .modal-title span").html(order_impaid_lang+'-'+advances+'Dh/'+totalPrice+'Dh');
        $("#editOrderModal .modal-title").addClass("orderImpaid");
        $("#editOrderModal .modal-title").removeClass("orderPaid");
        $("#editOrderModal .payOrder").prop('value', pay_order_lang);
        $("#editOrderModal .payOrder").addClass("btn-success");
        $("#editOrderModal .payOrder").removeClass("btn-danger");
        $(".newAvanceEdit").closest('div').attr("hidden",false);
    } else {
        $("#editOrderModal .modal-title span").html(order_paid_lang+'-'+totalPrice+'Dh');
        $("#editOrderModal .modal-title").addClass("orderPaid");
        $("#editOrderModal .modal-title").removeClass("orderImpaid");
        $("#editOrderModal .payOrder").prop('value', impay_order_lang);
        $("#editOrderModal .payOrder").removeClass("btn-success");
        $("#editOrderModal .payOrder").addClass("btn-danger");
        $(".newAvanceEdit").closest('div').attr("hidden",true);
    }


}