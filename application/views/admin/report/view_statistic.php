<?php $this->load->view('admin/partials/admin_header.php'); ?>
<link href="<?php echo base_url("assets/build2/css/custom.min.css"); ?>" rel="stylesheet">
<style>
    .validate {
        background: #26b99a !important;
        color: white;
    }
    small{
        font-size: 50%;
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

                   <div class="row">
                       <div class="col-xs-12 col-sm-6 col-md-3">
                           <a class="btn btn-warning  btn-block" name="printSpendingReport">
                               <span class="fa fa-print"></span><?= lang('expense_report') ?>
                           </a>
                       </div>
                       <div class="col-xs-12 col-sm-6 col-md-3">
                           <a class="btn btn-success  btn-block" name="printSalesReport">
                               <span class="fa fa-print"></span><?= lang('sale_report') ?>
                           </a>
                       </div>
                       <div class="col-xs-12 col-sm-6 col-md-3">
                           <a href="<?php echo base_url("admin/report"); ?>" class="btn btn-info btn-block" name="printSalesReport">
                               <span class="fa fa-print"></span><?= lang('article_report') ?>
                           </a>
                       </div>
                       <div class="col-xs-12 col-sm-6 col-md-3">
                           <a class="btn btn-primary  btn-block" name="printGlobalReport" style="min-width:180px;">
                               <span class="fa fa-print"></span><?= lang('global_report') ?>
                           </a>
                       </div>
                   </div>
               </div>
              <!-- <div class="col-xs-12 col-sm-3">
                   <a class="btn btn-success" name="printSalesReport">
                       <span class="fa fa-print"></span>Rapport des ventes
                   </a>
               </div>
               <div class="col-xs-12 col-sm-3">
                   <a href="<?php /*echo base_url("admin/report"); */?>" class="btn btn-success" name="printSalesReport">
                       <span class="fa fa-print"></span>Rapport des articles
                   </a>
               </div>-->
               <div class="col-xs-12 col-sm-12">
                   <div id="reportrange" class="pull-right full-width"
                        style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc">
                       <div class="pull-right">
                           <i class="glyphicon glyphicon-calendar fa fa-calendar"></i>
                           <span>December 30, 2014 - January 28, 2015</span> <b class="caret"></b>
                       </div>
                   </div>
               </div>
           </div>

        </div>
        <div class="clearfix"></div>
        <!--<pre>
                <?php /*print_r($report); */?>
            </pre>-->
        <hr>
        <div class="row tile_count">
            <div class="col-md-3 col-sm-6 col-xs-12 tile_stats_count">
                <span class="count_top"><i class="fa fa-user"></i><?= lang('turnover') ?></span>
                <div class="count report_amount"> <?php echo number_format((float)$report['consumption']['turnover'], 1, '.', ''); ?>
                    <small>DH</small>
                </div>
                <?php
                if($params['pack']==='pro'){
                if(number_format($params["parts"],0)=="2"){ ?>
                <div class="count_top"><i class="fa fa-dollar"></i> <span><?= lang('morning') ?>:</span> <span class="st_part"><?php echo number_format((float)$report['consumption_history']['st_part'], 2, '.', ''); ?></span> DH</div>
                <div class="count_top"><i class="fa fa-dollar"></i> <span style="margin-right: 7px;"><?= lang('evening') ?>:</span> <span class="nd_part"><?php echo number_format((float)$report['consumption_history']['turnover']-(float)$report['consumption_history']['st_part'], 2, '.', ''); ?></span> DH</div>
                <?php }?>
                <?php if (number_format($params["parts"], 0) == "3") { ?>
                    <div class="count_top"><i class="fa fa-dollar"></i>
                        <span style="margin-right: 35px;"><?= lang('morning') ?></span>: <span class="st_part"><?php echo number_format((float)$report['consumption_history']['st_part'], 2, '.', ''); ?></span>
                        <small>DH</small>
                    </div>
                    <div class="count_top"><i class="fa fa-dollar"></i> <span><?= lang('afternoon') ?></span>
                        : <span class="nd_part"><?php echo number_format((float)$report['consumption_history']['nd_part'], 1, '.', ''); ?></span> <small>DH</small>
                    </div>
                    <div class="count_top"><i class="fa fa-dollar"></i> <span style="margin-right: 39px;"><?= lang('evening') ?></span>
                        : <span class="rd_part"><?php echo number_format((float)$report['consumption_history']['rd_part'], 1, '.', ''); ?></span> <small>DH</small>
                    </div>
                <?php }} ?>
                <!-- <span class="count_bottom"><i class="green">4% </i> From last Week</span>-->
            </div>
            <div class="col-md-3 col-sm-6 col-xs-12 tile_stats_count">
                <span class="count_top"><i class="fa fa-user"></i> <?= lang('expense') ?></span>
                <div class="count red report_cost"><?php echo number_format((float)($report["charges"]), 1, '.', ''); ?>
                    <small>DH</small>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 col-xs-12 tile_stats_count">
                <span class="count_top"><?= lang('earnings') ?></span>
                <div class="count green report_profit"><?php echo number_format((float)($report['consumption']['turnover'] - $report["charges"]), 1, '.', ''); ?> <small>DH</small></div>
            </div>
            <div class="col-md-3 col-sm-6 col-xs-12 tile_stats_count">
                <span class="count_top"><i class="fa fa-user"></i><?= lang('number_of_sales') ?></span>
                <div class="count report_products"><?php echo number_format((float)($report['consumption']['s_quantity']), 0, '.', ''); ?>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2><?= lang('historiy') ?>
                            <small><?= lang('historiy') ?></small>
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
                                    <h2><?= lang('top_consumption_products') ?></h2>
                                    <div class="clearfix"></div>
                                </div>
                                <ul class="list-unstyled top_profiles scroll-view">
                                    <?php foreach ($report['products_cost'] as $key=>$products_cost){ ?>
                                    <li class="media event">
                                        <div class="media-body">
                                            <a class="title" href="<?php echo base_url("admin/product/statistic/". $products_cost["id"]); ?>"><?php echo $products_cost['name']; ?></a>
                                            <p><?= lang('consumption') ?> <strong><?php echo $products_cost['s_cost']; ?>DH</strong></p>
                                            <p>
                                                <small><?= lang('number_of_uses') ?> : <?php echo $products_cost['s_meal']; ?> <?= lang('time_nbr') ?></small>
                                            </p>
                                        </div>
                                    </li>
                                    <?php } ?>
                                </ul>
                                <li class="media event productModel" hidden>
                                    <div class="media-body">
                                        <a class="title" href="#"></a>
                                        <p><?= lang('consumption') ?> <strong></strong>
                                        </p>
                                        <p>
                                            <small>
                                            </small>
                                        </p>
                                    </div>
                                </li>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 col-sm-6 col-xs-12" id="chartContainer" style="height: 300px;"></div>
            <div class="col-md-6 col-sm-6 col-xs-12" style="height: 300px;">
                <div id="graph_bar_group2" style="background:#fff; height:300px;"></div>
            </div>
        </div>

        <div class="row" style="margin-top: 10px;">
            <div class="col-md-6 col-sm-6 col-xs-12 hide">
                <div class="x_panel tile ">
                    <div class="x_title">
                        <h2><?= lang('expenditure_details') ?></h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                            </li>
                            <li><a class="close-link"><i class="fa fa-close"></i></a>
                            </li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <div id="spendingContainer" style="height:238px; width: 100%;max-height: 230px;"></div>
                    </div>
                </div>
            </div>
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel tile ">
                    <div class="x_title">
                        <h2><?= lang('expenditure_details') ?></h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                            </li>
                            <li><a class="close-link"><i class="fa fa-close"></i></a>
                            </li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <canvas id="bar-ordersPayment" style="height:238px; width: 100%;"></canvas>
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
        function requestFullScreen(element) {
            // Supports most browsers and their versions.
            var requestMethod = element.requestFullScreen || element.webkitRequestFullScreen || element.mozRequestFullScreen || element.msRequestFullScreen;

            if (requestMethod) { // Native full screen.
                requestMethod.call(element);
            } else if (typeof window.ActiveXObject !== "undefined") { // Older IE.
                var wscript = new ActiveXObject("WScript.Shell");
                if (wscript !== null) {
                    wscript.SendKeys("{F11}");
                }
            }
        }

        var elem = document.body; // Make the body go full screen.
        requestFullScreen(elem);
    });
