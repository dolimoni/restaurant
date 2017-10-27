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
                <div class="text-center">
                    <h1>Ruban d'or</h1>
                </div>
            </div>
            <div class="clearfix"></div>
            <div class="row">
                <div>
                    Adresse
                </div>
                <div>
                    Rue Al Amal, El Jadida, Maroc
                </div>
                <div>Téléphone <span>: +212 5233-70656</span></div>

                <h3>A</h3>
                <div>
                        <div style="float: left">
                            <div>Nom : <span><?php echo $order['provider']['firstName'] . ' ' . $order['provider']['lastName']; ?></span></div>
                            <div>Entreprise : <span>-</span></div>
                            <div>Adresse : <span><?php echo $order['provider']['address'];?></span></div>
                            <div>Téléphone : <span><?php echo $order['provider']['phone'];?></span></div>
                        </div>
                        <div style="margin-top: -80px;margin-left: 500px;" >
                            <div>Nom : <span>Ruban d'or</span></div>
                            <div>Entreprise : <span>Ruban d'or</span></div>
                            <div>Adresse : <span>Rue Al Amal, El Jadida, Maroc</span></div>
                            <div>Téléphone : <span>+212 5233-70656</span></div>
                        </div>
                </div>
                <div class="text-center">
                    B.C. N°: 55
                </div>

                <div class="text-center">
                    <b><h1>BON DE COMMMANDE</h1></b>
                </div>
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <table class="table1">
                        <thead class="thead-default">
                        <tr>
                            <th>Article</th>
                            <th>Quantité</th>
                            <th>Prix unitaire</th>
                            <th>Unité</th>
                            <th width="23%">Total</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($order['productsList'] as $product ) { ?>
                        <tr>
                            <td><?php echo $product['name']; ?></td>
                            <td><?php echo $product['quantity']; ?></td>
                            <td><?php echo $product['unit_price']; ?></td>
                            <td><?php echo $product['unit']; ?></td>
                            <td><?php echo $product['quantity']* $product['unit_price'];?></td>

                        </tr>
                        <?php } ?>
                        </tbody>
                    </table>
                    <table class="table2 text-center" >
                        <tr>
                            <td colspan="4" class="text-right">SOUS TOTAL</td>
                            <td width="23%"><?php echo $order['underTotal'];?></td>
                        </tr>
                        <tr>
                            <td colspan="4" class="text-right">TVA</td>
                            <td ><?php echo $order['tva']*100; ?>%</td>
                        </tr>
                        <tr>
                            <td colspan="4" class="text-right">FRAIS LIVRAISON</td>
                            <td ><?php echo $order['shipping'] ; ?></td>
                        </tr>
                        <tr>
                            <td colspan="4" class="text-right">AUTRE</td>
                            <td ><?php echo $order['other'] ; ?></td>
                        </tr>
                        <tr>
                            <td colspan="4" class="text-right">TOTAL</td>
                            <td ><?php echo $order['underTotal']*(1+$order['tva']); ?>DH</td>
                        </tr>
                        </tbody>
                    </table>
                </div> <!-- /col -->


            </div> <!-- /row -->
        </div>

    </div> <!-- /.col-right -->


</div>


<div style="position:absolute;bottom:50px;">
    <i>Ruban d'or</i>
</div>
<div style="position: absolute;bottom: 50px;right: 120px;">
    <b>Casablanca, le <?php echo date('d m Y') ?></b>
</div>

</div>


</body>
</html>

