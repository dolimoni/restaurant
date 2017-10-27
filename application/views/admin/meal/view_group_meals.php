<?php $this->load->view('admin/partials/admin_header.php'); ?>
    <!-- page content -->
    <div class="right_col" role="main">
        <div class="">
            <div class="page-title">
                <div class="title_left">
                    <h3>Articles</h3>
                </div>
            </div>
            <div class="clearfix"></div>
            <hr>
            <div class="row">
                <button type="submit" class="btn btn-success" name="new"
                        onclick="window.location.href='<?php echo base_url('admin/meal/add/'); ?>'">
                    <span></span> Nouveau
                </button>
                <button type="submit" class="btn btn-warning" name="Fichier"
                        onclick="window.location.href='<?php echo base_url('admin/meal/loadFile/'); ?>'">
                    <span class="fa fa-print"></span> Importer
                </button>

                <div class="col-xs-12">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2>Liste des articles</h2>
                            <ul class="nav navbar-right panel_toolbox">
                                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                                <li><a class="close-link"><i class="fa fa-close"></i></a></li>
                            </ul>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">
                            <table id="datatable-responsive"
                                   class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0"
                                   width="100%">
                                <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Nom</th>
                                    <th>Coût</th>
                                    <th>Prix de vente</th>
                                    <th>Bénifices</th>
                                    <th>Nombre de produits</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tfoot>
                                <tr>
                                    <th>Id</th>
                                    <th>Nom</th>
                                    <th>Coût</th>
                                    <th>Prix de vente</th>
                                    <th>Bénifices</th>
                                    <th>Nombre de produits</th>
                                    <th>Action</th>
                                </tr>
                                </tfoot>
                                <tbody>
                                <?php foreach ($meals as $meal) { ?>
                                    <tr>
                                        <td><?php echo $meal['id']; ?></td>
                                        <td><?php echo $meal['meal_name']; ?></td>
                                        <td><?php echo $meal['cost']; ?></td>
                                        <td><?php echo $meal['sellPrice']; ?></td>
                                        <td><?php echo $meal['profit']; ?></td>
                                        <td><?php echo $meal['products_count']; ?></td>
                                        <td>
                                            <a href=" <?php echo base_url(); ?>admin/meal/edit/<?php echo $meal['id']; ?>"
                                               class="btn btn-primary btn-xs">Edit</a>
                                            <div class="btn btn-primary btn-xs open">Compositions</div>
                                            <a class="btn btn-danger btn-xs">Delete</a>
                                            <!--<pre>
                                                <?php /*print_r($meals); */ ?>
                                           </pre>-->
                                        </td>
                                    </tr>
                                    <tr class="productsRow">
                                        <td colspan="8">
                                            <table class="table">
                                                <thead>
                                                <tr class="info">
                                                    <th>Id</th>
                                                    <th>Nom</th>
                                                    <th>Prix</th>
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
                                                    <th>Prix</th>
                                                    <th>Quantité</th>
                                                    <th>Prix total</th>
                                                    <th>Taux de consomation</th>
                                                    <th>Actions</th>
                                                </tr>
                                                </tfoot>
                                                <tbody>
                                                <?php foreach ($meal['productsList'] as $product) { ?>
                                                    <tr class="success">
                                                        <td><?php echo $product['id']; ?></td>
                                                        <td><?php echo $product['name']; ?></td>
                                                        <td><?php echo $product['unit_price']; ?></td>
                                                        <td><?php echo $product['mp_quantity']; ?></td>
                                                        <td><?php echo $product['mp_quantity'] * $product['unit_price']; ?></td>
                                                        <td><?php echo $product['consumptionRate'] * 100; ?>%</td>
                                                        <td>
                                                            <a href=" <?php echo base_url(); ?>admin/employee/edit/{id}"
                                                               class="btn btn-primary btn-xs">Edit</a>
                                                            <a class="btn btn-danger btn-xs deleteProduct"
                                                               data-meal="<?php echo $product['meal']; ?>"
                                                               data-product="<?php echo $product['id']; ?>">Delete</a>
                                                        </td>
                                                    </tr>
                                                <?php } ?>
                                                </tbody>
                                            </table>
                                        </td>
                                    </tr>
                                <?php } ?>
                                </tbody>
                            </table>

                        </div> <!-- /content -->
                    </div><!-- /x-panel -->
                </div> <!-- /col -->
            </div> <!-- /row -->
             <!-- /row -->
        </div>
    </div> <!-- /.col-right -->
    <!-- /page content -->

<?php $this->load->view('admin/partials/admin_footer'); ?>
<script src="<?php echo base_url("assets/vendors/datatables.net/js/jquery.dataTables.min.js"); ?>"></script>

<script>
    $(document).ready(function () {
        $(".open").click(function () {
            $(this).closest("tr").next().toggle();
        });

        $('.deleteProduct').on('click', deleteProduct);

        function deleteProduct(){
            var meal_id=$(this).attr('data-meal');
            var product_id=$(this).attr('data-product');


            $.ajax({
                type: 'POST',
                url: "<?php echo base_url('admin/meal/apiDeleteProductForMeal'); ?>",
                data: {'meal_id': meal_id, 'product_id': product_id},
                dataType: 'json',
                success: function (data) {
                    if(data.status==="success"){
                        swal({
                            title: "Success",
                            text:  "Le produit a été bien supprimé",
                            type: "success",
                            timer: 1500,
                            showConfirmButton: false
                        });
                    }
                },
                error: function (data) {
                    console.log("error");
                    console.log(data);
                }
            });
        }


    });

</script>

<script>
    $(document).ready(function () {
        var handleDataTableButtons = function () {
            if ($("#datatable-responsive").length) {
                $("#datatable-responsive").DataTable({
                    aaSorting: [[0, 'desc']],
                    responsive: true,
                });
            }
        };

        TableManageButtons = function () {
            "use strict";
            return {

                init: function () {
                    handleDataTableButtons();
                }
            };
        }();

        TableManageButtons.init();
    });
</script>
