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
                <h3>Comparaison des prix</h3>
            </div>
        </div>
        <div class="clearfix"></div>
        <hr>
        <div class="container">
            <!-- /row -->

            <div class="col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Meilleurs prix</h2>
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
                                <th>Produit</th>
                                <th>Prix</th>
                                <th>Fournisseur</th>
                            </tr>
                            </thead>
                            <tfoot>
                            <tr>
                                <th>Produit</th>
                                <th>Prix</th>
                                <th>Fournisseur</th>
                            </tr>
                            </tfoot>
                            <tbody>
                            <?php foreach ($productsPrice as $product) { ?>
                                <tr>
                                    <td><?php echo $product['name']; ?></td>
                                    <td><?php echo $product['unit_price']; ?></td>
                                    <td><?php echo $product['provider']; ?></td>
                                </tr>
                            <?php } ?>
                            </tbody>
                        </table>

                    </div> <!-- /content -->
                </div><!-- /x-panel -->
            </div>

            <div class="col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Liste des prix</h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                            <li><a class="close-link"><i class="fa fa-close"></i></a></li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content table-responsive">
                        <table id="datatable-allPrice" class="table table-striped table-bordered dt-responsive nowrap"
                               cellspacing="0" width="100%">
                            <thead>
                            <tr>
                                <th>Produit</th>
                                <th>Prix</th>
                                <th>Fournisseur</th>
                            </tr>
                            </thead>
                            <tfoot>
                            <tr>
                                <th>Produit</th>
                                <th>Prix</th>
                                <th>Fournisseur</th>
                            </tr>
                            </tfoot>
                            <tbody>
                            <?php foreach ($products as $product) { ?>
                                <tr>
                                    <td><?php echo $product['name']; ?></td>
                                    <td><?php echo $product['unit_price']; ?></td>
                                    <td><?php echo $product['provider']; ?></td>
                                </tr>
                            <?php } ?>
                            </tbody>
                        </table>

                   </div> <!-- /content -->
               </div><!-- /x-panel -->
           </div>
           <div class="col-md-12 col-sm-12 col-xs-12">
               <div class="x_panel">
                   <div class="x_title">
                       <h2>Historique des prix
                           <small>Prix/Fournisseurs</small>
                       </h2>

                       <ul class="nav navbar-right panel_toolbox">
                           <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                           </li>
                           <li><a class="close-link"><i class="fa fa-close"></i></a>
                           </li>
                       </ul>
                       <div id="reportrange" class="pull-right"
                            style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc">
                           <i class="glyphicon glyphicon-calendar fa fa-calendar"></i>
                           <span>December 30, 2014 - January 28, 2015</span> <b class="caret"></b>
                       </div>
                       <div class="pull-right">
                           <input type="text" name="search"  placeholder="Nom du produit" />
                       </div>
                       <div class="clearfix"></div>
                   </div>
                   <div class="x_content2">
                       <div id="graph_area_price" style="width:100%; height:300px;"></div>
                   </div>
               </div>
           </div>
       </div>
    </div>
</div>


<?php $this->load->view('admin/partials/admin_footer'); ?>
<!-- bootstrap-daterangepicker -->
<script src="<?php echo base_url('assets/vendors/moment/min/moment.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/vendors/bootstrap-daterangepicker/daterangepicker.js'); ?>"></script>
<script src="<?php echo base_url('assets/build2/js/dateRangePicker2.js'); ?>"></script>
<!-- morris.js -->
<script src="<?php echo base_url('assets/vendors/raphael/raphael.js'); ?>"></script>
<script src="<?php echo base_url('assets/vendors/morris.js/morris.min.js'); ?>"></script>

<script>
    var rangeLink = "<?php echo base_url('admin/report/apiPriceRange'); ?>";
    start = '2017/01/01';
    end = '2100/12/31';
    // end='2017/11/28';

    var productToCompaire = $('input[name=search]').val();
    myData = {
        'product': productToCompaire,
        'startDate': start,
        'endDate': end
    };
    $(document).on('keyup', 'input[name=search]', function(){
        productToCompaire=$(this).val();
        myData['product']= productToCompaire;
        updateGraph();
    });


    if ($('#graph_area_price').length) {

        var chart = Morris.Area({
            element: 'graph_area_price',
            data: [],
            xkey: 'period',
            lineColors: ['#26B99A', '#34495E', '#ACADAC', '#3498DB'],
            pointSize: 1,
            hideHover: false,
            resize: true,
            behaveLikeLine: true
        });

        updateGraph();


        function updateGraph() {
            $.ajax({
                url: rangeLink,
                type: "POST",
                dataType: "json",
                data: myData,
                success: function (data) {
                    if (data.status === 'success') {

                        var providers = [];
                        $.each(data.providers, function (key, provider) {
                            providers.push(provider['name']);
                        });
                        chart.options.labels = providers;
                        chart.options.ykeys = providers;
                        chart.setData(data.prices); // this will redraw the chart

                    }
                    else {
                        console.log('Error');
                    }
                },
                error: function (data) {
                }
            });
        }

        myData['product'] = "<?php echo $productMultipleProviders["name"]; ?>";
        console.log(myData);
        updateGraph();

    }

</script>


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

            if ($("#datatable-allPrice").length) {
                $("#datatable-allPrice").DataTable({
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

