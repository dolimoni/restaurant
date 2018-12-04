<?php $this->load->view('admin/partials/admin_header.php'); ?>
<style>

</style>
<!-- page content -->
<div class="right_col" role="main">
    <div class="">
        <div class="page-title">
        </div>
        <div class="clearfix"></div>
        <hr>
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2><?= lang("list_products_stock"); ?></h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                            <li><a class="close-link"><i class="fa fa-close"></i></a></li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content table-responsive">
                        <table id="datatable-products" class="table table-striped" id="searchTable">
                            <thead>
                                <th>
                                    Id
                                </th>
                                <th>
                                    <?= lang("product"); ?>
                                </th>
                                <th>
                                    <?= lang("quantity"); ?>
                                </th>
                                <th>
                                    <?= lang("unit"); ?>
                                </th>
                                <th>
                                    <?= lang("unit_price"); ?>
                                </th>
                                <th>
                                    <?= lang("total_price"); ?>
                                </th>
                            </thead>
                            <tfoot>
                                <th>
                                    Id
                                </th>
                                <th>
                                    <?= lang("product"); ?>
                                </th>
                                <th>
                                    <?= lang("quantity"); ?>
                                </th>
                                <th>
                                    <?= lang("unit"); ?>
                                </th>
                                <th>
                                    <?= lang("unit_price"); ?>
                                </th>
                                <th>
                                    <?= lang("total_price"); ?>
                                </th>
                            </tfoot>
                            <tbody>
                            <?php foreach ($products as $product) {
                                $status= $product['min_quantity'] > $product['totalQuantity']?'danger':'success';
                                ?>
                                <tr class="productsList <?php echo $status; ?>">
                                    <td><?php echo $product['product'];?></td>
                                    <td><?php echo $product['name']; ?>
                                        <?php if($params["multi_site"] === "false" && $product["id_master"] >0){ ?>
                                        <sup><i class='fa fa-star color-gold'></i></sup></td>
                                    <?php } ?>
                                    <td>
                                        <?php echo number_format((float)($product['totalQuantity']), 2, '.', ''); ?>
                                    </td>
                                    <td><?php echo $product['unit']; ?></td>
                                    <td><?php echo $product['unit_price']; ?></td>
                                    <td><?php echo $product['sitting_money']; ?></td>
                                </tr>
                            <?php } ?>
                            </tbody>
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
    var swal_success_operation_lang = "<?= lang("swal_success_operation"); ?>";
    var swal_error_lang = "<?= lang("swal_error"); ?>";
    var swal_success_edit_lang = "<?= lang("swal_success_edit"); ?>";
    var swal_warning_delete_lang = "<?= lang("swal_warning_delete"); ?>";
    var swal_success_delete_lang = "<?= lang("swal_success_delete"); ?>";
</script>

<script src="<?php echo base_url("assets/vendors/datatables.net/js/jquery.dataTables.min.js"); ?>"></script>
<script src="https://cdn.datatables.net/buttons/1.5.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.flash.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.print.min.js"></script>

<script>
    $(document).ready(function () {
        var handleDataTableButtons = function () {
            if ($("#datatable-products").length) {
                $("#datatable-products").DataTable({
                    lengthMenu: [[-1, 10, 1000, 2000], ["All", 10, 1000, 2000 ]],
                    aaSorting: [[0, 'asc']],
                    responsive: true,
                    dom: 'Bfrtip',
                    buttons: [
                        {
                            extend: 'excel',
                            text: 'Exporter Excel',
                            className: 'btn btn-info'
                        }
                    ],
                    "language": {
                        "url": "<?php echo base_url("assets/vendors/datatables.net/French.json"); ?>"
                    }
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

