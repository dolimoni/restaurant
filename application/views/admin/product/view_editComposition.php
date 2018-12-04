<?php $this->load->view('admin/partials/admin_header.php'); ?>
<!-- page content -->
<div class="right_col" role="main">
    <div class="productsList">
        <!--<pre>
            <?php /*print_r($composition); */?>
        </pre>-->
        <div class="page-title">
            <div class="title_left">
                <h3>Produit composé</h3>
            </div>
        </div>

        <div class="clearfix"></div>
        <hr>

        <table id="datatable-quantity" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0"
               width="100%">
            <thead>
            <tr>
                <th>Quantité</th>
                <th>Prix</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tfoot>
            <tr>
                <th>Quantité</th>
                <th>Prix</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
            </tfoot>
            <tbody>
            <?php foreach ($quantities as $quantity) {
                $validate = "";
                /* if($quantity['status'] === "active"){
                     $validate="validate";
                 }*/
                ?>
                <tr class="<?php echo $validate; ?>">
                    <td><?php echo $quantity['quantity'] ?></td>
                    <td><?php echo $quantity['unit_price'] ?></td>
                    <td><?php echo $quantity['status'] ?></td>
                    <td width="10%">
                        <?php if ($quantity['status'] !== "active") { ?>
                            <button data-id="<?php echo $quantity['id'] ?>"
                                    class="btn btn-success btn-xs action activate"><span
                                        class="glyphicon glyphicon-ok"></span></button>
                        <?php } ?>
                        <?php if ($quantity['status'] !== "active") { ?>
                            <button data-id="<?php echo $quantity['id'] ?>"  class="btn btn-danger btn-xs deleteQuantity"><span
                                        class="glyphicon glyphicon-trash"></span></button>
                        <?php } ?>
                    </td>
                </tr>
            <?php } ?>
            </tbody>
        </table>


        <form id="addProduct" method="post">
            <div class="row productsListContent">
                <div class="col-md-12 col-sm-12 col-xs-12 productItem" data-id="1">
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
                            <fieldset>
                                <div class="row">
                                        <div class="col-md-6 col-xs-12">
                                            <div class="form-group">
                                                <input type="hidden" name="productId" value="<?php echo $composition['composition']['id']; ?>"/>
                                                Nom<span class="required">*</span> : <input class="form-control"
                                                                                            placeholder="Produit"
                                                                                            name="productName"
                                                                                            id="username" type="text"
                                                                                            value="<?php echo $composition['composition']['name']; ?>"
                                                                                            required>
                                            </div>

                                            <div class="form-group">
                                                Quantité produite<span class="required">*</span> : <input value="1" class="form-control mealQuantity"
                                                                                            placeholder="Quantity"
                                                                                            name="productQuantity"
                                                                                            id="quantity" type="text"
                                                                                            required>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-xs-12">
                                            <div class="form-group">
                                                Unité de mesure :
                                                <select class="form-control" name="unit">

                                                    <option name="unit"
                                                            value="kg" <?php if ($composition['composition']['unit'] === "kg") echo "selected"; ?>>
                                                        Kg
                                                    </option>
                                                    <option name="unit"
                                                            value="L" <?php if ($composition['composition']['unit'] === "L") echo "selected"; ?>>
                                                        L
                                                    </option>
                                                    <option name="unit"
                                                            value="pcs" <?php if ($composition['composition']['unit'] === "pcs") echo "selected"; ?> >
                                                        Pcs
                                                    </option>

                                                </select>
                                            </div>
                                            <div class="form-group">
                                                Prix unitaire<span class="required">*</span> : <input
                                                        class="form-control cost"
                                                        value="<?php echo $composition['composition']['unit_price']; ?>"
                                                        placeholder="Prix unitaire"
                                                        name="unit_price">
                                            </div>
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
            <?php foreach ($composition['products'] as $key => $productItem) { ?>
            <div class="col-md-6 col-sm-6 col-xs-12 product" data-id="<?php echo $key + 1; ?>">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Composition</h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                           <!-- <li><a class="close-link"><i class="fa fa-close"></i></a></li>-->
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <form method="post">
                            <fieldset>
                                <div class="">
                                   <div class="x_content">

                                       <div class="col-md-6">
                                       <select name="product" class="productSelect  md-button-v form-control">
                                           <?php foreach ($products as $product){
                                               $selected = $product['id'] == $productItem['product'] ? 'selected' : '';
                                               if($product['product']===$productItem['owner']){
                                                   continue;
                                               }
                                           ?>
                                               <option <?php echo $selected; ?>
                                                       value="<?php echo $product['id'] ?>" data-unit="<?php echo $product['unit'] ?>" data-price="<?php echo $product['unit_price'] ?>">
                                                   <?php echo $product['name'] ?>
                                               </option>
                                           <?php } ?>
                                       </select>
                                       </div>
                                       <?php
                                       $KgUnitHidden = 'hide';
                                       $LUnitHidden = 'hide';
                                       $unitConvert = $productItem['unitConvert'];
                                       if ($productItem['unit'] === "kg" || $productItem['unit'] === "pcs") {
                                           $KgUnitHidden = '';
                                       }
                                       if ($productItem['unit'] === "L") {
                                           $LUnitHidden = '';
                                       }
                                       $mp_unit=strtoupper($productItem['pc_unit']);
                                       $mp_unit= preg_replace('/\s+/', '', $mp_unit);
                                       ?>
                                       <div class="col-md-3">
                                       <select name="kgUnitHidden" class="kgUnitHidden md-button-v form-control <?php echo $KgUnitHidden ?>">
                                           <option value="1" name="Kilogramme" <?php if ($mp_unit === 'KILOGRAMME') { echo "selected";} ?>>Kilogramme</option>
                                           <option value="0.001" name="Gramme" <?php if ($mp_unit === 'GRAMME') { echo "selected";} ?>>Gramme</option>
                                           <option value="0.000001" name="Milligramme" <?php if ($mp_unit === 'MILLIGRAMME') {echo "selected";} ?>>Milligramme</option>
                                           <option value="<?php echo $unitConvert; ?>" name="pcs" <?php if ($mp_unit === 'PCS') {echo "selected";} ?>>Pcs</option>
                                       </select>
                                       <select name="lUnitHidden" class="lUnitHidden  md-button-v form-control <?php echo $LUnitHidden ?>">
                                               <option value="1" name="Litre" <?php if ($mp_unit === 'LITRE') {echo "selected";} ?> >Litre</option>
                                               <option value="0.001" name="Centilitre" <?php if ($mp_unit === 'CENTILITRE') {echo "selected";} ?>>Centilitre</option>
                                           <option <?php if ($mp_unit === 'MILLILITRE') echo "selected"; ?>
                                                   value="0.000001" name="Millilitre">Millilitre
                                           </option>
                                       </select>
                                       </div>
                                       <div class="col-md-3">
                                       <input class="form-inline  md-button-v form-control" placeholder="Quantité" name="quantity" value="<?php echo $productItem['quantity']; ?>"
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
            <?php } ?>
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
                                        <?php foreach ($products as $product) {
                                            if ($product['product'] === $productItem['owner']) {
                                                continue;
                                            }
                                            ?>
                                            <option value="<?php echo $product['id']; ?>"
                                                    data-unit="<?php echo $product['unit'] ?>"
                                                    data-price="<?php echo $product['unit_price']; ?>">
                                                <?php echo $product['name']; ?>
                                            </option>
                                        <?php } ?>
                                    </select>
                                    </div>
                                    <div class="col-md-3">
                                    <select name="kgUnitHidden" class="kgUnitHidden  md-button-v form-control <?php echo $KgUnitHidden ?>">
                                        <option value="1" name="Kilogramme">Kilogramme</option>
                                        <option value="0.001" name="Gramme">Gramme</option>
                                        <option value="0.000001" name="Milligramme">Milligramme</option>
                                        <option value="0.001" name="pcs">Pcs</option>
                                    </select>
                                    <select name="lUnitHidden" class="lUnitHidden  md-button-v form-control <?php echo $LUnitHidden ?>">
                                        <option value="1" name="Litre">Litre</option>
                                        <option value="0.001" name="Centilitre">Centilitre</option>
                                        <option value="0.000001" name="Millilitre">Millilitre</option>
                                    </select>
                                    </div>
                                    <div class="col-md-3">
                                    <input class="form-inline  md-button-v form-control" placeholder="Quantité" name="quantity"
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


        <input type="submit" name="buttonSubmit" value="Confirmer" class="btn btn-success"/>
    </div>
