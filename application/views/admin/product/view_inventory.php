<?php $this->load->view('admin/partials/admin_header.php'); ?>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
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
                <h3><?= lang("inventory"); ?></h3>
            </div>
        </div>
        <div class="clearfix"></div>
        <hr>
        <form id="addProductsForm" method="post">
        <h4 style="display: inline;"><?= lang("products_count"); ?> : </h4> <input type="number" name="productSize"/>
            <div type="submit" class="btn btn-info productSize"><?= lang("add"); ?></div>
        </form>
        <form id="addProduct" method="post">
            <div class="row productsListContent">
                <div class="col-md-6 col-sm-12 col-xs-12 productItem" data-id="1">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2><?= lang("product"); ?></h2>
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
                                        <input type="hidden" name="id"/>
                                        <?= lang("name"); ?><span class="required">*</span> : <input class="form-control"
                                                                                    placeholder="<?= lang("product"); ?>" name="name"
                                                                                    id="username" type="text" required>
                                    </div>
                                    <div class="form-group">
                                        <?= lang("quantity"); ?><span class="required">*</span> : <input class="form-control"
                                                                                         placeholder="<?= lang("quantity"); ?>"
                                                                                         data-totalquantity="0"
                                                                                         name="quantity">
                                    </div>
                                </fieldset>
                        </div> <!-- /content -->
                    </div><!-- /x-panel -->
                </div>
            </div>

            <div class="col-md-6 col-sm-12 col-xs-12 productItem productModel" hidden>
                <div class="x_panel">
                    <div class="x_title">
                        <h2><?= lang("product"); ?></h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                            <!-- <li><a class="close-link"><i class="fa fa-close"></i></a></li>-->
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <label><?php /*echo $message;*/ ?></label>
                            <fieldset>
                                <input type="hidden" name="id"/>
                                <div class="form-group">
                                    <?= lang("name"); ?><span class="required">*</span> : <input class="form-control" placeholder="<?= lang("product"); ?>" name="name"
                                                     id="username" type="text">
                                </div>
                                <div class="form-group">
                                    <?= lang("quantity"); ?><span class="required">*</span> : <input class="form-control" placeholder="<?= lang("qunatity"); ?>" name="quantity"
                                                                                     data-totalquantity="0">
                                </div>

                            </fieldset>
                    </div> <!-- /content -->
                </div><!-- /x-panel -->
            </div>

            <input type="submit" name="buttonSubmit" value="<?= lang("confirme"); ?>" class="btn btn-success"/>
        </form>
    </div>

</div> <!-- /.col-right -->
<!-- /page content -->

<?php $this->load->view('admin/partials/admin_footer'); ?>

<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>


<!--Auto complet-->

<script>

    $(document).ready(function () {
        var productSize = 1;
        var productsList = [];
        var productsCount=1;

        function formatDate(date) {
            var d = new Date(date),
                month = '' + (d.getMonth() + 1),
                day = '' + d.getDate(),
                year = d.getFullYear();

            if (month.length < 2) month = '0' + month;
            if (day.length < 2) day = '0' + day;

            return [year, month, day].join('-');
        }

        <?php
        $js_array = json_encode($productsName);
        echo "var productsName = " . $js_array . ";\n";
        ?>


        <?php
        $js_array = json_encode($products);
        echo "var products = " . $js_array . ";\n";
        ?>

        $("input[name=name]").autocomplete({
            source: productsName,
            select: function (event, ui) {
                var label = ui.item.label;
                var value = ui.item.value;
                var target = $(this);
                var product = getObject(products, value);
                console.log(product);
                target.closest(".x_content").find("input[name=id]").val(product.id);
                target.closest(".x_content").find("input[name=quantity]").attr("data-totalQuantity", product.totalQuantity);
            }
        });

        var getObject = function (products,property) {
            for (var i = 0, len = products.length; i < len; i++) {
                if (products[i].name === property)
                    return products[i]; // Return as soon as the object is found
            }
            return null; // The object was not found
        }

        $('#addProduct').submit( function (e) {
            e.preventDefault();  //prevent form from submitting
            for (var i = 1; i <= productsCount; i++) {

                var row = $('.productItem[data-id=' + i + ']');
                var id = row.find('input[name="id"]').val();
                var name = row.find('input[name="name"]').val();
                var initial_stock = parseFloat(row.find('input[name="quantity"]').attr("data-totalquantity").replace(',', '.'));
                var final_stock = parseFloat(row.find('input[name="quantity"]').val().replace(',', '.'));
                var delta= final_stock-initial_stock;
                var d = new Date();
                var product1 = {'product': id, 'initial_stock': initial_stock,"final_stock": final_stock,"delta":delta,"inventory_date": formatDate(d)};
               if(name!==""){
                   productsList.push(product1);
               }

            }

            console.log(productsList);
           if(productsList.length>0){
               $('#loading').show();
               $.ajax({
                   url: "<?php echo base_url(); ?>admin/product/addInventory",
                   type: "POST",
                   dataType: "json",
                   data: {"productsList": productsList},
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
                               text: "Une erreur s'est produite",
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
                   text: "Merci de remplir les champs obligatoires",
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

            $("input[name=name]").autocomplete({
                source: productsName,
                select: function (event, ui) {
                    var label = ui.item.label;
                    var value = ui.item.value;
                    var target = $(this);
                    var product = getObject(products, value);
                    console.log(product);
                    target.closest(".x_content").find("input[name=id]").val(product.id);
                    target.closest(".x_content").find("input[name=quantity]").attr("data-totalQuantity", product.totalQuantity);
                }
            });
        }


    });


</script>
