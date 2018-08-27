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
    .selectGroup{
        min-height: 160px;
    }

    @media (max-width: 767px) {
        .page-title .title_left {
            width: 100% !important;
            text-align:center;
        }
    }
</style>
<!-- page content -->
<div class="right_col" role="main">
    <div class="productsList">
        <div class="page-title">
            <div class="title_left">
                <h3><?= lang('edit_article') ?> : <?php echo $meal['name']; ?></h3>
            </div>
        </div>


        <div class="clearfix"></div>
        <hr>
        <div class="row tile_count">
            <div class="col-md-3 col-sm-6 col-xs-12 tile_stats_count">
                <span class="count_top"><i class="fa fa-line-chart"></i> <?= lang("products_count") ?></span>
                <div class="count productsCount"><?php echo count($productsComposition); ?></div>
                <!--<span class="count_bottom"><i class="green">4% </i> From last Week</span>-->
            </div>
            <?php if ($this->session->userdata('type') !== "cuisine") : ?>
            <div class="col-md-3 col-sm-6 col-xs-12 tile_stats_count">
                <span class="count_top"><i class="fa fa-line-chart"></i> <?= lang("cost") ?></span>
                <div class="count cost">
                    <?php
                        if($meal['cost']===''){
                            $meal['cost']=0;
                        }
                        echo $meal['cost'];
                    ?>
                    DH</div>
                <!--<span class="count_bottom"><i class="green"><i class="fa fa-sort-asc"></i>3% </i> From last Week</span>-->
            </div>
            <?php endif; ?>
            <div class="col-md-3 col-sm-6 col-xs-12 tile_stats_count">
                <span class="count_top"><i class="fa fa-line-chart"></i> <?= lang("sale_price") ?></span>
                <div class="count sellPrice green"><?php echo $meal['sellPrice'];?>DH</div>
                <!--<span class="count_bottom"><i class="green"><i class="fa fa-sort-asc"></i>69% </i></span>-->
            </div>
            <?php if ($this->session->userdata('type') !== "cuisine") : ?>
            <div class="col-md-3 col-sm-6 col-xs-12 tile_stats_count">
                <span class="count_top"><i class="fa fa-line-chart"></i> <?= lang("earnings") ?></span>
                <div class="count gain">

                    <?php
                    if ($meal['profit'] === '') {
                        $meal['profit'] = 0;
                    }
                    echo $meal['profit'];
                    ?>
                    DH</div>
                <!--<span class="count_bottom"><i class="red"><i class="fa fa-sort-desc"></i>12% </i> par rapport au dernier prix</span>-->
            </div>
            <?php endif; ?>
        </div>
        <div class="row article-title text-center">
            <div class="col-xs-12">
                <div class="row">
                    <div class="col-xs-12 col-sm-6 col-md-3">
                        <label><?= lang("article_name") ?> : </label>
                        <input value="<?php echo $meal["name"]; ?>" type="text" class="form-control mealName" name="name"/>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-3">
                        <label><?= lang("sale_price") ?> : </label>
                        <input value="<?php echo $meal["sellPrice"]; ?>" type="text" class="form-control sellPriceProduct" name="sellPrice"/>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-3">
                        <label><?= lang("article_count") ?> : </label>
                        <input value="<?php echo $meal["quantity"]; ?>" type="number" class="form-control mealQuantity"/>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-3">
                        <label><?= lang("box_code") ?> : </label>
                        <input value="<?php echo $meal["externalCode"]; ?>" type="number" class="form-control externalCode" disabled />
                    </div>
                </div>
            </div>
        </div>
        <div class="row mealComposition">
            <?php foreach ($productsComposition as $key => $pc) { ?>
            <div class="col-md-6  col-sm-6 col-xs-12 product" data-id="<?php echo $key+1; ?>" >
                                <div class="x_panel">
                                   <div class="x_title">
                                     <?php if ($this->session->userdata('type') !== "cuisine") : ?>
                                       <h2><?php echo $pc['name']; ?> -
                                           <?php echo number_format((float)($pc['unit_price'] * $pc['unitConvert']* $pc['mp_quantity']*$meal['quantity']), 2, '.', ''); ?>
                                       </h2>
                                     <?php endif; ?>
                                       <ul class="nav navbar-right panel_toolbox">
                                           <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                                          <!-- <li><a class="close-link"><i class="fa fa-close"></i></a></li>-->
                                       </ul>
                                       <div class="clearfix"></div>
                                   </div>
                                   <div class="x_content oldContent" style="margin-top:30px;">
                                       <div class="row">
                                           <?php
                                           $KgUnitHidden = 'hidden';
                                           $LUnitHidden = 'hidden';
                                           $unitConvert = $pc['unitConvert'];
                                           if ($pc['unit'] === "kg" || $pc['unit'] === "pcs") {
                                               $KgUnitHidden = '';
                                           }
                                           if ($pc['unit'] === "L") {
                                               $LUnitHidden = '';
                                           }
                                           $mp_unit=strtoupper($pc['mp_unit']);
                                           $mp_unit= preg_replace('/\s+/', '', $mp_unit);
                                           ?>
                                           <div class="col-xs-12 col-sm-6 col-md-6">
                                               <select name="product" class="productSelect form-control md-button-v">
                                                   <?php foreach ($products as $product) {
                                                       $selected = $product['id'] == $pc['product'] ? 'selected' : '';
                                                       ?>
                                                       <option <?php echo $selected; ?>
                                                               data-unit="<?php echo $product['unit']; ?>"
                                                               value="<?php echo $product['id']; ?>"
                                                               data-weightByUnit="<?php echo $product['weightByUnit'] ?>"
                                                               data-price="<?php echo $product['unit_price']; ?>"><?php echo $product['name']; ?></option>
                                                   <?php } ?>
                                               </select>
                                           </div>
                                           <div class="col-xs-12 col-sm-6 col-md-3">
                                               <select name="kgUnitHidden"
                                                       class="kgUnitHidden form-control small-button md-button-v <?php echo $KgUnitHidden ?>">
                                                   <option <?php if ($mp_unit === 'KILOGRAMME') {
                                                       echo "selected";
                                                   } ?>
                                                           value="1" name="Kilogramme">Kilogramme
                                                   </option>
                                                   <option <?php if ($mp_unit === 'GRAMME') {
                                                       echo "selected";
                                                   } ?>
                                                           value="0.001" name="Gramme">Gramme
                                                   </option>
                                                   <option <?php if ($mp_unit === 'MILLIGRAMME') echo "selected"; ?>
                                                           value="0.000001" name="Milligramme">Milligramme
                                                   </option>
                                                   <option <?php if ($mp_unit === 'PCS') echo "selected"; ?>
                                                           value="<?php echo $unitConvert; ?>" name="pcs">Pcs
                                                   </option>
                                               </select>
                                               <select name="lUnitHidden"
                                                       class="lUnitHidden form-control md-button-v <?php echo $LUnitHidden ?>">
                                                   <option <?php if ($mp_unit === 'LITRE') echo "selected"; ?>
                                                           value="1" name="Litre">Litre
                                                   </option>
                                                   <option <?php if ($mp_unit === 'CENTILITRE') echo "selected"; ?>
                                                           value="0.001" name="Centilitre">Centilitre
                                                   </option>
                                                   <option <?php if ($mp_unit === 'MILLILITRE') echo "selected"; ?>
                                                           value="0.000001" name="Millilitre">Millilitre
                                                   </option>
                                               </select>

                                           </div>
                                           <div class="col-xs-12 col-sm-12 col-md-3">
                                               <input class="form-inline form-control md-button-v" placeholder="<?= lang("quantity") ?>"
                                                      name="quantity"
                                                      value="<?php echo $pc['mp_quantity']* $meal['quantity']; ?>"
                                                      type="text">
                                           </div>

                                       </div>
                                   </div>
                               </div>

            </div>
            <?php } ?>
        </div> <!-- /row -->

        <button type="submit" class="btn btn-success" name="addProduct">
            <span class="fa fa-plus"></span> <?= lang("new_product") ?>
        </button>

        <div class="col-md-6  col-sm-6 col-xs-12 product productModel" hidden>
                            <div class="x_panel">
                                <div class="x_title">
                                    <h2><?= lang("product") ?></h2>
                                    <ul class="nav navbar-right panel_toolbox">
                                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                                        <!--<li><a class="close-link"><i class="fa fa-close"></i></a></li>-->
                                    </ul>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="x_content" style="margin-top:30px;" id="newContent">
                                    <div class="row">

                                        <?php
                                        $KgUnitHidden = 'hidden';
                                        $LUnitHidden = 'hidden';
                                        if ($products[0]['unit'] === "kg") {
                                            $KgUnitHidden = '';
                                        }
                                        if ($products[0]['unit'] === "L") {
                                            $LUnitHidden = '';
                                        }
                                        ?>

                                        <div class="col-xs-12 col-sm-6 col-md-6">
                                            <select name="product" class="productSelectNew form-control md-button-v">
                                                <?php foreach ($products as $product) { ?>
                                                    <option value="<?php echo $product['id']; ?>"
                                                            data-unit="<?php echo $product['unit']; ?>"
                                                            data-weightByUnit="<?php echo $product['weightByUnit'] ?>"
                                                            data-price="<?php echo $product['unit_price']; ?>"><?php echo $product['name']; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <div class="col-xs-12 col-sm-6 col-md-3">
                                            <select name="kgUnitHidden"
                                                    class="kgUnitHidden form-control md-button-v <?php echo $KgUnitHidden ?>">
                                                <option value="1" name="Kilogramme">Kilogramme</option>
                                                <option value="0.001" name="Gramme">Gramme</option>
                                                <option value="0.000001" name="Milligramme">Milligramme</option>
                                                <option value="0.001" name="pcs">Pcs</option>
                                            </select>
                                            <select name="lUnitHidden"
                                                    class="lUnitHidden form-control md-button-v <?php echo $LUnitHidden ?>">
                                                <option value="1" name="Litre">Litre</option>
                                                <option value="0.001" name="Centilitre">Centilitre</option>
                                                <option value="0.000001" name="Millilitre">Millilitre</option>
                                            </select>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-3">
                                            <input class="form-inline form-control md-button-v" placeholder="<?= lang("quantity") ?>" name="quantity"
                                                   type="text">
                                        </div>


                                    </div>
                                </div>
                            </div>

        </div>

        <div class="article-title text-center">
            <h4 style="display: inline;"><?= lang("article_group") ?></h4>
        </div>


        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2><?= lang("choose_family") ?></h2>
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

        <input type="submit" name="buttonSubmit" value="<?= lang("edit") ?>" class="btn btn-success"/>
    </div>
</div> <!-- /.col-right -->
<!-- /page content -->

    <?php $this->load->view('admin/partials/admin_footer'); ?>

<script>
    var swal_success_operation_lang = "<?= lang("swal_success_operation"); ?>";
    var swal_error_lang = "<?= lang("swal_error"); ?>";
    var swal_success_edit_lang = "<?= lang("swal_success_edit"); ?>";
    var swal_warning_delete_lang = "<?= lang("swal_warning_delete"); ?>";
    var swal_success_delete_lang = "<?= lang("swal_success_delete"); ?>";

    var product_lang= "<?= lang("product"); ?>";

    var swal_warining_meal_name_lang = "<?= lang("swal_warining_meal_name"); ?>";
    var swal_warining_meal_price_lang = "<?= lang("swal_warining_meal_price"); ?>";
    var swal_warining_negative_earning_lang = "<?= lang("swal_warining_negative_earning"); ?>";
    var swal_warining_category_obligatory_lang = "<?= lang("swal_warining_category_obligatory"); ?>";


</script>


<script>

    $(document).ready(function () {

        var gainRate=1;
        var group=0;
        var productsCount=<?php echo count($productsComposition); ?>;

        $('.sellPrice').html(<?php echo $meal['sellPrice']; ?> + 'DH');
        sellPrice='<?php echo $meal['sellPrice']; ?>';

        $('.sellPriceProduct').on('keyup', function () {
            calulPrixTotal();
        });
        $(document).on('keyup','input[name="quantity"]',calulPrixTotal);
        $(document).on('keyup','.mealQuantity',calulPrixTotal);

        $(document).on('change','.productSelectNew',{'checkOldProducts':true},calulPrixTotal);
        $(document).on('change','.productSelect,.kgUnitHidden,.lUnitHidden',calulPrixTotal);

        function calulPrixTotal() {
            var prixTotal = parseFloat(0);
            var panel = $(this).closest('.product');
            var mealQuantity= $(".mealQuantity").val();
            updateOptions(false);
            for (var i = 1; i <= productsCount; i++) {
                var row = $('.product[data-id=' + i + ']');
                l_panel = row.closest('.product');
                var title = l_panel.find("div.x_title h2");
                var unit = l_panel.find('select[name="product"] option:selected').attr('data-unit');
                var weightByunit = l_panel.find('select[name="product"] option:selected').attr('data-weightByunit');
                var quantity = parseFloat(row.find('input[type="text"]').val().replace(',', '.'));
                var unit_price = parseFloat(row.find('select').find('option:selected').attr('data-price').replace(',', '.'));

                var unitConvertName = 'Pcs';
                var unitConvert = 1;
                if (unit === 'kg') {
                    //prix par unité
                    console.log("this is "+unit);
                    var weightByunitConvert = 0;
                    if (weightByunit > 0) {
                        weightByunitConvert = weightByunit / 1000;
                    }
                    l_panel.find('select[name="kgUnitHidden"] option[name=pcs]').val(weightByunitConvert);
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
                    //prix par unité
                    console.log("this is " + unit);
                    var weightByunitConvert = 0;
                    if (weightByunit > 0) {
                        weightByunitConvert = weightByunit / 1000;
                    }
                    l_panel.find('select[name="kgUnitHidden"] option[name=pcs]').val(1);
                    unitConvert = parseFloat(l_panel.find('select[name="kgUnitHidden"] option:selected').val());
                    unitConvertName = l_panel.find('select[name="kgUnitHidden"] option:selected').text();
                    unitConvertName = unitConvertName.replace(/\s/g, '');
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

                if (quantity > 0 && unit_price > 0){
                    var productPrice= parseFloat(quantity * unit_price/mealQuantity);
                    title.html(product_lang+" - " + (quantity * unit_price).toFixed(3) + "dh");
                    prixTotal += productPrice;
                }

            }
            sellPrice=$(".sellPriceProduct").val();
            $(".count.sellPrice.green").html(sellPrice+'DH');
            $('.cost').html(prixTotal.toFixed(2) +'DH');

            if (sellPrice > 0) {
                $('.gain').html(parseFloat(sellPrice - prixTotal).toFixed(2) + 'DH');
            } else {
                $('.gain').html('0.00DH');
            }

            changeUnit(panel.find('select[name="product"] option:selected').attr('data-unit'), panel);
        };

        calulPrixTotal();


        function changeUnit(value, panel) {
            if (value === 'kg') {
                panel.find('.kgUnitHidden').removeAttr('hidden');
                panel.find('.lUnitHidden').attr('hidden', true);
            } else if (value === 'L') {
                panel.find('.lUnitHidden').removeAttr('hidden');
                panel.find('.kgUnitHidden').attr('hidden', true);
            } else {
                panel.find('.kgUnitHidden').removeAttr('hidden');
                panel.find('.lUnitHidden').attr('hidden', true);
            }
        }

        $('input[name="buttonSubmit"]').on('click', function () {
            var productsList=[];
            var prixTotal=0;
            var name=$('input.mealName').val();
            var mealQuantity = $(".mealQuantity").val();
            if(mealQuantity==0 || mealQuantity==""){
                mealQuantity=1;
            }
            for (var i = 1; i <= productsCount; i++) {

                var row = $('.product[data-id=' + i + ']');
                var l_panel = row.closest('.product');
                var unit = l_panel.find('select[name="product"] option:selected').attr('data-unit');

                var quantity = parseFloat(row.find('input[type="text"]').val().replace(',', '.'));
                var id= row.find('select').find('option:selected').val();
                var unit_price = parseFloat(row.find('select').find('option:selected').attr('data-price').replace(',', '.'));

                var unitConvertName = 'Pcs';
                var unitConvert = 1;
                if (unit === 'kg') {
                    unitConvert = l_panel.find('select[name="kgUnitHidden"] option:selected').val();
                    unitConvertName = l_panel.find('select[name="kgUnitHidden"] option:selected').text();
                    unit_price *= unitConvert;
                }
                if (unit === 'L') {
                    unitConvert = l_panel.find('select[name="lUnitHidden"] option:selected').val();
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
                    unitConvertName=unitConvertName.replace(/\s/g, '');
                    if(unitConvertName=="Pcs"){
                        unitConvert = 1;
                    }else{
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
                    var product= {
                        'id': id, 'quantity': quantity/mealQuantity, 'unit_price': unit_price, 'profit': profit,
                        'unit': unitConvertName,
                        'unitConvert': unitConvert
                    };
                    if (unit_price > 0) {
                        var productPrice = parseFloat(quantity * unit_price / mealQuantity);
                        prixTotal += productPrice;
                    }
                    productsList.push(product);
                }

            }
            var profit = prixTotal * gainRate - prixTotal;

            if(profit<0){
                profit=0;
            }
            var meal={'name':name,'id':<?php echo $meal['id']; ?>,'group':group,'productsList': productsList,"quantity": mealQuantity, 'cost': prixTotal,'sellPrice': sellPrice,'profit': profit};

            if(validate(meal)){
                $('#loading').show();
                console.log(meal);
                $.ajax({
                    url: "<?php echo base_url(); ?>admin/meal/apiEdit",
                    type: "POST",
                    dataType: "json",
                    data: {'meal': meal},
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
                            document.location.href = data.redirect;
                            var nextId = parseInt(<?php echo $meal['id']; ?>) + parseInt(1);
                            window.location.href = "<?php echo base_url("admin/meal/edit/"); ?>" + nextId;
                        }
                        else {
                            /*$('#show_id').html("<div style='border:1px solid red;font-size: 11px;margin:0 auto !important;'>" + response.error + "</div>");*/
                        }

                    },
                    error: function (data) {
                        $('#loading').hide();
                    }
                });
            }

        });

        function validate(meal) {
            var validate = true;
            if (meal['name'] === '') {
                swal({
                    title: "Attention",
                    text: swal_warining_meal_name_lang,
                    type: "warning",
                    timer: 2000,
                    showConfirmButton: false
                });
                validate = false;
            }else if (meal['sellPrice'] === '' || isNaN(meal['sellPrice'])) {
                swal({
                    title: "Attention",
                    text: swal_warining_meal_price_lang,
                    type: "warning",
                    timer: 2000,
                    showConfirmButton: false
                });
                validate = false;
            } else if (meal['sellPrice'] < meal['cost'] && meal['sellPrice'] > 0) {
                swal({
                    title: "Attention",
                    text: swal_warining_negative_earning_lang,
                    type: "warning",
                    timer: 2000,
                    showConfirmButton: false
                });
                validate = false;
            } else if (meal['group'] === 0) {
                swal({
                    title: "Attention",
                    text: swal_warining_category_obligatory_lang,
                    type: "warning",
                    timer: 2000,
                    showConfirmButton: false
                });
                validate = false;
            }
            return validate;
        }
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

        $(".well[data-id=<?php echo $meal['group']; ?>]").trigger("click");

        $('button[name="addProduct"]').on('click', addProduct);
        function addProduct(event) {
            var productModel = $('.productModel').clone().removeAttr('hidden');
            productModel.removeClass('productModel');
            productsCount++;
            productModel.attr('data-id',productsCount);
            $('.mealComposition').append(productModel);
            $('.productsCount').html(productsCount);
            console.log("productsCount", productsCount);
            if(productsCount>1){
                updateOptions(true);
            }
        }

        function updateOptions(newProductt) {

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
                    if (productsCount === i && newProductt) {
                        l_panel.find('select[name="product"] option[value=' + val + ']').attr('hidden', 'hidden');
                        l_panel.find('select[name="product"] option').not('[hidden]').first().attr('selected', 'selected');
                    } else {
                        l_panel.find('select[name="product"] option[value=' + val + ']').attr('hidden', 'hidden');
                    }
                }
            }
        }

        updateOptions(false);
    });

</script>
