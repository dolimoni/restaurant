<?php $this->load->view('admin/partials/admin_header.php'); ?>
<!-- page content -->
<div class="right_col" role="main">
    <div class="productsList">
        <div class="page-title">
            <div class="row text-center-sm">
                <h3>Ajouter des produits</h3>
            </div>
        </div>

        <div class="article-title text-center row">
            <div class="col-md-offset-4 col-md-5 col-sm-6 col-xs-12">
                <select name="department" class="departmentSelect form-control  md-button-v">
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

                                        <div class="row">
                                            <div class="col-xs-12 col-sm-8">
                                                <select name="product" class="productSelect form-control md-button-v">
                                                    <?php foreach ($products as $product) { ?>
                                                        <option value="<?php echo $product['id'] ?>"
                                                                data-unit="<?php echo $product['unit'] ?>"
                                                                data-price="<?php echo $product['unit_price'] ?>">
                                                            <?php echo $product['name'].' ('.$product['unit'].')' ?>
                                                        </option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                            <div class="col-xs-12 col-sm-4">
                                                <input class="form-inline form-control  md-button-v" placeholder="Quantité" name="quantity"
                                                       type="text">
                                            </div>
                                        </div>
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
                                        <div class="row" hidden>
                                            <div class="col-md-6">
                                                <select name="kgUnitHidden"
                                                        class="kgUnitHidden form-control md-button-v" <?php echo $KgUnitHidden ?>>
                                                    <option value="1" name="Kilogramme">Kilogramme</option>
                                                </select>
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

                                    <div class="row">
                                        <div class="col-xs-12 col-sm-8">
                                            <select name="product" class="productSelectNew form-control md-button-v">
                                                <?php foreach ($products as $product) { ?>
                                                    <option value="<?php echo $product['id']; ?>"
                                                            data-unit="<?php echo $product['unit'] ?>"
                                                            data-price="<?php echo $product['unit_price']; ?>">
                                                        <?php echo $product['name'].' ('.$product['unit'].')' ?>
                                                    </option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <div class="col-xs-12 col-sm-4">
                                            <input class="form-inline form-control md-button-v" placeholder="Quantité"
                                                   name="quantity"
                                                   type="text">
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

        <input type="submit" name="buttonSubmit" value="Confirmer" class="btn btn-success"/>


        <div class="row" hidden>
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Liste de vos produits en stock</h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                            <li><a class="close-link"><i class="fa fa-close"></i></a></li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content table-responsive">
                        <table class="table table-striped">
                            <tr>
                                <th>
                                    Id
                                </th>
                                <th>
                                    Nom
                                </th>
                                <th>
                                    Quantité
                                </th>
                            </tr>

                            <?php foreach ($products as $product) {
                                $status = $product['min_quantity'] > $product['totalQuantity'] ? 'danger' : 'success';
                                ?>
                                <tr class="<?php echo $status; ?>">
                                    <td><?php echo $product['product']; ?></td>
                                    <td><?php echo $product['name']; ?></td>
                                    <td><?php echo $product['totalQuantity'].' '.$product['unit']; ?></td>
                                </tr>
                            <?php } ?>
                        </table>
                    </div> <!-- /content -->
                </div><!-- /x-panel -->
            </div> <!-- /col -->
        </div>
    </div>
</div> <!-- /.col-right -->
<!-- /page content -->

<?php $this->load->view('admin/partials/admin_footer'); ?>



<script>

    $(document).ready(function () {
        var addStock_url="<?php echo base_url('admin/department/apiAddStock'); ?>";
        var gainRate = 1;
        var group = 0;
        var sellPrice = 0;
        var productsCount = 1;




        $('input[name="buttonSubmit"]').on('click', function () {

            var productsList = [];
            var prixTotal = 0;
            var name = $('input.mealName').val();
            for (var i = 1; i <= productsCount; i++) {

                var row = $('.product[data-id=' + i + ']');
                var l_panel = row.closest('.product');
                var quantity = parseFloat(row.find('input[type="text"]').val().replace(',', '.'));
                var id = row.find('select').find('option:selected').val();


                if (quantity ) {
                    var product = {
                        'id': id,
                        'quantity': quantity
                    };
                    productsList.push(product);
                }

            }

            var stock = {
                'productsList': productsList,
                'department': $('select[name="department"] option:selected').val()
            };

            console.log(stock);
            if(true){
                apiRequest(addStock_url,{'stock':stock});
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
