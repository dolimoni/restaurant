<?php $this->load->view('admin/partials/admin_header.php'); ?>
<style>
    .well {
        max-height: 155px;
    }

    .well img {
        max-height: 75px;
        width: 130px;
        height: 126px;
    }
    .benefit{
        background: #6cc;
        color: white;
    }

    .selectGroup {
        min-height: 160px;
    }
</style>
    <!-- page content -->
    <div class="right_col" role="main">
        <div class="">
            <div class="page-title">
                <!--<pre>
                    <?php /*print_r($meals);*/ ?>
                </pre>-->
                <div class="title_left">
                    <h3>Articles</h3>
                </div>
            </div>
            <div class="clearfix"></div>
            <hr>

            <?php
            //Columns must be a factor of 12 (1,2,3,4,6,12)
            $numOfCols = 6;
            $numOfSMCols = 2;
            $rowCount = 0;
            $bootstrapColWidth = 12 / $numOfCols;
            $bootstrapColSMWidth = 12 / $numOfSMCols;
            ?>
            <div class="row">
                <?php
                foreach ($groups as $group) {
                    ?>
                <a href="<?php echo base_url('admin/meal/groupMeals/' . $group['g_id']); ?>">
                    <div class="col-md-<?php echo $bootstrapColWidth; ?> col-sm-4 col-xs-<?php echo $bootstrapColSMWidth; ?>">
                        <div class="well selectGroup" data-id="<?php echo $group['id'] ?>">
                            <img src="<?php echo base_url(); ?>assets/images/<?php echo $group['image'] ?>" alt=""
                                 class="img-responsive">
                            <h4 class="brief text-center"><?php echo $group['g_name'] ?></h4>
                        </div>
                    </div>
                    <?php
                    $rowCount++;
                    if ($rowCount % $numOfCols == 0) echo '</div><div class="row">';
                }
                ?>
                </a>
            </div>


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
                        <div class="row">
                            <div class="col-md-3 col-sm-6 col-xs-12">
                                <label for="exampleInputName2">Rechercher</label>
                                <input type="text" placeholder="Nom du produit" class="form-control" id="searchInput"
                                       onkeyup="myFunction()">
                            </div>
                            <div class="col-md-offset-5 col-md-4 col-sm-6 col-xs-12 text-center">
                                <label for="exampleInputName2">Fiches Techniques complétées</label>
                                <b><div style="font-size: 20px;"><?php echo count($hasAtLeasOneProduct) . "/" . count($meals); ?></div></b>
                            </div>
                        </div>
                        <div class="x_content table-responsive">
                            <table id="datatable-responsivee"
                                   class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0"
                                   width="100%">
                                <thead>
                                <tr>
                                    <th class="md-hidden-only">Id</th>
                                    <th>Nom</th>
                                    <th class="sm-hidden">Famille</th>
                                    <th>Prix de vente</th>
                                    <?php if ($this->session->userdata('type') !== "cuisine") : ?>
                                    <th class="danger">Coût de revient</th>
                                    <th class="benefit">Bénifices</th>
                                    <?php endif; ?>
                                    <th width="20%">Action</th>
                                </tr>
                                </thead>
                                <tfoot>
                                <tr>
                                    <th class="md-hidden-only">Id</th>
                                    <th>Nom</th>
                                    <th class="sm-hidden">Famille</th>
                                    <th>Prix de vente</th>
                                    <?php if ($this->session->userdata('type') !== "cuisine") : ?>
                                    <th class="danger">Coût de revient</th>
                                    <th class="benefit">Bénifices</th>
                                    <?php endif; ?>
                                    <th>Action</th>
                                </tr>
                                </tfoot>
                                <tbody>
                                <?php foreach ($meals as $meal) { ?>
                                    <tr class="productsList">
                                        <td class="md-hidden-only"><?php echo $meal['meal_id']; ?></td>
                                        <td><?php echo $meal['meal_name']; ?></td>
                                        <td class="sm-hidden"><?php echo $meal['g_name']; ?></td>
                                        <td><?php echo $meal['sellPrice']; ?></td>
                                    <?php if ($this->session->userdata('type') !== "cuisine") : ?>
                                        <td class="danger"><?php echo number_format((float)($meal['cost']), 2, '.', ''); ?></td>
                                        <td class="benefit"><?php echo number_format((float)($meal['profit']), 2, '.', ''); ?></td>
                                    <?php endif; ?>
                                        <td>
                                            <a href=" <?php echo base_url(); ?>admin/meal/edit/<?php echo $meal['meal_id']; ?>"
                                               class="btn btn-primary  btn-xs"><i class="fa fa-pencil"></i></a>

                                            <a href=" <?php echo base_url(); ?>admin/meal/view/<?php echo $meal['meal_id']; ?>"
                                               class="btn btn-primary btn-xs"><i class="fa fa-eye"></i></a>

                                    <?php if ($params["acl_page"]["statistic"] or $this->session->userdata('type') === "admin") : ?>
                                            <a href=" <?php echo base_url(); ?>admin/meal/report/<?php echo $meal['meal_id']; ?>"
                                               class="btn btn-success btn-xs"><i class="fa fa-line-chart"></i></a>
                                    <?php endif; ?>

                                            <div class="btn btn-primary btn-xs open"><i class="fa fa-plus-square"></i></div>

                                            <a class="btn btn-danger btn-xs"><i class="fa fa-trash"></i></a>
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
                                                    <th>Quantity</th>
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
                                                    <th>Quantity</th>
                                                </tr>
                                                </tfoot>
                                                <tbody>
                                                <?php foreach ($meal['productsList'] as $product) { ?>
                                                    <tr class="success">
                                                        <td><?php echo $product['id']; ?></td>
                                                        <td><?php echo $product['name']; ?></td>
                                                        <td><?php echo $product['unit_price']; ?></td>
                                                        <td><?php echo $product['mp_quantity']* $meal['quantity'].' '.$product['mp_unit']; ?></td>
                                                        <td><?php echo $product['mp_quantity'] * $product['unit_price']* $product['unitConvert'] * $meal['quantity']; ?></td>
                                                        <td><?php echo $product['consumptionRate'] * 100; ?>%</td>
                                                        <th><?php echo $meal['quantity']; ?></th>
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

<!--Search in table-->
<script>
    function myFunction() {
        var input, filter, table, tr, td, i;
        input = document.getElementById("searchInput");
        filter = input.value.toUpperCase();
        table = document.getElementById("datatable-responsivee");
        console.log(table);
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
