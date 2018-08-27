<?php $this->load->view('admin/partials/admin_header.php'); ?>
<style>
    .departmentSelect{
        min-width:200px;
    }
    .row{
        margin-top: 15px;
        margin-bottom: 15px;
    }
</style>
<!-- page content -->
<div class="right_col" role="main">
    <div class="productsList">
        <div class="page-title">
            <div class="">
                <div class="row">
                    <div class="col-md-offset-4 col-md-5 col-sm-6 col-xs-12">
                        <select name="department" class="departmentSelect form-control md-button-v">
                            <?php foreach ($agencies as $agency) { ?>
                                <option value="<?php echo $agency['id'] ?>">
                                    <?php echo $agency['name'] ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
            </div>
        </div>


        <div class="clearfix"></div>
        <div class="row mealComposition">
            <div class="col-md-6 col-sm-6 col-xs-12 product" data-id="1">
                <div class="x_panel">
                    <div class="x_title">
                        <h2><?= lang('product'); ?></h2>
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
                                            <div class="col-md-8">
                                                <select name="product" class="productSelect form-control md-button-v">
                                                    <?php foreach ($products as $product) { ?>
                                                        <option value="<?php echo $product['id'] ?>"
                                                                data-unit="<?php echo $product['unit'] ?>"
                                                                data-price="<?php echo $product['unit_price'] ?>">
                                                            <?php echo $product['name'].' ('.$product['unit'].')'; ?>
                                                        </option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                            <div class="col-md-4">
                                                <input class="form-inline  form-control" placeholder="<?= lang("quantity"); ?>" name="quantity"
                                                       type="text">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <br/>
                            </fieldset>
                        </form>
                    </div> <!-- /content -->
                </div><!-- /x-panel -->
            </div>
            <!-- /col -->
        </div> <!-- /row -->
        <button type="submit" class="btn btn-info" name="addProduct">
            <span class="fa fa-plus"></span> <?= lang('new_product'); ?>
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
                                        <div class="col-md-8">
                                            <select name="product" class="productSelectNew form-control">
                                                <?php foreach ($products as $product) { ?>
                                                    <option value="<?php echo $product['id']; ?>"
                                                            data-unit="<?php echo $product['unit'] ?>"
                                                            data-price="<?php echo $product['unit_price']; ?>">
                                                        <?php echo $product['name'].' ('.$product['unit'].')'; ?>
                                                    </option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <div class="col-md-4">
                                            <input class="form-inline  form-control" placeholder="<?= lang("quantity"); ?>"
                                                                              name="quantity"
                                                                              type="text">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <br/>
                        </fieldset>
                    </form>
                </div> <!-- /content -->
            </div><!-- /x-panel -->
        </div>

        <input type="submit" name="buttonSubmit" value="<?= lang('confirme'); ?>" class="btn btn-success"/>


        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2><?= lang('products_in_stock'); ?></h2>
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
                                    <?= lang('name'); ?>
                                </th>
                                <th>
                                    <?= lang("quantity"); ?>
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
    var addStock_url="<?php echo base_url('admin/agency/apiAddStock'); ?>";
</script>

<script>

    $(document).ready(function () {

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


                if (quantity > 0) {
                    var product = {
                        'id': id,
                        'quantity': quantity,
                    };
                    productsList.push(product);
                }

            }

            var stock = {
                'productsList': productsList,
                'department': $('select[name="department"] option:selected').val()
            };
            if (true) {
                apiRequest(addStock_url,{'stock': stock});
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