</script>

<!-- ECharts -->
<script src="<?php echo base_url('assets/vendors/echarts/dist/echarts.js'); ?>"></script>

<script src="<?php echo base_url('assets/vendors/raphael/raphael.js'); ?>"></script>
<script src="<?php echo base_url('assets/vendors/morris.js/morris.js'); ?>"></script>


<script>
    var rangeLink = "<?php echo base_url('admin/report/apiStatistic'); ?>";
    var mealReportLink = "<?php echo base_url('admin/meal/report/'); ?>";
    var myStartDate;
    var myEndDate;


    var expense_lang = "<?= lang('expense') ?>";
    var sale_lang = "<?= lang('sale') ?>";
    var earning_lang = "<?= lang('earnings') ?>";
    var cost_lang = "<?= lang('cost') ?>";
    var most_profitable_items_lang = "<?= lang('most_profitable_items') ?>";
    var most_sold_items_lang = "Liste des articles les plus vendus";
    var price_in_dh_lang = "<?= lang('price_in_dh') ?>";
    var top_providers_orders_lang = "<?= lang("top_providers_orders"); ?>";
    var paid_lang = "<?= lang("paid"); ?>";
    var impaid_lang = "<?= lang("impaid"); ?>";
    var number_of_uses_lang = "<?= lang('number_of_uses') ?>";
    var time_nbr = "<?= lang('time_nbr') ?>";
    var barPayments=null;
