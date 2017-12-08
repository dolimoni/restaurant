<?php $this->load->view('admin/partials/admin_header.php'); ?>
<!-- page content -->
<div class="right_col" role="main">
    <div class="productsList">
        <div class="page-title">
            <div class="title_left">
                <h3>Ajouter des produits</h3>
            </div>
        </div>

        <div class="article-title text-center row">
            <div class="col-md-offset-4 col-md-5 col-sm-6 col-xs-12">
                <h4 style="display: inline;">Département : </h4>
                <select name="department" class="departmentSelect  md-button-v">
                    <?php foreach ($departments as $departments) { ?>
                        <option value="<?php echo $departments['id'] ?>">
                            <?php echo $departments['name'] ?>
                        </option>
                    <?php } ?>
                </select>
            </div>
        </div>
        <div class="row mealComposition">
            <div class="col-md-6 col-sm-6 col-xs-12 product" data-id="1">
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
                                    <div class="x_content">

                                        <select name="product" class="productSelect  md-button-v">
                                            <?php foreach ($products as $product) { ?>
                                                <option value="<?php echo $product['id'] ?>"
                                                        data-unit="<?php echo $product['unit'] ?>"
                                                        data-price="<?php echo $product['unit_price'] ?>">
                                                    <?php echo $product['name'] ?>
                                                </option>
                                            <?php } ?>
                                        </select>
                                        <?php
                                        $KgUnitHidden = 'hidden';
                                        $LUnitHidden = 'hidden';
                                        if (isset($products) && count($products) > 0) {
                                            if ($products[0]['unit'] === "kg") {
                                                $KgUnitHidden = '';
                                            }
                                            if ($products[0]['unit'] === "L") {
                                                $LUnitHidden = '';
                                            }
                                        }
                                        ?>
                                        <select name="kgUnitHidden"
                                                class="kgUnitHidden  md-button-v" <?php echo $KgUnitHidden ?>>
                                            <option value="1" name="Kilogramme">Kilogramme</option>
                                            <option value="0.001" name="Gramme">Gramme</option>
                                            <option value="0.000001" name="Milligramme">Milligramme</option>
                                        </select>
                                        <select name="lUnitHidden"
                                                class="lUnitHidden  md-button-v" <?php echo $LUnitHidden ?>>
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
        <button type="submit" class="btn btn-info" name="addProduct">
            <span class="fa fa-plus"></span> Nouveau produit
        </button>

        <div class="col-md-6 col-sm-6 col-xs-12 product productModel" hidden>
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

                                    <select name="product" class="productSelectNew  md-button-v">
                                        <?php foreach ($products as $product) { ?>
                                            <option value="<?php echo $product['id']; ?>"
                                                    data-unit="<?php echo $product['unit'] ?>"
                                                    data-price="<?php echo $product['unit_price']; ?>">
                                                <?php echo $product['name']; ?>
                                            </option>
                                        <?php } ?>
                                    </select>
                                    <select name="kgUnitHidden"
                                            class="kgUnitHidden  md-button-v" <?php echo $KgUnitHidden ?>>
                                        <option value="1" name="Kilogramme">Kilogramme</option>
                                        <option value="0.001" name="Gramme">Gramme</option>
                                        <option value="0.000001" name="Milligramme">Milligramme</option>
                                    </select>
                                    <select name="lUnitHidden"
                                            class="lUnitHidden  md-button-v" <?php echo $LUnitHidden ?>>
                                        <option value="1" name="Kilogramme">Litre</option>
                                        <option value="0.001" name="Centilitre">Centilitre</option>
                                        <option value="0.000001" name="Millilitre">Millilitre</option>
                                    </select>
                                    Quantité : <input class="form-inline  md-button-v" placeholder="Quantité"
                                                      name="quantity"
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



<script>

    $(document).ready(function () {

        var gainRate = 1;
        var group = 0;
        var sellPrice = 0;
        var productsCount = 1;
        $(document).on('keyup', 'input[name="quantity"]', calulPrixTotal);
        $("select").change(calulPrixTotal);



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

            // panel.find('.ProductUnit').html(unit);
            panel.find('.productCost').html(price * productQuantity);

            //end

            var l_panel = '';
            var prixTotal = parseFloat(0);
            for (var i = 1; i <= productsCount; i++) {
                var row = $('.product[data-id=' + i + ']');
                l_panel = row.closest('.product');
                var unit = l_panel.find('select[name="product"] option:selected').attr('data-unit');
                var quantity = parseFloat(row.find('input[type="text"]').val().replace(',', '.'));
                var unit_price = parseFloat(row.find('select').find('option:selected').attr('data-price').replace(',', '.'));
                var unitConvert = 1;
                var unitConvertName = '';
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


            changeUnit(panel.find('select[name="product"] option:selected').attr('data-unit'), panel);

        };

        function changeUnit(value, panel) {
            if (value === 'kg') {
                panel.find('.kgUnitHidden').removeAttr('hidden');
                panel.find('.lUnitHidden').attr('hidden', true);
            } else if (value === 'L') {
                panel.find('.lUnitHidden').removeAttr('hidden');
                panel.find('.kgUnitHidden').attr('hidden', true);
            } else {
                panel.find('.kgUnitHidden').attr('hidden', true);
                panel.find('.lUnitHidden').attr('hidden', true);
            }
        }

        $('input[name="buttonSubmit"]').on('click', function () {

            var productsList = [];
            var prixTotal = 0;
            var name = $('input.mealName').val();
            for (var i = 1; i <= productsCount; i++) {

                var row = $('.product[data-id=' + i + ']');
                var l_panel = row.closest('.product');
                var unit = l_panel.find('select[name="product"] option:selected').attr('data-unit');
                var quantity = parseFloat(row.find('input[type="text"]').val().replace(',', '.'));
                var id = row.find('select').find('option:selected').val();
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
                if (quantity > 0 && unit_price > 0) {
                    prixTotal += quantity * unit_price;
                    var product = {
                        'id': id,
                        'quantity': quantity,
                        'unitConvert': unitConvert
                    };
                    productsList.push(product);
                }

            }

            var stock = {
                'productsList': productsList,
                'department': $('select[name="department"] option:selected').val()
            };
            if (true) {
                console.log(stock);
                $.ajax({
                    url: "<?php echo base_url('admin/department/apiAddStock'); ?>",
                    type: "POST",
                    dataType: "json",
                    data: {'stock': stock},
                    success: function (data) {
                        if (data.status === 'success') {
                            //document.location.href = data.redirect;
                            swal({
                                title: "Success",
                                text: "L'opération a été bien effectuée",
                                type: "success",
                                timer: 1500,
                                showConfirmButton: false
                            });
                            loation.reload();
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

        var productSize = 1;


;


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