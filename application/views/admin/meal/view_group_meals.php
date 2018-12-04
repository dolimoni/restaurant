<?php $this->load->view('admin/partials/admin_header.php'); ?>
<style>
    .benefit {
        background: #6cc;
        color: white;
    }
</style>
    <!-- page content -->
    <div class="right_col" role="main">
        <div class="">
            <div class="page-title">
                <!--<pre>
                    <?php /*print_r($meals);*/?>
                </pre>-->
                <div class="title_left">
                    <h3><?= lang("meals_list") ?></h3>
                </div>
            </div>
            <div class="clearfix"></div>
            <hr>
            <div class="row tile_count">
                <div class="text-center tile_stats_count">
                    <div class="count">
                        <?php
                                echo $group['name'];
                        ?>
                    </div>
                </div>
            </div>
            <div class="row">
                <button type="submit" class="btn btn-success" name="new"
                        onclick="window.location.href='<?php  echo base_url('admin/meal/add/'. $group['id']); ?>'">
                    <span></span> <?= lang("new") ?>
                </button>
                <button type="submit" class="btn btn-warning" name="Fichier"
                        onclick="window.location.href='<?php echo base_url('admin/meal/loadFile/'); ?>'">
                    <span class="fa fa-print"></span> <?= lang("import") ?>
                </button>

                <div class="col-xs-12">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2><?= lang("meals_list") ?></h2>
                            <ul class="nav navbar-right panel_toolbox">
                                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                                <li><a class="close-link"><i class="fa fa-close"></i></a></li>
                            </ul>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content table-responsive">
                            <table id="datatable-responsive1"
                                   class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0"
                                   width="100%">
                                <thead>
                                <tr>
                                    <th class="md-hidden-only">Numéro</th>
                                    <th><?= lang("name") ?></th>
                                    <th><?= lang("sale_price") ?></th>
                                    <th class="danger"><?= lang("cost") ?></th>
                                    <th class="benefit"><?= lang("earnings") ?></th>
                                    <th width="20%">Action</th>
                                </tr>
                                </thead>
                                <tfoot>
                                <tr>
                                    <th class="md-hidden-only">Numéro</th>
                                    <th><?= lang("name") ?></th>
                                    <th><?= lang("sale_price") ?></th>
                                    <th class="danger"><?= lang("cost") ?></th>
                                    <th class="benefit"><?= lang("earnings") ?></th>
                                    <th>Action</th>
                                </tr>
                                </tfoot>
                                <tbody>
                                <?php foreach ($meals as $meal) { ?>
                                    <tr>
                                        <td class="md-hidden-only"><?php echo $meal['m_id']; ?></td>
                                        <td><?php echo $meal['meal_name']; ?></td>
                                        <td><?php echo number_format((float)($meal['sellPrice']), 2, '.', ''); ?></td>
                                        <td class="danger"><?php echo number_format((float)($meal['cost']), 2, '.', ''); ?></td>
                                        <td class="benefit"><?php echo number_format((float)($meal['profit']), 2, '.', ''); ?></td>
                                        <td>
                                            <a href=" <?php echo base_url(); ?>admin/meal/edit/<?php echo $meal['m_id']; ?>"
                                               class="btn btn-primary btn-xs "><i class="fa fa-pencil"></i></a>

                                            <a href=" <?php echo base_url(); ?>admin/meal/view/<?php echo $meal['m_id']; ?>"
                                               class="btn btn-primary btn-xs "><i class="fa fa-eye"></i></a>

                                    <?php if ($params["acl_page"]["statistic"] or $this->session->userdata('type') === "admin") : ?>
                                            <a href=" <?php echo base_url(); ?>admin/meal/report/<?php echo $meal['m_id']; ?>"
                                               class="btn btn-success btn-xs "><i class="fa fa-line-chart"></i></a>
                                    <?php endif; ?>

                                            <div class="btn btn-primary btn-xs  open"><i class="fa fa-plus-square"></i>
                                            </div>

                                            <a data-id="<?php echo $meal['m_id']; ?>" class="btn btn-danger btn-xs  deleteMeal"><i class="fa fa-trash"></i></a>

                                        </td>
                                    </tr>
                                    <tr class="productsRow">
                                        <td colspan="8">
                                            <table class="table">
                                                <thead>
                                                <tr class="info">
                                                    <th>Numéro</th>
                                                    <th><?= lang("name") ?></th>
                                                    <th><?= lang("price") ?></th>
                                                    <th><?= lang("quantity") ?></th>
                                                    <th><?= lang("total_price") ?>></th>
                                                    <th><?= lang("consumption_rate") ?></th>
                                                    <th><?= lang("quantity") ?></th>
                                                </tr>
                                                </thead>
                                                <tfoot>
                                                <tr class="info">
                                                    <th>Numéro</th>
                                                    <th><?= lang("name") ?></th>
                                                    <th><?= lang("price") ?></th>
                                                    <th><?= lang("quantity") ?></th>
                                                    <th><?= lang("total_price") ?>></th>
                                                    <th><?= lang("consumption_rate") ?></th>
                                                    <th><?= lang("quantity") ?></th>
                                                </tr>
                                                </tfoot>
                                                <tbody>
                                                <?php foreach ($meal['productsList'] as $product) { ?>
                                                    <tr class="success">
                                                        <td><?php echo $product['id']; ?></td>
                                                        <td><?php echo $product['name']; ?></td>
                                                        <td><?php echo number_format((float)($product['unit_price']), 2, '.', ''); ?></td>
                                                        <td><?php echo $product['mp_quantity']*$meal['quantity'] . ' ' . $product['mp_unit']; ?></td>
                                                        <td><?php echo $product['mp_quantity'] * $product['unit_price']* $product['unitConvert']* $meal['quantity']; ?></td>
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
    var swal_success_operation_lang = "<?= lang("swal_success_operation"); ?>";
    var swal_error_lang = "<?= lang("swal_error"); ?>";
    var swal_success_edit_lang = "<?= lang("swal_success_edit"); ?>";
    var swal_warning_delete_lang = "<?= lang("swal_warning_delete"); ?>";
    var swal_success_delete_lang = "<?= lang("swal_success_delete"); ?>";
    var swal_warning_obligatory_weight_lang = "<?= lang("swal_warning_obligatory_weight"); ?>";
</script>
<script>
    $(document).ready(function () {
        $(".open").click(function () {
            console.log('herer');
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
                            text: swal_success_delete_lang,
                            type: "success",
                            timer: 1500,
                            showConfirmButton: false
                        });
                        location.reload();
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
<script>
    $(document).ready(function () {
        $('a.deleteMeal').on('click',deleteMeal);


        function deleteMeal() {
            var meal_id = $(this).attr('data-id');
            //$(this).closest('tr').hide();
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
                    $.ajax({
                        url: "<?php echo base_url('admin/meal/apiDeleteMeal'); ?>",
                        type: "POST",
                        dataType: "json",
                        data: {'meal_id': meal_id},
                        success: function (data) {
                            if (data.status === 'success') {
                                swal({
                                    title: "Success",
                                    text: swal_success_delete_lang,
                                    type: "success",
                                    timer: 1500,
                                    showConfirmButton: false
                                });
                                location.reload();
                            }
                            else {
                                swal({
                                    title: "Erreur",
                                    text: swal_error_lang,
                                    type: "error",
                                    timer: 1500,
                                    showConfirmButton: false
                                });
                            }
                        },
                        error: function (data) {
                            swal({
                                title: "Erreur",
                                text: swal_error_lang,
                                type: "error",
                                timer: 1500,
                                showConfirmButton: false
                            });
                        }
                    });

                });



        }
    });
</script>
