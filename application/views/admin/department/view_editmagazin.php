<?php $this->load->view('admin/partials/admin_header.php'); ?>

<style>
    .row.quantity{
        margin:10px 0px;
    }
</style>
<!-- page content -->
<div class="right_col" role="main">
    <div class="productsList">
           <!-- <pre>
                <?php /*print_r($magazin); */?>
            </pre>-->
        <div class="page-title">
            <div class="">
                <h3>Modifier le magazin :</h3>
            </div>
        </div>



        <div class="row">
            <div class="article-title text-center">
                <div class="col-md-offset-3 col-md-6 col-sm-6 col-xs-12">
                    <h4 style="display: inline;">Nom du magazin : </h4> <input type="text" class="mealName" name="name"
                                                                               value="<?php echo $magazin['name']; ?>"/>
                </div>
            </div>
        </div>
        <div class="row mealComposition">
            <?php foreach ($magazin['mealsList'] as $key => $mealItem) { ?>
            <div class="col-md-6  col-sm-6 col-xs-12 product" data-id="<?php echo $key+1; ?>" >
                                <div class="x_panel testt">
                                   <div class="x_title">
                                       <h2><?php echo $mealItem['name']; ?></h2>
                                       <ul class="nav navbar-right panel_toolbox">
                                           <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                                           <li><a class="close-linkk"><i class="fa fa-close" data-id="<?php echo $mealItem['sm_id']; ?>"></i></a></li>
                                       </ul>
                                       <div class="clearfix"></div>
                                   </div>
                                   <div class="x_content oldContent" style="margin-top:30px;">

                                       <div class="row tile_count" style="margin-bottom:10px;">
                                           <div class="col-md-offset-3 col-md-3 col-sm-6 col-xs-12 tile_stats_count">
                                               <span class="count_top"><i class=""></i>Quantité stock</span>
                                               <div class="count"><?php echo $mealItem['quantityInMagazin']; ?></div>
                                               <!--<span class="count_bottom"><i class="green">4% </i> From last Week</span>-->
                                           </div>
                                           <div class="col-md-4 col-sm-6 col-xs-12 tile_stats_count">
                                               <span class="count_top"><i class=""></i>Quantité vente</span>
                                               <div class="count"><?php echo $mealItem['quantityToSale']; ?></div>
                                               <!--<span class="count_bottom"><i class="green">4% </i> From last Week</span>-->
                                           </div>
                                       </div>
                                       <div class="row">

                                         <div class="col-md-6 col-sm-12 col-xs-12" style="margin-bottom:10px;">
                                             <select name="product" class="productSelect md-button-v"
                                                     style="max-width:200px;" disabled>
                                                 <?php foreach ($meals as $meal) {
                                                     $selected = $meal['id'] == $mealItem['meal'] ? 'selected' : '';
                                                     ?>
                                                     <option <?php echo $selected; ?>
                                                             value="<?php echo $meal['id']; ?>"
                                                            ><?php echo $meal['name']; ?></option>
                                                 <?php } ?>
                                             </select>

                                         </div>
                                           <div class="col-md-6">
                                               <span class="sm-hidden">Vente : </span> <input
                                                       class="form-inline md-button-v" placeholder=""
                                                       name="quantityToSale"
                                                       type="text">
                                           </div>

                                       </div>

                                       <input type="hidden" name="quantityInMagazinNow"
                                              value="<?php echo $mealItem['quantityInMagazin']; ?>"

                                            <div class="row quantity">
                                                <div class="col-xs-6" hidden>
                                                    Nouvelle quantité : <input type="checkbox" name="saleQuantityType"/>
                                                </div>
                                                <input type="hidden" name="quantityInMagazinNow"
                                                       value="<?php echo $mealItem['quantityInMagazin']; ?>"
                                            </div>
                                   </div>
                               </div>

            </div>
            <?php } ?>
        </div> <!-- /row -->

       <!-- <button type="submit" class="btn btn-info" name="addMeal">
            <span class="fa fa-plus"></span> Ajouter un article
        </button>-->

        <div class="col-md-6  col-sm-6 col-xs-12 product productModel" hidden>
                            <div class="x_panel">
                                <div class="x_title">
                                    <h2>Article</h2>
                                    <ul class="nav navbar-right panel_toolbox">
                                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                                        <li><a class="close-link"><i class="fa fa-close"></i></a></li>
                                    </ul>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="x_content" style="margin-top:23px;" id="newContent">

                                    <div class="row">


                                       <div class="col-md-offset-4 col-md-4 col-sm-12 col-xs-12" style="margin-bottom:10px;">
                                           <select name="product" class="productSelectNew md-button-v" style="max-width:150px;">
                                               <?php foreach ($meals as $meal) { ?>
                                                   <option value="<?php echo $meal['id']; ?>"
                                                          ><?php echo $meal['name']; ?></option>
                                               <?php } ?>
                                           </select>
                                       </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6 col-sm-12 col-xs-12">
                                            <span class="sm-hidden">Stock : </span> <input
                                                    class="form-inline md-button-v" placeholder=""
                                                    name="quantityInMagazin"
                                                    type="text">
                                        </div>
                                        <div class="col-md-6 col-sm-12 col-xs-12">
                                            <span class="sm-hidden">Vente : </span> <input
                                                    class="form-inline md-button-v" placeholder=""
                                                    name="quantityToSale"
                                                    type="text">
                                        </div>
                                        <input type="checkbox" name="saleQuantityType" hidden/>
                                        <input type="checkbox" name="MagazinQuantityType" hidden/>
                                    </div>
                                </div>
                            </div>

        </div>


        <input type="submit" name="buttonSubmit" value="Enregister" class="btn btn-success"/>

    </div>
