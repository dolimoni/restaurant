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
           <!-- <pre>
                <?php /*print_r($report); */?>
            </pre>-->
        <div class="page-title">
          <!--  <div class="title_left">
                <h3>Articles</h3>
            </div>-->
        </div>
        <div class="clearfix"></div>
        <hr>
        <div class="row tile_count">
            <div class="col-md-3 col-sm-6 col-xs-12 tile_stats_count">
                <span class="count_top"><i class="fa fa-user"></i>Chiffre d'affaire</span>
                <div class="count report_amount"><?php echo number_format((float)$report['consumption']['turnover'], 2, '.', ''); ?>
                    DH
                </div>
                <!-- <span class="count_bottom"><i class="green">4% </i> From last Week</span>-->
            </div>
            <div class="col-md-3 col-sm-6 col-xs-12 tile_stats_count">
                <span class="count_top"><i class="fa fa-user"></i> Dépenses</span>
                <div class="count red report_profit"><?php echo number_format((float)($report['cp']['s_cost']), 2, '.', ''); ?>
                    DH
                </div>
            </div>
            <div class="col-md-3 col-sm-6 col-xs-12 tile_stats_count">
                <span class="count_top">Bénéfices</span>
                <div class="count green report_products"><?php echo number_format((float)($report['consumption']['turnover']- $report['cp']['s_cost']), 2, '.', ''); ?></div>
            </div>
            <div class="col-md-3 col-sm-6 col-xs-12 tile_stats_count">
                <span class="count_top"><i class="fa fa-user"></i>Nombre de vente</span>
                <div class="count report_cost"><?php echo number_format((float)($report['consumption']['s_quantity']), 0, '.', ''); ?>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Historique
                            <small>Historique</small>
                        </h2>
                        <div class="filter">
                            <!--<div id="reportrange" class="pull-right"
                                 style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc">
                                <i class="glyphicon glyphicon-calendar fa fa-calendar"></i>
                                <span>December 30, 2014 - January 28, 2015</span> <b class="caret"></b>
                            </div>-->
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <div class="col-md-9 col-sm-12 col-xs-12">
                            <div class="demo-container" style="height:280px">
                                <div id="chart_plot_05" class="demo-placeholder"></div>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-12 col-xs-12">
                            <div>
                                <div class="x_title">
                                    <h2>Top consommation produits</h2>
                                    <div class="clearfix"></div>
                                </div>
                                <ul class="list-unstyled top_profiles scroll-view">
                                        <?php foreach ($report['products_cost'] as $key=>$products_cost){ ?>
                                    <li class="media event">
                                       <!-- <a class="pull-left border-aero profile_thumb">
                                            <i class="fa fa-user aero"></i>
                                        </a>-->
                                        <div class="media-body">
                                            <a class="title" href="#"><?php echo $products_cost['name']; ?></a>
                                            <p>Consommation <strong><?php echo $products_cost['s_cost']; ?>DH</strong></p>
                                            <p>
                                                <small>Nombre d'utilisations : <?php echo $products_cost['s_meal']; ?> fois</small>
                                            </p>
                                        </div>
                                    </li>
                                    <?php } ?>
                                </ul>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6" id="chartContainer" style="height: 300px; width:50%"></div>
            <div class="col-md-6" style="height: 300px;">
                <div id="graph_bar_group2" style="background:#fff; height:300px;"></div>
            </div>
        </div>
    </div>
</div>

<?php $this->load->view('admin/partials/admin_footer'); ?>

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
    var rangeLink = "<?php echo base_url('admin/report/apiRange'); ?>";
    var mealReportLink = "<?php echo base_url('admin/meal/report/'); ?>";
</script>
<script src="<?php echo base_url('assets/build2/js/dateRangePicker.js'); ?>"></script>


