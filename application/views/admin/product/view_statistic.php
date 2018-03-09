<?php $this->load->view('admin/partials/admin_header.php');?>
<?php
$totalQuantity=0;
?>
<style>
    .scroll {
        overflow-y: scroll;
        height: 260px;
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
            <h1 class="count"><?php echo $product["name"]; ?></h1>
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
                <div class="col-md-12">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2>Historique
                                <small>Historique de stock</small>
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
            </div>
            <div class="row">
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
                            <h4>Quantité des produits utitlisés</h4>
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
                                                 style="width: <?php echo round($productConsumptionRate['sum_quantity'] / $report['totalConsumptionQuantity'] * 100); ?>%;">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="w_right w_20">

                                    <span><?php
                                        $l_quantity = $productConsumptionRate['sum_quantity'];
                                        if ($productConsumptionRate['unit'] === 'pcs') {
                                            $l_quantity = number_format((float)$l_quantity, 0, '.', '');
                                        }
                                        echo $l_quantity . ' ';
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
        </div>

    </div>

</div> <!-- /.col-right -->
<!-- /page content -->

<?php $this->load->view('admin/partials/admin_footer'); ?>
<script src="https://code.highcharts.com/highcharts.js"></script>



<script src="<?php echo base_url("assets/vendors/datatables.net/js/jquery.dataTables.min.js"); ?>"></script>
<script src="<?php echo base_url('assets/build2/js/product/statistic.js'); ?>"></script>

<script>
    $(document).ready(function () {
        var handleDataTableButtons = function () {
            if ($("#datatable-quantity").length) {
                $("#datatable-quantity").DataTable({

                    responsive: true,
                    "lengthMenu": [[5, 10, 50, -1], [5, 10, 50, "Tout"]],
                    "language": {
                        "url": "<?php echo base_url("assets/vendors/datatables.net/French.json"); ?>"
                    },
                   /* "bPaginate": false,*/
                    "bLengthChange": false,
                    "bFilter": true,
                    "bInfo": false,
                    "bAutoWidth": false,
                    "searching":false

                });
            }
            if ($("#datatable-department").length) {
                $("#datatable-department").DataTable({

                    responsive: true,
                    "lengthMenu": [[5, 10, 50, -1], [5, 10, 50, "Tout"]],
                    "language": {
                        "url": "<?php echo base_url("assets/vendors/datatables.net/French.json"); ?>"
                    },
                    "bPaginate": false,
                    "bLengthChange": false,
                    "bFilter": true,
                    "bInfo": false,
                    "bAutoWidth": false,
                    "searching": false

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
        $('#editProductForm').submit(function (e) {
            e.preventDefault();

            var newUserQuantity="true";
            var id = $('input[name="id"]').val();
            var name = $('input[name="name"]').val();
            var quantity = $('input[name="quantity"]').val();
            var unit = $('select[name="unit"]').val();
            var unit_price = $('input[name="unit_price"]').val();
            var weightByUnit = $('input[name="weightByUnit"]').val();
            var daily_quantity = $('input[name="daily_quantity"]').val();
            var min_quantity = $('input[name="min_quantity"]').val();
            var lostQuantity = $('input[name="lostQuantity"]').val();
            newUserQuantity = $('input[name="newUserQuantity"]').is(':checked');
            if(lostQuantity=="")lostQuantity= 0;
            var provider = $('select[name=provider]').val();
            var product = {
                'id':id,
                'name': name,
                'quantity': quantity,
                'unit': unit,
                'unit_price': unit_price,
                'weightByUnit': weightByUnit,
                'provider': provider,
                'min_quantity': min_quantity,
                'daily_quantity': daily_quantity,
                'lostQuantity': lostQuantity,
                "newUserQuantity": newUserQuantity,
                'status': 'active'
            };

            $.ajax({
                url: "<?php echo base_url('admin/product/apiEdit'); ?>",
                type: "POST",
                dataType: "json",
                data: {"product": product},
                success: function (data) {
                    if (data.status = "success") {
                        swal({
                            title: "Success",
                            text: "Success",
                            type: "success",
                            timer: 1500,
                            showConfirmButton: false
                        });
                        window.location.href = data.redirect;
                    }
                },
                error: function (data) {

                }
            });
        });

    });


</script>


<!-- bootstrap-daterangepicker -->
<script src="<?php echo base_url('assets/vendors/moment/min/moment.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/vendors/bootstrap-daterangepicker/daterangepicker.js'); ?>"></script>
<script>
    var base_url = "<?php echo base_url(); ?>";
    var product_id = "<?php echo $product['id']; ?>";
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

    inventory(productInventory);

</script>