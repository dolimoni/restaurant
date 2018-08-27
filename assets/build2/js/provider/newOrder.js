function newOrder(event) {
    var productsList = [];
    var underTotal = 0;
    var productsCount = $('#productsOrder > .row').length;
    for (var i = 0; i < productsCount; i++) {
        var row = $('.product[data-index=' + i + ']');
        var quantity = parseFloat(row.find('input[name="quantity"]').val().replace(',', '.'));
        var id = row.find('select[name="product"]').attr('data-id');
        var name = row.find('select[name="product"]').attr('data-name');
        var mark = row.find('select[name="product"] option:selected').attr('data-mark');
        var markName = row.find('select[name="product"] option:selected').attr('data-mark-name');
        var unit = row.find('select[name="product"]').attr('data-unit');
        var pack = row.find('select[name="product"]').attr('data-pack-order');
        var piecesByPack = row.find('select[name="product"]').attr('data-piecesByPack-order');
        //var idQuantity = row.find('select[name="product"]').attr('data-id-quantity');
        var unit_price = parseFloat(row.find('input[name="unit_price"]').val().replace(',', '.'));
        console.log(id, quantity, unit_price);
        if (quantity > 0 && unit_price > 0) {
            underTotal += quantity * unit_price;
            var product = {
                'id': id,
                'name': name,
                'quantity': quantity,
                'unit_price': unit_price,
                'unit': unit,
                'mark': mark,
                'markName': markName,
                'pack': pack,
                'piecesByPack': piecesByPack
            };
            productsList.push(product);
        }

    }

    var emailContent = "";
    var send = false;
    if ($('#editor-newOrder').html() !== "") {
        emailContent = $('#editor-newOrder').html();
        send = true;
    }
    var email = {
        'send': send,
        'content': emailContent,
        'to': $('.provider-mail').text()
    };
    var advances = getAdvances();

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
        'reference': $("#orderModal input[name=reference]").val(),
        'paymentType': $("#orderModal select[name=paymentType]").val(),
        'tva': $("#orderModal input[name=order_tva]").val(),
        'discount': $("#orderModal input[name=discount]").val(),
        'orderDate': convertDate($("#orderModal #order_date_field").val(), "/", "-", 1),
        'paymentDate': convertDate($("#orderModal #payment_date_field").val(), "/", "-", 1),
        'shipping': '-',
        'other': '-',
        'email': email,
        'advances': advances
    };


    var data = {
        'order': order,
    };
    var params = {
        'swal': 'true',
        'callable': true,
        'reload': false,
        'callbackdata': event
    };
    if (validate(order)) {
        apiRequest(event.data.url, data, params, newOrderCallback);
    }

}

function newOrderCallback(data, params) {
    console.log(params);
    window.open(data.fullfilepath);
    if (params.data.sub_url !== "admin/provider/apiPrintOrder") {
        var url = window.location.href;
        if (!url.match('#')) {
            window.location.href = url + "#tab_orders";
        }
        location.reload();
    }
}