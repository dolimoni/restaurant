<?php $this->load->view('admin/partials/admin_header.php'); ?>
<!-- page content -->
<div class="right_col" role="main">
    <div class="productsList">

        <!-- /row -->

        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="collapse" id="editAlert">
                    <form id="editAlertForm">
                        <fieldset>
                            <input type="hidden" name="id"/>
                            <div class="row">
                                <div class="col-xs-6">
                                    <br>
                                    <label for="name"><?= lang('quantity'); ?> :</label>
                                    <select disabled="true"  name="product" class="productSelect form-control md-button-v">
                                        <?php foreach ($products as $product) { ?>
                                            <option value="<?php echo $product['id'] ?>">
                                                <?php echo $product['name'] ?>
                                            </option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="col-xs-6">
                                    <br>
                                    <label for="name"><?= lang('quantity'); ?> :</label>
                                    <input type="text" step="any" class="form-control" name="quantity"
                                           placeholder="<?= lang('quantity'); ?>"
                                           required>
                                </div>
                            </div>
                            <br/>
                            <div class="text-right">
                                <input class="btn btn-success" type="submit" name="editAlert" value="Modifier"/>
                            </div>

                        </fieldset>
                    </form>
                    <br>
                </div>
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Historique des entrées sorties</h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                            <li><a class="close-link"><i class="fa fa-close"></i></a></li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content table-products">
                        <div class="table-responsive">
                            <table id="datatable-products" class="table table-striped table-bordered dt-responsive nowrap"
                                   cellspacing="0" width="100%">
                                <thead>
                                <tr>
                                    <th>
                                        Produit
                                    </th>
                                    <th>
                                        Département
                                    </th>
                                    <th>
                                        Quantité
                                    </th>
                                    <th>
                                        Unité
                                    </th>
                                    <th>
                                        Date
                                    </th>
                                    <th>
                                        Type
                                    </th>
                                    <th>
                                        Actions
                                    </th>
                                </tr>
                                </thead>
                                <tfoot>
                                <tr>
                                    <th>
                                        Produit
                                    </th>
                                    <th>
                                        Département
                                    </th>
                                    <th>
                                        Quantité
                                    </th>
                                    <th>
                                        Unité
                                    </th>
                                    <th>
                                        Date
                                    </th>
                                    <th>
                                        Type
                                    </th>
                                    <th>
                                        Actions
                                    </th>
                                </tr>
                                </tfoot>

                                <tbody>
                                <?php foreach ($products as $product) {?>
                                    <tr class="success">
                                        <td><?php echo $product['p_name']; ?></td>
                                        <td><?php echo $product['d_name']; ?></td>
                                        <td><?php echo $product['quantity'] ?></td>
                                        <td><?php echo $product['unit'] ?></td>
                                        <td><?php echo $product['date'] ?></td>
                                        <td>
                                            <?php if($product['type']==="out"){ ?>
                                                <img class="arrow-left correctMeal" src="<?php echo base_url('assets/images/arrow-right.png'); ?>" />
                                            <?php }else{ ?>
                                                <img class="arrow-left correctMeal" src="<?php echo base_url('assets/images/arrow-left.png'); ?>" />
                                            <?php } ?>
                                        </td>
                                        <td>
                                            <div>
                                                <?php if($product['type']==="out"){ ?>
                                                    <button
                                                            data-quantity="<?php echo $product['quantity'] ?>"
                                                            data-id="<?php echo $product['id'] ?>"
                                                            class="btn btn-info btn-xs action editAlert small-button"
                                                            data-type="edit"><span
                                                                class="glyphicon glyphicon-edit"></span></button>
                                                    <button class="btn btn-danger btn-xs action deleteAlert small-button"
                                                            data-id="<?php echo $product['id'] ?>"
                                                            data-type="delete"><span
                                                                class="fa fa-trash"></span></button>
                                                <?php } ?>
                                            </div>
                                        </td>
                                    </tr>
                                <?php } ?>
                                </tbody>
                            </table>

                        </div>
                    </div> <!-- /content -->
                </div><!-- /x-panel -->
            </div> <!-- /col -->
        </div>
    </div>
</div> <!-- /.col-right -->
<!-- /page content -->

<?php $this->load->view('admin/partials/admin_footer'); ?>

<script src="<?php echo base_url("assets/vendors/datatables.net/js/jquery.dataTables.min.js"); ?>"></script>
<script>
    $(document).ready(function () {
        var handleDataTableButtons = function () {
            if ($("#datatable-products").length) {
                $("#datatable-products").DataTable({
                    'sorting': false,
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
    var editStockHistory_url="<?php echo base_url('admin/department/apiEditStockHistory'); ?>";
    var deleteStock_url="<?php echo base_url('admin/department/apiDeleteStock'); ?>";

    var swal_warning_delete_lang = "<?= lang("swal_warning_delete"); ?>";
</script>
<script src="<?php echo base_url('assets/build2/js/department/historyProducts.js') ?>"></script>
