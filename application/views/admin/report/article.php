<?php $this->load->view('admin/partials/admin_header.php'); ?>
<style>
    .validate {
        background: #26b99a !important;
        color: white;
    }

    @media (max-width: 480px) {
        #datatable-sales_filter{
            float: left !important;
            text-align: left !important;
        }
        #reportrange{
            float:left !important;
        }
    }
</style>
<!-- page content -->
<div class="right_col" role="main">
   <!-- <div class="well" style="overflow: auto">
        <div class="col-md-12">
            <div id="reportrange" class="pull-right"
                 style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc">
                <i class="glyphicon glyphicon-calendar fa fa-calendar"></i>
                <span>December 30, 2014 - January 28, 2015</span> <b class="caret"></b>
            </div>
        </div>
    </div>-->
    <div class="">
        <div class="page-title">
           <!-- <pre>
                <?php /*print_r($articles); */?>
            </pre>-->
            <div class="title_left">
                <h3><?= lang("articles") ?></h3>
            </div>
        </div>
        <div class="clearfix"></div>
        <hr>
        <div id="chartContainer" style="height: 370px; width: 100%;"></div>
        <div class="row">

            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2><?= lang("article_report") ?></h2>
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
                    <div class="x_content table-responsive">
                        <table class="table table-striped" id="datatable-sales">
                            <thead>
                            <tr>
                                <th>
                                    <?= lang("name") ?>
                                </th>
                                <th>
                                    <?= lang("quantity") ?>
                                </th>
                                <th>
                                    <?= lang("amount") ?>
                                </th>
                                <th style="background: #6cc;color: white;">
                                    <?= lang("earnings") ?>
                                </th>
                                <th class="danger">
                                    <?= lang("cost") ?>
                                </th>
                                <th>
                                    Actions
                                </th>
                            </tr>
                            </thead>
                            <tbody id="tbodyid">
                            <?php
                            $t_quantity=0;
                            $t_amount=0;
                            $t_profits=0;
                            $t_costs=0;
                            foreach ($articles as $article) {
                                $t_quantity+= $article['s_quantity'];
                                $t_amount+= $article['s_amount'];
                                $u_profit= $article['s_amount'] - $article['s_cost'];
                                if($u_profit>=0){
                                    $t_profits+= $u_profit;
                                }else{
                                    //$u_profit=0;
                                }
                                $t_costs+= $article['s_cost'];
                            ?>
                                <tr data-id="">
                                    <td data-type="name"> <?php echo $article['name']; ?></td>
                                    <td data-type="quantity"><?php echo $article['s_quantity']; ?></td>
                                    <td data-type="amount">
                                        <?php echo number_format((float)$article['s_amount'], 2, '.', ''); ?>DH
                                    </td>
                                    <td data-type="benefit" style="background: #6cc; color: white;"><?php echo number_format((float)$u_profit, 2, '.', ''); ?> DH</td>
                                    <td data-type="cost" class="danger"><?php echo number_format((float)$article['s_cost'], 2, '.', ''); ?> DH</td>
                                    <td>
                                        <!--<button class="btn btn-danger btn-xs action" data-type="delete"
                                                data-toggle="modal" data-target="#delete"><span
                                                class="glyphicon glyphicon-trash"></span></button>-->
                                        <button class="btn btn-success btn-xs action"
                                                onclick="window.location.href='<?php echo base_url('admin/meal/report/'.$article['meal']); ?>'"><span
                                                    class="fa fa-eye"></span></button>
                                    </td>
                                </tr>
                            <?php } ?>

                            <tr>
                                <td>#</td>
                                <td><?php echo $t_quantity; ?></td>
                                <td><?= lang("total") ?> : <?php echo number_format((float)$t_amount, 2, '.', ''); ?>DH</td>
                                <td style="background: #6cc;color: white;"><?= lang("total") ?>
                                    : <?php echo number_format((float)$t_profits, 2, '.', ''); ?>DH
                                </td>
                                <td class="danger"><?= lang("total") ?>
                                    : <?php echo number_format((float)$t_costs, 2, '.', ''); ?>
                                    DH
                                </td>
                                <td>
                                    <button class="btn btn-success btn-xs action"
                                            onclick="window.location.href='<?php echo base_url('admin/report/statistic'); ?>'"><span
                                                class="fa fa-eye"></span></button>
                                </td>
                            </tr>

                            </tbody>


                            <tfoot>
                            <tr>
                                <th>
                                    <?= lang("name") ?>
                                </th>
                                <th>
                                    <?= lang("quantity") ?>
                                </th>
                                <th>
                                    <?= lang("amount") ?>
                                </th>
                                <th style="background: #6cc;color: white;">
                                    <?= lang("earnings") ?>
                                </th>
                                <th class="danger">
                                    <?= lang("cost") ?>
                                </th>
                                <th>
                                    Actions
                                </th>
                            </tr>
                            </tfoot>
                        </table>
                    </div> <!-- /content -->
                </div><!-- /x-panel -->
            </div> <!-- /col -->
        </div> <!-- /row -->
    </div>
