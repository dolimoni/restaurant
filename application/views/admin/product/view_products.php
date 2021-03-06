<?php $this->load->view('admin/partials/admin_header.php'); ?>
<style>
    tr{
        white-space: nowrap;
    }
</style>
<!-- page content -->
<div class="right_col" role="main">
    <div class="">
        <div class="page-title">
            <div class="row">
                <div class="col-xs-12 col-sm-12">
                    <a href="<?php echo base_url("admin/product/consumption"); ?>" class="btn btn-info" name="printSalesReport">
                        <span class="fa fa-print"></span>Historique de consommation
                    </a>
                    <a href="<?php echo base_url("admin/product/inventoryHistory"); ?>" class="btn btn-success" name="printSalesReport">
                        <span class="fa fa-print"></span>Historique d'inventaire
                    </a>
                </div>

            </div>
        </div>
        <div class="clearfix"></div>
        <hr>
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Liste de vos produits en stock</h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                            <li><a class="close-link"><i class="fa fa-close"></i></a></li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="row">
                        <div class="col-md-3 col-sm-6 col-xs-12">
                            <label for="exampleInputName2">Rechercher</label>
                            <input type="text" placeholder="Nom du produit" class="form-control" id="searchInput" onkeyup="myFunction()">
                        </div>
                    </div>
                    <div class="x_content table-responsive">
                        <table class="table table-striped" id="searchTable">
                            <tr>
                                <th width="15%">
                                    Id
                                </th>
                                <th width="20%">
                                    Produit
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
                                <th width="5%">
                                    Prix total
                                </th>
                                <th width="5%">
                                    %
                                </th>
                                <th width="40%">
                                    Actions
                                </th>
                            </tr>
                            
                            <?php foreach ($products as $product) {
                                $status= $product['min_quantity'] > $product['totalQuantity']?'danger':'success';
                            ?>
                            <tr class="productsList <?php echo $status; ?>">
                                <td><?php echo $product['product'];?></td>
                                <td><?php echo $product['name']; ?></td>
                                <td>
                                    <?php echo number_format((float)($product['totalQuantity']), 2, '.', ''); ?>
                                </td>
                                <td><?php echo $product['unit']; ?></td>
                                <td><?php echo $product['unit_price']; ?></td>
                                <td><?php echo $product['sitting_money']; ?></td>
                                <td><?php echo number_format($product['sitting_money'] / $sittingMoney * 100, 2); ?>%</td>
                                <td>
                                    <?php if($params["acl_page"]["acl_write"] or $this->session->userdata('type') === "admin") :?>
                                    <a href=" <?php echo base_url('admin/product/edit/'. $product['product']); ?>" class="btn btn-primary btn-xs">Modifier</a>
                                    <?php endif; ?>

                                    <?php if ($params["acl_page"]["acl_delete"] or $this->session->userdata('type') === "admin") : ?>
                                    <div class="btn btn-info btn-xs open">Articles</div>
                                    <?php endif; ?>

                                    <?php if ($params["acl_page"]["statistic"] or $this->session->userdata('type') === "admin") : ?>
                                        <a href=" <?php echo base_url('admin/product/statistic/' . $product['product']); ?>"
                                           class="btn btn-warning btn-xs">Statistiques</a>
                                    <?php endif; ?>

                                    <?php if ($params["acl_page"]["acl_delete"] or $this->session->userdata('type') === "admin") : ?>
                                    <a  class="btn btn-danger btn-xs deleteProduct" data-id="<?php echo $product['product']; ?>">Supprimer</a>
                                    <?php endif; ?>

                                    <?php if ($product['min_quantity'] > $product['totalQuantity'] && $product['provider'] > 0 && ($params["acl_page"]["acl_write"] or $this->session->userdata('type') === "admin")) { ?>
                                        <a href=" <?php echo base_url('admin/provider/show/' . $product['provider']); ?>"
                                           class="btn btn-success btn-xs">Commander</a>
                                    <?php } ?>
                                </td>
                            </tr>
                                <tr class="productsRow">
                                    <td colspan="8">
                                        <table class="table">
                                            <thead>
                                            <tr class="info">
                                                <th>Id</th>
                                                <th>Nom</th>
                                                <th>Quantité</th>
                                                <th>Prix total</th>
                                                <th>Taux de consomation</th>
                                                <th>Actions</th>
                                            </tr>
                                            </thead>
                                            <tfoot>
                                            <tr class="info">
                                                <th>Id</th>
                                                <th>Nom</th>
                                                <th>Quantité</th>
                                                <th>Prix total</th>
                                                <th>Taux de consomation</th>
                                                <th>Actions</th>
                                            </tr>
                                            </tfoot>
                                            <tbody>
                                            <?php foreach ($product['meals'] as $meal) { ?>
                                                <tr class="success">
                                                    <td><?php echo $meal['name']; ?></td>
                                                    <td>Test</td>
                                                    <td><?php echo $meal['quantity'].' '. $meal['mp_unit']; ?></td>
                                                    <td><?php echo $meal['quantity'] * $product['unit_price'] * $meal['unitConvert']; ?></td>
                                                    <td><?php echo $meal['consumptionRate'] * 100; ?>%</td>

                                                     <td>
                                                         <a href=" <?php echo base_url('admin/meal/edit/' . $meal['meal']); ?>"
                                                            class="btn btn-primary btn-xs">Modifier</a>
                                                     </td>
                                                </tr>
                                            <?php } ?>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                            <?php } ?>


                            <tr>
                                <th>
                                    Composition
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
                                    Prix unitair
                                </th>
                                <th colspan="4">
                                    Actions
                                </th>
                            </tr>

                            <?php foreach ($productsComposition as $composition) {
                                $status= $composition['min_quantity'] > $composition['totalQuantity']?'danger':'warning';
                            ?>
                            <tr class="productsList <?php echo $status; ?>">
                                <td><?php echo $composition['product'];?></td>
                                <td><?php echo $composition['name']; ?></td>
                                <td>
                                    <?php echo number_format((float)($composition['totalQuantity']), 2, '.', ''); ?>
                                </td>
                                <td><?php echo $composition['unit']; ?></td>
                                <td><?php echo $composition['unit_price']; ?></td>
                                </td>
                                <td colspan="4">
                                <?php if ($params["acl_page"]["acl_write"] or $this->session->userdata('type') === "admin") : ?>
                                    <a href=" <?php echo base_url('admin/product/editComposition/'. $composition['product']); ?>" class="btn btn-primary btn-xs">Modifier</a>
                                <?php endif; ?>
                                <?php if ($params["acl_page"]["statistic"] or $this->session->userdata('type') === "admin") : ?>
                                    <a href=" <?php echo base_url('admin/product/statistic/' . $composition['product']); ?>"
                                       class="btn btn-warning btn-xs">Statistiques</a>
                                <?php endif; ?>
                                <?php if ($params["acl_page"]["acl_read"] or $this->session->userdata('type') === "admin") : ?>
                                    <div class="btn btn-info btn-xs open">Articles</div>
                                <?php endif; ?>
                                <?php if ($params["acl_page"]["acl_delete"] or $this->session->userdata('type') === "admin") : ?>
                                    <a  class="btn btn-danger btn-xs deleteProduct" data-id="<?php echo $composition['product']; ?>">Supprimer</a>
                                <?php endif; ?>
                                </td>
                            </tr>
                                <tr class="productsRow">
                                    <td colspan="6">
                                        <table class="table">
                                            <thead>
                                            <tr class="info">
                                                <th>Id</th>
                                                <th>Nom</th>
                                                <th>Quantité</th>
                                                <th>Prix total</th>
                                                <th>Taux de consomation</th>
                                                <th>Actions</th>
                                            </tr>
                                            </thead>
                                            <tfoot>
                                            <tr class="info">
                                                <th>Id</th>
                                                <th>Nom</th>
                                                <th>Quantité</th>
                                                <th>Prix total</th>
                                                <th>Taux de consomation</th>
                                                <th>Actions</th>
                                            </tr>
                                            </tfoot>
                                            <tbody>
                                            <?php foreach ($composition['meals'] as $meal) { ?>
                                                <tr class="success">
                                                    <td><?php echo $meal['name']; ?></td>
                                                    <td></td>
                                                    <td><?php echo $meal['quantity'] . ' ' . $meal['mp_unit']; ?></td>
                                                    <td><?php echo $meal['quantity'] * $product['unit_price'] * $meal['unitConvert']; ?></td>
                                                    <td><?php echo $meal['consumptionRate'] * 100; ?>%</td>

                                                    <td>
                                                        <a href=" <?php echo base_url('admin/meal/edit/' . $meal['meal']); ?>"
                                                           class="btn btn-primary btn-xs">Modifier</a>
                                                    </td>
                                                </tr>
                                            <?php } ?>
                                            </tbody>
                                        </table>
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
        $(".open").click(function () {
            $(this).closest("tr").next().toggle();
        });
        $(".deleteProduct").on('click', deleteProductEvent);

        function deleteProductEvent(){
            var myData={
                'id':$(this).attr('data-id')
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

        function deleteProduct(data){
            var myData={
                'id':data['id']
            };
            $.ajax({
                url: "<?php echo base_url('admin/product/apiDelete')?>",
                type: "POST",
                dataType: "json",
                data: myData,
                beforeSend: function () {
                    $('#loading').show();
                },
                complete: function () {
                    $('#loading').hide();
                },
                success: function (data) {
                    if (data.status === "success") {
                        swal({
                            title: "Success",
                            text: "Success",
                            type: "success",
                            timer: 1500,
                            showConfirmButton: false
                        });
                        location.reload();
                    }
                    else if(data.status === "warning") {
                        swal({
                            title: "Attention!",
                            text: data.message,
                            type: "warning",
                            timer: 2000,
                            showConfirmButton: false
                        });
                    }else{
                        swal({
                            title: "Erreur",
                            text: "Une erreur s'est produite",
                            type: "error",
                            timer: 1500,
                            showConfirmButton: false
                        });
                    }
                },
                error: function (data) {
                    swal({
                        title: "Erreur",
                        text: "Une erreur s'est produite",
                        type: "error",
                        timer: 1500,
                        showConfirmButton: false
                    });
                }
            });
        }
    });
</script>



<!--Search in table-->
<script>
    function myFunction() {
        var input, filter, table, tr, td, i;
        input = document.getElementById("searchInput");
        filter = input.value.toUpperCase();
        table = document.getElementById("searchTable");
        tr = table.getElementsByClassName("productsList");
        for (i = 0; i < tr.length; i++) {
            td = tr[i].getElementsByTagName("td")[1];
            console.log(td);
            if (td) {
                if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
                    tr[i].style.display = "";
                } else {
                    tr[i].style.display = "none";
                }
            }
        }
    }
</script>
