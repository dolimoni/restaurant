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
                    <div id="reportrange1" class="pull-right"
                         style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc">
                        <i class="glyphicon glyphicon-calendar fa fa-calendar"></i>
                        <span>December 30, 2014 - January 28, 2015</span> <b class="caret"></b>
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
    var rangeLink = "<?php echo base_url('admin/report/apiRange'); ?>";
</script>

<script src="<?php echo base_url('assets/vendors/bootstrap-daterangepicker/daterangepicker.js'); ?>"></script>

<script src="<?php echo base_url('assets/vendors/moment/min/moment.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/vendors/bootstrap-daterangepicker/daterangepicker.js'); ?>"></script>

<!--Statistiques-->
<script src="<?php echo base_url('assets/build/js/canvasjs.min.js'); ?>"></script>
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
            text: 'Précision du stock'
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
    var cb = function (start, end, label) {
        console.log(start.toISOString(), end.toISOString(), label);
        $('#reportrange1 span').html(start.format('YYYY/MM/DD') + ' - ' + end.format('MMMM D, YYYY'));
        console.log(start.format('YYYY/MM/DD'));

        myData = {
            'id':<?php echo $product['id']; ?>,
            'startDate': start.format('YYYY/MM/DD'),
            'endDate': end.format('YYYY/MM/DD')
        };
        $.ajax({
            url: "<?php echo base_url('admin/product/apiStatistics'); ?>",
            type: "POST",
            dataType: "json",
            data: myData,
            success: function (data) {
                if (data.status === "success") {
                    /*****************************CHANGE CONSOMMATION GRAPH****************************************************/
                    //empty quantity graph
                    $('.product-quantity .progress-bar').css({
                        'display': 'none',
                    });
                    $('.product-quantity .w_right span:nth-child(1)').html(0);
                    //price graph
                    var myDataPoints = [];
                    var mealConsumptionRateRange = data.report.productConsumptionRate;
                    inventory(data.report.productInventory);
                    var totalQuantity=0;
                    $.each(mealConsumptionRateRange, function (key, mealConsumptionRateProduct) {
                        totalQuantity+= parseFloat(mealConsumptionRateProduct['sum_quantity']);
                        console.log(totalQuantity);
                        if (mealConsumptionRateProduct['avg_unit_price']) {
                            var total = parseFloat(mealConsumptionRateProduct['avg_unit_price'] * mealConsumptionRateProduct['sum_quantity']);
                            var point = {
                                y: total,
                                label: mealConsumptionRateProduct['name'],
                                unit: 'DH',
                                yRound:total.toFixed(2)
                            };
                            myDataPoints.push(point);
                            if (!$('#quantity_' + mealConsumptionRateProduct['meal']).length) {
                                var productModel = $(".product-quantity-model").clone().removeAttr("hidden");
                                productModel.addClass("widget_summary");
                                productModel.attr('id', 'quantity_' + mealConsumptionRateProduct['product']);
                                productModel.removeClass("product-quantity-model");
                                productModel.find(' .progress-bar').attr('style', 'width: ' + Math.round(mealConsumptionRateProduct['sum_quantity'] / mealConsumptionRateRange['totalQuantity'] * 100) + '%')
                                productModel.find(' .w_right span:nth-child(1)').html(mealConsumptionRateProduct['sum_quantity']);
                                productModel.find(' .w_right span:nth-child(2)').html(" " + mealConsumptionRateProduct['unit']);
                                productModel.find(".w_left.w_25").html(mealConsumptionRateProduct["name"]);
                                $(".productsConsomationList").append(productModel);
                                console.log(productModel);
                            }
                            //change quantity graph
                            $('#quantity_' + mealConsumptionRateProduct['meal'] + ' .progress-bar').attr('style', 'width: ' + Math.round(mealConsumptionRateProduct['sum_quantity'] / mealConsumptionRateRange['totalQuantity'] * 100) + '%')
                            $('#quantity_' + mealConsumptionRateProduct['meal'] + ' .w_right span:nth-child(1)').html(mealConsumptionRateProduct['sum_quantity']);
                        }
                    });
                    $(".product-quantity-total").find(' .w_right span:nth-child(1)').html(parseFloat(totalQuantity).toFixed(2));


                    var chart = new CanvasJS.Chart("chartContainer", {
                        animationEnabled: true,
                        data: [{
                            type: "doughnut",
                            startAngle: 60,
                            //innerRadius: 60,
                            indexLabelFontSize: 17,
                            indexLabel: "{label} - #percent%",
                            toolTipContent: "<b>{label}:</b> {yRound} (#percent%)",
                            dataPoints: myDataPoints
                        }]
                    });
                    chart.render();
                    /*********************************************************************************/

                }
                else {
                    console.log('Error');
                }
            },
            error: function (data) {
            }
        });
    };

    function changeReportData(data) {
        console.log("reportData", data);
        $('.report_amount').html(data['amount'] + 'DH');
        $('.report_cost').html(data['cost'] + 'DH');
        $('.report_profit').html(data['profit'] + 'DH');
        $('.report_lost').html(data['lost']);
        <?php if($params['department'] === "false"){ ?>
        $('.report_quantity').html(data['quantity']);
        <?php }else { ?>
        $('.report_quantity').html(data['quantity'] + '/' + data['prepared']);
        <?php } ?>

        //$('.report_products').html(data['prepared']);
    }
    var optionSet1 = {
        startDate: moment().subtract(29, 'days'),
        endDate: moment(),
        minDate: '01/01/2017',
        maxDate: '12/31/2027',
        showDropdowns: true,
        showWeekNumbers: true,
        timePicker: false,
        timePickerIncrement: 1,
        timePicker12Hour: true,
        ranges: {
            'Aujourd\'hui': [moment(), moment()],
            'Hier': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
            'Dernier 7 jours': [moment().subtract(6, 'days'), moment()],
            'Dernier 30 jours': [moment().subtract(29, 'days'), moment()],
            'Ce mois': [moment().startOf('month'), moment().endOf('month')],
            'Mois précédent': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        },
        opens: 'left',
        buttonClasses: ['btn btn-default'],
        applyClass: 'btn-small btn-primary',
        cancelClass: 'btn-small',
        format: 'MM/DD/YYYY',
        separator: ' to ',
        locale: {
            applyLabel: 'Envoyer',
            cancelLabel: 'Annuler',
            fromLabel: 'From',
            toLabel: 'To',
            customRangeLabel: 'Personnalisé',
            daysOfWeek: ['Lu', 'Ma', 'Me', 'Je', 'Ve', 'Sa', 'Di'],
            monthNames: ['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre'],
            firstDay: 1
        }
    };

    $('#reportrange1 span').html(moment().subtract(29, 'days').format('MMMM D, YYYY') + ' - ' + moment().format('MMMM D, YYYY'));
    $('#reportrange1').daterangepicker(optionSet1, cb);
</script>