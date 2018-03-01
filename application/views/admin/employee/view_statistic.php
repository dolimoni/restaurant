<?php $this->load->view('admin/partials/admin_header.php'); ?>
<link href="<?php echo base_url("assets/build2/css/custom.min.css"); ?>" rel="stylesheet">
<style>
    .validate {
        background: #26b99a !important;
        color: white;
    }
</style>
<!-- page content -->
<div class="right_col" role="main">
    <div class="">

        <div class="page-title">
          <!--  <div class="title_left">
                <h3>Articles</h3>
            </div>-->
        <div id="reportrange" class="pull-right"
             style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc">
            <i class="glyphicon glyphicon-calendar fa fa-calendar"></i>
            <span>December 30, 2014 - January 28, 2015</span> <b class="caret"></b>
        </div>

        </div>
        <div class="clearfix"></div>
        <div class="container">
            <!-- /row -->
            <div class="col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Statistiques</h2>
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
                                <th>Département</th>
                                <th>Nombre d'employées</th>
                                <th>Salaire totale</th>
                                <th>Total des ventes</th>
                                <th>Salaire moyen par jour</th>
                                <th>Moyen des ventes par jour</th>
                            </tr>
                            </thead>
                            <tfoot>
                            <tr>
                                <th>Département</th>
                                <th>Nombre d'employées</th>
                                <th>Salaire totale</th>
                                <th>Total des ventes</th>
                                <th>Salaire moyen par jour</th>
                                <th>Moyen des ventes par jour</th>
                            </tr>
                            </tfoot>
                            <tbody>
                                <?php foreach ($report as $key => $value){
                                    if(!isset($value["s_amount"])){
                                        $value["s_amount"]=0;
                                        $value["sale_avg"]=0;
                                    }
                                    ?>
                                    <tr>
                                        <td><?php echo $value["name"]; ?></td>
                                        <td><?php echo $value["count_employee"]; ?></td>
                                        <td><?php echo $value["sum_salary"]; ?></td>
                                        <td><?php echo $value["s_amount"]; ?></td>
                                        <td><?php echo $value["salary_avg"]; ?></td>
                                        <td><?php echo $value["sale_avg"]; ?></td>
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
<script src="<?php echo base_url('assets/build2/js/besystem.js'); ?>"></script>

<!-- bootstrap-daterangepicker -->
<script src="<?php echo base_url('assets/vendors/moment/min/moment.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/vendors/bootstrap-daterangepicker/daterangepicker.js'); ?>"></script>


<script>
    var rangeLink = "<?php echo base_url('admin/employee/apiStatistic'); ?>";
    var myStartDate;
    var myEndDate;
</script>
<script src="<?php echo base_url('assets/build2/js/employee/dateRangePicker.js'); ?>"></script>



