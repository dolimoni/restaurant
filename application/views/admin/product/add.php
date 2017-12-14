<?php $this->load->view('admin/partials/admin_header.php'); ?>
<style>
    .profile_details:nth-child(2n) {
        clear: none;
    }
    .profile_details:nth-child(3n) {
        clear: none;
    }
</style>
<!-- page content -->
<div class="right_col" role="main">
    <div class="productsList">
        <div class="page-title">
            <div class="title_left">
                <h3>Ajouter des produits</h3>
            </div>
        </div>
        <div class="clearfix"></div>
        <hr>
        <form id="addProductsForm" method="post">
        <h4 style="display: inline;">Nombre de produit à ajouter : </h4> <input type="number" name="productSize"/>
            <div type="submit" class="btn btn-info productSize">Ajouter</div>
        </form>
        <form id="addProduct" method="post">
            <div class="row productsListContent">
                <div class="col-md-6 col-sm-12 col-xs-12 productItem" data-id="1">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2>Produit</h2>
                            <ul class="nav navbar-right panel_toolbox">
                                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                                <!--<li><a class="close-link"><i class="fa fa-close"></i></a></li>-->
                            </ul>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">
                            <label><?php /*echo $message;*/ ?></label>
                                <fieldset>
                                    <div class="form-group">
                                        Nom<span class="required">*</span> : <input class="form-control"
                                                                                    placeholder="Produit" name="name"
                                                                                    id="username" type="text" required>
                                    </div>
                                    <div class="form-group">
                                        Quantité<span class="required">*</span> : <input class="form-control"
                                                                                         placeholder="Quantité"
                                                                                         name="quantity"
                                                                                         type="number">
                                    </div>
                                    <div class="form-group">
                                        Unité de mesure :
                                        <select class="form-control" name="unit">
                                            <option name="unit" value="kg">Kg</option>
                                            <option name="unit" value="pcs">Pcs</option>
                                            <option name="unit" value="L">Litre</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        Fournisseur :
                                        <select class="form-control" name="provider">
                                            <option value="0">Aucun</option>
                                            <?php foreach ($providers as $provide) { ?>
                                                <option
                                                        value="<?php echo $provide['id']; ?>"><?php echo $provide['name']; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        Prix unitaire<span class="required">*</span> : <input class="form-control"
                                                                                              placeholder="Prix unitaire"
                                                                                              name="unit_price">
                                    </div>

                                    <div class="form-group">
                                        Quantité minimum du stock : <input class="form-control"
                                                                           placeholder="Quantité minimum du stock"
                                                                           name="min_quantity" >
                                    </div>
                                    <div class="form-group">
                                        Consomation par jour : <input class="form-control" placeholder="Quantité"
                                                                      name="daily_quantity"
                                                                      type="number">
                                    </div>
                                    <br/>
                                    <!-- <input type="submit" name="buttonSubmit" value="Confirmer" class="btn btn-success" />
                                     <div value="Nouveau produit" class="btn btn-info newProduct" >Nouveau produit</div>-->
                                </fieldset>
                        </div> <!-- /content -->
                    </div><!-- /x-panel -->
                </div>
            </div>

            <div class="col-md-6 col-sm-12 col-xs-12 productItem productModel" hidden>
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
                            <fieldset>
                                <div class="form-group">
                                    Produit : <input class="form-control" placeholder="Produit" name="name"
                                                     id="username" type="text">
                                </div>
                                <div class="form-group">
                                    Quantité : <input class="form-control" placeholder="Quantité" name="quantity"
                                                      type="number">
                                </div>
                                <div class="form-group">
                                    Unité de mesure :
                                    <select class="form-control" name="unit">
                                        <option name="unit" value="kg">Kg</option>
                                        <option name="unit" value="pcs">Pcs</option>
                                        <option name="unit" value="l">Litre</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    Fournisseur :
                                    <select class="form-control" name="provider">
                                        <option value="0">Aucun</option>
                                        <?php foreach ($providers as $provide) { ?>
                                            <option name="unit"
                                                    value="<?php echo $provide['name']; ?>"><?php echo $provide['name']; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    Prix unitaire : <input class="form-control" placeholder="Prix unitaire"
                                                           name="unit_price">
                                </div>
                                <div class="form-group">
                                    Quantité minimum du stock : <input class="form-control"
                                                                       placeholder="Quantité minimum du stock"
                                                                       name="min_quantity" type="number">
                                    <div class="form-group">
                                        Consomation par jour : <input class="form-control" placeholder="Quantité"
                                                                      name="daily_quantity"
                                                                      type="number">
                                    </div>
                                    <br/>
                                    <!-- <input type="submit" name="buttonSubmit" value="Confirmer" class="btn btn-success" />
                                     <div value="Nouveau produit" class="btn btn-info newProduct" >Nouveau produit</div>-->
                            </fieldset>
                    </div> <!-- /content -->
                </div><!-- /x-panel -->
            </div>

            <input type="submit" name="buttonSubmit" value="Confirmer" class="btn btn-success"/>
        </form>
    </div>

</div> <!-- /.col-right -->
<!-- /page content -->

<?php $this->load->view('admin/partials/admin_footer'); ?>

<script>

    $(document).ready(function () {
        var productSize = 1;
        var productsList = [];
        var productsCount=1;
        /*$(".productSize").click(function () {
            productSize = $('input[name="productSize"]').val();
            if (productSize > 1) {
                $('.right-product').fadeIn("slow");
            }
            if (productSize > 2) {
                $('.row[data-id=2]').fadeIn("slow");
            }

            // container.append(productContainer[0]);
        });*/
        $('#addProduct').submit( function (e) {
            e.preventDefault();  //prevent form from submitting
            for (var i = 1; i <= productsCount; i++) {

                var row = $('.productItem[data-id=' + i + ']');

                var name = row.find('input[name="name"]').val();
                var quantity = row.find('input[name="quantity"]').val();
                var unit = row.find('select[name="unit"]').val();
                var unit_price = row.find('input[name="unit_price"]').val();
                var daily_quantity = row.find('input[name="daily_quantity"]').val();
                var min_quantity = row.find('input[name="min_quantity"]').val();
                var provider = $('select[name=provider]').val();
                var product1 = {'name': name, 'quantity': quantity, 'unit': unit, 'unit_price': unit_price,'provider': provider, 'min_quantity': min_quantity, 'daily_quantity': daily_quantity,'status':'active'};
               if(name!=="" && quantity>0 && unit_price>0){
                   productsList.push(product1);
               }
            }

           if(productsList.length>0){
               $.ajax({
                   url: "<?php echo base_url(); ?>admin/product/add",
                   type: "POST",
                   dataType: "json",
                   data: {"productsList": productsList},
                   success: function (data) {
                       if (data.status = "success") {
                           swal({
                               title: "Success",
                               text: "Success",
                               type: "success",
                               timer: 1500,
                               showConfirmButton: false
                           });

                           //window.location.href = data.redirect;
                       } else {
                           swal({
                               title: "Oups !",
                               text: "Une erreur s'est produite",
                               type: "error",
                               timer: 1500,
                               showConfirmButton: false
                           });

                       }
                   },
                   error: function (data) {
                       // do something
                   }
               });
           }

           else{
               swal({
                   title: "Attention",
                   text: "Merci de remplir les champs obligatoires",
                   type: "info",
                   timer: 1500,
                   showConfirmButton: false
               });
           }
            productsList = [];
        });


        $('#addProductsForm').submit(addProducts);
        $('.productSize').on('click',addProducts);
        function addProducts(e) {
            e.preventDefault();
            productSize = $('input[name="productSize"]').val();
            if(productSize==="")
                productSize=1;
            for ($i = 1; $i <= productSize; $i++){
                productsCount++;
                var productModel = $('.productModel').clone();
                productModel.removeClass('productModel');
                productModel.removeAttr('hidden');
                productModel.attr('data-id', productsCount);
                $('.productsListContent').append(productModel);
            }
        }


    });


</script>
