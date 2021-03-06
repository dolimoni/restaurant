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

    .selectGroup {
        min-height: 160px;
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
            <?php if ($this->session->userdata('type') !== "cuisine") : ?>
            <div class="col-md-3 col-sm-6 col-xs-12 tile_stats_count">
                <span class="count_top"><i class="fa fa-line-chart"></i> Coût</span>
                <div class="count cost">0DH</div>
                <!--<span class="count_bottom"><i class="green"><i class="fa fa-sort-asc"></i>3% </i> From last Week</span>-->
            </div>
            <?php endif; ?>
            <div class="col-md-3 col-sm-6 col-xs-12 tile_stats_count">
                <span class="count_top"><i class="fa fa-line-chart"></i> Prix de vente</span>
                <div class="count sellPrice green">0DH</div>
                <!--<span class="count_bottom"><i class="green"><i class="fa fa-sort-asc"></i>69% </i></span>-->
            </div>
            <?php if ($this->session->userdata('type') !== "cuisine") : ?>
            <div class="col-md-3 col-sm-6 col-xs-12 tile_stats_count">
                <span class="count_top"><i class="fa fa-line-chart"></i> Bénifices</span>
                <div class="count gain">0DH</div>
                <!--<span class="count_bottom"><i class="red"><i class="fa fa-sort-desc"></i>12% </i> par rapport au dernier prix</span>-->
            </div>
            <?php endif; ?>
        </div>

        <div class="article-title text-center row">
            <div class="col-xs-12">
                <div class="row">
                    <div class="col-xs-12 col-sm-6 col-md-3">
                        <label>Nom de l'article : </label>
                        <input type="text" class="form-control mealName" name="name"/>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-3">
                        <label>Prix de vente : </label>
                        <input type="text" class="form-control sellPrice" name="sellPrice"/>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-3">
                        <label>Nombre d'articles : </label>
                        <input value="1" type="number" class="form-control mealQuantity"/>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-3">
                        <label>Code Caisse : </label>
                        <input type="number" class="form-control externalCode"/>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mealComposition">
            <div class="col-md-6 col-sm-6 col-xs-12 product" data-id="1">
                <div class="x_panel">
                    <div class="x_title">
                        <?php if ($this->session->userdata('type') !== "cuisine") : ?>
                        <h2>Produit</h2>
                        <?php endif; ?>
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
                                <div class="row">
                                   <div class="x_content">

                                       <select name="product" class="productSelect  md-button-v">
                                           <?php foreach ($products as $product){ ?>
                                               <option value="<?php echo $product['id'] ?>" data-unit="<?php echo $product['unit'] ?>"
                                                       data-price="<?php echo $product['unit_price'] ?>"
                                                       data-weightByUnit="<?php echo $product['weightByUnit'] ?>">
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
                                           <option value="0.001" name="pcs">Pcs</option>
                                       </select>
                                       <select name="lUnitHidden" class="lUnitHidden  md-button-v" <?php echo $LUnitHidden ?>>
                                               <option value="1" name="Kilogramme">Litre</option>
                                               <option value="0.001" name="Centilitre">Centilitre</option>
                                               <option value="0.000001" name="Millilitre">Millilitre</option>
                                       </select>
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
                            <div class="row">
                                <div class="x_content" id="newContent">

                                    <select name="product" class="productSelectNew  md-button-v">
                                        <?php foreach ($products as $product) { ?>
                                            <option value="<?php echo $product['id']; ?>"
                                                    data-unit="<?php echo $product['unit'] ?>"
                                                    data-weightByUnit="<?php echo $product['weightByUnit'] ?>"
                                                    data-price="<?php echo $product['unit_price']; ?>">
                                                <?php echo $product['name']; ?>
                                            </option>
                                        <?php } ?>
                                    </select>
                                    <select name="kgUnitHidden" class="kgUnitHidden  md-button-v" <?php echo $KgUnitHidden ?>>
                                        <option value="1" name="Kilogramme">Kilogramme</option>
                                        <option value="0.001" name="Gramme">Gramme</option>
                                        <option value="0.000001" name="Milligramme">Milligramme</option>
                                        <option value="0.001" name="pcs">Pcs</option>
                                    </select>
                                    <select name="lUnitHidden" class="lUnitHidden  md-button-v" <?php echo $LUnitHidden ?>>
                                        <option value="1" name="Kilogramme">Litre</option>
                                        <option value="0.001" name="Centilitre">Centilitre</option>
                                        <option value="0.000001" name="Millilitre">Millilitre</option>
                                    </select>
                                    <input class="form-inline  md-button-v" placeholder="Quantité" name="quantity"
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
                        $numOfSMCols = 2;
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
        $(document).on('keyup', '.mealQuantity', calulPrixTotal);
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
                    console.log("this is " + unit);
                    var weightByunitConvert = 0;
                    if (weightByunit > 0) {
                        weightByunitConvert = weightByunit / 1000;
                    }
                    l_panel.find('select[name="kgUnitHidden"] option[name=pcs]').val(1);
                    unitConvert = parseFloat(l_panel.find('select[name="kgUnitHidden"] option:selected').val());
                    unitConvertName = l_panel.find('select[name="kgUnitHidden"] option:selected').text();


                    if (unitConvertName === "Kilogramme") {
                        unit_price = (unit_price / weightByunit)/0.001;
                    }else if (unitConvertName === "Gramme") {
                        unit_price = (unit_price / weightByunit);
                    } else if (unitConvertName === "Milligramme") {
                        unit_price = (unit_price / weightByunit) * 0.001;
                    } else {
                        unit_price *= unitConvert;
                    }
                }
                if (quantity > 0 && unit_price > 0){
                    var productPrice = parseFloat(quantity * unit_price / mealQuantity);
                    title.html("Produit - " + parseFloat(quantity * unit_price).toFixed(3) + "dh");
                    prixTotal += productPrice;
                }
            }

            $('.cost').html(prixTotal.toFixed(2)+'DH');

            if (sellPrice > 0) {
                $('.gain').html(parseFloat(sellPrice - prixTotal).toFixed(2) + 'DH');
            } else {
                $('.gain').html('0.00DH');
            }

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
                panel.find('.kgUnitHidden').removeAttr('hidden');
                panel.find('.lUnitHidden').attr('hidden', true);
            }
        }

        $('input[name="buttonSubmit"]').on('click', function () {

            var productsList=[];
            var prixTotal=0;
            var name=$('input.mealName').val();
            var externalCode=$('input.externalCode').val();
            var mealQuantity = $(".mealQuantity").val();
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
                if (unit === 'pcs') {
                    var weightByunit = l_panel.find('select[name="product"] option:selected').attr('data-weightByunit');
                    unitConvertName = l_panel.find('select[name="kgUnitHidden"] option:selected').text();
                    var weightByunitConvert = 0;
                    if (weightByunit > 0) {
                        weightByunitConvert = weightByunit / 1000;
                    }
                    unitConvert = l_panel.find('select[name="kgUnitHidden"] option:selected').val();
                    unitConvertName = unitConvertName.replace(/\s/g, '');
                    if (unitConvertName == "Pcs") {
                        unitConvert = 1;
                    } else {
                        unitConvert = unitConvert / weightByunitConvert;
                    }
                    if (unitConvertName === "Kilogramme") {
                        unit_price = (unit_price / weightByunit) / 0.001;
                    } else if (unitConvertName === "Gramme") {
                        unit_price = (unit_price / weightByunit);
                    } else if (unitConvertName === "Milligramme") {
                        unit_price = (unit_price / weightByunit) * 0.001;
                    } else {
                        unit_price *= unitConvert;
                    }
                }
                if (quantity > 0){
                    var product={'id':id,'quantity':quantity/mealQuantity,'unit_price':unit_price,'profit': profit,'unit': unitConvertName,'unitConvert': unitConvert};
                    productsList.push(product);
                }
                if(unit_price > 0){
                    var productPrice = parseFloat(quantity * unit_price / mealQuantity);
                    prixTotal += productPrice;
                }

            }
            var profit = sellPrice-prixTotal;
            if(profit<0){
                profit=0;
            }
            prixTotal=parseFloat(prixTotal).toFixed(2);
            sellPrice=parseFloat(sellPrice).toFixed(2);
            profit=parseFloat(profit).toFixed(2);
            //var sellPrice = prixTotal * gainRate ;
            var meal = {
                'name': name,
                'group': group,
                'productsList': productsList,
                'quantity': mealQuantity,
                'cost': prixTotal,
                'sellPrice': sellPrice,
                'externalCode': strPad(externalCode, 18),
                'profit': profit
            };
            console.log(meal);
            if (validate(meal)) {
                console.log(meal);
                $('#loading').show();
                $.ajax({
                    url: "<?php echo base_url("admin/meal/add"); ?>",
                    type: "POST",
                    dataType: "json",
                    data: {'meal': meal},
                    success: function (data) {
                        $('#loading').hide();
                        if (data.status === true) {
                            swal({
                                title: "Success",
                                text: "Success",
                                type: "success",
                                timer: 1500,
                                showConfirmButton: false
                            });
                            document.location.href = data.redirect;
                        }else if(data.status === "warning"){
                            swal({
                                title: "Attention",
                                text: data.msg,
                                type: "warning",
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
                            /*$('#show_id').html("<div style='border:1px solid red;font-size: 11px;margin:0 auto !important;'>" + response.error + "</div>");*/
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

        function strPad(i, l, s) {
            var o = i.toString();
            if (!s) {
                s = '0';
            }
            while (o.length < l) {
                o = s + o;
            }
            return o;
        };

        function validate(meal) {
            var validate=true;
            console.log("validate", meal);
            if(meal['name']===''){
                swal({
                    title: "Attention",
                    text: "Quel est le nom de votre article ?",
                    type: "warning",
                    timer: 2000,
                    showConfirmButton: false
                });
                validate=false;
            }else if (meal['sellPrice'] === '' || isNaN(meal['sellPrice'])) {
                swal({
                    title: "Attention",
                    text: "Quel est le prix de votre article ?",
                    type: "warning",
                    timer: 2000,
                    showConfirmButton: false
                });
                validate = false;
            }else if(parseFloat(meal['sellPrice']) < parseFloat(meal['cost']) && meal['sellPrice'] > 0){
                swal({
                    title: "Attention",
                    text: "Le bénifice est négative",
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


        $(".well[data-id=<?php echo $defaultGroup; ?>]").trigger("click");
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
