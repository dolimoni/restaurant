<?php $this->load->view('admin/partials/admin_header.php'); ?>
<!-- page content -->
<div class="right_col" role="main">
    <div class="productsList">
        <div class="page-title">
            <div class="title_left">
                <h3>Modifier l'article : <?php echo $meal['name']; ?></h3>
            </div>
        </div>
       <!-- <pre>
           <?php /*print_r($meal); */?>
        </pre>-->

        <div class="clearfix"></div>
        <hr>
        <div class="row tile_count">
            <div class="col-md-3 col-sm-4 col-xs-6 tile_stats_count">
                <span class="count_top"><i class="fa fa-line-chart"></i> Nombre de produits</span>
                <div class="count productsCount"><?php echo $meal['products_count']; ?></div>
                <!--<span class="count_bottom"><i class="green">4% </i> From last Week</span>-->
            </div>
            <div class="col-md-3 col-sm-4 col-xs-6 tile_stats_count">
                <span class="count_top"><i class="fa fa-line-chart"></i> Coût</span>
                <div class="count cost"> <?php echo $meal['cost']; ?>DH</div>
                <!--<span class="count_bottom"><i class="green"><i class="fa fa-sort-asc"></i>3% </i> From last Week</span>-->
            </div>
            <div class="col-md-3 col-sm-4 col-xs-6 tile_stats_count">
                <span class="count_top"><i class="fa fa-line-chart"></i> Prix de vente</span>
                <div class="count sellPrice green"><?php echo $meal['sellPrice'];?>DH</div>
                <!--<span class="count_bottom"><i class="green"><i class="fa fa-sort-asc"></i>69% </i></span>-->
            </div>
            <div class="col-md-3 col-sm-4 col-xs-6 tile_stats_count">
                <span class="count_top"><i class="fa fa-line-chart"></i> Bénifices</span>
                <div class="count gain"> <?php echo $meal['profit']; ?>DH</div>
                <span class="count_bottom"><i class="red"><i class="fa fa-sort-desc"></i>12% </i> par rapport au dernier prix</span>
            </div>
        </div>
        <div class="article-title text-center">
            <h4 style="display: inline;">Nom de l'article : </h4> <input type="text" class="mealName" name="name" value="<?php echo $meal['name'];?>"/>
            <h4 style="display: inline;">Prix de vente : </h4> <input value="<?php echo $meal['sellPrice']; ?>" type="text" class="sellPriceProduct" name="sellPrice"/>
        </div>
        <div class="row mealComposition">
            <?php foreach ($productsComposition as $key => $pc) { ?>
            <div class="col-md-6 col-sm-6 col-xs-6 product" data-id="<?php echo $key+1; ?>" >
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Compositions</h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                            <li><a class="close-link"><i class="fa fa-close"></i></a></li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <label><?php echo $message; ?></label>
                        <form method="post">
                            <fieldset>
                                <div class="x_panel">
                                   <div class="x_title">
                                       <h2>Produit</h2>
                                       <ul class="nav navbar-right panel_toolbox">
                                           <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                                           <li><a class="close-link"><i class="fa fa-close"></i></a></li>
                                       </ul>
                                       <div class="clearfix"></div>
                                   </div>
                                   <div class="x_content oldContent">

                                       <select name="product" class="productSelect" >
                                           <?php foreach ($products as $product) {
                                           $selected= $product['id'] == $pc['product'] ? 'selected':'';

                                           ?>
                                           <option <?php echo $selected; ?> value="<?php echo $product['id']; ?>" data-price="<?php echo $product['unit_price']; ?>"><?php echo $product['name']; ?></option>
                                           <?php } ?>
                                       </select>
                                       Quantité : <input class="form-inline" placeholder="Quantité" name="quantity" value="<?php echo $pc['mp_quantity'];?>"
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
            <?php } ?>
        </div> <!-- /row -->

        <button type="submit" class="btn btn-success" name="addProduct">
            <span class="fa fa-plus"></span> Nouveau produit
        </button>

        <div class="col-md-6 col-sm-6 col-xs-6 product productModel" hidden>
            <div class="x_panel">
                <div class="x_title">
                    <h2>Compositions</h2>
                    <ul class="nav navbar-right panel_toolbox">
                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                        <li><a class="close-link"><i class="fa fa-close"></i></a></li>
                    </ul>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <label><?php echo $message; ?></label>
                    <form method="post">
                        <fieldset>
                            <div class="x_panel">
                                <div class="x_title">
                                    <h2>Produit</h2>
                                    <ul class="nav navbar-right panel_toolbox">
                                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                                        <li><a class="close-link"><i class="fa fa-close"></i></a></li>
                                    </ul>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="x_content" id="newContent">

                                    <select name="product" class="productSelectNew">
                                       <?php foreach ($products as $product) {?>
                                        <option value="<?php echo $product['id'];?>" data-price="<?php echo $product['unit_price']; ?>"><?php echo $product['name']; ?></option>
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

        <div class="article-title text-center">
            <h4 style="display: inline;">Famille de l'article : </h4>
        </div>


        <?php
            include('include/groups.php');
        ?>

        <input type="submit" name="buttonSubmit" value="Modifier" class="btn btn-success"/>
    </div>
</div> <!-- /.col-right --> 
<!-- /page content -->

<?php $this->load->view('admin/partials/admin_footer'); ?>



<script>

    $(document).ready(function () {

        var gainRate=1;
        var group=0;
        var productsCount=<?php echo $meal['products_count']; ?>;

        $('.sellPrice').html(<?php echo $meal['sellPrice']; ?> + 'DH');
        sellPrice=<?php echo $meal['sellPrice']; ?>;

        $('.sellPriceProduct').on('keyup', function () {
            calulPrixTotal();
        });
        $(document).on('keyup','input[name="quantity"]',calulPrixTotal);

        $(document).on('change','.productSelectNew',{'checkOldProducts':true},calulPrixTotal);
        $(document).on('change','.productSelect',calulPrixTotal);

        function calulPrixTotal() {
            var prixTotal = parseFloat(0);
            for (var i = 1; i <= productsCount; i++) {
                var row = $('.product[data-id=' + i + ']');
                var quantity = parseFloat(row.find('input[type="text"]').val().replace(',', '.'));
                var unit_price = parseFloat(row.find('select').find('option:selected').attr('data-price').replace(',', '.'));
                if (quantity > 0 && unit_price > 0)
                    prixTotal += quantity * unit_price;
            }
            $('.cost').html(prixTotal+'DH');
            $('.gain').html(sellPrice - prixTotal+'DH');
        };

        $('input[name="buttonSubmit"]').on('click', function () {

            var productsList=[];
            var prixTotal=0;
            var name=$('input.mealName').val();
            for (var i = 1; i <= productsCount; i++) {

                var row = $('.product[data-id=' + i + ']');
                console.log(row);
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
            if(group===0){
                group=1;
            }
            var meal={'name':name,'id':<?php echo $meal['id']; ?>,'group':group,'productsList': productsList, 'cost': prixTotal,'sellPrice': sellPrice,'profit': profit};

            $.ajax({
                url: "<?php echo base_url(); ?>admin/meal/editApi",
                type: "POST",
                dataType: "json",
                data: {'meal': meal},
                success: function (data) {
                    if (data.status === 'success'){
                        swal({
                            title: "Success",
                            text: "Success",
                            type: "success",
                            timer: 1500,
                            showConfirmButton: false
                        });
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


        $('.well').on('click',function () {
            group = $(this).attr('data-id');
            var actualColor = $(this).css('backgroundColor')
            var defaultColor="rgb(245, 245, 245)";
            var selectedColor="rgb(91, 192, 222)";
            if(actualColor=== selectedColor){
                $(this).css(
                    {
                        'background': defaultColor,
                        'color': 'rgb(115, 135, 156)',
                    }
                );
            }else{

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
            productModel.attr('data-id',productsCount);
            $('.mealComposition').append(productModel);
            $('.productsCount').html(productsCount);
        }

    });

</script>
