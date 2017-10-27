<?php $this->load->view('admin/partials/admin_header.php'); ?>
<style>
    .validate{
        background: #26b99a !important;
        color: white;
    }
</style>
    <!-- page content -->
    <div class="right_col" role="main">
        <div class="">
            <div class="page-title">
                <div class="title_left">
                    <h3>Produits</h3>
                </div>
            </div>
            <div class="clearfix"></div>
            <hr>
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2>Liste des produits vendu aujoud'hui</h2>
                            <ul class="nav navbar-right panel_toolbox">
                                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                                <li><a class="close-link"><i class="fa fa-close"></i></a></li>
                            </ul>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">
                            <table class="table table-striped">
                                <tr>
                                    <th>
                                        Id
                                    </th>
                                    <th>
                                        Code
                                    </th>
                                    <th>
                                        Description
                                    </th>
                                    <th>
                                        Qunatité
                                    </th>
                                    <th>
                                        Montant
                                    </th>
                                    <th>
                                        Nom
                                    </th>
                                    <th>
                                        Actions
                                    </th>
                                </tr>

                               <?php foreach ($rows as $row) { ?>
                                <tr data-id="<?php echo $row[0]; ?>">
                                    <td data-type="id"><?php echo $row['product']['id']; ?></td>
                                    <td data-type="externalCode"><?php echo $row[0];?></td>
                                    <td data-type="description"><?php echo $row[1]; ?></td>
                                    <td data-type="quantity"><?php echo $row[2]/1000; ?></td>
                                    <td data-type="amount"><?php echo $row[3]/100; ?></td>
                                    <td data-type="name"> <?php echo $row['product']['name']; ?></td>
                                    <td>
                                        <button class="btn btn-danger btn-xs action" data-type="delete"
                                                data-toggle="modal" data-target="#delete"><span
                                                    class="glyphicon glyphicon-trash"></span></button>
                                        <button class="btn btn-default btn-xs action" data-type="validate"
                                                data-toggle="modal" data-target="#livraison"><span
                                                    class="glyphicon glyphicon-ok"></span></button>
                                    </td>
                                </tr>
                                <?php } ?>

                                <tr>
                                    <td>-</td>
                                    <td>-</td>
                                    <td>-</td>
                                    <td>TOTALE : 3000</td>
                                    <td>TOTALE : 20500DH</td>
                                    <td></td>
                                    <td>
                                        <button class="btn btn-danger btn-xs action" data-type="delete" data-id="18"
                                                data-toggle="modal" data-target="#delete"><span
                                                    class="glyphicon glyphicon-trash"></span></button>
                                        <button class="btn btn-default btn-xs action" data-type="livraison" data-id="18"
                                                data-toggle="modal" data-target="#livraison"><span
                                                    class="glyphicon glyphicon-ok"></span></button>
                                    </td>
                                </tr>

                            </table>
                            <div class="text-right">
                                <button type="button" class="btn btn-success " name="validate">
                                    Valider
                                </button>
                            </div>

                        </div> <!-- /content -->
                    </div><!-- /x-panel -->
                </div> <!-- /col -->
            </div> <!-- /row -->
        </div>
    </div> <!-- /.col-right -->
    <!-- /page content -->

<?php $this->load->view('admin/partials/admin_footer'); ?>

<script>
$('button[data-type="validate"]').on('click',function () {
   var id = $(this).closest('tr').attr('data-id');
   var tr = $(this).closest('tr');
   console.log();
   if(tr.hasClass('validate')){
       tr.removeClass('validate');
   }else{
       tr.addClass('validate');
   }

});
$('button[name="validate"]').on('click', function () {
    var mealsList = [];
    $('tr.validate').each(function (i, obj) {
        var tr = $(this);
        var id = tr.find('td[data-type="id"]').text();
        var externalCode = tr.find('td[data-type="externalCode"]').text();
        var description = tr.find('td[data-type="description"]').text();
        var qunatity = tr.find('td[data-type="quantity"]').text();
        var amount = tr.find('td[data-type="amount"]').text();
        var name = tr.find('td[data-type="name"]').text();
        var product={
            'id':id,
            'externalCode': externalCode,
            'description':description,
            'quantity':qunatity,
            'amount':amount,
            'name':name
        };
        mealsList.push(product);
    });

    var myData={'mealsList': mealsList};
    $.ajax({
        url: "<?php echo base_url(); ?>admin/meal/apiConsumption",
        type: "POST",
        dataType: "json",
        data: myData,
        success: function (data) {
            if (data.status === 'success') {
                swal({
                    title: "Success",
                    text: "L'opératon a été effectuée avec success",
                    type: "success",
                    timer: 1500,
                    showConfirmButton: false
                });
            }
            else {
                var content='';
                  $.each(data.productsList, function (key, product) {
                        content+=product['name']+",";
                    });
                swal({
                    title: "La quantité de certain produits est insuffisante",
                    type: "error",
                    showCloseButton: true,
                    html: true
                });
            }
        },
        error: function (data) {
            swal({
                title: "Erreur",
                text: "Une erreur s\'est produite",
                type: "error",
                timer: 1500,
                showConfirmButton: false
            });
        }
    });


});
</script>
