function productsToOrder(event) {
    var productsList = [];
    var underTotal = 0;
    var productsCount = $('#productToOrder > .row').length;
    for (var i = 0; i < productsCount; i++) {
        var row = $('.product[data-index=' + i + ']');
        var quantity = parseFloat(row.find('input[name="quantityToOrder"]').val().replace(',', '.'));
        var id = row.find('input[name="productToOrder"]').attr('data-id');
        var idQuantity = row.attr("data-id-quantity");
        var name = row.find('input[name="productToOrder"]').attr('data-name');
        var unit_price = parseFloat(row.find('input[name="productToOrder"]').attr('data-price').replace(',', '.'));
        if (quantity > 0 && unit_price > 0) {
            underTotal += quantity * unit_price;
            var product = {'id': id, 'name': name, 'quantity': quantity, 'unit_price': unit_price,"idQuantity": idQuantity, 'unit': '-'};
            productsList.push(product);
        }

    }

    var emailContent = "";
    var send = false;
    if ($('#editor-productsToOrder').html() !== "") {
        emailContent = $('#editor-productsToOrder').html();
        send = true;
    }
    var email = {
        'send': send,
        'content': emailContent,
        'to': $('.provider-mail').text()
    }

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
        'tva': $('.provider-tva').attr('data-tva'),
        'shipping': '-',
        'other': '-',
        'email': email
    };


    $('#loading').show();
    $.ajax({
        url: event.data.url,
        type: "POST",
        dataType: "json",
        data: {'order': order},
        success: function (data) {
            $('#loading').hide();
            if (data.status === true) {
                window.open("<?=base_url()?>" + data.filepath);
                if (event.data.url !== "admin/provider/apiPrintOrder") {
                    var url = window.location.href;
                    if (!url.match('#')) {
                        window.location.href = url + "#tab_orders";
                    }
                    location.reload();
                }
            }
            else {
                console.log('ko');
            }

        },
        error: function (data) {
            $('#loading').hide();
        }
    });



}