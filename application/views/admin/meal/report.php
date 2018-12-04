<?php $this->load->view('admin/partials/admin_header.php'); ?>
<style>
    .scroll {
        overflow-y: scroll;
        height: 260px;
    }
</style>
<?php
if (!isset($report['s_cost'])) {
    //header('Location:' . base_url('admin/report/index'));
}
?>
<div class="container body">
    <div class="main_container">


        <!-- top navigation -->

        <!-- /top navigation -->

        <!-- page content -->
        <div class="right_col" role="main">
            <!-- top tiles -->
            <div class="row">


                <div class="col-md-12">
                    <div id="reportrange1" class="pull-right"
                         style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc">
                        <i class="glyphicon glyphicon-calendar fa fa-calendar"></i>
                        <span>December 30, 2014 - January 28, 2015</span> <b class="caret"></b>
                    </div>
                </div>
            </div>
            <div class="row tile_count">
                <div class="col-md-3 col-sm-4 col-xs-12 tile_stats_count">
                    <span class="count_top"><i class="fa fa-user"></i> <?= lang('total_sale') ?></span>
                    <div class="count report_amount"><?php echo number_format((float)$report['amount'] * $report['s_quantity'], 2, '.', ''); ?>
                        DH
                    </div>
                    <!-- <span class="count_bottom"><i class="green">4% </i> From last Week</span>-->
                </div>
                <div class="col-md-3 col-sm-4 col-xs-12 tile_stats_count">
                    <span class="count_top"><i class="fa fa-user"></i><?= lang('cost_price') ?></span>
                    <div class="count red report_cost"><?php echo number_format((float)($report['s_cost']), 2, '.', ''); ?>
                        DH
                    </div>
                    <!-- <span class="count_bottom"><i class="green"><i
                                 class="fa fa-sort-asc"></i>34% </i> From last Week</span>-->
                </div>
                <div class="col-md-3 col-sm-4 col-xs-12 tile_stats_count">
                    <span class="count_top"><i class="fa fa-user"></i> <?= lang('earnings') ?></span>
                    <div class="count green report_profit"><?php echo number_format((float)($report['amount'] * $report['s_quantity'] - $report['s_cost']), 2, '.', ''); ?>
                        DH
                    </div>
                    <!--  <span class="count_bottom"><i class="red"><i
                                  class="fa fa-sort-desc"></i>12% </i> From last Week</span>-->
                </div>
                <div class="col-md-3 col-sm-4 col-xs-12 tile_stats_count">
                    <span class="count_top"><i class="fa fa-clock-o"></i> <?= lang('sales') ?></span>
                    <?php if($params['department']==="false" or $params['showDepartmentContent'] === "false"){ ?>
                    <div class="count report_quantity"><?php echo number_format((float)$report['s_quantity'], 0, '.', ''); ?></div>
                    <?php } else { ?>
                    <div class="count report_quantity"><?php echo number_format((float)$report['s_quantity'], 0, '.', ''); ?>
                        /<?php echo($report['prepared_quantity']); ?></div>
                    <?php }?>

               <!-- <div class="col-md-1 col-sm-4 col-xs-12 tile_stats_count">
                    <span class="count_top">Préparations</span>
                    <div class="count report_products"></div>
                </div>-->

                <!--<div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
                    <span class="count_top"><i class="fa fa-user"></i> Total Connections</span>
                    <div class="count">7,325</div>
                    <span class="count_bottom"><i class="green"><i
                                class="fa fa-sort-asc"></i>34% </i> From last Week</span>
                </div>-->
            </div>

            <!-- /top tiles -->

            <div class="row tile_count">
                <div class="text-center tile_stats_count">
                    <div class="count"><?php echo $meal['name']; ?></div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="dashboard_graph">

                        <div class="row x_title">
                            <div class="col-md-6">
                                <h3><?= lang('earnings_report') ?>
                                    <small><?= lang('expense') ?>-<?= lang('sales') ?>-<?= lang('earn') ?></small>
                                </h3>
                            </div>
                        </div>

                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div id="chart_plot_01" class="demo-placeholder" hidden></div>
                            <div id="chartContainer1" style="height: 370px; width: 100%;" hidden></div>
                        </div>

                        <div class="clearfix"></div>
                    </div>
                </div>

            </div>
            <br/>

            <div class="row">


                <div class="col-md-6 col-sm-6 col-xs-12">
                    <div class="x_panel tile fixed_height_320">
                        <div class="x_title">
                            <h2><?= lang('used_products_quantity') ?></h2>
                            <ul class="nav navbar-right panel_toolbox">
                                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                </li>
                                <li><a class="close-link"><i class="fa fa-close"></i></a>
                                </li>
                            </ul>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content scroll productsConsomationList">
                            <h4><?= lang('used_products_quantity') ?></h4>
                            <?php foreach ($report['mealConsumptionRate'] as $mealConsumptionRate) { ?>

                                <div class="widget_summary product-quantity"
                                     id="quantity_<?php echo $mealConsumptionRate['product'] ?>">
                                    <a class="w_left w_25" href="<?php echo base_url("admin/product/statistic/" . $mealConsumptionRate["product"]); ?>">
                                            <?php echo $mealConsumptionRate['name']; ?>
                                    </a>

                                    <div class="w_center w_55">
                                        <div class="progress">
                                            <div class="progress-bar bg-green" role="progressbar"
                                                 style="width: <?php echo round($mealConsumptionRate['sum_quantity'] / $report['totalConsumptionQuantity'] * 100); ?>%;">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="w_right w_20">

                                    <span><?php
                                        $l_quantity = $mealConsumptionRate['sum_quantity'];
                                        $weightByUnit = $mealConsumptionRate['weightByUnit'];
                                        if ($mealConsumptionRate['unit'] === 'pcs') {
                                            $l_quantity = number_format((float)($l_quantity), 2, '.', '');
                                            $zero_quantity=false;
                                            if($l_quantity<=0){
                                                $l_quantity=1;
                                                $weightByUnit=0;
                                                $zero_quantity=true;
                                            }
                                            if($weightByUnit>0){
                                                $l_quantity=number_format((float)($weightByUnit/$l_quantity), 2, '.', '');
                                            }
                                            if($zero_quantity){
                                                $l_quantity=0;
                                            }
                                        }
                                        echo $l_quantity . ' ';
                                        ?>
                                    </span>
                                        <span>
                                        <?php
                                        echo $mealConsumptionRate['unit'];
                                        ?>
                                    </span>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                            <?php } ?>
                            <div class="product-quantity product-quantity-model" hidden>
                                <div class="w_left w_25">
                                </div>
                                <div class="w_center w_55">
                                    <div class="progress">
                                        <div class="progress-bar bg-green" role="progressbar"
                                             <?php
                                                $width = 0;
                                                if($report['totalConsumptionQuantity']<=0){
                                                    $report['totalConsumptionQuantity']=1;
                                                    //$width=round($mealConsumptionRate['sum_quantity'] / $report['totalConsumptionQuantity'] * 100);
                                                }
                                             ?>
                                             style="width: <?php echo 50; ?>%;">
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
                            <h2><?= lang('consumption_products') ?></h2>
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


                <div class="col-xs-12">
                    <h3>Historique de consommation</h3>
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
                            <?php foreach ($report['mealConsumptionRate'] as $mealConsumptionRate) { ?>
                                <tr>
                                    <td><?php echo $mealConsumptionRate['name'];?></td>
                                    <td><?php echo $mealConsumptionRate['sum_quantity'].' '.$mealConsumptionRate['unit'];?></td>
                                    <td><?php echo $mealConsumptionRate['avg_unit_price']*$mealConsumptionRate['sum_quantity'].'Dh';?></td>
                                </tr>
                            <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="col-xs-12">
                    <h3>Historique des pertes</h3>
                    <div class="table-responsive">
                        <table id="datatable-losts" class="table table-striped table-bordered dt-responsive nowrap mgrt10" cellspacing="0" width="100%">
                            <thead>
                            <tr>
                                <th>Quantity</th>
                                <th>Date</th>
                            </tr>
                            </thead>
                            <tfoot>
                            <tr>
                                <th>Quantity</th>
                                <th>Date</th>
                            </tr>
                            </tfoot>
                            <tbody>
                            <?php foreach ($report['losts_list'] as $lost) { ?>
                                <tr>
                                    <td><?php echo $lost['s_lost'];?></td>
                                    <td><?php echo $lost['createdAt'];?></td>
                                </tr>
                            <?php } ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-md-6 col-sm-12 col-xs-12 text-center hide">
                        <h3 class="count_top" style="display:  inline-block;"><?= lang("lost"); ?></h3>
                        <h3 class="count_top report_lost" style="display:  inline-block;"><?php echo number_format((float)$report['s_lost'], 0, '.', ''); ?></h3>
                    </div>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <div class="col-md-6">
                            <h4 style="display: inline;"><?= lang("add_lost"); ?> : </h4>
                        </div>
                        <div class="col-md-3">
                            <input class="form-control" type="number"name="lostQuantity"/>
                        </div>
                        <div class="col-md-3">
                            <button class="btn btn-info lostQuantityButton"><?= lang("confirme"); ?></button>
                        </div>
                    </div>
                </div>

            </div>


        </div>
        <!-- <footer>
             <div class="pull-right">
                 Gentelella - Bootstrap Admin Template by <a href="https://colorlib.com">Colorlib</a>
             </div>
             <div class="clearfix"></div>
         </footer>-->
    </div>
</div>
<?php $this->load->view('admin/partials/admin_footer'); ?>

    <script>
        var tableConsumption;
        var apiEvolutionRange_url="<?php echo base_url("admin/meal/apiEvolutionRange") ?>";
        var meal_id="<?php echo $meal['id'] ?>";
        var cost_lang = "<?= lang("cost") ?>";
        var sales_lang = "<?= lang("sales") ?>";
        var earnings_lang = "<?= lang("earnings") ?>";
        var price_in_dh_lang = "<?= lang("price_in_dh") ?>";
    </script>

    <script src="<?php echo base_url("assets/vendors/datatables.net/js/jquery.dataTables.min.js"); ?>"></script>

    <!-- bootstrap-daterangepicker -->
<script src="<?php echo base_url('assets/vendors/moment/min/moment.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/vendors/bootstrap-daterangepicker/daterangepicker.js'); ?>"></script>
<script>
    var rangeLink = "<?php echo base_url('admin/report/apiRange'); ?>";
</script>

<script src="<?php echo base_url('assets/vendors/bootstrap-daterangepicker/daterangepicker.js'); ?>"></script>

<script src="<?php echo base_url('assets/vendors/Flot/jquery.flot.js'); ?>"></script>
<script src="<?php echo base_url('assets/vendors/Flot/jquery.flot.pie.js'); ?>"></script>
<script src="<?php echo base_url('assets/vendors/Flot/jquery.flot.time.js'); ?>"></script>
<script src="<?php echo base_url('assets/vendors/Flot/jquery.flot.stack.js'); ?>"></script>
<script src="<?php echo base_url('assets/vendors/Flot/jquery.flot.resize.js'); ?>"></script>
<script>
    window.onload = function () {

        <?php
        $js_array = json_encode($report['mealConsumptionRate']);
        echo "var mealConsumptionRate = " . $js_array . ";\n";
        ?>

        var myDataPoints = [];
        $.each(mealConsumptionRate, function (key, mealConsumptionRateProduct) {
            var point = {
                y: mealConsumptionRateProduct['avg_unit_price'] * mealConsumptionRateProduct['sum_quantity'],
                label: mealConsumptionRateProduct['name'],
                unit: 'DH'
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
                toolTipContent: "<b>{label}:</b> {y}{unit} (#percent%)",
                dataPoints: myDataPoints
            }]
        });
        chart.render();

    }
