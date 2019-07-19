<?php $this->load->view('admin/partials/admin_header.php');?>
<?php
$totalQuantity=0;
?>
<style>
    .scroll {
        overflow-y: scroll;
        height: 260px;
    }
    .row{
        margin-top: 15px;
        margin-bottom: 15px;
    }
</style>

<!-- page content -->
<div class="right_col" role="main">
    <div class="productsList">
        <div class="page-title">
            <div class="title_left">
                <h3>Statistiques du produit</h3>
            </div>
        </div>
        <div class="clearfix"></div>
        <hr>
        <div class="text-center tile_stats_count">
            <h1 class="count"><a href="<?php echo base_url('admin/product/edit/'.$product['id']) ?>"><?php echo $product["name"]; ?></a> </h1>
        </div>

        <div class="row productsListContent" id="productPanel">

            <div class="row">
                <div class="col-md-12">
                    <div id="reportrange" class="pull-right"
                         style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc">
                        <i class="glyphicon glyphicon-calendar fa fa-calendar"></i>
                        <span>December 30, 2014 - January 28, 2015</span> <b class="caret"></b>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 chart_plot_05_panel">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2>Historique
                                <small>Historique de consommation</small>
                            </h2>
                            <div class="filter">
                            </div>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">
                            <div class="col-xs-12">
                                <div class="demo-container" style="height:280px">
                                    <div id="chart_plot_05" class="demo-placeholder"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 chart_plot_07_panel">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2>Historique
                                <small>Historique de commande</small>
                            </h2>
                            <div class="filter">
                            </div>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">
                            <div class="col-xs-12">
                                <div class="demo-container" style="height:280px">
                                    <div id="chart_plot_07" class="demo-placeholder"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <?php
                $hidden='';
                if(count($report['productConsumptionRate'])===0){
                    $hidden='hidden';
                }

                ?>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <div class="x_panel tile fixed_height_320">
                        <div class="x_title">
                            <h2>Quantités utilisées dans les articles</h2>
                            <ul class="nav navbar-right panel_toolbox">
                                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                </li>
                                <li><a class="close-link"><i class="fa fa-close"></i></a>
                                </li>
                            </ul>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content scroll productsConsomationList">
                            <?php foreach ($report['productConsumptionRate'] as $productConsumptionRate) {
                                $totalQuantity += $productConsumptionRate['sum_quantity'];
                                ?>

                                <div class="widget_summary product-quantity"
                                     id="quantity_<?php echo $productConsumptionRate['meal'] ?>">
                                    <a href="<?php echo base_url("admin/meal/report/" . $productConsumptionRate["meal"]); ?>" class="w_left w_25">
                                        <?php echo $productConsumptionRate['name']; ?>
                                    </a>
                                    <div class="w_center w_55">
                                        <div class="progress">
                                            <div class="progress-bar bg-green" role="progressbar"
                                                 style="width: <?php echo number_format(round($productConsumptionRate['sum_quantity'] / $report['totalConsumptionQuantity'] * 100),2); ?>%;">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="w_right w_20">

                                    <span><?php
                                        $l_quantity = $productConsumptionRate['sum_quantity'];
                                        if ($productConsumptionRate['unit'] === 'pcs') {
                                            $l_quantity = number_format((float)$l_quantity, 0);
                                        }
                                        echo number_format($l_quantity,2) . ' ';
                                        ?>
                                    </span>
                                        <span>
                                        <?php
                                        echo $productConsumptionRate['unit'];
                                        ?>
                                    </span>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                            <?php } ?>
                            <div class="widget_summary product-quantity-total">
                                <div class="w_left w_25">
                                    TOTAL
                                </div>
                                <div class="w_center w_55">
                                    <div class="progress">
                                        <div class="progress-bar bg-green" role="progressbar"
                                             style="width:100%">
                                        </div>
                                    </div>
                                </div>
                                <div class="w_right w_20">

                                    <?php if($totalQuantity>0){ ?>
                                    <span><?php
                                        if ($productConsumptionRate['unit'] === 'pcs') {
                                            $totalQuantity = number_format((float)$l_quantity, 0, '.', '');
                                        }
                                        echo $totalQuantity . ' ';
                                        ?>
                                    </span>
                                    <span>
                                        <?php
                                        echo $productConsumptionRate['unit'];
                                        ?>
                                    </span>
                                    <?php } ?>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                            <div class="product-quantity product-quantity-model" hidden>
                                <div class="w_left w_25"></div>
                                <div class="w_center w_55">
                                    <div class="progress">
                                        <div class="progress-bar bg-green" role="progressbar"
                                             style="width: <?php echo round($productConsumptionRate['sum_quantity'] / $report['totalConsumptionQuantity'] * 100); ?>%;">
                                        </div>
                                    </div>
                                </div>
                                <div class="w_right w_20">

                                    <span>
                                    </span>
                                    <span>
                                    </span>
                                </div>
                                <div class="clearfix"></div>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-sm-6 col-xs-12">
                    <div class="x_panel tile ">
                        <div class="x_title">
                            <h2>Consomation des articles</h2>
                            <ul class="nav navbar-right panel_toolbox">
                                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                </li>
                                <li><a class="close-link"><i class="fa fa-close"></i></a>
                                </li>
                            </ul>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">
                            <div id="chartContainer" style="height:238px; width: 100%;"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12" id="container"></div>
            </div>
            <h2 class="large-title-reverse">Consomation des articles</h2>
            <div class="row">
                <div class="col-xs-12">
                    <div class="table-responsive">
                        <table id="datatable-consumption" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                            <thead>
                            <tr>
                                <th>Produit</th>
                                <th>Quantity</th>
                                <th>Prix</th>
                            </tr>
                            </thead>
                            <tfoot>
                            <tr>
                                <th>Produit</th>
                                <th>Quantity</th>
                                <th>Prix</th>
                            </tr>
                            </tfoot>
                            <tbody>
                            <?php foreach ($report['productConsumptionRate'] as $productConsumptionRate) { ?>
                                <tr>
                                    <td><?php echo $productConsumptionRate['name'];?></td>
                                    <td><?php echo $productConsumptionRate['sum_quantity'].' '.$productConsumptionRate['unit'];?></td>
                                    <td><?php echo $productConsumptionRate['avg_unit_price']*$productConsumptionRate['sum_quantity'].'Dh';?></td>
                                </tr>
                            <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <h2 class="large-title-reverse">Historique des commandes</h2>
            <div class="row">
                <div class="col-xs-12">
                    <div class="table-responsive">
                        <table id="datatable-orders" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                            <thead>
                            <tr>
                                <th>Quantité</th>
                                <th>Prix unitaire</th>
                                <th>Prix totale</th>
                                <th>Fournisseur</th>
                                <th>Date de commande</th>
                            </tr>
                            </thead>
                            <tfoot>
                            <tr>
                                <th>Quantité</th>
                                <th>Prix unitaire</th>
                                <th>Prix totale</th>
                                <th>Fournisseur</th>
                                <th>Date de commande</th>
                            </tr>
                            </tfoot>
                            <tbody>
                            <?php foreach ($product_orders as $product_order) {
                                $totalOrderQuantity=$product_order['quantity'];
                                if($product_order['pack']==='true'){
                                    $totalOrderQuantity= number_format($product_order['quantity'],0).' pack de '.$product_order['piecesByPack'].' pieces';
                                }
                                ?>
                                <tr>
                                    <td><?php echo $totalOrderQuantity ?></td>
                                    <td><?php echo $product_order['od_price'] ?></td>
                                    <td><?php echo $product_order['od_price']*$product_order['quantity'] ?></td>
                                    <td><?php echo $product_order['name'] ?></td>
                                    <td><?php echo $product_order['orderDate'] ?></td>
                                </tr>
                            <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <h2 class="large-title-reverse">Historique des pertes</h2>
            <div class="row">
                <div class="col-xs-12">
                    <div class="table-responsive">
                        <table id="datatable-losts" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                            <thead>
                            <tr>
                                <th>Quantité</th>
                                <th>Type de perte</th>
                            </tr>
                            </thead>
                            <tfoot>
                            <tr>
                                <th>Quantité</th>
                                <th>Prix unitaire</th>
                            </tr>
                            </tfoot>
                            <tbody>
                            <?php foreach ($product_losts as $product_lost) {
                                $lostType='';
                                if($product_lost['type']==='delete'){
                                    $lostType='Suppression de stock';
                                }else if($product_lost['type']==='lost'){
                                    $lostType='Perte manuelle';
                                }else if($product_lost['type']==='init'){
                                    $lostType='Perte à la commande';
                                }else if($product_lost['type']==='inventory'){
                                    $lostType='Inventaire';
                                }
                                ?>
                                <tr>
                                    <td><?php echo $product_lost['quantity']; ?></td>
                                    <td><?php echo $lostType; ?></td>
                                </tr>
                            <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>

    </div>

</div> <!-- /.col-right -->
<!-- /page content -->

<?php $this->load->view('admin/partials/admin_footer'); ?>
<script src="https://code.highcharts.com/highcharts.js"></script>



<script src="<?php echo base_url("assets/vendors/datatables.net/js/jquery.dataTables.min.js"); ?>"></script>





<!-- bootstrap-daterangepicker -->
<script src="<?php echo base_url('assets/vendors/moment/min/moment.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/vendors/bootstrap-daterangepicker/daterangepicker.js'); ?>"></script>
<script>
    var base_url = "<?php echo base_url(); ?>";
    var product_id = "<?php echo $product['id']; ?>";
    var datatable_fr_ulr="<?php echo base_url("assets/vendors/datatables.net/French.json"); ?>";
    <?php
    $js_array = json_encode($report);
    echo "var report = " . $js_array . ";\n";
    ?>
</script>

<script src="<?php echo base_url('assets/vendors/bootstrap-daterangepicker/daterangepicker.js'); ?>"></script>

<script src="<?php echo base_url('assets/vendors/moment/min/moment.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/vendors/bootstrap-daterangepicker/daterangepicker.js'); ?>"></script>

<!--Statistiques-->
<script src="<?php echo base_url('assets/build/js/canvasjs.min.js'); ?>"></script>


<!-- Flot -->
<script src="<?php echo base_url('assets/vendors/Flot/jquery.flot.js'); ?>"></script>
<script src="<?php echo base_url('assets/vendors/Flot/jquery.flot.pie.js'); ?>"></script>
<script src="<?php echo base_url('assets/vendors/Flot/jquery.flot.time.js'); ?>"></script>
<script src="<?php echo base_url('assets/vendors/Flot/jquery.flot.stack.js'); ?>"></script>
<script src="<?php echo base_url('assets/vendors/Flot/jquery.flot.resize.js'); ?>"></script>

<!-- DateJS -->
<script src="<?php echo base_url('assets/vendors/DateJS/build/date.js'); ?>"></script>

<script>
    $(document).ready(function () {

        <?php
        $js_array = json_encode($report['productConsumptionRate']);
        echo "var mealConsumptionRate = " . $js_array . ";\n";
        ?>



        var myDataPoints = [];
        $.each(mealConsumptionRate, function (key, mealConsumptionRateProduct) {
            var total=parseFloat(mealConsumptionRateProduct['avg_unit_price'] * mealConsumptionRateProduct['sum_quantity']);
            var point = {
                y: total,
                label: mealConsumptionRateProduct['name'],
                unit: 'DH',
                yRound: total.toFixed(2)
            };
            myDataPoints.push(point);
        });
        var chart = new CanvasJS.Chart("chartContainer", {
            animationEnabled: true,
            data: [{
                type: "doughnut",
                startAngle: 60,
                //innerRadius: 60,
                indexLabelFontSize: 17,
                indexLabel: "{label} - #percent%",
                toolTipContent: "<b>{label}:</b> {yRound}{unit} (#percent%)",
                dataPoints: myDataPoints
            }]
        });
        chart.render();

    });
</script>


<script>
    <?php
    $js_array = json_encode($productInventory);
    echo "var productInventory = " . $js_array . ";\n";
    ?>

    function inventory(productInventory) {
        console.log("init_inventory");
        var chart = {
            type: 'column'
        };
        var title = {
            text: 'Inventaire'
        };
        var xAxis = {
            categories: ['Historique']
        };
        var yAxis = {
            title: {
                text: "Variations"
            }
        };
        var credits = {
            enabled: false
        };
        var tooltip = {
            formatter: function () {
                var tooltip;
                tooltip = "<b>" + this.series.userOptions.ID + "</b> : " + this.series.name + " " + this.series.userOptions.DELTA;
                return tooltip;
            }
        };
        var series = [];
        $.each(productInventory, function (key, inventory) {
            var color = "#6cc";
            var name = "Gain";
            if (inventory.delta < 0) {
                color = "red";
                name = "Perte";
            }
            var serie = {
                showInLegend: false,
                name: name,
                data: [parseFloat(inventory.delta)],
                color: color,
                IS: inventory.initial_stock,
                FS: inventory.final_stock,
                ID: inventory.inventory_date,
                DELTA: parseFloat(inventory.delta)
            };
            series.push(serie);
        });

        var json = {};
        json.chart = chart;
        json.title = title;
        json.xAxis = xAxis;
        json.yAxis = yAxis;
        json.credits = credits;
        json.series = series;
        json.tooltip = tooltip;
        $('#container').highcharts(json);
    }

    if(productInventory.length>0){
        $('#container').show();
        inventory(productInventory);
    }else{
        $('#container').fadeOut();
    }

</script>


<script src="<?php echo base_url('assets/build2/js/product/statistic.js'); ?>"></script>
