<?php $this->load->view('partials/admin_header.php'); ?>

<link href="<?php echo base_url("assets/build/css/main.css"); ?>" rel="stylesheet">
<!-- page content -->
<div class="right_col" role="main">
    <div class="productsList">
        <div class="page-title">
            <div class="title_left">
                <h3>Liste des chambres</h3>
            </div>
        </div>
         <!-- /row -->
    </div>

    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <!--  <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                      <li><a class="close-link"><i class="fa fa-close"></i></a></li>
                  </ul>-->
                <div id="reportrange" class="pull-right"
                     style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc">
                    <i class="glyphicon glyphicon-calendar fa fa-calendar"></i>
                    <span>December 30, 2014 - January 28, 2015</span> <b class="caret"></b>
                </div>

                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <table class="table table-striped">
                    <tr>
                        <th>
                            N°
                        </th>
                        <th>
                            Nombre de lits
                        </th>
                        <th>
                            Nombre de persoones
                        </th>
                        <th>
                            Logement
                        </th>
                        <th>
                            Avance
                        </th>
                        <th>
                            Report
                        </th>
                        <th>
                            Autre
                        </th>
                        <th>
                            Observation
                        </th>
                        <th>
                            Actions
                        </th>
                    </tr>
                    <tbody id="tbodyid">
                        <?php include('include/table_room_rows.php');?>
                    </tbody>


                </table>
            </div> <!-- /content -->
        </div><!-- /x-panel -->
    </div>
</div>




<?php $this->load->view('partials/admin_footer'); ?>