</div> <!-- /.col-right -->
<!-- /page content -->

<?php $this->load->view('admin/partials/admin_footer'); ?>
<script>
    var most_profitable_items_lang="<?= lang("most_profitable_items") ?>";
    var most_sold_items_lang="Liste des articles les plus vendus";
    var price_in_dh_lang="<?= lang("price_in_dh") ?>";
    var sale_lang="<?= lang("sale") ?>";
    var earnings_lang="<?= lang("earnings") ?>";
</script>
<!-- bootstrap-daterangepicker -->
<script src="<?php echo base_url('assets/vendors/moment/min/moment.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/vendors/bootstrap-daterangepicker/daterangepicker.js'); ?>"></script>

<!-- ECharts -->
<script src="<?php echo base_url('assets/vendors/echarts/dist/echarts.js'); ?>"></script>


<script>
    var rangeLink = "<?php echo base_url('admin/report/apiRange'); ?>";
    var mealReportLink = "<?php echo base_url('admin/meal/report/'); ?>";
    var table_meals;
    $(document).ready(function () {
        var handleDataTableButtons = function () {
            if ($("#datatable-sales").length) {
                table_meals = $("#datatable-sales").DataTable({
                    "columns": [
                        {"data": "name"},
                        {"data": "quantity"},
                        {"data": "amount"},
                        {"data": "earnings"},
                        {"data": "cost"},
                        {"data": "actions"},
                    ],
                    responsive: true,
                    "lengthMenu": [[25, 50, 200, -1], [25, 50, 200, "Tout"]],
                    "bSort": false,
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

<script src="<?php echo base_url('assets/build2/js/dateRangePicker.js'); ?>"></script>
<script src="<?php echo base_url("assets/vendors/datatables.net/js/jquery.dataTables.min.js"); ?>"></script>


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
                        for (var i = 0; i < e.entries.length; i++) {
                            var str1 = "<span style= \"color:" + e.entries[i].dataSeries.color + "\">" + e.entries[i].dataSeries.name + "</span>: <strong>" + e.entries[i].dataPoint.y + "</strong> <br/>";
                            mostSales = "<span style= \"color:" + e.entries[i].dataSeries.color + "\">" + e.entries[i].dataSeries.name + "</span>: <strong>" + e.entries[i].dataPoint.y + "</strong> <br/>";
                            total = e.entries[i].dataPoint.y + total;
                            str = str.concat(str1);
                        }
                        total = parseFloat(e.entries[0].dataPoint.y - e.entries[1].dataPoint.y);
                        str2 = "<strong>" + e.entries[0].dataPoint.label + "</strong> <br/>";
                        str3 = "<span style = \"color:Tomato\">Coût: </span><strong>" + total + "</strong><br/>";
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
    });
</script>
<script src="<?php echo base_url('assets/build/js/canvasjs.min.js'); ?>"></script>
