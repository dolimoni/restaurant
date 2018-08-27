<?php $this->load->view('admin/partials/admin_header.php'); ?>
<!-- page content -->
<div class="right_col" role="main">
    <div class="productsList">
        <div class="page-title">
            <div class="title_left">
                <h3>Ajouter un client</h3>
            </div>
        </div>

        <div class="clearfix"></div>
        <hr>
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
                <form id="addCustomerForm" enctype="multipart/form-data">
                    <fieldset>
                        <div class="row">
                            <div class="col-xs-4">
                                <br>
                                <label for="name">Nom :</label>
                                <input type="text" class="form-control" name="name"
                                       placeholder="article"
                                       required>
                            </div>
                            <div class="col-xs-4">
                                <br>
                                <label for="name">Téléphone :</label>
                                <input type="text" step="any" class="form-control" name="phone"
                                       placeholder="prix"
                                       required>
                            </div>
                            <div class="col-xs-4">
                                <br>
                                <label for="name">Adresse :</label>
                                <input type="text" step="any" class="form-control" name="address"
                                       placeholder="prix"
                                       required>
                            </div>
                        </div>
                        <br/>

                        <!--  <div class="text-right">
                              <input class="btn btn-success" type="submit" name="addCustomer" value="Confirmer"/>
                          </div>-->

                    </fieldset>
                </form>
            </div>

        </div>


      <!--  <div class="article-title text-center">
            <h4 style="display: inline;">Nom de l'article : </h4> <input type="text" class="mealName" name="name"/>
            <h4 style="display: inline;">Prix de vente : </h4> <input type="text" class="sellPrice" name="sellPrice"/>
        </div>-->
        <h3>Réduction</h3>
        <div class="row mealComposition">
            <div class="col-md-6 col-sm-6 col-xs-6 product" data-id="1">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Article</h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                            <li><a class="close-link"><i class="fa fa-close"></i></a></li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <form method="post">
                            <fieldset>
                                <div class="">
                                   <div class="x_content">

                                       <div class="row">
                                           <div class="col-md-3">
                                               <select name="product" class="productSelect">
                                                   {products}
                                                   <option value="{id}" data-unit="{unit}" data-price="{unit_price}">
                                                       {name}
                                                   </option>
                                                   {/products}
                                               </select>
                                           </div>
                                           <div class="col-md-7">
                                               Réduction (%):
                                               <input class="form-inline" placeholder="Réduction" name="quantity"
                                                      type="text">
                                           </div>
                                           <div class="col-md-2">
                                              2000DH
                                           </div>
                                       </div>


                                   </div>
                               </div>

                                <br/>
                               <!-- <input type="submit" name="buttonSubmit" value="Confirmer" class="btn btn-success" />
                                <div value="Nouveau produit" class="btn btn-info newProduct" >Nouveau produit</div>-->
                            </fieldset>
                        </form>
                    </div> <!-- /content -->
                </div><!-- /x-panel -->
            </div>
             <!-- /col -->
        </div> <!-- /row -->
        <button type="submit" class="btn btn-success" name="addProduct">
            <span class="fa fa-plus"></span> Nouveau article
        </button>

        <div class="col-md-6 col-sm-6 col-xs-6 product productModel" hidden>
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
                    <form method="post">
                        <fieldset>
                            <div class="">
                                <div class="x_content" id="newContent">

                                    <select name="product" class="productSelectNew">
                                        <?php foreach ($products as $product) { ?>
                                            <option value="<?php echo $product['id']; ?>"
                                                    data-price="<?php echo $product['unit_price']; ?>"><?php echo $product['name']; ?></option>
                                        <?php } ?>
                                    </select>
                                    Quantité : <input class="form-inline" placeholder="Quantité" name="quantity"
                                                      type="text">
                                </div>
                            </div>

                            <br/>
                            <!-- <input type="submit" name="buttonSubmit" value="Confirmer" class="btn btn-success" />
                             <div value="Nouveau produit" class="btn btn-info newProduct" >Nouveau produit</div>-->
                        </fieldset>
                    </form>
                </div> <!-- /content -->
            </div><!-- /x-panel -->
        </div>
        <input type="submit" name="buttonSubmit" value="Confirmer" class="btn btn-success"/>
    </div>
</div> <!-- /.col-right --> 
<!-- /page content -->

<?php $this->load->view('admin/partials/admin_footer'); ?>

