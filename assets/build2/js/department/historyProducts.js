$(document).ready(function () {
    $(document).on('click', ".editAlert", editAlertEvent);
    var l_id = -1;

    function editAlertEvent() {
        if ($(this).attr('data-id') === l_id || l_id === -1) {
            $('#editAlert').toggle('slow');
        }
        l_id = $(this).attr('data-id');
        l_sh_id = $(this).attr('data-sh-id');
        var row = $(this).closest('tr');
        $('#editAlert select.productSelect').val($(this).attr('data-id'));
        $('#editAlert input[name="quantity"]').val(row.find("[data-quantity]").attr('data-quantity'));

        console.log(l_id);
        $('#editAlert input[name="id"]').val(l_id);

        scroll("editAlert");
    }

    // This is a functions that scrolls to #{blah}link
    function scroll(id) {
        // Scroll
        $('html,body').animate({scrollTop: $("#" + id).offset().top}, 'slow');
    }


    $('button.deleteAlert').on('click', deleteAlertEvent);


    function deleteAlertEvent() {
        var stock_history_id = $(this).attr('data-id');
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
                apiRequest(deleteStock_url,{'stock_history_id': stock_history_id});
            });


    }




    //EDTI STOCK HISTORY

    $('#editAlertForm').on('submit', function (e) {
        e.preventDefault();
        var stock_history = {
            'id': $("#editAlertForm input[name='id']").val(),
            'quantity': $("#editAlertForm input[name='quantity']").val(),
        };

        var validForm = true;
        if (validForm) {
            apiRequest(editStockHistory_url,{"stock_history": stock_history});
        }
    });

});
