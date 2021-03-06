<?php $this->load->view('admin/partials/admin_header.php');

?>

<!-- page content -->
<div class="right_col" role="main">
    <div class="productsList">
       <!-- <pre>
            <?php /*print_r($report); */?>
        </pre>-->
        <div class="page-title">
            <div class="title_left">
                <h3>Modifier le produit : <?php echo $product['name']; ?></h3>
            </div>
        </div>
        <div class="clearfix"></div>
        <hr>




        <div class="col-xs-12 " >
            <div class="x_panel">
                <div class="x_title">
                    <h2>Détails des quantités</h2>
                    <ul class="nav navbar-right panel_toolbox">
                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                        <li><a class="close-link"><i class="fa fa-close"></i></a></li>
                    </ul>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <h4>Quantité/Prix</h4>
                    <div class="table-responsive">
                        <table id="datatable-quantityy" class="table table-striped table-bordered dt-responsive nowrap"
                               cellspacing="0" width="100%">
                            <thead>
                            <tr>
                                <th>Quantité</th>
                                <th>Prix</th>
                                <th>Fournisseur</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tfoot>
                            <tr>
                                <th>Quantité</th>
                                <th>Prix</th>
                                <th>Fournisseur</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                            </tfoot>
                            <tbody>
                            <?php foreach ($quantities as $quantity) {
                                $validate = "";
                                /* if($quantity['status'] === "active"){
                                     $validate="validate";
                                 }*/
                                ?>
                                <tr class="<?php echo $validate; ?>">
                                    <td><?php echo $quantity['quantity'] ?></td>
                                    <td><?php echo $quantity['unit_price'] ?></td>
                                    <td><?php echo ucfirst($quantity['pv_name']) ?></td>
                                    <td><?php echo ucfirst($quantity['status']) ?></td>
                                    <td width="13%">
                                        <?php if ($quantity['status'] !== "active") { ?>
                                            <button data-id="<?php echo $quantity['id'] ?>"
                                                    class="btn btn-info btn-xs action activate"><span
                                                        class="glyphicon glyphicon-ok"></span></button>
                                        <?php } ?>
                                        <button data-id="<?php echo $quantity['id'] ?>"
                                                data-quantity="<?php echo $quantity['unit_price'] ?>"
                                                data-provider="<?php echo $quantity['pv_id'] ?>"
                                                class="btn btn-warning btn-xs action edit"><span
                                                    class="glyphicon glyphicon-edit"></span></button>
                                        <a href="<?php echo base_url("admin/provider/show/". $quantity["pv_id"]); ?>" class="btn btn-success btn-xs action edit"><span
                                                    class="glyphicon glyphicon-shopping-cart"></span></a>

                                    </td>
                                </tr>
                            <?php } ?>
                            </tbody>
                        </table>
                    </div>

                    <?php if ($params['department'] === "true") { ?>
                    <h4>Quantité/Département</h4>
                    <div class="row"></div>
                    <div class="row"></div>
                    <table id="datatable-department" class="table table-striped table-bordered dt-responsive nowrap"
                           cellspacing="0" width="100%">
                        <thead>
                        <tr>
                            <th>Département</th>
                            <th>Quantité</th>
                        </tr>
                        </thead>
                        <tfoot>
                        <tr>
                            <th>Département</th>
                            <th>Quantité</th>
                        </tr>
                        </tfoot>
                        <tbody>
                        <?php foreach ($departments as $department) {
                            ?>
                            <tr>
                                <td><?php echo $department['name'] ?></td>
                                <td><?php echo $department['quantity'] ?></td>
                            </tr>
                        <?php } ?>
                       <!-- <tr>
                            <td>Économat</td>
                            <td><?php /*echo array_sum(array_column($quantities, 'quantity')) - array_sum(array_column($departments, 'quantity')); */?></td>
                        </tr>-->
                        </tbody>
                    </table>
                    <?php } ?>

                </div> <!-- /content -->
            </div><!-- /x-panel -->
        </div>



        <div class="row productsListContent">
            <div class="row">
                <div class="col-md-offset-3 col-md-6 col-sm-12 col-xs-12 productItem" id="productPanel" data-id="1">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2>Produit</h2>
                            <ul class="nav navbar-right panel_toolbox">
                                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                                <!-- <li><a class="close-link"><i class="fa fa-close"></i></a></li>-->
                            </ul>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">
                            <label><?php /*echo $message;*/ ?></label>
                            <form method="post" id="editProductForm">
                                <fieldset>
                                    <input name="id" type="hidden" value="<?php echo $product['id']; ?>"/>
                                    <div class="form-group">
                                        Produit : <input value="<?php echo $product['name']; ?>" class="form-control"
                                                         placeholder="Produit" name="name"
                                                         id="username" type="text">
                                    </div>
                                    <div class="form-group" hidden>
                                        Nouvelle quantité : <input class="form-control" placeholder="Quantité"
                                                                   name="quantity"
                                                                   type="text" >
                                    </div>
                                    <div class="form-group">
                                        Unité de mesure :
                                        <select class="form-control" name="unit">
                                            <option name="unit"
                                                    value="kg" <?php if ($product['unit'] === "kg") echo "selected"; ?>>
                                                Kg
                                            </option>
                                            <option name="unit"
                                                    value="L" <?php if ($product['unit'] === "L") echo "selected"; ?>>L
                                            </option>
                                            <option name="unit"
                                                    value="pcs" <?php if ($product['unit'] === "pcs") echo "selected"; ?> >
                                                Pcs
                                            </option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        Fournisseur :
                                        <select class="form-control" name="provider">
                                            <option value="0">Aucun</option>
                                            <?php foreach ($providers as $provider) {
                                                $selected = '';
                                                if ($provider['id'] === $product['provider']) {
                                                    $selected = "selected";
                                                }
                                                $providerName = $provider['name'];
                                                if ($providerName === "") {
                                                    $providerName = $provider['title'];
                                                }
                                                ?>
                                                ?>
                                                <option name="provider"
                                                        value="<?php echo $provider['id']; ?>" <?php echo $selected; ?>><?php echo $providerName; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        Prix unitaire : <input value="<?php echo $product['unit_price']; ?>"
                                                               class="form-control" placeholder="Prix unitaire"
                                                               name="unit_price" type="text">
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" checked="checked" name="newUserQuantity"> Créer
                                                nouveau stock si le prix ou le fournisseur sont différents
                                            </label>
                                        </div>

                                    </div>
                                    <div class="form-group">
                                        Poid par unité(en gr)<input value="<?php echo $product['weightByUnit']; ?>"
                                                                    class="form-control" placeholder="Poid par unité"
                                                                    name="weightByUnit">
                                    </div>

                                    <div class="form-group">
                                        Quantité minimum du stock : <input
                                                value="<?php echo $product['min_quantity']; ?>" class="form-control"
                                                placeholder="Prix unitaire"
                                                name="min_quantity" type="text">
                                    </div>
                                    <div class="form-group">
                                        Consomation par jour : <input value="<?php echo $product['daily_quantity']; ?>"
                                                                      class="form-control" placeholder="Quantité"
                                                                      name="daily_quantity"
                                                                      type="text">


                                        <div class="form-group">
                                            Perte : <input class="form-control" placeholder="Quantité"
                                                           name="lostQuantity"
                                                           type="number">
                                        </div>
                                        <br/>
                                        <!-- <input type="submit" name="buttonSubmit" value="Confirmer" class="btn btn-success" />
                                         <div value="Nouveau produit" class="btn btn-info newProduct" >Nouveau produit</div>-->
                                        <div class="text-center">
                                            <input type="submit" name="buttonSubmit" value="Enregistrer"
                                                   class="btn btn-success "/>
                                            <input type="button" name="saveAndGo" value="Enregistrer et passer au suivant"
                                                   class="btn btn-info "/>
                                           <!-- <input type="submit" name="buttonSubmit" value="Confirmer et passer au suivant"
                                                   class="btn btn-info"/>-->
                                        </div>
                                </fieldset>
                            </form>
                        </div> <!-- /content -->
                    </div><!-- /x-panel -->
                </div>
            </div>
        </div>

    </div>

</div> <!-- /.col-right -->
<!-- /page content -->

<?php $this->load->view('admin/partials/admin_footer'); ?>
<script src="<?php echo base_url("assets/vendors/datatables.net/js/jquery.dataTables.min.js"); ?>"></script>


<script>
    $(document).ready(function () {
        var handleDataTableButtons = function () {
            if ($("#datatable-quantity").length) {
                $("#datatable-quantity").DataTable({

                    responsive: true,
                    "lengthMenu": [[5, 10, 50, -1], [5, 10, 50, "Tout"]],
                    "language": {
                        "url": "<?php echo base_url("assets/vendors/datatables.net/French.json"); ?>"
                    },
                   /* "bPaginate": false,*/
                    "bLengthChange": false,
                    "bFilter": true,
                    "bInfo": false,
                    "bAutoWidth": false,
                    "searching":false

                });
            }
            if ($("#datatable-department").length) {
                $("#datatable-department").DataTable({

                    responsive: true,
                    "lengthMenu": [[5, 10, 50, -1], [5, 10, 50, "Tout"]],
                    "language": {
                        "url": "<?php echo base_url("assets/vendors/datatables.net/French.json"); ?>"
                    },
                    "bPaginate": false,
                    "bLengthChange": false,
                    "bFilter": true,
                    "bInfo": false,
                    "bAutoWidth": false,
                    "searching": false

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

<script>

    var old_unit="<?php echo $product["unit"]; ?>";
    console.log(old_unit);
    $(document).ready(function () {
        $("input[name=saveAndGo]").on("click", {saveType: "saveAndGo"},save)
        $('#editProductForm').submit({saveType:"simple"},save);

        function save(e) {
            e.preventDefault();
            var newUserQuantity = "true";
            var id = $('input[name="id"]').val();
            var name = $('input[name="name"]').val();
            var quantity = $('input[name="quantity"]').val();
            var unit = $('select[name="unit"]').val();
            var unit_price = $('input[name="unit_price"]').val();
            var weightByUnit = $('input[name="weightByUnit"]').val();
            var daily_quantity = $('input[name="daily_quantity"]').val();
            var min_quantity = $('input[name="min_quantity"]').val();
            var lostQuantity = $('input[name="lostQuantity"]').val();
            newUserQuantity = $('input[name="newUserQuantity"]').is(':checked');
            if (lostQuantity == "") lostQuantity = 0;
            var provider = $('select[name=provider]').val();
            var product = {
                'id': id,
                'name': name,
                'quantity': quantity,
                'unit': unit,
                'unit_price': unit_price,
                'weightByUnit': weightByUnit,
                'provider': provider,
                'min_quantity': min_quantity,
                'daily_quantity': daily_quantity,
                'lostQuantity': lostQuantity,
                "newUserQuantity": newUserQuantity,
                'status': 'active'
            };

            if(validate(product)){
                $.ajaxx({
                    url: "<?php echo base_url('admin/product/apiEdit'); ?>",
                    type: "POST",
                    dataType: "json",
                    data: {"product": product},
                    beforeSend: function () {
                        $('#loading').show();
                    },
                    complete: function () {
                        $('#loading').hide();
                    },
                    success: function (data) {
                        if (data.status = "success") {
                            swal({
                                title: "Success",
                                text: "Success",
                                type: "success",
                                timer: 1500,
                                showConfirmButton: false
                            });
                            var nextId = parseInt(id) + parseInt(1);
                            if (e.data.saveType === "saveAndGo") {
                                window.location.href = "<?php echo base_url("admin/product/edit/"); ?>" + nextId;
                            } else {
                                window.location.href = "<?php echo base_url("admin/product/index/"); ?>";
                            }
                        }
                    },
                    error: function (data) {

                    }
                });
            }
        }

        function validate(product){
            var validate=false;
            if(old_unit!==product["unit"] && product["weightByUnit"]<=0){
                swal({
                    title: "Attention",
                    text: "Vous devez renseigner le poid par unité après le changement de l'unité",
                    type: "warning",
                    timer: 2000,
                    showConfirmButton: false
                });
                validate = false;
            }else{
                validate=true;
            }

            return validate;
        }
    });


</script>


<script>
    $(document).ready(function () {
        $('button.activate').on('click', activateEvent);
        $('button.edit').on('click', editEvent);

        function editEvent(){
            var quantity = $(this).attr('data-quantity');
            var provider = $(this).attr('data-provider');
            $('input[name="unit_price"]').val(quantity);
            console.log(provider);
            $('select[name=provider]').val(provider);
            scroll("productPanel")

        }

        function scroll(id) {
            // Scroll
            $('html,body').animate({scrollTop: $("#" + id).offset().top}, 'slow');
        }
        function activateEvent(event) {
            var id = $(this).attr('data-id');
            $('#loading').show();
            $.ajax({
                    url: "<?php echo base_url('admin/product/apiActivateQuantity'); ?>",
                    type: "POST",
                    dataType: "json",
                    data: {'quantity_id':id},
                    success: function (data) {

                        $('#loading').hide();
                        if (data.status === 'success') {
                            swal({
                                title: "Success",
                                text: "Success",
                                type: "success",
                                timer: 1500,
                                showConfirmButton: false
                            });
                            location.reload();
                        }
                        else {
                            $('#loading').hide();
                            swal({
                                title: "Erreur",
                                text: "Erreur",
                                type: "error",
                                timer: 1500,
                                showConfirmButton: false
                            });
                        }
                    },
                    error: function (data) {
                        $('#loading').hide();
                        swal({
                            title: "Erreur",
                            text: "Erreur",
                            type: "error",
                            timer: 1500,
                            showConfirmButton: false
                        });
                    }
               });
        }
    });
</script>

<!-- bootstrap-daterangepicker -->
<script src="<?php echo base_url('assets/vendors/moment/min/moment.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/vendors/bootstrap-daterangepicker/daterangepicker.js'); ?>"></script>
<script>
    var rangeLink = "<?php echo base_url('admin/report/apiRange'); ?>";
</script>

<script src="<?php echo base_url('assets/vendors/bootstrap-daterangepicker/daterangepicker.js'); ?>"></script>

<script src="<?php echo base_url('assets/vendors/moment/min/moment.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/vendors/bootstrap-daterangepicker/daterangepicker.js'); ?>"></script>

<!--Statistiques-->
<script src="<?php echo base_url('assets/build/js/canvasjs.min.js'); ?>"></script>
<script>
    $(document).ready(function () {

        <?php
        $js_array = json_encode($report['productConsumptionRate']);
        echo "var mealConsumptionRate = " . $js_array . ";\n";
        ?>



        var myDataPoints = [];
        $.each(mealConsumptionRate, function (key, mealConsumptionRateProduct) {
            var total=parseFloat(mealConsumptionRateProduct['avg_unit_price'] * mealConsumptionRateProduct['sum_quantity']);
            var point = {
                y: total,
                label: mealConsumptionRateProduct['name'],
                unit: 'DH',
                yRound: total.toFixed(2)
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
                toolTipContent: "<b>{label}:</b> {yRound}{unit} (#percent%)",
                dataPoints: myDataPoints
            }]
        });
        chart.render();

    });
</script>