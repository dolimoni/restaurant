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
        table, td, th {
            border: 1px solid #ddd;
            text-align: left;
        }

        table {
            border-collapse: collapse;
            width: 100%;
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
            <div class="title_left">
                <h3>Article</h3>
            </div>
        </div>
        <div class="clearfix"></div>
        <hr>
        <div class="row">
            <h1 class="text-center"><?php echo $meal['name']; ?></h1>
            <div class="col-md-12 col-sm-12 col-xs-12">
                <table class="table">
                    <thead class="thead-default">
                    <tr>
                        <th>Id</th>
                        <th>Produit</th>
                        <th>Quantité</th>
                        <th>Coût</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($products as $product) { ?>
                    <tr class=".success">
                        <th scope="row"><?php echo $product['id']; ?></th>
                        <td><?php echo $product['name']; ?></td>
                        <td><?php echo $product['name']; ?></td>
                        <td><?php echo $product['unit_price']; ?></td>
                    </tr>
                   <?php } ?>
                    <tr>
                        <td hiddenn></td>
                        <td hidden></td>
                        <td>Total</td>
                        <td>500.22 DH</td>
                    </tr>
                    </tbody>
                </table>
            </div> <!-- /col -->



        </div> <!-- /row --> 
    </div>

</div> <!-- /.col-right -->


</div>


<div style="position:absolute;bottom:50px;">
    <i>Nom du restaurant</i>
</div>
<div style="position: absolute;bottom: 50px;right: 120px;">
    <b>Casablanca, le <?php echo date('d m Y')?></b>
</div>

</div>


</body>
</html>

