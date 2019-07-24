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
                <h3><?= lang('add_products'); ?></h3>
            </div>
        </div>
        <div class="clearfix"></div>
        <hr>
        <form id="addProductsForm" method="post">
        <h4 style="display: inline;"><?= lang('products_count'); ?> : </h4> <input type="number" name="productSize"/>
            <div type="submit" class="btn btn-info productSize"><?= lang('add'); ?></div>
        </form>
        <form id="addProduct" method="post">
            <div class="row productsListContent">
                <div class="col-md-6 col-sm-12 col-xs-12 productItem" data-id="1">
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
                            <label><?php /*echo $message;*/ ?></label>
                                <fieldset>
                                    <div class="form-group">
                                        <?= lang('name'); ?><span class="required">*</span> : <input class="form-control"
                                                                                    placeholder="<?= lang('product'); ?>" name="name"
                                                                                    id="username" type="text" required>
                                    </div>
                                   <!-- <div class="form-group">
                                        Quantité<span class="required">*</span> : <input class="form-control"
                                                                                         placeholder="Quantité"
                                                                                         name="quantity">
                                    </div>-->
                                    <div class="form-group">
                                        <?= lang('unit_of_measure'); ?> :
                                        <select class="form-control" name="unit">
                                            <option name="unit" value="kg">Kg</option>
                                            <option name="unit" value="pcs">Pcs</option>
                                            <option name="unit" value="L">Litre</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <?= lang('provider'); ?> :
                                        <select class="form-control" name="provider">
                                            <option value="0"><?= lang('neither'); ?></option>
                                            <?php foreach ($providers as $provide) {
                                                $providerName= $provide['name'];
                                                if($providerName===""){
                                                    $providerName= $provide['title'];
                                                }
                                                ?>
                                                <option
                                                        value="<?php echo $provide['id']; ?>"><?php echo $providerName; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <?= lang('unit_price'); ?><span class="required">*</span> : <input class="form-control"
                                                                                              placeholder="<?= lang('unit_price'); ?>"
                                                                                              name="unit_price">
                                    </div>
                                    <div class="form-group">
                                        <?= lang('weightByUnit'); ?><input class="form-control"placeholder="<?= lang('weightByUnit'); ?>"
                                                                                              name="weightByUnit">
                                    </div>

                                    <div class="form-group">
                                        <?= lang('min_stock_quantity'); ?> : <input class="form-control"
                                                                           placeholder="<?= lang('min_stock_quantity'); ?>"
                                                                           name="min_quantity" >
                                    </div>
                                    <div class="form-group">
                                        <?= lang('daily_consumption'); ?> : <input class="form-control" placeholder="<?= lang('quantity'); ?>"
                                                                      name="daily_quantity">
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
                        <h2><?= lang('product'); ?></h2>
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
                                    <?= lang('name'); ?><span class="required">*</span> : <input class="form-control" placeholder="<?= lang('product'); ?>" name="name"
                                                     id="username" type="text">
                                </div>
                              <!--  <div class="form-group">
                                    Quantité<span class="required">*</span> : <input class="form-control" placeholder="Quantité" name="quantity">
                                </div>-->
                                <div class="form-group">
                                    <?= lang('unit_of_measure'); ?> :
                                    <select class="form-control" name="unit">
                                        <option name="unit" value="kg">Kg</option>
                                        <option name="unit" value="pcs">Pcs</option>
                                        <option name="unit" value="L">Litre</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <?= lang('provider'); ?> :
                                    <select class="form-control" name="provider">
                                        <option value="0"><?= lang('neither'); ?></option>
                                        <?php foreach ($providers as $provider) { ?>
                                            <option name="unit"
                                                    value="<?php echo $provider['id']; ?>"><?php echo $provider['name']; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <?= lang('unit_price'); ?><span class="required">*</span> : <input class="form-control" placeholder="Prix unitaire"
                                                           name="unit_price">
                                </div>
                                <div class="form-group">
                                    <?= lang('weightByUnit'); ?>(en gr)<input class="form-control" placeholder="Poid par unité"
                                                         name="weightByUnit">
                                </div>
                                <div class="form-group">
                                    <?= lang('min_stock_quantity'); ?> : <input class="form-control"
                                                                       placeholder="Quantité minimum du stock"
                                                                       name="min_quantity">
                                    <div class="form-group">
                                        <?= lang('daily_consumption'); ?> : <input class="form-control" placeholder="<?= lang('quantity'); ?>"
                                                                      name="daily_quantity">
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
    var swal_warning_obligatory_fields_lang=<?= lang("swal_warning_obligatory_fields"); ?>
</script>
<script>

    $(document).ready(function () {
        var productSize = 1;
        var productsList = [];
        var productsCount=1;

        $('#addProduct').submit( function (e) {
            e.preventDefault();  //prevent form from submitting
            for (var i = 1; i <= productsCount; i++) {

                var row = $('.productItem[data-id=' + i + ']');

                var name = row.find('input[name="name"]').val();
                //var quantity = parseFloat(row.find('input[name="quantity"]').val().replace(',', '.'));
                var unit = row.find('select[name="unit"]').val();
                var unit_price = row.find('input[name="unit_price"]').val();
                var weightByUnit = 0;
                var daily_quantity = 0;
                var min_quantity =0;
                var provider = row.find('select[name=provider]').val();
                var product1 = {'name': name, 'quantity': 0, 'unit': unit, 'unit_price': unit_price,'weightByUnit': weightByUnit,'provider': provider, 'min_quantity': min_quantity, 'daily_quantity': daily_quantity,'status':'active'};
               if(name!==""){
                   productsList.push(product1);
               }
            }

           if(productsList.length>0){
               $.ajax({
                   url: "<?php echo base_url(); ?>admin/product/add",
                   type: "POST",
                   dataType: "json",
                   data: {"productsList": productsList},
                   beforeSend: function () {
                       $('#loading').show();
                   },
                   complete: function () {
                       $('#loading').hide();
                   },
                   success: function (data) {
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
                           swal({
                               title: "Oups !",
                               text: "Erreur",
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
                   text: swal_warning_obligatory_fields_lang,
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
