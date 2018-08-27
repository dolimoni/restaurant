<?php $this->load->view('admin/partials/admin_header.php'); ?>
<style>
    .profile_details:nth-child(3n) {
        clear: none;
    }
    input[name=search]{
        height: 31px;
        margin-right: 11px;
    }
</style>
<!-- page content -->
<div class="right_col" role="main">
    <div class="productsList">
        <div class="page-title">
            <div class="title_left">
                <h3><?= lang("history_of_orders") ?></h3>
            </div>
        </div>
        <div class="clearfix"></div>
        <hr>
        <div class="container">
            <!-- /row -->


            <div class="col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2><?= lang("orders_list") ?></h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                            <li><a class="close-link"><i class="fa fa-close"></i></a></li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content table-responsive">
                        <table id="datatable-bestPrice" class="table table-striped table-bordered dt-responsive nowrap"
                               cellspacing="0" width="100%">
                            <thead>
                            <tr>
                                <th><?= lang("number_of_order") ?></th>
                                <th><?= lang("provider") ?></th>
                                <th><?= lang("amount") ?></th>
                                <th><?= lang("status") ?></th>
                                <th><?= lang("regulation") ?></th>
                                <th><?= lang("date_of_order") ?></th>
                            </tr>
                            </thead>
                            <tfoot>
                            <tr>
                                <th>Numéro de la commande</th>
                                <th>Fournisseur</th>
                                <th>Montant</th>
                                <th>Status</th>
                                <th>Réglement</th>
                                <th>Date de la commande</th>
                            </tr>
                            </tfoot>
                            <tbody>
                            <?php foreach ($orders as $order) {
                                $status= lang('pending');
                                $paid= lang('impaid');
                                if(strtoupper($order['status'])==="RECEIVED"){
                                    $status= lang('received');
                                }else if(strtoupper($order['status']) === "CANCELED"){
                                    $status = lang('canceled');
                                }

                                if(strtoupper($order['paid'])==="TRUE"){
                                    $paid= lang('paid');
                                }
                            ?>
                                <tr>
                                    <td><?php echo $order['id']; ?></td>
                                    <td><a href="<?php echo base_url('admin/provider/show/'.$order['pv_id']);?>"><?php echo $order['pv_name']; ?></a> </td>
                                    <td><?php echo $order['amount']; ?></td>
                                    <td><?php echo $status; ?></td>
                                    <td><?php echo $paid; ?></td>
                                    <td><?php echo $order['orderDate']; ?></td>
                                </tr>
                            <?php } ?>
                            </tbody>
                        </table>

                    </div> <!-- /content -->
                </div><!-- /x-panel -->
            </div>
       </div>
    </div>
</div>


<?php $this->load->view('admin/partials/admin_footer'); ?>




<script src="<?php echo base_url("assets/vendors/datatables.net/js/jquery.dataTables.min.js"); ?>"></script>
<script>
    $(document).ready(function () {
        var handleDataTableButtons = function () {
            if ($("#datatable-bestPrice").length) {
                $("#datatable-bestPrice").DataTable({
                    aaSorting: [[0, 'desc']],
                    responsive: true,
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