</script>
<script src="<?php echo base_url('assets/build2/js/statistic/statistic.js'); ?>"></script>
<!--<script src="<?php /*echo base_url('assets/build2/js/dateRangePickerStatistics.js'); */?>"></script>-->
<script src="<?php echo base_url('assets/build/js/canvasjs.min.js'); ?>"></script>

<script type="text/javascript">
    var params = {
        'params': {
            'sort': true,
            'sort_by': 's_amount',
            'max': 6
        }
    };
    <?php
    $js_array = json_encode($report);
    echo "var report = " . $js_array . ";\n";
    ?>
    updateSpendingGraph(report);
    $(document).ready(function () {
        $.ajax({
            url: "<?php echo base_url(); ?>admin/report/apiReport",
            type: "POST",
            dataType: "json",
            data: params,
            beforeSend: function () {
                $('#loading').show();
            },
            complete: function () {
                $('#loading').hide();
            },
            success: function (data) {
                if (data.status === true) {
                    var amount = [];
                    var quantity = [];
                    var profit = [];
                    updatePaiementsGraph(data.report);
                    $.each(data.articles, function (key, article) {
                        var amountData = {y: parseInt(article['s_amount']), label: article['name']};
                        var quantityData = {y: parseInt(article['s_quantity']), label: article['name']};
                        var profitData = {y: parseInt(article['s_amount']-article['s_cost']), label: article['name']};

                        amount.push(amountData);
                        quantity.push(quantityData);
                        profit.push(profitData);
                    });

                    var chart = new CanvasJS.Chart("chartContainer", {
                        animationEnabled: true,
                        title: {
                            text: most_sold_items_lang
                        },
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
                            name: sale_lang,
                            color: "#34495e",
                            dataPoints: amount
                        }]
                    });
                    chart.render();

                    function toolTipFormatter(e) {
                        var str = "";
                        var total = 0;
                        var str3;
                        var str2;
                        var mostSales;
                        for (var i = 0; i < 1; i++) {
                            var str1 = "<span style= \"color:" + e.entries[i].dataSeries.color + "\">" + e.entries[i].dataSeries.name + "</span>: <strong>" + e.entries[i].dataPoint.y + "</strong> <br/>";
                            var mostSales = "<span style= \"color:" + e.entries[i].dataSeries.color + "\">" + e.entries[i].dataSeries.name + "</span>: <strong>" + e.entries[i].dataPoint.y + "</strong> <br/>";
                            total = e.entries[i].dataPoint.y + total;
                            str = str.concat(str1);
                        }
                        total = parseFloat(e.entries[0].dataPoint.y - e.entries[1].dataPoint.y);
                        str2 = "<strong>" + e.entries[0].dataPoint.label + "</strong> <br/>";
                        str3 = "<span style = \"color:Tomato\">"+cost_lang+": </span><strong>" + total + "</strong><br/>";
                        //return (str2.concat(str)).concat(str3);
                        return mostSales;
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

        function updatePaiementsGraph(data){
            // Bar chart
            var report= data.report;
            var paymentData=[];
            var paymentLabels = [];
            var impaid_amount=0;
            var paid_amount=0;
            var advance=0;

            paymentLabels.push(paid_lang);
            paymentLabels.push(impaid_lang);
            paymentLabels.push('A payer');

            paid_amount=parseFloat(report.payment[0].amount).toFixed(2);
            advance=parseFloat(report.payment[0].amount_advance).toFixed(2);
            impaid_amount=parseFloat(report.payment[1].amount_impaid).toFixed(2);

            paymentData.push(parseFloat(advance)+parseFloat(0));
            paymentData.push(impaid_amount);
            paymentData.push(report.ordersToPayAmount);

            var paymentTitle= {
                display: true,
                text: paid_lang+'-'+impaid_lang
            };
            var datasets=[{
                data: paymentData
            }];
            var backgroundColor = ["#3cba9f", "#c45850","#3e95ce"];
            if (barPayments) {
                barPayments.destroy();
            }
            barPayments=barCart("bar-ordersPayment", paymentLabels, datasets, paymentTitle, backgroundColor);
        }
    });
</script>

<!--Plot_5-->
<script>
    $(document).ready(function () {

        if ($("#chart_plot_05").length) {
            <?php
            $js_array = json_encode($report['sales_history']);
            $js_array_charge = json_encode($report['charges_history']);
            echo "var sales = " . $js_array . ";\n";
            echo "var charges = " . $js_array_charge . ";\n";
            ?>
            var chart_plot_05_data = [];
            var chart_plot_charge_data = [];

            $.each(sales, function (key, sale) {
                chart_plot_05_data.push([new Date(sale['report_date']), sale['s_amount']]);
            });

            $.each(charges, function (key, charge) {
                chart_plot_charge_data.push([new Date(charge['paymentDate']), charge['price']]);
            });

            timeformat = "%d-%m-%y";
            if($(document).width()<= 450){
                timeformat = "%m-%y";
            }
            var min_val=0;
            if(chart_plot_05_data[0]){
                min_val=chart_plot_05_data[0][0];
            }
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
                    mouseActiveRadius: 100,
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
                colors: ['#96CA59', '#FF7070','#3F97EB', '#72c380', '#6f7a8a', '#f7cb38', '#5a8022', '#2c7282'],
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
                    labelAngle:60,
                    minTickSize: [2, "day"],
                    timeformat: timeformat,
                    min: min_val,
                    max: chart_plot_05_data[20]
                }
            };

            $.plot($("#chart_plot_05"),
                [{
                    label: sale_lang,
                    data: chart_plot_05_data,
                    lines: {
                        fillColor: "rgba(150, 202, 89, 0.12)"
                    },
                    points: {
                        fillColor: "#fff"
                    }
                },{
                    label: expense_lang,
                    data: chart_plot_charge_data,
                    lines: {
                        fill:false,
                    },
                    points: {
                        fillColor: "#fff"
                    }
                }], chart_plot_05_settings);

        }

        console.log("chart_plot_charge_data", chart_plot_charge_data);

        /************************Tooltip begin**************************/
        function showChartTooltip(x, y, contents) {
            $('<div id="charttooltip" class="chart-tooltip">' + contents + '<\/div>').css( {
                position: 'absolute',
                display:'none',
                top: y - 25,
                left:x - 25,
                border:'1px solid #bfbfbf',
                padding:'2px',
                'background-color':'#ffffff',
                opacity:1}
            ).appendTo("body").fadeIn(200);
        }

        $("#chart_plot_05").bind("plothover", function (event, pos, item) {
            $("#x").text(pos.x.toFixed(2));
            $("#y").text(pos.y.toFixed(2));
            if (item) {
                $("#charttooltip").remove();
                var x = item.datapoint[0].toFixed(2),
                    y = item.datapoint[1].toFixed(2);
                showChartTooltip(item.pageX, item.pageY, y+'DH');
            } else {
                $("#charttooltip").remove();
            }
        });
        /*************************Tooltip end******************************/




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
                labels: [sale_lang], // ['Licensed', 'SORN']
                hideHover: 'auto',
                xLabelAngle: 60,
                resize: true
            });
        }
    });
