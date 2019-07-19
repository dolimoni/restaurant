function editOrder(event) {
    var productsList = [];
    var underTotal = 0;
    var productsCount = $('#editProductsOrder > .row').length;
    for (var i = 0; i < productsCount; i++) {
        var row = $('#editProductsOrder .product[data-index=' + i + ']');
        var quantity = parseFloat(row.find('input[name="quantity"]').val().replace(',', '.'));
        var id = row.find('select[name="product"]').attr('data-id');
        var name = row.find('select[name="product"]').attr('data-name');
        var mark = row.find('select[name="product"] option:selected').attr('data-mark');
        var markName = row.find('select[name="product"] option:selected').attr('data-mark-name');
        var unit = row.find('select[name="product"]').attr('data-unit');
        var unit_price = row.find('input[name="unit_price"]').val();
        var pack = row.find('select[name="product"]').attr('data-pack-order');
        var piecesByPack = row.find('select[name="product"]').attr('data-piecesByPack-order');
        // var unit_price = parseFloat(row.find('input[name="product"]').attr('data-price').replace(',', '.'));
        if (quantity > 0) {
            underTotal += quantity * unit_price;
            var product = {
                'id': id,
                'name': name,
                'quantity': quantity,
                'unit_price': unit_price,
                'unit': unit,
                "mark": mark,
                'markName': markName,
                'pack': pack,
                'piecesByPack': piecesByPack,
            };
            productsList.push(product);
        }

    }

    var status = $(".orderActualStatus").text();
    var advances = getAdvances(false);
    var deletedAdvances = getDeletedAdvances();

    var order = {
        'productsList': productsList,
        'provider': {
            'firstName': $('.provider-firstName').text(),
            'lastName': $('.provider-lastName').text(),
            'address': $('.provider-address').text(),
            'phone': $('.provider-phone').text(),
            'mail': $('.provider-mail').text(),
            'id': $('#provider_id').attr('data-id')
        },
        'underTotal': underTotal,
        'reference': $("#editOrderModal input[name=reference]").val(),
        'paymentType': $("#editOrderModal select[name=paymentType]").val(),
        'tva': $("#editOrderModal input[name=order_tva]").val(),
        'discount': $("#editOrderModal input[name=discount]").val(),
        'orderDate': convertDate($("#editOrderModal #edit_order_date_field").val(), "/", "-", 1),
        'paymentDate': convertDate($("#editOrderModal #edit_payment_date_field").val(), "/", "-", 1),
        'shipping': '-',
        'other': '-',
        'status': status,
        'oldStatus': $(".orderActualStatus").attr("data-status"),
        'id': $('.orderId').val(),
        'advances': advances,
        'deletedAdvances': deletedAdvances
    };
    var data = {
        'order': order
    };
    var params = {
        'swal': 'true',
        'callable': true,
        'reload': false,
        'callbackdata': event
    };
    if (validate(order)) {
        //console.log(order);
        apiRequest(event.data.url, data, params, editOrderCallback);
    }
}

function editOrderCallback(data, params) {
    //console.log(data.filepath);
    if (data.filepath) {
        window.open(data.fullfilepath);
    }
    $(".orderActualStatus").attr("data-status", data.orderStatus);
    if (params.data.sub_url !== "admin/provider/apiPrintOrder") {
        //location.reload();
        var url = window.location.href;
        if (!url.match('#')) {
            window.location.href = url + "#tab_orders";
        }
        location.reload();
    }
}