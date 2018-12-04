<?php $this->load->view('admin/partials/admin_header.php'); ?>
<!-- page content -->
<div class="right_col" role="main">
    <div class="productsList">
        <div class="page-title">
            <div class="title_left">
                <h3><?= lang('composition_product'); ?></h3>
            </div>
        </div>

        <div class="clearfix"></div>
        <hr>


        <form id="addProduct" method="post">
            <div class="row productsListContent">
                <div class="col-md-12 col-sm-12 col-xs-12 productItem" data-id="1">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2><?= lang('product'); ?></h2>
                            <ul class="nav navbar-right panel_toolbox">
                                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                                <!--<li><a class="close-link"><i class="fa fa-close"></i></a></li>-->
                            </ul>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">
                            <fieldset>
                                <div class="row">
                                        <div class="col-md-6 col-xs-12">
                                            <div class="form-group">
                                                <?= lang('name'); ?><span class="required">*</span> : <input class="form-control"
                                                                                            placeholder="<?= lang('product'); ?>"
                                                                                            name="productName"
                                                                                            id="username" type="text"
                                                                                            required>
                                            </div>

                                            <div class="form-group">
                                                Quantité produite<span class="required">*</span> : <input value="1" class="form-control mealQuantity"
                                                                                            placeholder="<?= lang('quantity'); ?>"
                                                                                            name="quantity"
                                                                                            id="quantity" type="text"
                                                                                            required>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-xs-12">
                                            <div class="form-group">
                                                <?= lang('unit_of_measure'); ?> :
                                                <select class="form-control" name="unit">
                                                    <option value="kg">Kg</option>
                                                    <option value="pcs">Pcs</option>
                                                    <option value="L">Litre</option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <?= lang('unit_price'); ?><span class="required">*</span> : <input
                                                        class="form-control cost"
                                                        value="0.00"
                                                        placeholder="<?= lang('unit_price'); ?>"
                                                        name="unit_price">
                                        </div>
                                </div>
                                <br/>
                                <!-- <input type="submit" name="buttonSubmit" value="Confirmer" class="btn btn-success" />
                                 <div value="Nouveau produit" class="btn btn-info newProduct" >Nouveau produit</div>-->
                            </fieldset>
                        </div> <!-- /content -->
                    </div><!-- /x-panel -->
                </div>
            </div>
        </form>
        <div class="row mealComposition">
            <div class="col-md-6 col-sm-6 col-xs-12 product" data-id="1">
                <div class="x_panel">
                    <div class="x_title">
                        <h2><?= lang('composition'); ?></h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                            <!--<li><a class="close-link"><i class="fa fa-close"></i></a></li>-->
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <form method="post">
                            <fieldset>
                                <div class="">
                                   <div class="x_content">

                                       <div class="col-md-6">
                                           <select name="product" class="form-control productSelect  md-button-v">
                                               <?php foreach ($products as $product){ ?>
                                                   <option value="<?php echo $product['id'] ?>"
                                                           data-unit="<?php echo $product['unit'] ?>"
                                                           data-weightByUnit="<?php echo $product['weightByUnit'] ?>"
                                                           data-price="<?php echo $product['unit_price'] ?>">
                                                       <?php echo $product['name'] ?>
                                                   </option>
                                               <?php } ?>
                                           </select>
                                       </div>

                                       <?php
                                        $KgUnitHidden='hide';
                                        $LUnitHidden='hide';
                                        if(isset($products) && count($products)>0){
                                            if ($products[0]['unit'] === "kg") {
                                                $KgUnitHidden = '';
                                            }
                                            if ($products[0]['unit'] === "L") {
                                                $LUnitHidden = '';
                                            }
                                        }
                                       ?>
                                       <div class="col-md-3">
                                           <select name="kgUnitHidden" class="kgUnitHidden form-control md-button-v <?php echo $KgUnitHidden ?>">
                                               <option value="1" name="Kilogramme">Kilogramme</option>
                                               <option value="0.001" name="Gramme">Gramme</option>
                                               <option value="0.000001" name="Milligramme">Milligramme</option>
                                               <option value="0.001" name="pcs">Pcs</option>
                                           </select>
                                           <select name="lUnitHidden" class="lUnitHidden form-control md-button-v <?php echo $LUnitHidden ?>" >
                                               <option value="1" name="Litre">Litre</option>
                                               <option value="0.001" name="Centilitre">Centilitre</option>
                                               <option value="0.000001" name="Millilitre">Millilitre</option>
                                           </select>
                                       </div>

                                       <div class="col-md-3">
                                           <input class="form-inline form-control md-button-v" placeholder="<?= lang('quantity'); ?>" name="quantity"
                                                  type="text"><!--<span class="ProductUnit"> Kg</span>
                                       <div class="text-center productCost">0 Dh</div>-->
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
            <span class="fa fa-plus"></span> <?= lang('new_product'); ?>
        </button>

        <div class="col-md-6 col-sm-6 col-xs-12 product productModel" hidden>
            <div class="x_panel">
                <div class="x_title">
                    <h2><?= lang('composition'); ?></h2>
                    <ul class="nav navbar-right panel_toolbox">
                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                        <!--<li><a class="close-link"><i class="fa fa-close"></i></a></li>-->
                    </ul>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <form method="post">
                        <fieldset>
                            <div class="">
                                <div class="x_content" id="newContent">

                                    <div class="col-md-6">
                                        <select name="product" class="productSelectNew  md-button-v form-control">
                                            <?php foreach ($products as $product) { ?>
                                                <option value="<?php echo $product['id']; ?>"
                                                        data-unit="<?php echo $product['unit'] ?>"
                                                        data-weightByUnit="<?php echo $product['weightByUnit'] ?>"
                                                        data-price="<?php echo $product['unit_price']; ?>">
                                                    <?php echo $product['name']; ?>
                                                </option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <select name="kgUnitHidden" class="kgUnitHidden md-button-v form-control <?php echo $KgUnitHidden ?>" >
                                            <option value="1" name="Kilogramme">Kilogramme</option>
                                            <option value="0.001" name="Gramme">Gramme</option>
                                            <option value="0.000001" name="Milligramme">Milligramme</option>
                                            <option value="0.001" name="pcs">Pcs</option>
                                        </select>
                                        <select name="lUnitHidden" class="lUnitHidden  md-button-v form-control <?php echo $LUnitHidden ?>" >
                                            <option value="1" name="Kilogramme">Litre</option>
                                            <option value="0.001" name="Centilitre">Centilitre</option>
                                            <option value="0.000001" name="Millilitre">Millilitre</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                       <input class="form-inline  md-button-v form-control" placeholder="<?= lang('quantity'); ?>" name="quantity"
                                                          type="text">
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


        <input type="submit" name="buttonSubmit" value="<?= lang('confirme'); ?>" class="btn btn-success"/>
    </div>
</div> <!-- /.col-right --> 
<!-- /page content -->

<?php $this->load->view('admin/partials/admin_footer'); ?>
<script>
    var swal_error_lang ="<?= lang("swal_error"); ?>";
    var swal_ask_article_name_lang ="<?= lang("swal_ask_article_name"); ?>";
</script>

<script>

    $(document).ready(function () {

        var sellPrice=0;
        var productsCount=1;

        $(document).on('change', '.productSelect,.productSelectNew,.kgUnitHidden,.lUnitHidden', calulPrixTotal);
        $(document).on('keyup', 'input[name=quantity]', calulPrixTotal);

        function calulPrixTotal() {

            //changing product informations

            //panel parent du produit
            var panel = $(this).closest('.product');
            //prix et unité
            var unit = panel.find('select[name="product"] option:selected').attr('data-unit');
            var price = parseFloat(panel.find('select[name="product"] option:selected').attr('data-price'));
            var productQuantity = parseFloat(panel.find('input[name="quantity"]').val());
            var mealQuantity = $(".mealQuantity").val();

            updateOptions(false);

            // panel.find('.ProductUnit').html(unit);
            panel.find('.productCost').html(price*productQuantity);

            //end

            var l_panel='';
            var prixTotal = parseFloat(0);
            for (var i = 1; i <= productsCount; i++) {
                var row = $('.product[data-id=' + i + ']');
                l_panel = row.closest('.product');
                var title = l_panel.find("div.x_title h2");
                var unit = l_panel.find('select[name="product"] option:selected').attr('data-unit');
                var weightByunit = l_panel.find('select[name="product"] option:selected').attr('data-weightByunit');
                var quantity = parseFloat(row.find('input[type="text"]').val().replace(',', '.'));
                var unit_price = parseFloat(row.find('select').find('option:selected').attr('data-price').replace(',', '.'));
                var unitConvert=1;
                var unitConvertName='';
                if (unit === 'kg') {

                    //prix par unité
                    var weightByunitConvert=0;
                    if(weightByunit>0){
                        weightByunitConvert= weightByunit/1000;
                    }
                    l_panel.find('select[name="kgUnitHidden"] option[name=pcs]').val(weightByunitConvert);
                    unitConvert = parseFloat(l_panel.find('select[name="kgUnitHidden"] option:selected').val());
                    unitConvertName = parseFloat(l_panel.find('select[name="kgUnitHidden"] option:selected').text());
                    unit_price *= unitConvert;
                }
                if (unit === 'L') {
                    unitConvert = parseFloat(l_panel.find('select[name="lUnitHidden"] option:selected').val());
                    unitConvertName = parseFloat(l_panel.find('select[name="lUnitHidden"] option:selected').text());
                    unit_price *= unitConvert;
                }
                if (unit === 'pcs') {

                    //prix par unité
                    var weightByunitConvert = 0;
                    if (weightByunit > 0) {
                        weightByunitConvert = weightByunit / 1000;
                    }
                    l_panel.find('select[name="kgUnitHidden"] option[name=pcs]').val(1);
                    unitConvert = parseFloat(l_panel.find('select[name="kgUnitHidden"] option:selected').val());
                    unitConvertName = l_panel.find('select[name="kgUnitHidden"] option:selected').text();


                    if (unitConvertName === "Kilogramme") {
                        unit_price = (unit_price / weightByunit)*1000;
                    }else if (unitConvertName === "Gramme") {
                        unit_price = (unit_price / weightByunit);
                    } else if (unitConvertName === "Milligramme") {
                        unit_price = (unit_price / weightByunit) * 0.001;
                    } else {
                        unit_price *= unitConvert;
                    }

                    if(weightByunit==0 && unitConvertName!=='Pcs'){
                        unit_price=0;
                    }
                    

                }
                if (quantity > 0 && unit_price > 0){
                    var productPrice = parseFloat(quantity * unit_price / mealQuantity);
                    title.html("Produit - " + parseFloat(quantity * unit_price).toFixed(3) + "dh");
                    prixTotal += productPrice;
                }
            }


            if(mealQuantity>0){
                $('.cost').val(prixTotal.toFixed(2));
            }

            changeUnit(panel.find('select[name="product"] option:selected').attr('data-unit'), panel);

        };
        function changeUnit(value,panel) {
            if(value==='kg'){
                panel.find('.kgUnitHidden').removeClass('hide');
                panel.find('.lUnitHidden').addClass('hide');
            }else if(value==='L'){
                panel.find('.lUnitHidden').removeClass('hide');
                panel.find('.kgUnitHidden').addClass('hide');
            }else{
                panel.find('.kgUnitHidden').removeClass('hide');
                panel.find('.lUnitHidden').addClass('hide');
            }
        }

        $('input[name="buttonSubmit"]').on('click', function () {

            var productsList=[];
            var prixTotal=0;
            var name=$('input[name=productName]').val();
            var productQuantity=$('input[name=productQuantity]').val();
            var productUnit=$('select[name="unit"] option:selected').val();
            var mealQuantity = $(".mealQuantity").val();
            for (var i = 1; i <= productsCount; i++) {

                var row = $('.product[data-id=' + i + ']');
                l_panel = row.closest('.product');
                var title = l_panel.find("div.x_title h2");
                var unit = l_panel.find('select[name="product"] option:selected').attr('data-unit');
                var weightByunit = l_panel.find('select[name="product"] option:selected').attr('data-weightByunit');
                var quantity = parseFloat(row.find('input[type="text"]').val().replace(',', '.'));
                var id= row.find('select').find('option:selected').val();
                var unit_price = parseFloat(row.find('select').find('option:selected').attr('data-price').replace(',', '.'));
                var unitConvert=1;
                var unitConvertName='';

                //conversion des unités
                var unitConvertName = 'Pcs';
                var unitConvert = 1;
                if (unit === 'kg') {

                    l_panel.find('select[name="kgUnitHidden"] option[name=pcs]').val(weightByunitConvert);
                    unitConvert = parseFloat(l_panel.find('select[name="kgUnitHidden"] option:selected').val());
                    unitConvertName = l_panel.find('select[name="kgUnitHidden"] option:selected').text();
                    //prix par unité
                    var weightByunitConvert=0;
                    if(weightByunit>0){
                        weightByunitConvert= weightByunit/1000;
                    }
                    unit_price *= unitConvert;
                }
                if (unit === 'L') {
                    unitConvert = parseFloat(l_panel.find('select[name="lUnitHidden"] option:selected').val());
                    unitConvertName = l_panel.find('select[name="lUnitHidden"] option:selected').text();
                    unit_price *= unitConvert;
                }
                if (unit === 'pcs') {

                    //prix par unité
                    var weightByunitConvert = 0;
                    if (weightByunit > 0) {
                        weightByunitConvert = weightByunit / 1000;
                    }
                    l_panel.find('select[name="kgUnitHidden"] option[name=pcs]').val(1);
                    unitConvert = parseFloat(l_panel.find('select[name="kgUnitHidden"] option:selected').val());
                    unitConvertName = l_panel.find('select[name="kgUnitHidden"] option:selected').text();


                    if (unitConvertName === "Kilogramme") {
                        unit_price = (unit_price / weightByunit)*1000;
                    }else if (unitConvertName === "Gramme") {
                        unit_price = (unit_price / weightByunit);
                    } else if (unitConvertName === "Milligramme") {
                        unit_price = (unit_price / weightByunit) * 0.001;
                    } else {
                        unit_price *= unitConvert;
                    }

                    if(weightByunit==0 && unitConvertName!=='Pcs'){
                        unit_price=0;
                    }


                }
                if (quantity > 0 && unit_price > 0){
                    prixTotal += quantity * unit_price;
                    var product={'id':id,'quantity':quantity,'unit_price':unit_price,'unit': unitConvertName,'unitConvert': unitConvert};
                    productsList.push(product);
                }

            }


            var compositionUnitPrice=$("input[name=unit_price]").val();
            var composition = {
                'name': name,
                'quantity': mealQuantity,
                'unit': productUnit,
                'productsList': productsList,
                'cost': compositionUnitPrice,
            };
            if (validate(composition)) {
                $('#loading').show();
                $.ajax({
                    url: "<?php echo base_url('admin/product/addComposition'); ?>",
                    type: "POST",
                    dataType: "json",
                    data: {'composition': composition},
                    success: function (data) {
                        $('#loading').hide();
                        if (data.status = "success") {
                            swal({
                                title: "Success",
                                text: "Success",
                                type: "success",
                                timer: 1500,
                                showConfirmButton: false
                            });

                            window.location.href = data.redirect;
                        } else {
                            $('#loading').hide();
                            swal({
                                title: "Oups !",
                                text: swal_error_lang,
                                type: "error",
                                timer: 1500,
                                showConfirmButton: false
                            });

                        }
                    },
                    error: function (data) {
                        swal({
                            title: "Oups !",
                            text: swal_error_lang,
                            type: "error",
                            timer: 1500,
                            showConfirmButton: false
                        });
                    }
                });
            }
        });



        function validate(meal) {
            var validate=true;
            if(meal['name']===''){
                swal({
                    title: "Attention",
                    text: swal_ask_article_name_lang,
                    type: "warning",
                    timer: 2000,
                    showConfirmButton: false
                });
                validate=false;
            }
            return validate;
        }

        var productSize=1;


;


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

        function updateOptions(newProduct) {

            var selectedProducts = [];
            for (var i = 1; i <= productsCount; i++) {
                var row = $('.product[data-id=' + i + ']');
                var l_panel = row.closest('.product');
                var optionValue = l_panel.find('select[name="product"] option:selected').val();
                var unit = l_panel.find('select[name="product"] option:selected').attr('data-unit');
                var price = l_panel.find('select[name="product"] option:selected').attr('data-price');
                var option = {
                    'unit': unit,
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
                    var val = selectedProducts[j]['value'];
                    var actualVal = l_panel.find('select[name="product"] option:selected').val();
                    if (productsCount === i && newProduct) {
                        l_panel.find('select[name="product"] option[value=' + val + ']').attr('hidden', 'hidden');
                        l_panel.find('select[name="product"] option').not('[hidden]').first().attr('selected', 'selected');
                    } else {
                        l_panel.find('select[name="product"] option[value=' + val + ']').attr('hidden', 'hidden');
                    }
                }
            }
        }
    });


</script>