<script type="text/javascript">
    var params = {
        'params': {
            'sort': true,
            'sort_by': 's_amount',
            'max': 6
        }
    };
    $(document).ready(function () {
        $.ajax({
            url: "<?php echo base_url(); ?>admin/report/apiReport",
            type: "POST",
            dataType: "json",
            data: params,
            success: function (data) {
                if (data.status === true) {
                    var amount = [];
                    var quantity = [];
                    var profit = [];
                    console.log('--->!',data);
                    $.each(data.articles, function (key, article) {
                        var amountData = {y: parseInt(article['s_amount']), label: article['name']};
                        var quantityData = {y: parseInt(article['s_quantity']), label: article['name']};
                        var profitData = {y: parseInt(article['s_amount']-article['s_cost']), label: article['name']};

                        amount.push(amountData);
                        quantity.push(quantityData);
                        profit.push(profitData);
                    });

                    console.log(amount);


                    var chart = new CanvasJS.Chart("chartContainer", {
                        animationEnabled: true,
                        title: {
                            text: "Liste des articles les plus rentables"
                        },
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
                else {
                    console.log('Error');
                }
            },
            error: function (data) {
            }
        });
    });
</script>

<!--Plot_5-->
<script>
    $(document).ready(function () {

        if ($("#chart_plot_05").length) {
            <?php
            $js_array = json_encode($report['sales_history']);
            echo "var sales = " . $js_array . ";\n";
            ?>
            var chart_plot_05_data = [];
            console.log('sales',sales);
           /* for (var i = 0; i < 30; i++) {
                chart_plot_05_data.push([new Date(Date.today().add(i).days()).getTime(), randNum() + i + i + 10]);
            }*/

            $.each(sales, function (key, sale) {
                console.log(new Date(sale['report_date']).getTime());
                chart_plot_05_data.push([new Date(sale['report_date']), sale['s_amount']]);
            });
            var chart_plot_05_settings = {
                grid: {
                    show: true,
                    aboveData: true,
                    color: "#3f3f3f",
                    labelMargin: 10,
                    axisMargin: 0,
                    borderWidth: 0,
                    borderColor: null,
                    minBorderMargin: 5,
                    clickable: true,
                    hoverable: true,
                    autoHighlight: true,
                    mouseActiveRadius: 100
                },
                series: {
                    lines: {
                        show: true,
                        fill: true,
                        lineWidth: 2,
                        steps: false
                    },
                    points: {
                        show: true,
                        radius: 4.5,
                        symbol: "circle",
                        lineWidth: 3.0
                    }
                },
                legend: {
                    position: "ne",
                    margin: [0, -25],
                    noColumns: 0,
                    labelBoxBorderColor: null,
                    labelFormatter: function (label, series) {
                        return label + '&nbsp;&nbsp;';
                    },
                    width: 40,
                    height: 1
                },
                colors: ['#96CA59', '#3F97EB', '#72c380', '#6f7a8a', '#f7cb38', '#5a8022', '#2c7282'],
                shadowSize: 0,
                tooltip: true,
                tooltipOpts: {
                    content: "%s: %y.0",
                    xDateFormat: "%d/%m",
                    shifts: {
                        x: -30,
                        y: -50
                    },
                    defaultTheme: false
                },
                yaxis: {
                    min: 0
                },
                xaxis: {
                    mode: "time",
                    minTickSize: [1, "day"],
                    timeformat: "%d/%m/%y",
                    min: chart_plot_05_data[0][0],
                    max: chart_plot_05_data[20]
                }
            };

            $.plot($("#chart_plot_05"),
                [{
                    label: "Historique",
                    data: chart_plot_05_data,
                    lines: {
                        fillColor: "rgba(150, 202, 89, 0.12)"
                    },
                    points: {
                        fillColor: "#fff"
                    }
                }], chart_plot_05_settings);

        }
    });
</script>


<script>
    $(document).ready(function () {
        if ($('#graph_bar_group2').length) {

            <?php
            $js_array = json_encode($report['sales_history_month']);
            echo "var sales_month = " . $js_array . ";\n";
            ?>
            var sales_data=[];
              $.each(sales_month, function (key, sales_month ) {
                    var sale ={"period": sales_month['report_date'].slice(0, -3),"licensed": sales_month['s_amount']};
                  sales_data.push(sale);
                });
            Morris.Bar({
                element: 'graph_bar_group2',
                data: sales_data,

                xkey: 'period',
                barColors: ['#26B99A', '#34495E', '#ACADAC', '#3498DB'],
                ykeys: ['licensed'], //['licensed', 'sorned']
                labels: ['Ventes'], // ['Licensed', 'SORN']
                hideHover: 'auto',
                xLabelAngle: 60,
                resize: true
            });

        }

    });
</script>
<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>