<?php if($this->session->flashdata('message') != NULL) : ?>
<script>
    swal({
      title: "Success",
      text: "<?php echo $this->session->flashdata('message'); ?>",
      type: "success",
      timer: 1500,
      showConfirmButton: false
    });
</script>

<?php endif ?>

<script>

    $(document).ready(function () {

        var gainRate=1;
        var group=0;
        var sellPrice=0;
        var productsCount=1;
        $(document).on('keyup','input[name="quantity"]',calulPrixTotal);
        $("select").change(calulPrixTotal);

        $('.sellPrice').on('keyup', function () {
            sellPrice= $(this).val();
            $('.sellPrice').html($(this).val() + 'DH');
            calulPrixTotal();
        });

        $(document).on('change', '.productSelectNew', calulPrixTotal);
        $(document).on('change', '.productSelect', calulPrixTotal);

        function calulPrixTotal() {

            //changing product informations

            //panel parent du produit
            var panel = $(this).closest('.product');
            //prix et unité
            var unit = panel.find('option:selected').attr('data-unit');
            var price = parseFloat(panel.find('option:selected').attr('data-price'));
            var productQuantity = parseFloat(panel.find('input[name="quantity"]').val());
            console.log(productQuantity);

            panel.find('.ProductUnit').html(unit);
            panel.find('.productCost').html(price*productQuantity);

            //end


            var prixTotal = parseFloat(0);
            for (var i = 1; i <= productsCount; i++) {
                var row = $('.product[data-id=' + i + ']');
                var quantity = parseFloat(row.find('input[type="text"]').val().replace(',', '.'));
                var unit_price = parseFloat(row.find('select').find('option:selected').attr('data-price').replace(',', '.'));
                if (quantity > 0 && unit_price > 0)
                    prixTotal += quantity * unit_price;
            }

            $('.cost').html(prixTotal+'DH');
            $('.gain').html(sellPrice- prixTotal+'DH');

        };

        $('input[name="buttonSubmit"]').on('click', function () {

            var productsList=[];
            var prixTotal=0;
            var name=$('input.mealName').val();
            for (var i = 1; i <= 2; i++) {

                var row = $('.product[data-id=' + i + ']');

                var quantity = parseFloat(row.find('input[type="text"]').val().replace(',', '.'));
                var id= row.find('select').find('option:selected').val();
                var unit_price = parseFloat(row.find('select').find('option:selected').attr('data-price').replace(',', '.'));
                if (quantity > 0 && unit_price > 0){
                    prixTotal += quantity * unit_price;
                    var product={'id':id,'quantity':quantity,'unit_price':unit_price,'profit': profit};
                    productsList.push(product);
                }

            }
            var profit = prixTotal * gainRate - prixTotal;
            //var sellPrice = prixTotal * gainRate ;
            if (group === 0) {
                group = 1;
            }
            var meal={'name':name,'group':group,'productsList': productsList, 'cost': prixTotal,'sellPrice': sellPrice,'profit': profit};
            console.log(meal);
            $.ajax({
                url: "<?php echo base_url(); ?>admin/meal/add",
                type: "POST",
                dataType: "json",
                data: {'meal': meal},
                success: function (data) {
                    if (data.status === true){
                        document.location.href = data.redirect;
                    }
                    else{
                        /*$('#show_id').html("<div style='border:1px solid red;font-size: 11px;margin:0 auto !important;'>" + response.error + "</div>");*/
                    }

                },
                error: function (data) {
                    // do something
                }
            });

        });

        var productSize=1;


        $('.well').on('click', function () {
            group = $(this).attr('data-id');
            var actualColor = $(this).css('backgroundColor')
            var defaultColor = "rgb(245, 245, 245)";
            var selectedColor = "rgb(91, 192, 222)";
            if (actualColor === selectedColor) {
                $(this).css(
                    {
                        'background': defaultColor,
                        'color': 'rgb(115, 135, 156)',
                    }
                );
            } else {

                $('.well').css(
                    {
                        'background': defaultColor,
                        'color': 'rgb(115, 135, 156)',
                    }
                );

                $(this).css(
                    {
                        'background': '#5bc0de',
                        'color': 'white',
                    }
                );
            }

        });


        $('button[name="addProduct"]').on('click', addProduct);
        function addProduct(event) {
            var productModel = $('.productModel').clone().removeAttr('hidden');
            productModel.removeClass('productModel');
            productsCount++;
            productModel.attr('data-id', productsCount);
            $('.mealComposition').append(productModel);
            $('.productsCount').html(productsCount);
        }
    });


</script>
