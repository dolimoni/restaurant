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
                    <b><h1>Rapport des dépenses</h1></b>
                </div>
                <div class="text-center">
                    <b> Du <?php echo $startDate; ?> au <?php echo $endDate; ?> <b/>
                </div>
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div style="margin-top:30px 0px;">Commandes produits</div>
                    <table class="table1">
                        <thead class="thead-default">
                        <tr>
                            <th>Article</th>
                            <th>Quantité</th>
                            <th>Prix unitaire</th>
                            <th>Total</th>
                            <th>Fournisseur</th>
                            <th>Paiement</th>
                            <th>Date</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($stocks_history_order as $stock ) {
                            $paid="Impayée";
                            $status="En attente";
                            if($stock["paid"]==="true"){
                                $paid="Payée";
                                $orders+= $stock['total'];
                            }
                            if(strtoupper($stock["status"])==="RECEIVED"){
                                $status = "Reçue";
                            }
                        ?>
                        <tr>
                            <td><?php echo $stock['name']; ?></td>
                            <td><?php echo $stock['quantity']; ?></td>
                            <td><?php echo $stock['unit_price']; ?></td>
                            <td><?php echo $stock['total']; ?></td>
                            <td><?php echo $stock['pv_name'];?></td>
                            <td><?php echo $paid;?></td>
                            <td><?php echo $stock["date_commande"];?></td>
                        </tr>
                        <?php } ?>
                        </tbody>
                    </table>
                    <!--<table class="table1">
                        <thead class="thead-default">
                        <tr>
                            <th>Article</th>
                            <th>Quantité</th>
                            <th>Prix unitaire</th>
                            <th>Total</th>
                            <th>Fournisseur</th>
                            <th>Paiement</th>
                            <th>date</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php /*foreach ($stocks_history as $stock ) { */?>
                        <tr>
                            <td><?php /*echo $stock['name']; */?></td>
                            <td><?php /*echo $stock['quantity']; */?></td>
                            <td><?php /*echo $stock['unit_price']; */?></td>
                            <td><?php /*echo $stock['total']; */?></td>
                            <td><?php /*echo $stock['pv_name'];*/?></td>
                            <td>Payée</td>
                            <td><?php /*echo $stock["date_commande"];*/?></td>
                        </tr>
                        <?php /*} */?>
                        </tbody>
                    </table>-->
                    <div style="margin-top:30px 0px;">Achats divers</div>
                    <table class="table1">
                        <thead>
                        <tr>
                            <th>Article</th>
                            <th>Quantité</th>
                            <th>Prix unitaire</th>
                            <th>Total</th>
                            <th>Fournisseur</th>
                            <th>Paiement</th>
                            <th>Date</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($purchases as $purchase ) {
                            $paid = "Impayée";
                            if ($purchase["paid"] === "true") {
                                $paid = "Payée";
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



                    <div style="margin-top:30px 0px;">Maintenace</div>
                    <table class="table1">
                        <thead>
                        <tr>
                            <th>Article</th>
                            <th>Prix</th>
                            <th>Problème</th>
                            <th>Réparateur</th>
                            <th>Date</th>
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

                    <div style="margin-top:30px 0px;">Employées : avances</div>
                    <table class="table1">
                        <thead>
                        <tr>
                            <th>Nom</th>
                            <th>Avance</th>
                            <th>Date</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($advances as $advance ) {
                            /*$maintenance += $reparation['price'];*/
                            $t_salary+= $advance["advance_amount"];
                        ?>
                        <tr>
                            <td><?php echo $advance['name']." ". $advance['prenom']; ?></td>
                            <td><?php echo $advance['advance_amount']; ?></td>
                            <td><?php echo $advance["day"];?></td>
                        </tr>
                        <?php } ?>
                        </tbody>
                    </table>
                    <div style="margin-top:30px 0px;">Employées : Salaires</div>
                    <table class="table1">
                        <thead>
                        <tr>
                            <th>Nom</th>
                            <th>Salaire</th>
                            <th>Avance</th>
                            <th>Absences</th>
                            <th>Soustraction</th>
                            <th>Reste</th>
                            <th>Date de paiement</th>
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

                    <div style="margin-top:30px 0px;">Total</div>
                    <table class="table1">
                        <thead>
                        <tr>
                            <th>Commandes produits</th>
                            <th>Divers</th>
                            <th>Maintenance</th>
                            <th>Salaire</th>
                            <th>Total</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td><?php echo $orders; ?></td>
                            <td><?php echo $divers; ?></td>
                            <td><?php echo $maintenance; ?></td>
                            <td><?php echo $t_salary; ?></td>
                            <td><?php echo $orders+$divers+$maintenance+$t_salary; ?></td>
                        </tr>
                        </tbody>
                    </table>
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

