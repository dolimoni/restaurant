<?php $this->load->view('admin/partials/admin_header.php'); ?>
<?php
    if(!isset($report['s_amount'])){
        header('Location:'.base_url('admin/report/index'));
    }
?>
<div class="container body">
    <div class="main_container">


        <!-- top navigation -->

        <!-- /top navigation -->

        <!-- page content -->
        <div class="right_col" role="main">
             <!--<pre>
                <?php /*print_r($report); */?>
            </pre>-->
            <!-- top tiles -->
            <div class="row tile_count">
                <div class="col-md-3 col-sm-4 col-xs-6 tile_stats_count">
                    <span class="count_top"><i class="fa fa-user"></i> Total de vente</span>
                    <div class="count"><?php echo number_format((float)$report['s_amount'], 2, '.', '') ;?>DH</div>
                    <span class="count_bottom"><i class="green">4% </i> From last Week</span>
                </div>
                <div class="col-md-3 col-sm-4 col-xs-6 tile_stats_count">
                    <span class="count_top"><i class="fa fa-user"></i>Coût de fabrication</span>
                    <div class="count"><?php echo number_format((float)($report['s_amount'] - $report['s_profit']), 2, '.', ''); ?>DH</div>
                    <span class="count_bottom"><i class="green"><i
                                class="fa fa-sort-asc"></i>34% </i> From last Week</span>
                </div>
                <div class="col-md-3 col-sm-4 col-xs-6 tile_stats_count">
                    <span class="count_top"><i class="fa fa-user"></i> Profit</span>
                    <div class="count green"><?php echo number_format((float)$report['s_profit'], 2, '.', ''); ?>DH</div>
                    <span class="count_bottom"><i class="red"><i
                                class="fa fa-sort-desc"></i>12% </i> From last Week</span>
                </div>
                <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
                    <span class="count_top"><i class="fa fa-clock-o"></i> Quantitées vendu</span>
                    <div class="count"><?php echo number_format((float)$report['s_quantity'], 0, '.', ''); ?></div>
                    <span class="count_bottom"><i class="green"><i
                                    class="fa fa-sort-asc"></i>3% </i> From last Week</span>
                </div>
                <div class="col-md-1 col-sm-4 col-xs-6 tile_stats_count">
                    <span class="count_top">Produits</span>
                    <div class="count"><?php echo count($report['mealConsumptionRate']);?></div>
                </div>

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
                    <div class="count"><?php echo $report['name']; ?></div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="dashboard_graph">

                        <div class="row x_title">
                            <div class="col-md-6">
                                <h3>Rapport des gains
                                    <small>Dépenses-Ventes-Gain</small>
                                </h3>
                            </div>
                            <div class="col-md-6">
                                <div id="reportrange1" class="pull-right"
                                     style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc">
                                    <i class="glyphicon glyphicon-calendar fa fa-calendar"></i>
                                    <span>December 30, 2014 - January 28, 2015</span> <b class="caret"></b>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div id="chart_plot_01" class="demo-placeholder" hidden></div>
                            <div id="chartContainer1" style="height: 370px; width: 100%;" hidden></div>
                        </div>
                        <!--<div class="col-md-3 col-sm-3 col-xs-12 bg-white">
                            <div class="x_title">
                                <h2>Top Campaign Performance</h2>
                                <div class="clearfix"></div>
                            </div>

                            <div class="col-md-12 col-sm-12 col-xs-6">
                                <div>
                                    <p>Facebook Campaign</p>
                                    <div class="">
                                        <div class="progress progress_sm" style="width: 76%;">
                                            <div class="progress-bar bg-green" role="progressbar"
                                                 data-transitiongoal="80"></div>
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    <p>Twitter Campaign</p>
                                    <div class="">
                                        <div class="progress progress_sm" style="width: 76%;">
                                            <div class="progress-bar bg-green" role="progressbar"
                                                 data-transitiongoal="60"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 col-sm-12 col-xs-6">
                                <div>
                                    <p>Conventional Media</p>
                                    <div class="">
                                        <div class="progress progress_sm" style="width: 76%;">
                                            <div class="progress-bar bg-green" role="progressbar"
                                                 data-transitiongoal="40"></div>
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    <p>Bill boards</p>
                                    <div class="">
                                        <div class="progress progress_sm" style="width: 76%;">
                                            <div class="progress-bar bg-green" role="progressbar"
                                                 data-transitiongoal="50"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>-->

                        <div class="clearfix"></div>
                    </div>
                </div>

            </div>
            <br/>

            <div class="row">


                <div class="col-md-6 col-sm-6 col-xs-12">
                    <div class="x_panel tile fixed_height_320">
                        <div class="x_title">
                            <h2>Quantité des produits utitlisés</h2>
                            <ul class="nav navbar-right panel_toolbox">
                                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                </li>
                                <li class="dropdown">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
                                       aria-expanded="false"><i class="fa fa-wrench"></i></a>
                                    <ul class="dropdown-menu" role="menu">
                                        <li><a href="#">Settings 1</a>
                                        </li>
                                        <li><a href="#">Settings 2</a>
                                        </li>
                                    </ul>
                                </li>
                                <li><a class="close-link"><i class="fa fa-close"></i></a>
                                </li>
                            </ul>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">
                            <h4>Quantité des produits utitlisés</h4>
                            <?php foreach ($report['mealConsumptionRate'] as $mealConsumptionRate) { ?>

                            <div class="widget_summary">
                                <div class="w_left w_25">
                                    <?php echo $mealConsumptionRate['name'];?>
                                </div>
                                <div class="w_center w_55">
                                    <div class="progress">
                                        <div class="progress-bar bg-green" role="progressbar"
                                              style="width: <?php echo round($mealConsumptionRate['sum_quantity']/ $report['totalConsumptionQuantity']*100);?>%;">
                                        </div>
                                    </div>
                                </div>
                                <div class="w_right w_20">

                                    <span><?php
                                        $l_quantity= $mealConsumptionRate['sum_quantity'];
                                        if($mealConsumptionRate['unit']==='pcs'){
                                            $l_quantity= number_format((float)$l_quantity, 0, '.', '');
                                        }
                                        echo $l_quantity.' '. $mealConsumptionRate['unit'];
                                        ?>
                                    </span>
                                </div>
                                <div class="clearfix"></div>
                            </div>

                            <?php } ?>

                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-sm-6 col-xs-12">
                    <div class="x_panel tile ">
                        <div class="x_title">
                            <h2>Consomation des produits</h2>
                            <ul class="nav navbar-right panel_toolbox">
                                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                </li>
                                <li class="dropdown">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
                                       aria-expanded="false"><i class="fa fa-wrench"></i></a>
                                    <ul class="dropdown-menu" role="menu">
                                        <li><a href="#">Settings 1</a>
                                        </li>
                                        <li><a href="#">Settings 2</a>
                                        </li>
                                    </ul>
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
                </div><!--<div class="col-md-6 col-sm-6 col-xs-12">
                    <div class="x_panel tile fixed_height_320 overflow_hidden">
                        <div class="x_title">
                            <h2>Consomation des produits</h2>
                            <ul class="nav navbar-right panel_toolbox">
                                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                </li>
                                <li class="dropdown">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
                                       aria-expanded="false"><i class="fa fa-wrench"></i></a>
                                    <ul class="dropdown-menu" role="menu">
                                        <li><a href="#">Settings 1</a>
                                        </li>
                                        <li><a href="#">Settings 2</a>
                                        </li>
                                    </ul>
                                </li>
                                <li><a class="close-link"><i class="fa fa-close"></i></a>
                                </li>
                            </ul>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">
                            <table style="width:100%">
                                <tr>
                                    <th>
                                        <div class="col-lg-7 col-md-7 col-sm-7 col-xs-7">
                                            <p class="">Device</p>
                                        </div>
                                        <div class="col-lg-5 col-md-5 col-sm-5 col-xs-5">
                                            <p class="">Progress</p>
                                        </div>
                                    </th>
                                </tr>
                                <tr>
                                    <td>
                                        <table class="tile_info">
                                            <tr>
                                                <td>
                                                    <p><i class="fa fa-square blue"></i>Produit 1 </p>
                                                </td>
                                                <td>35%</td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <p><i class="fa fa-square green"></i>Produit 2 </p>
                                                </td>
                                                <td>5%</td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <p><i class="fa fa-square purple"></i>Produit 3 </p>
                                                </td>
                                                <td>20%</td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <p><i class="fa fa-square aero"></i>Produit 4 </p>
                                                </td>
                                                <td>15%</td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <p><i class="fa fa-square red"></i>Produit 5 </p>
                                                </td>
                                                <td>30%</td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>-->


                <!--<div class="col-md-4 col-sm-4 col-xs-12">
                    <div class="x_panel tile fixed_height_320">
                        <div class="x_title">
                            <h2>Quick Settings</h2>
                            <ul class="nav navbar-right panel_toolbox">
                                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                </li>
                                <li class="dropdown">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
                                       aria-expanded="false"><i class="fa fa-wrench"></i></a>
                                    <ul class="dropdown-menu" role="menu">
                                        <li><a href="#">Settings 1</a>
                                        </li>
                                        <li><a href="#">Settings 2</a>
                                        </li>
                                    </ul>
                                </li>
                                <li><a class="close-link"><i class="fa fa-close"></i></a>
                                </li>
                            </ul>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">
                            <div class="dashboard-widget-content">
                                <ul class="quick-list">
                                    <li><i class="fa fa-calendar-o"></i><a href="#">Settings</a>
                                    </li>
                                    <li><i class="fa fa-bars"></i><a href="#">Subscription</a>
                                    </li>
                                    <li><i class="fa fa-bar-chart"></i><a href="#">Auto Renewal</a></li>
                                    <li><i class="fa fa-line-chart"></i><a href="#">Achievements</a>
                                    </li>
                                    <li><i class="fa fa-bar-chart"></i><a href="#">Auto Renewal</a></li>
                                    <li><i class="fa fa-line-chart"></i><a href="#">Achievements</a>
                                    </li>
                                    <li><i class="fa fa-area-chart"></i><a href="#">Logout</a>
                                    </li>
                                </ul>

                                <div class="sidebar-widget">
                                    <h4>Profile Completion</h4>
                                    <canvas width="150" height="80" id="chart_gauge_01" class=""
                                            style="width: 160px; height: 100px;"></canvas>
                                    <div class="goal-wrapper">
                                        <span id="gauge-text" class="gauge-value pull-left">0</span>
                                        <span class="gauge-value pull-left">%</span>
                                        <span id="goal-text" class="goal-value pull-right">100%</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>-->

            </div>


        </div>
        <!-- /page content -->

        <!-- footer content -->
        <footer>
            <div class="pull-right">
                Gentelella - Bootstrap Admin Template by <a href="https://colorlib.com">Colorlib</a>
            </div>
            <div class="clearfix"></div>
        </footer>
        <!-- /footer content -->
    </div>
