<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Restaurant</title>


    <!-- Bootstrap -->
    <link href="<?php echo base_url("assets/vendors/bootstrap/dist/css/bootstrap.min.css"); ?>" rel="stylesheet">
    <link href="<?php echo base_url("assets/css/main.css"); ?>" rel="stylesheet">

    <style>
        h1 h2 h3 h4 h5 h6 {
            color: #768399;
        }

        table,td, th {
            border: 1px solid #ddd;
            text-align: left;
        }

        .table1 tr{
            border: 1px;
        }

        .table1 th {
            border: 1px solid #ddd;
            text-align: left;
            background: #ddd;
            color: black;
        }

        .table1 {
            border-collapse: collapse;
            width: 100%;
        }
        .table2{
            width: 100%;
            /*border-left: none;*/
            border-bottom: none;
            text-align: right;
        }
        .table2 td{
            border-left: none;
        }
        .table2 td:nth-child(1){
            border-bottom: none;
            border-top: none;
        }

        .table2 tr{
           /* border: none;*/
            text-align: right;
        }
        .table2 td{
            padding:8px;
        }

        th, td {
            padding: 15px;
        }
    </style>

</head>

<body style="background: none; width: 80%; margin: auto;color:#768399;">
<?php
$turnover_total=0;
$charge_total=0;
?>
<div class="container body">
  <!-- page content -->
    <div role="main">
        <div class="">
            <div class="page-title">

                <div class="text-center">
                    <h1><?php echo $params['name']; ?></h1>
                </div>
            </div>
            <div class="clearfix"></div>
            <div class="row">

                <div class="text-center">
                    <b><h1><?= lang('global_report') ?></h1></b>
                </div>
                <div class="text-center">
                    <b> <?= lang('from') ?> <?php echo $startDate; ?> <?= lang('to') ?> <?php echo $endDate; ?> <b/>
                </div>
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <table class="table1">
                        <thead class="thead-default">
                        <tr>
                            <th><?= lang('turnover') ?></th>
                            <th><?= lang('expense') ?></th>
                            <th><?= lang('earnings') ?></th>
                            <th><?= lang('date') ?></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($sales_charges_history as $sale_charge_history ){
                        $turnover= number_format((float)$sale_charge_history['s_amount'], 2, '.', '');
                        $charge= number_format((float)$sale_charge_history['price'], 2, '.', '');
                        $turnover_total+= $turnover;
                        $charge_total+= $charge;
                        ?>
                        <tr>
                            <td><?php echo $turnover ?></td>
                            <td><?php echo $charge; ?></td>
                            <td><?php echo $turnover-$charge ?></td>
                            <td><?php echo $sale_charge_history["report_date"]; ?></td>
                        </tr>
                        <?php } ?>
                        </tbody>
                    </table>

                    <div style="margin-top:30px 0px;"><?= lang('total') ?></div>
                    <table class="table1">
                        <thead>
                        <tr>
                            <th><?= lang('turnover') ?></th>
                            <th><?= lang('expense') ?></th>
                            <th><?= lang('earnings') ?></th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td><?php echo $turnover_total; ?></td>
                            <td><?php echo $charge_total; ?></td>
                            <td><?php echo $turnover_total- $charge_total; ?></td>
                        </tr>
                        </tbody>
                    </table>
                </div> <!-- /col -->


            </div> <!-- /row -->
        </div>

    </div> <!-- /.col-right -->


</div>


<div style="position:absolute;bottom:50px;">
    <i><?php echo $params['name']; ?></i>
</div>
<div style="position: absolute;bottom: 50px;right: 120px;">
    <b>Casablanca, le <?php echo date('d m Y') ?></b>
</div>

</div>


</body>
</html>