</div> <!-- /.col-right --> 
<!-- /page content -->

<?php $this->load->view('admin/partials/admin_footer'); ?>

<script src="<?php echo base_url("assets/vendors/datatables.net/js/jquery.dataTables.min.js"); ?>"></script>

<script>
    var deleteQuantity_url = "<?php echo base_url('admin/product/apiDeleteQuantity'); ?>"
</script>

<script>
    $(document).ready(function () {
        var handleDataTableButtons = function () {
            if ($("#datatable-quantity").length) {
                $("#datatable-quantity").DataTable({

                    responsive: true,
                    "lengthMenu": [[5, 10, 50, -1], [5, 10, 50, "Tout"]],
                    "order": [[ 3, "asc" ]],
                    "language": {
                        "url": "<?php echo base_url("assets/vendors/datatables.net/French.json"); ?>"
                    }

                });
            }
        };

        TableManageButtons = function () {
            "use strict";
            return {

                init: function () {
                    handleDataTableButtons();
                }
            };
        }();

        TableManageButtons.init();
    });
</script>

<script>

    $(document).ready(function () {

        $(".deleteQuantity").on('click', deleteQuantityEvent);

        function deleteQuantityEvent(){
            var myData={
                'quantity':$(this).attr('data-id')
            }
            swal({
                    title: "Attention ! ",
                    text: "Vous voulez vraiment supprimer cette quantité?",
                    type: "warning",
                    showConfirmButton: true,
                    showCancelButton: true,
                    cancelButtonText: 'Non',
                    confirmButtonText: 'Oui'
                },
                function () {
                    apiRequest(deleteQuantity_url,myData);
                });
        }


        var sellPrice=0;
        var productsCount=<?php echo count($composition['products']); ?>;


        $(document).on('change', '.productSelect,.productSelectNew,.kgUnitHidden,.lUnitHidden', calulPrixTotal);
        $(document).on('keyup', 'input[name=quantity],input[name=productQuantity]', calulPrixTotal);

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


            console.log('prixTotal',prixTotal);
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
            var productId=$('input[name=productId]').val();
            var productQuantity=$('input[name=productQuantity]').val();
            var productUnit=$('select[name="unit"] option:selected').val();
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
                    var product={'id':id,'quantity':quantity,'unit_price':unit_price,'unit': unitConvertName,'unitConvert': unitConvert};
                    productsList.push(product);
                }

            }

            var compositionUnitPrice = $("input[name=unit_price]").val();
            var composition = {
                'name': name,
                'id': productId,
                'quantity': productQuantity,
                'min_quantity': 0,
                'daily_quantity': 0,
                'provider': 'interne',
                'status':'active',
                'unit': productUnit,
                'productsList': productsList,
                'cost': compositionUnitPrice,
                'unit_price': compositionUnitPrice,
                'lostQuantity':0
            };
            if (validate(composition)) {
                console.log(composition)
                $.ajax({
                    url: "<?php echo base_url('admin/product/apiEditComposition'); ?>",
                    type: "POST",
                    dataType: "json",
                    data: {'composition': composition},
                    success: function (data) {
                        if (data.status === 'success') {
                            swal({
                                title: "Success",
                                text: "La modification a été bien effecutée",
                                type: "success",
                                timer: 2000,
                                showConfirmButton: false
                            });
                            document.location.href = data.redirect;
                        }
                        else {
                            swal({
                                title: "Erreur",
                                text: "Une erreur s'est produite",
                                type: "success",
                                timer: 2000,
                                showConfirmButton: false
                            });
                            /*$('#show_id').html("<div style='border:1px solid red;font-size: 11px;margin:0 auto !important;'>" + response.error + "</div>");*/
                        }

                    },
                    error: function (data) {
                        swal({
                            title: "Erreur",
                            text: "Une erreur s'est produite",
                            type: "success",
                            timer: 2000,
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
                    text: "Quel est le nom de votre produit ?",
                    type: "warning",
                    timer: 2000,
                    showConfirmButton: false
                });
                validate=false;
            }
            /*if(meal['quantity']===''){
                swal({
                    title: "Attention",
                    text: "Quel est la quantité de votre produit ?",
                    type: "warning",
                    timer: 2000,
                    showConfirmButton: false
                });
                validate=false;
            }*/
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


<script>
    $(document).ready(function () {
        $('button.activate').on('click', activateEvent);

        function activateEvent(event) {
            var id = $(this).attr('data-id');
            $.ajax({
                url: "<?php echo base_url('admin/product/apiActivateQuantity'); ?>",
                type: "POST",
                dataType: "json",
                data: {'quantity_id': id},
                success: function (data) {
                    if (data.status === 'success') {
                        swal({
                            title: "Success",
                            text: "Success",
                            type: "success",
                            timer: 1500,
                            showConfirmButton: false
                        });
                        location.reload();
                    }
                    else {
                        swal({
                            title: "Erreur",
                            text: "Erreur",
                            type: "error",
                            timer: 1500,
                            showConfirmButton: false
                        });
                    }
                },
                error: function (data) {
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
</script>