</script>
<script src="<?php echo base_url('assets/build/js/canvasjs.min.js'); ?>"></script>


<script src="<?php echo base_url('assets/vendors/flot.orderbars/js/jquery.flot.orderBars.js'); ?>"></script>


<script src="<?php echo base_url('assets/build2/js/custom.js'); ?>"></script>
<script src="<?php echo base_url('assets/vendors/flot-spline/js/jquery.flot.spline.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/vendors/flot.curvedlines/curvedLines.js'); ?>"></script>

<script src="<?php echo base_url('assets/vendors/DateJS/build/date.js'); ?>"></script>
<script src="<?php echo base_url('assets/vendors/gauge.js/dist/gauge.min.js'); ?>"></script>


<script>
    var daysInReport =<?php echo $report['rds']; ?>;

    var myData = {
        'id':<?php echo $meal['id'];?>,
    };
    var apiEvolutionRange_url="<?php echo base_url('admin/meal/apiEvolutionRange'); ?>";
    params={
        'swal':'false',
        'callable':true,
        'reload':false,
        'callbackdata':null
    };
    apiRequest(apiEvolutionRange_url,myData,params,apiEvolutionRangeCallback);


    // add lost quantity

    $('.lostQuantityButton').on('click', lostQuantityEvent);
    function lostQuantityEvent() {
        lostQuantity = $('input[name="lostQuantity"]').val();
        if (lostQuantity > 0) {
            var mealsList = [];
            var meal = {
                'id':<?php echo $meal['id'];?>,
                'amount': 0,
                'amount': 0,
                'quantity': lostQuantity,
                'total': 0,
                'date': 0
            }
            mealsList.push(meal);
            $.ajax({
                url: "<?php echo base_url('admin/meal/apiAddLostQuantity'); ?>",
                type: "POST",
                dataType: "json",
                data: {'mealsList': mealsList},
                beforeSend: function () {
                    $('#loading').show();
                },
                complete: function () {
                    $('#loading').hide();
                },
                success: function (data) {
                    if (data.status === 'success') {
                        swal({
                            title: "Success",
                            text: "l'opération a été bien effectuée",
                            type: "success",
                            timer: 1500,
                            showConfirmButton: false
                        });
                        location.reload();
                    }
                    else {
                        swal({
                            title: "Erreur",
                            text: "Une erreur s'est produite",
                            type: "error",
                            timer: 1500,
                            showConfirmButton: false
                        });
                    }
                },
                error: function (data) {
                    swal({
                        title: "Erreur",
                        text: "Une erreur s'est produite",
                        type: "error",
                        timer: 1500,
                        showConfirmButton: false
                    });
                }
            });
        }
    }

    function oneDayChart(data) {
        var amount = [];
        var quantity = [];
        var profit = [];

        var amountData = {
            y: parseFloat(<?php echo number_format((float)$report['amount'] * $report['s_quantity'], 2, '.', '');?>),
            label: "<?php echo $meal['name'];?>"
        };
        var quantityData = {
            y: parseFloat(<?php echo number_format((float)$report['amount'], 0, '.', '');?>),
            label: "<?php echo $meal['name'];?>"
        };
        var profitData = {
            y: parseFloat(<?php echo number_format((float)$report['amount'] * $report['s_quantity'] - $report['s_cost'], 2, '.', '');?>),
            label: "<?php echo $meal['name'];?>"
        };


        if (data) {
            amountData = {
                y: parseFloat(data[0]['amount']) * parseFloat(data[0]['s_quantity']),
                label: "'" + data[0]['name'] + "'"
            };
            quantityData = {
                y: parseFloat(data[0]['s_quantity']),
                label: "'" + data[0]['name'] + "'"
            };
            profitData = {
                y: parseFloat(data[0]['amount'] * data[0]['s_quantity'] - data[0]['s_cost']),
                label: "'" + data[0]['name'] + "'"
            };


        }
        amount.push(amountData);
        quantity.push(quantityData);
        profit.push(profitData);

        var chart = new CanvasJS.Chart("chartContainer1", {
            animationEnabled: true,
            axisY: {
                title: price_in_dh_lang
            },
            legend: {
                cursor: "pointer",
                itemclick: toggleDataSeries
            },
            toolTip: {
                shared: true,
                content: toolTipFormatter
            },
            data: [{
                type: "bar",
                showInLegend: true,
                name: sales_lang,
                color: "#34495e",
                dataPoints: amount
            },
                {
                    type: "bar",
                    showInLegend: true,
                    name: earnings_lang,
                    color: "#6cc",
                    dataPoints: profit
                }]
        });
        chart.render();
        function toolTipFormatter(e) {
            var str = "";
            var total = 0;
            var str3;
            var str2;
            for (var i = 0; i < e.entries.length; i++) {
                var str1 = "<span style= \"color:" + e.entries[i].dataSeries.color + "\">" + e.entries[i].dataSeries.name + "</span>: <strong>" + e.entries[i].dataPoint.y + "</strong> <br/>";
                total = e.entries[i].dataPoint.y + total;
                str = str.concat(str1);
            }
            total = parseFloat(e.entries[0].dataPoint.y - e.entries[1].dataPoint.y);
            str2 = "<strong>" + e.entries[0].dataPoint.label + "</strong> <br/>";
            str3 = "<span style = \"color:Tomato\">Coût: </span><strong>" + total + "</strong><br/>";
            return (str2.concat(str)).concat(str3);
        }

        function toggleDataSeries(e) {
            if (typeof (e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
                e.dataSeries.visible = false;
            }
            else {
                e.dataSeries.visible = true;
            }
            chart.render();
        }
    }
    function flot_chart(data,ajax=false) {
        console.log("data", data);
        var evolutionLength=0;
          $.each(data, function (key,element) {
                if(element["id"]){
                    evolutionLength++;
                }
            });
          console.log(evolutionLength);
          var a=moment(0);
          var b=moment(0);
          if(data[0]){
               a = moment(data[0]["createdAt"]);
               b = moment(data[evolutionLength-1]["createdAt"]);
          }
        c=Math.abs(b.diff(a, 'days'));
        daysMarks= Math.round(c/31);
        daysMarks= Math.round(c/31);
        if(daysMarks===0){
            daysMarks=1;
        }
        if ($(document).width() <= 768) {
            daysMarks = 10;
        }
        var chart_plot_01_settings = {
            series: {
                lines: {
                    show: true,
                    fill: false
                },
                splines: {
                    show: false,
                    tension: 0.4,
                    lineWidth: 1,
                    fill: 0.4
                },
                points: {
                    radius: 0,
                    show: false
                },
                shadowSize: 2
            },
            grid: {
                verticalLines: true,
                hoverable: true,
                clickable: true,
                tickColor: "#d5d5d5",
                borderWidth: 1,
                color: '#fff'
            },
            colors: ["rgba(38, 185, 154, 0.38)", "rgba(3, 88, 106, 0.38)"],
            xaxis: {
                tickColor: "rgba(51, 51, 51, 0.06)",
                mode: "time",
                tickSize: [daysMarks, "day"],
                tickLength: 10,
                axisLabel: "Date",
                axisLabelUseCanvas: true,
                axisLabelFontSizePixels: 12,
                axisLabelFontFamily: 'Verdana, Arial',
                axisLabelPadding: 10
            },
            yaxis: {
                ticks: 8,
                tickColor: "rgba(51, 51, 51, 0.06)",
            },
            tooltip: true,
            legend: {
                labelFormatter: function labelFormatter(label, series) {
                    return "<div style='font-size:8pt; text-align:center; padding:2px; color:black;'>" + label + "</div>";
                }
            }
        };

        var arr_data1 = [];

        var chartSells = {
            'label': sales_lang,
            'data': {},
            'color': '#73879c'
        };
        var chartProfits = {
            'label': earnings_lang,
            'data': {},
        };
        var chartCosts = {
            'label': cost_lang,
            'data': {},
            'color': '#a94442'
        };

        var chartSellsArray = [];
        var chartProfitsArray = [];
        var chartCostsArray = [];


        var cost=parseFloat(0).toFixed(2);
        $.each(data, function (key, entry) {
            var d = new Date(entry['rd']);

            if (!!d.valueOf()) { // Valid date
                chartSellsArray.push([gd(d.getFullYear(), d.getMonth() + 1, d.getDate()), parseFloat(entry['amount'] * entry['s_quantity'])]);
                chartProfitsArray.push([gd(d.getFullYear(), d.getMonth() + 1, d.getDate()), (parseFloat(entry['amount'] * entry['s_quantity'] - entry['s_cost']))]);
                chartCostsArray.push([gd(d.getFullYear(), d.getMonth() + 1, d.getDate()), entry['s_cost']]);
            }
            cost += parseFloat(entry['s_cost']);
        });
        chartSells['data'] = chartSellsArray;
        chartProfits['data'] = chartProfitsArray;
        chartCosts['data'] = chartCostsArray;

        arr_data1.push(chartSells);
        arr_data1.push(chartProfits);
        arr_data1.push(chartCosts);

        var DATA1 = [{
            "label": "Group-1",
            "data": [
                [0.25, 0.25],
                [0.5, 0.5],
                [0.875, 0.875],
                [1, 1]
            ]
        }];


        $.plot($("#chart_plot_01"), arr_data1, chart_plot_01_settings);


        if(ajax){
            l_scost= data.s_cost;
            l_lost= data.s_lost;
            l_squantity= data.s_quantity;
            l_amount= data.s_total;
            var reportData = {
                'amount': parseFloat(l_amount).toFixed(2),
                'cost': parseFloat(cost).toFixed(2),
                //'prepared': parseInt(data[0]['prepared_quantity']),//productsCount,// mealConsumptionRateRange contains products and other variabls
                'prepared': parseInt(0),//productsCount,// mealConsumptionRateRange contains products and other variabls
                'profit': parseFloat(l_amount - l_scost).toFixed(2),
                'quantity': parseInt(l_squantity),
                'lost': parseInt(l_lost),
            };
            changeReportData(reportData);
        }

    }


    function apiEvolutionRangeCallback(data) {
        /*****************************CHANGE CONSOMMATION GRAPH****************************************************/
        //empty quantity graph
        $('.product-quantity .progress-bar').css({
            'display': 'none',
        });
        $('.product-quantity .w_right span:nth-child(1)').html(0);
        //price graph
        var myDataPoints = [];
        var mealConsumptionRateRange = data.evolution.mealConsumptionRateRange;
        $.each(mealConsumptionRateRange, function (key, mealConsumptionRateProduct) {
            if (mealConsumptionRateProduct['avg_unit_price']) {
                var point = {
                    y: mealConsumptionRateProduct['avg_unit_price'] * mealConsumptionRateProduct['sum_quantity'],
                    label: mealConsumptionRateProduct['name'],
                    unit: 'DH'
                };
                myDataPoints.push(point);

                if (!$('#quantity_' + mealConsumptionRateProduct['product']).length) {
                    var productModel = $(".product-quantity-model").clone().removeAttr("hidden");
                    productModel.addClass("widget_summary");
                    productModel.attr('id', 'quantity_' + mealConsumptionRateProduct['product']);
                    productModel.removeClass("product-quantity-model");
                    productModel.find(' .progress-bar').attr('style', 'width: ' + parseFloat( Math.round(mealConsumptionRateProduct['sum_quantity'] / mealConsumptionRateRange['totalQuantity'] * 100)).toFixed(2) + '%');
                    productModel.find(' .w_right span:nth-child(1)').html(parseFloat(mealConsumptionRateProduct['sum_quantity']).toFixed(2));
                    productModel.find(' .w_right span:nth-child(2)').html(" " + mealConsumptionRateProduct['unit']);
                    productModel.find(".w_left.w_25").html(mealConsumptionRateProduct["name"]);
                    $(".productsConsomationList").append(productModel);
                    console.log(productModel);
                }
                //change quantity graph
                $('#quantity_' + mealConsumptionRateProduct['product'] + ' .progress-bar').attr('style', 'width: ' + parseFloat(Math.round(mealConsumptionRateProduct['sum_quantity'] / mealConsumptionRateRange['totalQuantity'] * 100)).toFixed(2) + '%')
                $('#quantity_' + mealConsumptionRateProduct['product'] + ' .w_right span:nth-child(1)').html(parseFloat(mealConsumptionRateProduct['sum_quantity']).toFixed(2));
            }
        });

        var chart = new CanvasJS.Chart("chartContainer", {
            animationEnabled: true,
            data: [{
                type: "doughnut",
                startAngle: 60,
                //innerRadius: 60,
                indexLabelFontSize: 17,
                indexLabel: "{label} - #percent%",
                toolTipContent: "<b>{label}:</b> {y} (#percent%)",
                dataPoints: myDataPoints
            }]
        });
        chart.render();
        /*********************************************************************************/
        var cost = 0;

        if (data.rds.length === 1) {
            $("#chart_plot_01").addClass('hide');
            $("#chartContainer1").fadeIn();
            oneDayChart(data.evolution);
            cost = parseFloat(data.evolution[0]['s_cost']).toFixed(2)
        }else {
            $("#chartContainer1").hide();
            $("#chart_plot_01").fadeIn();
            flot_chart(data.evolution,true);
            $.each(data.evolution, function (key, meal) {
                if (meal['id']) {
                    cost += parseFloat(meal['s_cost']);
                }
            });
        }


            var productsCount = -2;
            $.each(data.evolution.mealConsumptionRateRange, function (key, products) {
                productsCount++;
            });
            var l_amount = 0;
            var l_scost = 0;
            var l_squantity = 0;
            if (data.evolution[0]) {
                l_amount = data.evolution[0]['amount'];
                l_scost = data.evolution[0]['s_cost'];
                l_squantity = data.evolution[0]['s_quantity'];
            }else{
                /* l_amount=0;
                 l_scost=0;
                 l_squantity=0;*/
            }
            l_scost= data.evolution.s_cost;
            l_lost= data.evolution.s_lost;
            l_squantity= data.evolution.s_quantity;
            l_amount= data.evolution.s_total;
            var reportData = {
                'amount': parseFloat(l_amount).toFixed(2),
                'cost': parseFloat(cost).toFixed(2),
                //'prepared': parseInt(data.evolution[0]['prepared_quantity']),//productsCount,// mealConsumptionRateRange contains products and other variabls
                'prepared': parseInt(0),//productsCount,// mealConsumptionRateRange contains products and other variabls
                'profit': parseFloat(l_amount - l_scost).toFixed(2),
                'quantity': parseInt(l_squantity),
                'lost': parseInt(l_lost),
            };
            changeReportData(reportData);
            updateDataTable(data.evolution.mealConsumptionRateRange);
    }
    function updateDataTable(products) {
        tableConsumption.clear().draw();
        $.each(products, function (key,product ) {
            if(key>=0){
                var row = tableConsumption.row.add({
                    "name": product.name,
                    "quantity": parseFloat(product['sum_quantity']).toFixed(2),
                    "price": parseFloat(product['avg_unit_price'] * product['sum_quantity']).toFixed(2),
                }).draw().node();
            }
        });
    }
    function changeReportData(data) {
        console.log("reportData", data);
        $('.report_amount').html(data['amount']+'DH');
        $('.report_cost').html(data['cost']+'DH');
        $('.report_profit').html(data['profit']+'DH');
        $('.report_lost').html(data['lost']);
        <?php if($params['department'] === "false" or $params['showDepartmentContent'] === "false"){ ?>
        $('.report_quantity').html(data['quantity']);
        <?php }else { ?>
        $('.report_quantity').html(data['quantity'] + '/' + data['prepared']);
        <?php } ?>

        //$('.report_products').html(data['prepared']);
    }
</script>



<script>
    function init_daterangepicker(){
        var optionSet1 = {
            startDate: moment().subtract(365, 'days'),
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
        var cb = function (start, end, label) {
            console.log(start.toISOString(), end.toISOString(), label);
            $('#reportrange1 span').html(start.format('YYYY/MM/DD') + ' - ' + end.format('MMMM D, YYYY'));
            console.log(start.format('YYYY/MM/DD'));

            myData = {
                'id':<?php echo $meal['id'];?>,
                'startDate': start.format('YYYY/MM/DD'),
                'endDate': end.format('YYYY/MM/DD')
            };
            var apiEvolutionRange_url="<?php echo base_url('admin/meal/apiEvolutionRange'); ?>";
            params={
                'swal':'false',
                'callable':true,
                'reload':false,
                'callbackdata':null
            };
            apiRequest(apiEvolutionRange_url,myData,params,apiEvolutionRangeCallback);
        };
        $('#reportrange1 span').html(moment().subtract(365, 'days').format('MMMM D, YYYY') + ' - ' + moment().format('MMMM D, YYYY'));
        $('#reportrange1').daterangepicker(optionSet1, cb);
    }
    $(document).ready(function () {

        var handleDataTableButtons = function () {
            if ($("#datatable-purchase").length) {
                $("#datatable-purchase").DataTable({
                    aaSorting: [[5, 'desc']],
                    responsive: true,
                    "lengthMenu": [[25, 50, 200, -1], [25, 50, 200, "Tout"]],
                    "language": {
                        "url": "<?php echo base_url("assets/vendors/datatables.net/French.json"); ?>"
                    }
                });
            }

            if ($("#datatable-consumption").length) {
                tableConsumption=$("#datatable-consumption").DataTable({
                    responsive: true,
                    "lengthMenu": [[25, 50, 200, -1], [25, 50, 200, "Tout"]],
                    "language": {
                        "url": "<?php echo base_url("assets/vendors/datatables.net/French.json"); ?>"
                    },
                    "columns": [
                        {"data": "name"},
                        {"data": "quantity"},
                        {"data": "price"},
                    ],
                    "bPaginate": false,
                    "bLengthChange": false,
                    "bFilter": true,
                    "bInfo": false,
                });
            }

            if ($("#datatable-losts").length) {
                $("#datatable-losts").DataTable({
                    responsive: true,
                    "lengthMenu": [[25, 50, 200, -1], [25, 50, 200, "Tout"]],
                    "language": {
                        "url": "<?php echo base_url("assets/vendors/datatables.net/French.json"); ?>"
                    },
                    "bPaginate": false,
                    "bLengthChange": false,
                    "bFilter": true,
                    "bInfo": false,
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
        init_daterangepicker();

    });
</script>