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
<div class="container body">
  <!-- page content -->
    <div role="main">
        <div class="">
            <div class="page-title">
                <?php
                    $orders=0;
                    $advances=0;
                    $maintenance=0;
                    $divers=0;
                    $t_salary=0;
                ?>
                <div class="text-center">
                    <h1><?php echo $params['name']; ?></h1>
                </div>
            </div>
            <div class="clearfix"></div>
            <div class="row">

                <div class="text-center">
                    <b><h1><?= lang('expense_report') ?></h1></b>
                </div>
                <div class="text-center">
                    <b> <?= lang('from') ?> <?php echo $startDate; ?> <?= lang('to') ?> <?php echo $endDate; ?> <b/>
                </div>
                <div class="col-md-12 col-sm-12 col-xs-12">


                    <?php if(count($orders_advances)){ ?>
                        <div style="margin-top:30px 0px;">Commandes</div>
                        <table class="table1">
                            <thead class="thead-default">
                            <tr>
                                <th>N° de commande</th>
                                <th><?= lang('price') ?></th>
                                <th><?= lang('date') ?></th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($orders_advances as $orders_advance ) {
                                $advances+=number_format((float)$orders_advance['amount'], 2, '.', '');
                                ?>
                                <tr>
                                    <td><?php echo $orders_advance['order_id']; ?></td>
                                    <td><?php echo number_format((float)$orders_advance['amount'], 2, '.', '') ?></td>
                                    <td><?php echo $orders_advance['paymentDate']; ?></td>
                                </tr>
                            <?php } ?>
                            </tbody>
                        </table>
                    <?php } ?>


                    <?php if(count($orders_advances)){ ?>
                        <div style="margin-top:30px 0px;"><?= lang('products_order') ?></div>
                        <table class="table1">
                            <thead class="thead-default">
                            <tr>
                                <th>N°Commande</th>
                                <th><?= lang('article') ?></th>
                                <th><?= lang('quantity') ?></th>
                                <th><?= lang('unit_price') ?></th>
                                <th><?= lang('total') ?></th>
                                <th><?= lang('provider') ?></th>
                               <!-- <th><?/*= lang('payment') */?></th>-->
                                <th><?= lang('date') ?></th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $id=0;
                            foreach ($stocks_history_order as $stock ) {
                                $paid= lang('impaid');
                                $status= lang('pending');
                                if($stock["paid"]==="true"){
                                    $paid= lang('paid');
                                    //$orders+= ($stock['total']);
                                }else if($stock["advance"]>0){
                                    $paid='Avance('.number_format($stock["advance"],2).')';
                                    //$orders+= $stock['advance'];
                                }
                                if(strtoupper($stock["status"])==="RECEIVED"){
                                    $status = lang('received');
                                }
                                if($id!==$stock['id']){
                                    $id=$stock['id'];
                                    //$orders-=$stock['discount'];
                                }
                            ?>
                            <tr>
                                <td><?php echo $stock['id']; ?></td>
                                <td><?php echo $stock['name']; ?></td>
                                <td><?php echo number_format((float)$stock['quantity'], 2, '.', '') ?></td>
                                <td><?php echo $stock['unit_price']; ?></td>
                                <td><?php echo number_format((float)$stock['total'], 2, '.', '') ?></td>
                                <td><?php echo $stock['pv_name'];?></td>
                               <!-- <td><?php /*echo $paid;*/?></td>-->
                                <td><?php echo $stock["paymentDate"];?></td>
                            </tr>
                            <?php } ?>
                            </tbody>
                        </table>
                    <?php } ?>




                    <?php if(count($purchases)){ ?>
                        <div style="margin-top:30px 0px;"><?= lang('various_purchases') ?></div>
                        <table class="table1">
                            <thead>
                            <tr>
                                <th><?= lang('article') ?></th>
                                <th><?= lang('quantity') ?></th>
                                <th><?= lang('unit_price') ?></th>
                                <th><?= lang('total') ?></th>
                                <th><?= lang('provider') ?></th>
                                <th><?= lang('payment') ?></th>
                                <th><?= lang('date') ?></th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($purchases as $purchase ) {
                                $paid = lang("impaid");
                                if ($purchase["paid"] === "true") {
                                    $paid = lang("paid");
                                    $divers+= $purchase['price'];
                                }
                            ?>
                            <tr>
                                <td><?php echo $purchase['article']; ?></td>
                                <td><?php echo $purchase['quantity']; ?></td>
                                <td><?php echo $purchase['price']/$purchase['quantity']; ?></td>
                                <td><?php echo $purchase['price']; ?></td>
                                <td><?php echo $purchase['provider'];?></td>
                                <td><?php echo $paid; ?></td>
                                <td><?php echo $purchase["date"];?></td>
                            </tr>
                            <?php } ?>
                            </tbody>
                        </table>
                    <?php } ?>



                    <?php if(count($reparations)){ ?>
                        <div style="margin-top:30px 0px;"><?= lang('maintenance') ?></div>
                        <table class="table1">
                            <thead>
                            <tr>
                                <th><?= lang('article') ?></th>
                                <th><?= lang('price') ?></th>
                                <th><?= lang('problem') ?></th>
                                <th><?= lang('repairer') ?></th>
                                <th><?= lang('date') ?></th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($reparations as $reparation ) {
                                $maintenance += $reparation['price'];
                            ?>
                            <tr>
                                <td><?php echo $reparation['article']; ?></td>
                                <td><?php echo $reparation['price']; ?></td>
                                <td><?php echo $reparation['problem']; ?></td>
                                <td><?php echo $reparation['repairer']; ?></td>
                                <td><?php echo $reparation["date"];?></td>
                            </tr>
                            <?php } ?>
                            </tbody>
                        </table>
                    <?php } ?>

                    <?php if(count($employees_advance) and $params['pack']==="pro"){ ?>
                        <div style="margin-top:30px 0px;"><?= lang('employees') ?> : <?= lang('advances') ?></div>
                        <table class="table1">
                            <thead>
                            <tr>
                                <th><?= lang('name') ?></th>
                                <th><?= lang('advance') ?></th>
                                <th><?= lang('date') ?></th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($employees_advances as $employees_advance ) {
                                /*$maintenance += $reparation['price'];*/
                                $t_salary+= $employees_advance["advance_amount"];
                            ?>
                            <tr>
                                <td><?php echo $employees_advance['name']." ". $employees_advance['prenom']; ?></td>
                                <td><?php echo $employees_advance['advance_amount']; ?></td>
                                <td><?php echo $employees_advance["day"];?></td>
                            </tr>
                            <?php } ?>
                            </tbody>
                        </table>
                    <?php } ?>

                    <?php if(count($salaries) and $params['pack']==="pro"){ ?>
                        <div style="margin-top:30px 0px;"><?= lang('employees') ?> : <?= lang('salaries') ?></div>
                        <table class="table1">
                            <thead>
                            <tr>
                                <th><?= lang('name') ?></th>
                                <th><?= lang('salary') ?></th>
                                <th><?= lang('advance') ?></th>
                                <th><?= lang('absences') ?></th>
                                <th><?= lang('substraction') ?></th>
                                <th><?= lang('remain') ?></th>
                                <th><?= lang('date_of_payment') ?></th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($salaries as $salary ) {
                                $t_salary += $salary['remain'];

                            ?>
                            <tr>
                                <td><?php echo $salary['name']." ".$salary['prenom']; ?></td>
                                <td><?php echo $salary['s_salary']; ?></td>
                                <td><?php echo $salary["advance"];?></td>
                                <td><?php echo $salary["absence"];?></td>
                                <td><?php echo $salary["substraction"];?></td>
                                <td><?php echo $salary["remain"];?></td>
                                <td><?php echo $salary["paymentDate"];?></td>
                            </tr>
                            <?php } ?>
                            </tbody>
                        </table>
                    <?php } ?>

                    <div style="margin-top:30px 0px;"><?= lang('total') ?></div>

                    <?php if($params['pack']==='pro'){ ?>
                    <table class="table1">
                        <thead>
                        <tr>
                            <th><?= lang('products_order') ?></th>
                            <th><?= lang('various') ?></th>
                            <th><?= lang('maintenance') ?></th>
                            <th><?= lang('salary') ?></th>
                            <th><?= lang('total') ?></th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td><?php echo $orders+$advances; ?></td>
                            <td><?php echo $divers; ?></td>
                            <td><?php echo $maintenance; ?></td>
                            <td><?php echo $t_salary; ?></td>
                            <td><?php echo $orders+$advances+$divers+$maintenance+$t_salary; ?></td>
                        </tr>
                        </tbody>
                    </table>
                    <?php }else if($params['pack']==='starter'){
                        $t_salary=0;
                        ?>
                        <table class="table1">
                            <thead>
                            <tr>
                                <th><?= lang('products_order') ?></th>
                                <th><?= lang('various') ?></th>
                                <th><?= lang('maintenance') ?></th>
                                <th><?= lang('total') ?></th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td><?php echo $orders+$advances; ?></td>
                                <td><?php echo $divers; ?></td>
                                <td><?php echo $maintenance; ?></td>
                                <td><?php echo $orders+$advances+$divers+$maintenance+$t_salary; ?></td>
                            </tr>
                            </tbody>
                        </table>
                    <?php } ?>
                    <!--<table class="table2 text-center" >
                        <tr>
                            <td colspan="4" class="text-right">SOUS TOTAL</td>
                            <td width="23%">55</td>
                        </tr>
                        <tr>
                            <td colspan="4" class="text-right">TVA</td>
                            <td >55</td>
                        </tr>
                        <tr>
                            <td colspan="4" class="text-right">FRAIS LIVRAISON</td>
                            <td >55</td>
                        </tr>
                        <tr>
                            <td colspan="4" class="text-right">AUTRE</td>
                            <td >55</td>
                        </tr>
                        <tr>
                            <td colspan="4" class="text-right">TOTAL</td>
                            <td >55</td>
                        </tr>
                        </tbody>
                    </table>-->
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

