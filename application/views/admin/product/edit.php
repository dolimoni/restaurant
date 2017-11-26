<?php $this->load->view('admin/partials/admin_header.php');

?>

<!-- page content -->
<div class="right_col" role="main">
    <div class="productsList">
        <div class="page-title">
            <div class="title_left">
                <h3>Modifier le produit</h3>
            </div>
        </div>
        <div class="clearfix"></div>
        <hr>
        <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
            <thead>
            <tr>
                <th>Quantité</th>
                <th>Prix</th>
                <th>Status</th>
                <th>Activer</th>
            </tr>
            </thead>
            <tfoot>
            <tr>
                <th>Quantité</th>
                <th>Prix</th>
                <th>Status</th>
                <th>Activer</th>
            </tr>
            </tfoot>
            <tbody>
            <?php foreach ($quantities as $quantity) {
                    $validate="";
                   /* if($quantity['status'] === "active"){
                        $validate="validate";
                    }*/
            ?>
                <tr class="<?php echo $validate; ?>">
                    <td><?php echo $quantity['quantity']?></td>
                    <td><?php echo $quantity['unit_price']?></td>
                    <td><?php echo $quantity['status']?></td>
                    <td width="10%">
                       <?php if($quantity['status']!=="active"){ ?>
                           <button data-id="<?php echo $quantity['id'] ?>" class="btn btn-default btn-xs action activate"><span
                                       class="glyphicon glyphicon-ok"></span></button>
                       <?php } ?>
                    </td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
        <div class="row productsListContent">
            <div class="col-md-offset-3 col-md-6 col-sm-12 col-xs-12 productItem" data-id="1">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Produit</h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                            <li><a class="close-link"><i class="fa fa-close"></i></a></li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <label><?php /*echo $message;*/ ?></label>
                        <form method="post">
                            <fieldset>
                                <input name="id" type="hidden" value="<?php echo $product['id']; ?>"/>
                                <div class="form-group">
                                    Produit : <input value="<?php echo $product['name'];?>" class="form-control" placeholder="Produit" name="name"
                                                     id="username" type="text">
                                </div>
                                <div class="form-group">
                                    Nouvelle quantité : <input class="form-control" placeholder="Quantité" name="quantity"
                                                      type="text">
                                </div>
                                <div class="form-group">
                                    Unité de mesure :
                                    <select class="form-control" name="unit">
                                        <option name="unit"
                                                value="kg" <?php if ($product['unit'] === "kg") echo "selected"; ?>>Kg
                                        </option>
                                        <option name="unit" value="L" <?php if ($product['unit'] === "L") echo "selected"; ?>>L</option>
                                        <option name="unit" value="pcs" <?php if ($product['unit'] === "pcs") echo "selected"; ?> >Pcs</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    Fournisseur :
                                    <select class="form-control" name="provider">
                                        <option value="0">Aucun</option>
                                        <?php foreach ($providers as $provider) {
                                            $selected='';
                                            if($provider['id']=== $product['provider']){
                                                $selected="selected";
                                            }
                                        ?>
                                            <option name="provider"
                                                    value="<?php echo $provider['id']; ?>" <?php echo $selected; ?>><?php echo $provider['name']; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    Prix unitaire : <input value="<?php echo $product['unit_price']; ?>" class="form-control" placeholder="Prix unitaire"
                                                           name="unit_price" type="text">
                                </div>

                                <div class="form-group">
                                    Quantité minimum du stock : <input value="<?php echo $product['min_quantity']; ?>" class="form-control" placeholder="Prix unitaire"
                                                                       name="min_quantity" type="text">
                                </div>
                                <div class="form-group">
                                    Consomation par jour : <input value="<?php echo $product['daily_quantity']; ?>" class="form-control" placeholder="Quantité"
                                                                  name="daily_quantity"
                                                                  type="text">
                                </div>
                                <br/>
                                <!-- <input type="submit" name="buttonSubmit" value="Confirmer" class="btn btn-success" />
                                 <div value="Nouveau produit" class="btn btn-info newProduct" >Nouveau produit</div>-->
                            </fieldset>
                        </form>
                    </div> <!-- /content -->
                </div><!-- /x-panel -->
            </div>
        </div>
        <div class="text-center">
            <input type="submit" name="buttonSubmit" value="Confirmer" class="btn btn-success "/>
        </div>
    </div>

</div> <!-- /.col-right -->
<!-- /page content -->

<?php $this->load->view('admin/partials/admin_footer'); ?>

<script>

    $(document).ready(function () {
        $('input[name="buttonSubmit"]').on('click', function () {


            var id = $('input[name="id"]').val();
            var name = $('input[name="name"]').val();
            var quantity = $('input[name="quantity"]').val();
            var unit = $('select[name="unit"]').val();
            var unit_price = $('input[name="unit_price"]').val();
            var daily_quantity = $('input[name="daily_quantity"]').val();
            var min_quantity = $('input[name="min_quantity"]').val();
            var provider = $('select[name=provider]').val();
            var product = {
                'id':id,
                'name': name,
                'quantity': quantity,
                'unit': unit,
                'unit_price': unit_price,
                'provider': provider,
                'min_quantity': min_quantity,
                'daily_quantity': daily_quantity,
                'status': 'active'
            };

            console.log(product);
            $.ajax({
                url: "<?php echo base_url('admin/product/apiEdit'); ?>",
                type: "POST",
                dataType: "json",
                data: {"product": product},
                success: function (data) {
                    if (data.status = "success") {
                        swal({
                            title: "Success",
                            text: "Success",
                            type: "success",
                            timer: 1500,
                            showConfirmButton: false
                        });
                    }
                },
                error: function (data) {
                    // do something
                }
            });
        });

    });


</script>


<script>
    $(document).ready(function () {
        $('button.activate').on('click', activateEvent);

        function activateEvent() {
            var id = $(this).attr('data-id');
            $.ajax({
                    url: "<?php echo base_url('admin/product/apiActivateQuantity'); ?>",
                    type: "POST",
                    dataType: "json",
                    data: {'quantity_id':id},
                    success: function (data) {
                        if (data.status === 'success') {
                            swal({
                                title: "Success",
                                text: "Success",
                                type: "success",
                                timer: 1500,
                                showConfirmButton: false
                            });
                        }
                        else {
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