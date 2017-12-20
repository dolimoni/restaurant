<?php $this->load->view('admin/partials/admin_header.php'); ?>
<style>
    .well {
        max-height: 155px;
    }

    .well img {
        max-height: 75px;
        width: 130px;
        height: 126px;
    }
</style>
<!-- page content -->
<div class="right_col" role="main">
    <div class="productsList">
        <div class="page-title">
            <div class="title_left">
                <h3>Ajouter un article</h3>
            </div>
        </div>

        <div class="clearfix"></div>
        <hr>
        <div class="row tile_count">
            <div class="col-md-3 col-sm-6 col-xs-12 tile_stats_count">
                <span class="count_top"><i class="fa fa-line-chart"></i> Nombre de produits</span>
                <div class="count productsCount">1</div>
                <!--<span class="count_bottom"><i class="green">4% </i> From last Week</span>-->
            </div>
            <div class="col-md-3 col-sm-6 col-xs-12 tile_stats_count">
                <span class="count_top"><i class="fa fa-line-chart"></i> Coût</span>
                <div class="count cost">0DH</div>
                <!--<span class="count_bottom"><i class="green"><i class="fa fa-sort-asc"></i>3% </i> From last Week</span>-->
            </div>
            <div class="col-md-3 col-sm-6 col-xs-12 tile_stats_count">
                <span class="count_top"><i class="fa fa-line-chart"></i> Prix de vente</span>
                <div class="count sellPrice green">0DH</div>
                <!--<span class="count_bottom"><i class="green"><i class="fa fa-sort-asc"></i>69% </i></span>-->
            </div>
            <div class="col-md-3 col-sm-6 col-xs-12 tile_stats_count">
                <span class="count_top"><i class="fa fa-line-chart"></i> Bénifices</span>
                <div class="count gain">0DH</div>
                <!--<span class="count_bottom"><i class="red"><i class="fa fa-sort-desc"></i>12% </i> par rapport au dernier prix</span>-->
            </div>
        </div>

        <div class="article-title text-center row">
           <div class="col-md-offset-1 col-md-5 col-sm-6 col-xs-12">
               <h4 style="display: inline;">Nom de l'article : </h4> <input type="text" class="mealName" name="name"/>
           </div>
            <div class="col-md-5 col-sm-6 col-xs-12">
                <h4 style="display: inline;">Prix de vente : </h4> <input type="text" class="sellPrice"
                                                                          name="sellPrice"/>
            </div>
        </div>
        <div class="row mealComposition">
            <div class="col-md-6 col-sm-6 col-xs-12 product" data-id="1">
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
                        <label><?php echo $message; ?></label>
                        <form method="post">
                            <fieldset>
                                <div class="">
                                   <div class="x_content">

                                       <select name="product" class="productSelect  md-button-v">
                                           <?php foreach ($products as $product){ ?>
                                               <option value="<?php echo $product['id'] ?>" data-unit="<?php echo $product['unit'] ?>" data-price="<?php echo $product['unit_price'] ?>">
                                                   <?php echo $product['name'] ?>
                                               </option>
                                           <?php } ?>
                                       </select>
                                       <?php
                                        $KgUnitHidden='hidden';
                                        $LUnitHidden='hidden';
                                        if(isset($products) && count($products)>0){
                                            if ($products[0]['unit'] === "kg") {
                                                $KgUnitHidden = '';
                                            }
                                            if ($products[0]['unit'] === "L") {
                                                $LUnitHidden = '';
                                            }
                                        }
                                       ?>
                                       <select name="kgUnitHidden" class="kgUnitHidden  md-button-v" <?php echo $KgUnitHidden ?>>
                                           <option value="1" name="Kilogramme">Kilogramme</option>
                                           <option value="0.001" name="Gramme">Gramme</option>
                                           <option value="0.000001" name="Milligramme">Milligramme</option>
                                       </select>
                                       <select name="lUnitHidden" class="lUnitHidden  md-button-v" <?php echo $LUnitHidden ?>>
                                               <option value="1" name="Kilogramme">Litre</option>
                                               <option value="0.001" name="Centilitre">Centilitre</option>
                                               <option value="0.000001" name="Millilitre">Millilitre</option>
                                       </select>
                                       Quantité :
                                       <input class="form-inline  md-button-v" placeholder="Quantité" name="quantity"
                                                         type="text"><!--<span class="ProductUnit"> Kg</span>
                                       <div class="text-center productCost">0 Dh</div>-->
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
            <span class="fa fa-plus"></span> Nouveau produit
        </button>

        <div class="col-md-6 col-sm-6 col-xs-12 product productModel" hidden>
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
                    <label><?php echo $message; ?></label>
                    <form method="post">
                        <fieldset>
                            <div class="">
                                <div class="x_content" id="newContent">

                                    <select name="product" class="productSelectNew  md-button-v">
                                        <?php foreach ($products as $product) { ?>
                                            <option value="<?php echo $product['id']; ?>"
                                                    data-unit="<?php echo $product['unit'] ?>"
                                                    data-price="<?php echo $product['unit_price']; ?>">
                                                <?php echo $product['name']; ?>
                                            </option>
                                        <?php } ?>
                                    </select>
                                    <select name="kgUnitHidden" class="kgUnitHidden  md-button-v" <?php echo $KgUnitHidden ?>>
                                        <option value="1" name="Kilogramme">Kilogramme</option>
                                        <option value="0.001" name="Gramme">Gramme</option>
                                        <option value="0.000001" name="Milligramme">Milligramme</option>
                                    </select>
                                    <select name="lUnitHidden" class="lUnitHidden  md-button-v" <?php echo $LUnitHidden ?>>
                                        <option value="1" name="Kilogramme">Litre</option>
                                        <option value="0.001" name="Centilitre">Centilitre</option>
                                        <option value="0.000001" name="Millilitre">Millilitre</option>
                                    </select>
                                    Quantité : <input class="form-inline  md-button-v" placeholder="Quantité" name="quantity"
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


            <div class="col-md-12 col-sm-12 col-xs-12" >
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Choisissez une famille</h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                            <!--<li><a class="close-link"><i class="fa fa-close"></i></a></li>-->
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <?php
                        //Columns must be a factor of 12 (1,2,3,4,6,12)
                        $numOfCols = 6;
                        $numOfSMCols = 3;
                        $rowCount = 0;
                        $bootstrapColMDWidth = 12 / $numOfCols;
                        $bootstrapColSMWidth = 12 / $numOfSMCols;
                        ?>
                            <div class="row">
                                <?php
                                foreach ($groups as $group) {
                                    ?>
                                    <div class="col-md-<?php echo $bootstrapColMDWidth; ?> col-xs-12 col-xs-<?php echo $bootstrapColSMWidth; ?>">
                                        <div class="well selectGroup" data-id="<?php echo $group['g_id'] ?>">
                                            <img src="<?php echo base_url(); ?>assets/images/<?php echo $group['image'] ?>"
                                                 alt=""
                                                 class="img-responsive">
                                            <h4 class="brief text-center"><?php echo $group['g_name'] ?></h4>
                                        </div>
                                    </div>
                                    <?php
                                    $rowCount++;
                                    if ($rowCount % $numOfCols == 0) echo '</div><div class="row">';
                                }
                                ?>
                            </div>
                    </div> <!-- /content -->
                </div><!-- /x-panel -->
            </div>





        <input type="submit" name="buttonSubmit" value="Confirmer" class="btn btn-success"/>
    </div>