</div>
<?php $this->load->view('admin/partials/admin_footer'); ?>

<!-- bootstrap-daterangepicker -->
<script src="<?php echo base_url('assets/vendors/moment/min/moment.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/vendors/bootstrap-daterangepicker/daterangepicker.js'); ?>"></script>
<script>
    var rangeLink = "<?php echo base_url('admin/report/apiRange'); ?>";
</script>
<script src="<?php echo base_url('assets/build2/js/custom.js'); ?>"></script>

<script src="<?php echo base_url('assets/vendors/Flot/jquery.flot.js');?>"></script>
<script src="<?php echo base_url('assets/vendors/Flot/jquery.flot.pie.js');?>"></script>
<script src="<?php echo base_url('assets/vendors/Flot/jquery.flot.time.js');?>"></script>
<script src="<?php echo base_url('assets/vendors/Flot/jquery.flot.stack.js');?>"></script>
<script src="<?php echo base_url('assets/vendors/Flot/jquery.flot.resize.js');?>"></script>
<script>
    window.onload = function () {

        <?php
        $js_array = json_encode($report['mealConsumptionRate']);
        echo "var mealConsumptionRate = " . $js_array . ";\n";
        ?>

        var myDataPoints=[];
          $.each(mealConsumptionRate, function (key, mealConsumptionRateProduct) {
                var point={
                    y: mealConsumptionRateProduct['avg_unit_price']* mealConsumptionRateProduct['sum_quantity'],
                    label: mealConsumptionRateProduct['name']
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
                toolTipContent: "<b>{label}:</b> {y} (#percent%)",
                dataPoints: myDataPoints
            }]
        });
        chart.render();

    }
