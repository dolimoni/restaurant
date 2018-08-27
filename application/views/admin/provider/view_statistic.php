<?php $this->load->view('admin/partials/admin_header.php'); ?>
<link href="<?php echo base_url("assets/build2/css/custom.min.css"); ?>" rel="stylesheet">
<style>
    .validate {
        background: #26b99a !important;
        color: white;
    }

    .myContainer {
        width: 80%;
        margin: 20px auto;
    }
</style>
<!-- page content -->
<div class="right_col" role="main">
    <div class="">

        <div class="page-title">
          <!--  <div class="title_left">
                <h3>Articles</h3>
            </div>-->
           <div class="row">
               <div class="col-xs-12 col-sm-12">
                   <div id="reportrange" class="pull-right"
                        style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc">
                       <i class="glyphicon glyphicon-calendar fa fa-calendar"></i>
                       <span>December 30, 2014 - January 28, 2015</span> <b class="caret"></b>
                   </div>
               </div>
           </div>

        </div>
        <div class="clearfix"></div>
        <!--<pre>
                <?php /*print_r($report); */?>
            </pre>-->
        <hr>
        <div class="row">
            <div class="col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2><?= lang("orders"); ?>
                            <small><?= lang("provider_list"); ?></small>
                        </h2>
                        <div class="filter">
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <div class="col-xs-12">
                            <div class="myContainer">
                                <div>
                                    <canvas id="bar-orders"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">

            <div class="col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2><?= lang("orders"); ?>
                            <small><?= lang("regulation"); ?></small>
                        </h2>
                        <div class="filter">
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <div class="col-xs-12">
                            <div class="myContainer">
                                <div>
                                    <canvas id="bar-ordersPayment"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="x_panel">
                    <div class="x_title">
                        <h2><?= lang("orders"); ?>
                            <small><?= lang("impaid"); ?></small>
                        </h2>
                        <div class="filter">
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <div class="x_content table-responsive">
                            <table id="datatable-impaid"
                                   class="table table-striped table-bordered dt-responsive nowrap"
                                   cellspacing="0" width="100%">
                                <thead>
                                <tr>
                                    <th><?= lang("provider"); ?></th>
                                    <th><?= lang("amount"); ?></th>
                                </tr>
                                </thead>
                                <tfoot>
                                <tr>
                                    <th><?= lang("provider"); ?></th>
                                    <th><?= lang("amount"); ?></th>
                                </tr>
                                </tfoot>
                                <tbody id="tbody">

                                <?php foreach ($impaidOrders as $impaidOrder) { ?>
                                    <tr>
                                        <td><a href="<?php echo base_url("admin/provier/show"+ $impaidOrder["p_id"]); ?>"><?php echo $impaidOrder["name"]; ?></a></td>
                                        <td><?php echo $impaidOrder["amount"]; ?></td>
                                    </tr>
                                <?php } ?>
                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>

                <div class="x_panel">
                    <div class="x_title">
                        <h2>Commandes à payer
                            <small>Commandes à payer</small>
                        </h2>
                        <div class="filter">
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <div class="x_content table-responsive">
                            <table id="datatable-topay"
                                   class="table table-striped table-bordered dt-responsive nowrap"
                                   cellspacing="0" width="100%">
                                <thead>
                                <tr>
                                    <th><?= lang("provider"); ?></th>
                                    <th><?= lang("amount"); ?></th>
                                </tr>
                                </thead>
                                <tfoot>
                                <tr>
                                    <th><?= lang("provider"); ?></th>
                                    <th><?= lang("amount"); ?></th>
                                </tr>
                                </tfoot>
                                <tbody id="tbody">

                                <?php foreach ($ordersToPay as $orderToPay) { ?>
                                    <tr>
                                        <td><a href="<?php echo base_url("admin/provier/show/".$orderToPay["p_id"]); ?>"><?php echo $orderToPay["name"]; ?></a></td>
                                        <td><?php echo $orderToPay["amount"]; ?></td>
                                    </tr>
                                <?php } ?>
                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>
</div>

<?php $this->load->view('admin/partials/admin_footer'); ?>
<script src="<?php echo base_url("assets/vendors/datatables.net/js/jquery.dataTables.min.js"); ?>"></script>
<!-- bootstrap-daterangepicker -->
<script src="<?php echo base_url('assets/vendors/moment/min/moment.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/vendors/bootstrap-daterangepicker/daterangepicker.js'); ?>"></script>
<!-- Flot -->
<script src="<?php echo base_url('assets/vendors/Flot/jquery.flot.js'); ?>"></script>
<script src="<?php echo base_url('assets/vendors/Flot/jquery.flot.pie.js'); ?>"></script>
<script src="<?php echo base_url('assets/vendors/Flot/jquery.flot.time.js'); ?>"></script>
<script src="<?php echo base_url('assets/vendors/Flot/jquery.flot.stack.js'); ?>"></script>
<script src="<?php echo base_url('assets/vendors/Flot/jquery.flot.resize.js'); ?>"></script>


<!-- DateJS -->
<script src="<?php echo base_url('assets/vendors/DateJS/build/date.js'); ?>"></script>




<!-- ECharts -->
<script src="<?php echo base_url('assets/vendors/echarts/dist/echarts.js'); ?>"></script>

<script src="<?php echo base_url('assets/vendors/raphael/raphael.js'); ?>"></script>
<script src="<?php echo base_url('assets/vendors/morris.js/morris.js'); ?>"></script>


<script>
    var base_url = "<?php echo base_url(''); ?>";
    var statisticLink = "<?php echo base_url('admin/provider/apiStatistic'); ?>";
    var datatableFrench = "<?php echo base_url("assets/vendors/datatables.net/French.json"); ?>";

    var swal_success_operation_lang = "<?= lang("swal_success_operation"); ?>";
    var swal_error_lang = "<?= lang("swal_error"); ?>";
    var swal_success_edit_lang = "<?= lang("swal_success_edit"); ?>";
    var swal_warning_delete_lang = "<?= lang("swal_warning_delete"); ?>";
    var swal_success_delete_lang = "<?= lang("swal_success_delete"); ?>";

    var paid_lang = "<?= lang("paid"); ?>";
    var impaid_lang = "<?= lang("impaid"); ?>";
    var top_providers_orders_lang = "<?= lang("top_providers_orders"); ?>";

</script>
<script src="<?php echo base_url('assets/build/js/canvasjs.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/build2/js/provider/statistics.js'); ?>"></script>