</div> <!-- /.col-right --> 
<!-- /page content -->

<?php $this->load->view('admin/partials/admin_footer'); ?>



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
        $(document).on('change', '.productSelect,.kgUnitHidden,.lUnitHidden', calulPrixTotal);

        function calulPrixTotal() {

            //changing product informations

            //panel parent du produit
            var panel = $(this).closest('.product');
            //prix et unité
            var unit = panel.find('select[name="product"] option:selected').attr('data-unit');
            var price = parseFloat(panel.find('select[name="product"] option:selected').attr('data-price'));
            var productQuantity = parseFloat(panel.find('input[name="quantity"]').val());

            updateOptions(false);

           // panel.find('.ProductUnit').html(unit);
            panel.find('.productCost').html(price*productQuantity);

            //end

            var l_panel='';
            var prixTotal = parseFloat(0);
            for (var i = 1; i <= productsCount; i++) {
                var row = $('.product[data-id=' + i + ']');
                l_panel = row.closest('.product');
                var unit = l_panel.find('select[name="product"] option:selected').attr('data-unit');
                var quantity = parseFloat(row.find('input[type="text"]').val().replace(',', '.'));
                var unit_price = parseFloat(row.find('select').find('option:selected').attr('data-price').replace(',', '.'));
                var unitConvert=1;
                var unitConvertName='';
                if (unit === 'kg') {
                    unitConvert = parseFloat(l_panel.find('select[name="kgUnitHidden"] option:selected').val());
                    unitConvertName = parseFloat(l_panel.find('select[name="kgUnitHidden"] option:selected').text());
                    unit_price *= unitConvert;
                }
                if (unit === 'L') {
                    unitConvert = parseFloat(l_panel.find('select[name="lUnitHidden"] option:selected').val());
                    unitConvertName = parseFloat(l_panel.find('select[name="lUnitHidden"] option:selected').text());
                    unit_price *= unitConvert;
                }
                if (quantity > 0 && unit_price > 0)
                    prixTotal += quantity * unit_price;
            }

            $('.cost').html(prixTotal.toFixed(2)+'DH');
            $('.gain').html((sellPrice- prixTotal).toFixed(2)+'DH');


            changeUnit(panel.find('select[name="product"] option:selected').attr('data-unit'), panel);

        };

        function changeUnit(value,panel) {
            if(value==='kg'){
                panel.find('.kgUnitHidden').removeAttr('hidden');
                panel.find('.lUnitHidden').attr('hidden',true);
            }else if(value==='L'){
                panel.find('.lUnitHidden').removeAttr('hidden');
                panel.find('.kgUnitHidden').attr('hidden', true);
            }else{
                panel.find('.kgUnitHidden').attr('hidden', true);
                panel.find('.lUnitHidden').attr('hidden', true);
            }
        }

        $('input[name="buttonSubmit"]').on('click', function () {

            var productsList=[];
            var prixTotal=0;
            var name=$('input.mealName').val();
            for (var i = 1; i <= productsCount; i++) {

                var row = $('.product[data-id=' + i + ']');
                var l_panel = row.closest('.product');
                var unit = l_panel.find('select[name="product"] option:selected').attr('data-unit');
                var quantity = parseFloat(row.find('input[type="text"]').val().replace(',', '.'));
                var id= row.find('select').find('option:selected').val();
                var unit_price = parseFloat(row.find('select').find('option:selected').attr('data-price').replace(',', '.'));

                //conversion des unités
                var unitConvertName = 'Pcs';
                var unitConvert = 1;
                if (unit === 'kg') {
                    unitConvert = parseFloat(l_panel.find('select[name="kgUnitHidden"] option:selected').val());
                    unitConvertName = l_panel.find('select[name="kgUnitHidden"] option:selected').text();
                    unit_price *= unitConvert;
                }
                if (unit === 'L') {
                    unitConvert = parseFloat(l_panel.find('select[name="lUnitHidden"] option:selected').val());
                    unitConvertName = l_panel.find('select[name="lUnitHidden"] option:selected').text();
                    unit_price *= unitConvert;
                }
                if (quantity > 0 && unit_price > 0){
                    prixTotal += quantity * unit_price;
                    var product={'id':id,'quantity':quantity,'unit_price':unit_price,'profit': profit,'unit': unitConvertName,'unitConvert': unitConvert};
                    productsList.push(product);
                }

            }
            var profit = prixTotal * gainRate - prixTotal;
            //var sellPrice = prixTotal * gainRate ;
            var meal = {
                'name': name,
                'group': group,
                'productsList': productsList,
                'cost': prixTotal,
                'sellPrice': sellPrice,
                'profit': profit
            };
            if (validate(meal)) {
                console.log(meal);
                $.ajax({
                    url: "<?php echo base_url(); ?>admin/meal/add",
                    type: "POST",
                    dataType: "json",
                    data: {'meal': meal},
                    success: function (data) {
                        if (data.status === true) {
                            document.location.href = data.redirect;
                        }
                        else {
                            /*$('#show_id').html("<div style='border:1px solid red;font-size: 11px;margin:0 auto !important;'>" + response.error + "</div>");*/
                        }

                    },
                    error: function (data) {
                        // do something
                    }
                });
            }


        });

        function validate(meal) {
            var validate=true;
            if(meal['name']===''){
                swal({
                    title: "Attention",
                    text: "Quel est le nom de votre article ?",
                    type: "warning",
                    timer: 2000,
                    showConfirmButton: false
                });
                validate=false;
            }else if(meal['sellPrice']===0){
                swal({
                    title: "Attention",
                    text: "Quel est le prix de votre article ?",
                    type: "warning",
                    timer: 2000,
                    showConfirmButton: false
                });
                validate=false;
            }else if(meal['sellPrice']< meal['cost']){
                swal({
                    title: "Attention",
                    text: "Le prix est inférieur au coût",
                    type: "warning",
                    timer: 2000,
                    showConfirmButton: false
                });
                validate=false;
            }else if(meal['group']===0){
                swal({
                    title: "Attention",
                    text: "Vous devez choisir une catégorie",
                    type: "warning",
                    timer: 2000,
                    showConfirmButton: false
                });
                validate=false;
            }
            return validate;
        }

        var productSize=1;


        $('.well.selectGroup').on('click', function () {
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

                $('.well.selectGroup').css(
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
            updateOptions(true);
        }
        function updateOptions(newProduct){

            var selectedProducts = [];
            for (var i = 1; i <= productsCount; i++) {
                var row = $('.product[data-id=' + i + ']');
                var l_panel = row.closest('.product');
                var optionValue = l_panel.find('select[name="product"] option:selected').val();
                var unit = l_panel.find('select[name="product"] option:selected').attr('data-unit');
                var price = l_panel.find('select[name="product"] option:selected').attr('data-price');
                var option={
                    'unit':unit,
                    'price': price,
                    'value': optionValue,
                }
                selectedProducts.push(option);
            }
            for (var i = 1; i <= productsCount; i++) {
                var row = $('.product[data-id=' + i + ']');
                var l_panel = row.closest('.product');
                l_panel.find('select[name="product"] option').removeAttr('hidden');
                for (var j = 0; j < selectedProducts.length; j++) {
                    var val= selectedProducts[j]['value'];
                    var actualVal= l_panel.find('select[name="product"] option:selected').val();
                    console.log(selectedProducts.length);
                    console.log(j+1);
                    if(productsCount===i && newProduct){
                        l_panel.find('select[name="product"] option[value=' + val + ']').attr('hidden','hidden');
                        l_panel.find('select[name="product"] option').not('[hidden]').first().attr('selected', 'selected');
                    }else{
                        l_panel.find('select[name="product"] option[value=' + val + ']').attr('hidden', 'hidden');
                    }
                }
            }
        }
    });


</script>
