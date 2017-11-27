<?php $this->load->view('admin/partials/admin_header.php'); ?>
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
                        <h2>Liste des produits que vous devez commander</h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                            <li><a class="close-link"><i class="fa fa-close"></i></a></li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content table-responsive">
                        <table class="table table-striped">
                            <tr>
                                <th>
                                    Id
                                </th>
                                <th>
                                    Nom
                                </th>
                                <th>
                                    Quantité
                                </th>
                                <th>
                                    Unité
                                </th>
                                <th>
                                    Prix unitaire
                                </th>
                                <th colspan="2">
                                    Actions
                                </th>
                            </tr>
                            
                            <?php foreach ($products as $product) {
                                $status= $product['min_quantity'] > $product['quantity']?'danger':'success';
                            ?>
                            <tr class="<?php echo $status; ?>">
                                <td><?php echo $product['id'];?></td>
                                <td><?php echo $product['name']; ?></td>
                                <td><?php echo $product['quantity']; ?></td>
                                <td><?php echo $product['unit']; ?></td>
                                <td><?php echo $product['unit_price']; ?></td>
                                <td>
                                    <a href=" <?php echo base_url('admin/product/edit/'. $product['id']); ?>" class="btn btn-primary btn-xs">Modifier</a>
                                    <a class="btn btn-danger btn-xs deleteProduct"
                                       data-id="<?php echo $product['id']; ?>">Supprimer</a>
                                </td>
                            </tr>
                            <?php } ?>
                        </table>
                    </div> <!-- /content --> 
                </div><!-- /x-panel --> 
            </div> <!-- /col --> 
        </div> <!-- /row --> 
    </div>
</div> <!-- /.col-right --> 
<!-- /page content -->
<?php $this->load->view('admin/partials/admin_footer'); ?>
<script>
    $(document).ready(function () {

        $(".deleteProduct").on('click', deleteProductEvent);

        function deleteProductEvent() {
            var myData = {
                'id': $(this).attr('data-id')
            }
            swal({
                    title: "Attention ! ",
                    text: "Vous voulez vraiment supprimer ce produit ?",
                    type: "warning",
                    showConfirmButton: true,
                    showCancelButton: true,
                    cancelButtonText: 'Non',
                    confirmButtonText: 'Oui'
                },
                function () {
                    deleteProduct(myData);
                });
        }

        function deleteProduct(data) {
            var myData = {
                'id': data['id']
            };
            console.log(myData);
            $.ajax({
                url: "<?php echo base_url('admin/product/apiDelete')?>",
                type: "POST",
                dataType: "json",
                data: myData,
                success: function (data) {
                    if (data.status === "success") {
                        swal({
                            title: "Success",
                            text: "Success",
                            type: "success",
                            timer: 1500,
                            showConfirmButton: false
                        });
                    }
                    else {
                        console.log('Error');
                    }
                },
                error: function (data) {
                }
            });
        }
    });
</script>