</div> <!-- /.col-right -->
<!-- /page content -->

    <?php $this->load->view('admin/partials/admin_footer'); ?>



<script>

    $(document).ready(function () {

        var gainRate=1;
        var group=0;
        var quantityOverFlow=true;
        var productsCount=<?php echo count($magazin['mealsList']) ?>;

        $(document).on('change', '.productSelect,.productSelectNew', calulPrixTotal);

        function calulPrixTotal() {
            var panel = $(this).closest('.product');
            updateOptions(false);
        };

        $('input[name="buttonSubmit"]').on('click', function () {
            $('#loading').show();
            var mealsList=[];
            var prixTotal=0;
            var name=$('input.mealName').val();
            for (var i = 1; i <= productsCount; i++) {

                var row = $('.product[data-id=' + i + ']');
                var l_panel = row.closest('.product');

                var quantityInMagazinInput= row.find('input[name="quantityInMagazin"]');
                var quantityInMagazin = 0;
                if(quantityInMagazinInput.val()){
                    console.log(quantityInMagazinInput);
                    quantityInMagazin = parseFloat(quantityInMagazinInput.val().replace(',', '.'));
                }

                var quantityToSale = parseFloat(row.find('input[name="quantityToSale"]').val().replace(',', '.'));
                var quantityInMagazinNow = parseFloat(row.find('input[name="quantityInMagazinNow"]').val());
                var quantity= quantityInMagazin+ quantityToSale;
                var id= row.find('select').find('option:selected').val();
                var mealName= row.find('select').find('option:selected').text();

                if(quantityInMagazinNow< quantityToSale){
                    quantityOverFlow=true;
                    swal({
                        title: "Attention",
                        text: "Quantité de stock insuffisant pour l'article : "+ mealName,
                        type: "warning",
                        timer: 2000,
                        showConfirmButton: false
                    });
                    break;
                }
                if (quantityInMagazin || quantityToSale){
                    var meal = {
                        'id': id,
                        'quantityInMagazin': quantityInMagazin,
                        'quantityToSale': quantityToSale,
                        //'quantity': quantity,
                        'magazinQuantityType': row.find("input[name='MagazinQuantityType']").is(':checked'),
                        'saleQuantityType': row.find("input[name='saleQuantityType']").is(':checked'),
                    };
                    mealsList.push(meal);
                }

            }

            var magazin={'name':name,'id':<?php echo $magazin['id']; ?>,'department':<?php echo $magazin['department']; ?>,'mealsList': mealsList};
            //console.log(magazin);
            if(true){
                $.ajax({
                    url: "<?php echo base_url('admin/department/apiEditMagazin'); ?>",
                    type: "POST",
                    dataType: "json",
                    data: {'magazin': magazin},
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
                            location.reload();
                            //document.location.href = data.redirect;
                        }
                        else {
                            swal({
                                title: "Erreur",
                                text: "Une erreur s'est produite",
                                type: "error",
                                timer: 1500,
                                showConfirmButton: false
                            });
                        }

                    },
                    error: function (data) {
                        $('#loading').hide();
                        swal({
                            title: "Erreur",
                            text: "Une erreur s'est produite",
                            type: "error",
                            timer: 1500,
                            showConfirmButton: false
                        });
                    }
                });
            }else{
                $('#loading').hide();
            }

        });

        function validate(magazin) {
            var validate = true;
            if (quantityOverFlow) {
                validate = false;
            }
            return validate;
        }


        var productSize=1;



        $('button[name="addMeal"]').on('click', addMeal);
        function addMeal(event) {
            var productModel = $('.productModel').clone().removeAttr('hidden');
            productModel.removeClass('productModel');
            productsCount++;
            productModel.attr('data-id',productsCount);
            $('.mealComposition').append(productModel);
            $('.productsCount').html(productsCount);
            if(productsCount>1){
                updateOptions(true);
            }
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

        updateOptions(false);


    });

</script>

<!--Delete Meal from magazin-->
<script>
    $(document).ready(function () {
        $('.fa-close').on('click', deleteMealEvent);


        function deleteMealEvent(event) {
            var meal_id = $(this).attr('data-id');
            var vm = $(this);
            swal({
                    title: "Attention ! ",
                    text: "Vous voulez vraiment supprimer cet article ?",
                    type: "warning",
                    showConfirmButton: true,
                    showCancelButton: true,
                    cancelButtonText: 'Non',
                    confirmButtonText: 'Oui'
                },
                function () {
                console.log(meal_id);
                    var a = vm.closest(".x_panel");
                    console.log(a);
                    a.remove();
                    $.ajax({
                        url: "<?php echo base_url('admin/department/apiDeleteMealFromMagazin'); ?>",
                        type: "POST",
                        dataType: "json",
                        data: {'meal_id': meal_id},
                        success: function (data) {
                            if (data.status === 'success') {
                                swal({
                                    title: "Success",
                                    text: "L'article a été bien supprimé",
                                    type: "success",
                                    timer: 1500,
                                    showConfirmButton: false
                                });
                               // location.reload();
                            }
                            else {
                                swal({
                                    title: "Erreur",
                                    text: "Une erreur s'est produite",
                                    type: "error",
                                    timer: 1500,
                                    showConfirmButton: false
                                });
                            }
                        },
                        error: function (data) {
                            swal({
                                title: "Erreur",
                                text: "Une erreur s'est produite",
                                type: "error",
                                timer: 1500,
                                showConfirmButton: false
                            });
                        }
                    });

                });


        }
    });
</script>

