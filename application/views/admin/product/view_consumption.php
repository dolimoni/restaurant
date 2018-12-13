<?php $this->load->view('admin/partials/admin_header.php'); ?>
<!-- page content -->
<div class="right_col" role="main">
    <div class="">
        <div class="page-title">
            <div class="row">
                <div class="col-xs-8 col-sm-12">
                    <div id="reportrange" class="pull-right"
                         style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc">
                        <i class="glyphicon glyphicon-calendar fa fa-calendar"></i>
                        <span>December 30, 2014 - January 28, 2015</span> <b class="caret"></b>
                    </div>
                </div>
            </div>
        </div>
        <div class="clearfix"></div>
        <hr>
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Quantité de consummation</h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                            <li><a class="close-link"><i class="fa fa-close"></i></a></li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <!--<div class="row">
                        <div class="col-md-3 col-sm-6 col-xs-12">
                            <label for="exampleInputName2">Rechercher</label>
                            <input type="text" placeholder="Nom du produit" class="form-control" id="searchInput" onkeyup="myFunction()">
                        </div>
                    </div>-->
                    <div class="x_content table-responsive">
                        <table class="table table-striped" id="searchTable">
                            <thead>
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
                                <th width="40%">
                                    Actions
                                </th>
                            </tr>
                            </thead>
                            <tfoot>
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
                                <th width="40%">
                                    Actions
                                </th>
                            </tr>
                            </tfoot>
                            <tbody id="tbody">
                            <?php foreach ($products as $product) {?>
                                <tr class="productsList success">
                                    <td><?php echo $product['p_id']; ?></td>
                                    <td><?php echo $product['name']; ?></td>
                                    <td>
                                        <?php echo number_format((float)($product['cp_quantity']), 2, '.', '').' '.$product['unit']; ?>
                                    </td>
                                    <td>
                                        <?php if ($params["acl_page"]["acl_write"] or $this->session->userdata('type') === "admin") : ?>
                                            <a href="<?php echo base_url('admin/product/edit/' . $product['p_id']); ?>"
                                               class="btn btn-primary btn-xs">Modifier</a>
                                        <?php endif; ?>

                                        <?php if ($params["acl_page"]["statistic"] or $this->session->userdata('type') === "admin") : ?>
                                            <a href="<?php echo base_url('admin/product/statistic/' . $product['p_id']); ?>"class="btn btn-warning btn-xs">Statistiques</a>
                                        <?php endif; ?>
                                    </td>
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
<script src="<?php echo base_url("assets/vendors/datatables.net/js/jquery.dataTables.min.js"); ?>"></script>
<script src="https://cdn.datatables.net/buttons/1.5.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.flash.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.print.min.js"></script>

<script>
    var productsTable;
    $(document).ready(function () {
        var handleDataTableButtons = function () {

            if ($("#searchTable").length) {
                productsTable=$("#searchTable").DataTable({
                    "columns": [
                        {"data": "id"},
                        {"data": "name"},
                        {"data": "quantity"},
                        {"data": "actions"}
                    ],
                    responsive: true,
                    "language": {
                        "url": "<?php echo base_url("assets/vendors/datatables.net/French.json"); ?>"
                    },
                    dom: 'Bfrtip',
                    buttons: [
                        {
                            extend: 'excel',
                            text: 'Exporter Excel',
                            className: 'btn btn-info',
                            exportOptions: {
                                columns: 'th:not(:last-child)'
                            }
                        }
                    ]
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
    var consumptionLink = "<?php echo base_url("admin/product/apiConsumption"); ?>";
    var baseUrl = "<?php echo base_url(); ?>";
</script>
<script src="<?php echo base_url('assets/vendors/moment/min/moment.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/vendors/bootstrap-daterangepicker/daterangepicker.js'); ?>"></script>
<script src="<?php echo base_url('assets/build2/js/product/consumption.js'); ?>"></script>