</script>
<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>


<script src="<?php echo base_url('assets/vendors/flot.orderbars/js/jquery.flot.orderBars.js');?>"></script>
<script src="<?php echo base_url('assets/vendors/flot-spline/js/jquery.flot.spline.min.js');?>"></script>
<script src="<?php echo base_url('assets/vendors/flot.curvedlines/curvedLines.js');?>"></script>

<script src="<?php echo base_url('assets/vendors/DateJS/build/date.js');?>"></script>
<script src="<?php echo base_url('assets/vendors/gauge.js/dist/gauge.min.js');?>"></script>




<script>
    var daysInReport=<?php echo $report['days']; ?>;
    $.ajax({
        url: "<?php echo base_url('admin/meal/apiEvolution'); ?>",
        type: "POST",
        dataType: "json",
        data: {'id':<?php echo $report['meal'];?>},
        success: function (data) {
            if (data.status === true) {
                if(daysInReport===1){
                    $("#chart_plot_01").hide();
                    $("#chartContainer1").fadeIn();
                    oneDayChart(data.evolution);
                }else{
                    $("#chartContainer1").hide();
                    $("#chart_plot_01").fadeIn();
                    flot_chart(data.evolution);
                }
            }
            else {
                console.log('Error');
            }
        },
        error: function (data) {
        }
    });

    function oneDayChart(data){
        var amount = [];
        var quantity = [];
        var profit = [];

        var amountData = {y: parseInt(<?php echo number_format((float)$report['s_amount'], 2, '.', '');?>), label: "<?php echo $report['name'];?>"};
        var quantityData = {y: parseInt(<?php echo number_format((float)$report['s_amount'], 0, '.', '');?>), label: "<?php echo $report['name'];?>"};
        var profitData = {y: parseInt(<?php echo number_format((float)$report['s_profit'], 2, '.', '');?>), label: "<?php echo $report['name'];?>"};

        console.log(data[0]['s_amount']);
        console.log(data[0]['s_quantity']);
        console.log(data[0]['profit']);
        if(data){
             amountData = {
                 y: parseInt(data[0]['s_amount']),
                 label: "'"+ data[0]['name']+"'"
             };
            quantityData = {
                 y: parseInt(data[0]['s_quantity']),
                 label: "'"+ data[0]['name']+"'"
             };
            profitData = {
                 y: parseInt(data[0]['profit']* data[0]['s_quantity']),
                 label: "'"+ data[0]['name']+"'"
             };

        }
        console.log(amountData);
        amount.push(amountData);
        quantity.push(quantityData);
        profit.push(profitData);

        var chart = new CanvasJS.Chart("chartContainer1", {
            animationEnabled: true,
            axisY: {
                title: "Prix en Dh"
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
                name: "Vente",
                color: "#34495e",
                dataPoints: amount
            },
                {
                    type: "bar",
                    showInLegend: true,
                    name: "Profit",
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
    function flot_chart(data) {
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
                tickSize: [1, "day"],
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
            legend:{
               labelFormatter: function labelFormatter(label, series) {
                   return "<div style='font-size:8pt; text-align:center; padding:2px; color:black;'>" + label + "</div>";
               }
            }
        };

        var arr_data1=[];

        var chartSells={
            'label':'Ventes',
            'data':{},
            'color':'#73879c'
        };
        var chartProfits={
            'label':'Bénéfices',
            'data':{},
        };
        var chartCosts={
            'label':'Coûts',
            'data':{},
            'color':'#a94442'
        };

        var chartSellsArray=[];
        var chartProfitsArray=[];
        var chartCostsArray=[];


        $.each(data, function (key, entry) {
            var d = new Date(entry['ca']);

            if (!!d.valueOf()) { // Valid date
                console.log(entry['profit']);
                console.log(entry['s_quantity']);
                chartSellsArray.push([gd(d.getFullYear(), d.getMonth()+1, d.getDate()), entry['s_amount']]);
                chartProfitsArray.push([gd(d.getFullYear(), d.getMonth()+1, d.getDate()), entry['profit']* entry['s_quantity']]);
                chartCostsArray.push([gd(d.getFullYear(), d.getMonth()+1, d.getDate()), entry['s_amount'] - entry['profit']* entry['s_quantity']]);
            }
        });
        chartSells['data']= chartSellsArray;
        chartProfits['data']= chartProfitsArray;
        chartCosts['data']= chartCostsArray;

        arr_data1.push(chartSells);
        arr_data1.push(chartProfits);
        arr_data1.push(chartCosts);

        var DATA = [{
            "label": "Group-1",
            "data": [
                [0.25, 0.25],
                [0.5, 0.5],
                [0.875, 0.875],
                [1, 1]
            ]
        }];

        console.log(arr_data1);
        console.log(DATA);

        $.plot($("#chart_plot_01"), arr_data1, chart_plot_01_settings);

    }


    var cb = function (start, end, label) {
        console.log(start.toISOString(), end.toISOString(), label);
        $('#reportrange1 span').html(start.format('YYYY/MM/DD') + ' - ' + end.format('MMMM D, YYYY'));
        console.log(start.format('YYYY/MM/DD'));

        myData = {'id':<?php echo $report['meal'];?>,'startDate': start.format('YYYY/MM/DD'), 'endDate': end.format('YYYY/MM/DD')};
        $.ajax({
            url: "<?php echo base_url('admin/meal/apiEvolutionRange'); ?>",
            type: "POST",
            dataType: "json",
            data: myData,
            success: function (data) {
                if (data.status === true) {
                    if (data.evolution.length===1) {
                        $("#chart_plot_01").hide();
                        $("#chartContainer1").fadeIn();
                        oneDayChart(data.evolution);
                    } else {
                        $("#chartContainer1").hide();
                        $("#chart_plot_01").fadeIn();
                        flot_chart(data.evolution);
                    }
                }
                else {
                    console.log('Error');
                }
            },
            error: function (data) {
            }
        });
    };

    var optionSet1 = {
        startDate: moment().subtract(29, 'days'),
        endDate: moment(),
        minDate: '01/01/2012',
        maxDate: '12/31/2015',
        dateLimit: {
            days: 60
        },
        showDropdowns: true,
        showWeekNumbers: true,
        timePicker: false,
        timePickerIncrement: 1,
        timePicker12Hour: true,
        ranges: {
            'Today': [moment(), moment()],
            'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
            'Last 7 Days': [moment().subtract(6, 'days'), moment()],
            'Last 30 Days': [moment().subtract(29, 'days'), moment()],
            'This Month': [moment().startOf('month'), moment().endOf('month')],
            'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        },
        opens: 'left',
        buttonClasses: ['btn btn-default'],
        applyClass: 'btn-small btn-primary',
        cancelClass: 'btn-small',
        format: 'MM/DD/YYYY',
        separator: ' to ',
        locale: {
            applyLabel: 'Submit',
            cancelLabel: 'Clear',
            fromLabel: 'From',
            toLabel: 'To',
            customRangeLabel: 'Custom',
            daysOfWeek: ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa'],
            monthNames: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
            firstDay: 1
        }
    };

    $('#reportrange1 span').html(moment().subtract(29, 'days').format('MMMM D, YYYY') + ' - ' + moment().format('MMMM D, YYYY'));
    $('#reportrange1').daterangepicker(optionSet1, cb);
</script>