</script>
<script>
    $(document).ready(function () {

        $("a[name=printSpendingReport]").on("click", {url: "admin/report/apiPrintSpendingReport"}, printReportEvent);
        $("a[name=printSalesReport]").on("click", {url: "admin/report/apiPrintSalesReport"}, printReportEvent);
        $("a[name=printGlobalReport]").on("click", {url: "admin/report/apiPrintGlobalReport"}, printReportEvent);
        function printReportEvent(event){
            var myData = {
                "startDate": $('#reportrange').data('daterangepicker').startDate.format('YYYY-MM-DD'),
                "endDate": $('#reportrange').data('daterangepicker').endDate.format('YYYY-MM-DD'),
            };
            $.ajax({
                url: "<?php echo base_url(); ?>"+event.data.url,
                type: "POST",
                dataType: "json",
                data: myData,
                beforeSend: function () {
                    $('#loading').show();
                },
                complete: function () {
                    $('#loading').hide();
                },
                success: function (data) {
                    if (data.status === "success") {
                        window.open("<?=base_url()?>" + data.filepath);
                    } else {
                        swal({
                            title: "Erreur",
                            text: "Une erreur s'est produite",
                            type: "warning",
                            timer: 1500,
                            showConfirmButton: false
                        });
                    }
                },
                error: function (data) {
                    swal({
                        title: "Erreur",
                        text: "Une erreur s'est produite",
                        type: "warning",
                        timer: 1500,
                        showConfirmButton: false
                    });
                }
            });
        }
    });
</script>
<script src="<?php echo base_url('assets/build/js/canvasjs.min.js'); ?>"></script>
