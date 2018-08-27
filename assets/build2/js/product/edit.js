
function init() {
    $('#addMarkForm').submit(function (e) {
        e.preventDefault();
       var name = $(this).find('input[name=name]').val();
       var id = $('input[name=id]').val();
       var mark={
           'name':name,
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
        $('#editMarkModal input[name=name]').val(name);
        $('#editMarkModal input[name=id]').val(id);
    });

    $('#editMarkForm').submit(function (e) {
        e.preventDefault();
        var name = $(this).find('input[name=name]').val();
        var mark_id = $(this).find('input[name=id]').val();
        var id = $('input[name=id]').val();
        var mark={
            'name':name,
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

        if(this.value!=='pcs'){
            $('#pack').attr('disabled','true');
            $('div.piecesByPack').fadeOut();
            $('#pack').prop('checked', false); // Unchecks it
        }else{
            $('#pack').removeAttr('disabled');
        }
    });

}


$(document).ready(function () {

    init();

});
