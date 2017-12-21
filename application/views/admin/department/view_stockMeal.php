<?php $this->load->view('admin/partials/admin_header.php'); ?>
<!-- page content -->
<div class="right_col" role="main">
    <div class="productsList">
        <div class="page-title">
            <!-- <pre>
                <?php /*print_r($productsComposition); */ ?>
            </pre>-->
            <!--<div class="row">
                <h3>Modifier le magazin :</h3>
            </div>-->
        </div>


        <input type="hidden" name="department" value="<?php echo $department; ?>"/>
        <div class="row mealComposition">
            <div class="col-md-6  col-sm-6 col-xs-12 product" data-id="1">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Article</h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                            <li><a class="close-link"><i class="fa fa-close"></i></a></li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content" style="margin-top:30px;" id="newContent">
                        <div class="row">


                            <div class="col-md-6 col-sm-12 col-xs-12">
                                <select name="product" data-name="meal" class="productSelectNew md-button-v"
                                        style="max-width:150px;">
                                    <?php foreach ($meals as $meal) { ?>
                                        <option value="<?php echo $meal['id']; ?>"
                                        ><?php echo $meal['name']; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="col-md-6 col-sm-12 col-xs-12">
                                <select name="product" data-name="magazin" class="productSelectNew md-button-v"
                                        style="max-width:150px;">
                                    <option value="0">Aucun</option>
                                    <?php foreach ($magazins as $magazin) { ?>
                                        <option value="<?php echo $magazin['id']; ?>"
                                        ><?php echo $magazin['name']; ?></option>
                                    <?php } ?>
                                </select>
                            </div>

                            <div class="col-md-6 col-sm-12 col-xs-12">
                                <input class="form-inline md-button-v"
                                       placeholder="Vente" name="quantityToSale"
                                       type="text">
                            </div>
                            <div class="col-md-6 col-sm-12 col-xs-12">
                                <input class="form-inline md-button-v"
                                       placeholder="Stock" name="quantityInMagazin"
                                       type="text">
                            </div>

                        </div>
                    </div>
                </div>

            </div>
        </div> <!-- /row -->


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
                <div class="x_content" style="margin-top:30px;" id="newContent">
                    <div class="row">


                        <div class="col-md-6 col-sm-12 col-xs-12">
                            <select name="product" data-name="meal" class="productSelectNew md-button-v" style="max-width:150px;">
                                <?php foreach ($meals as $meal) { ?>
                                    <option value="<?php echo $meal['id']; ?>"
                                    ><?php echo $meal['name']; ?></option>
                                <?php } ?>
                            </select>
                        </div><div class="col-md-6 col-sm-12 col-xs-12">
                            <select name="product" data-name="magazin" class="productSelectNew md-button-v" style="max-width:150px;">
                                <option value="0">Aucun</option>
                                <?php foreach ($magazins as $magazin) { ?>
                                    <option value="<?php echo $magazin['id']; ?>"
                                    ><?php echo $magazin['name']; ?></option>
                                <?php } ?>
                            </select>
                        </div>

                        <div class="col-md-6 col-sm-12 col-xs-12">
                           <input class="form-inline md-button-v"
                                                                             placeholder="Vente" name="quantityToSale"
                                                                             type="text">
                        </div><div class="col-md-6 col-sm-12 col-xs-12">
                           <input class="form-inline md-button-v"
                                                                             placeholder="Stock" name="quantityInMagazin"
                                                                             type="text">
                        </div>

                    </div>
                </div>
            </div>

        </div>


        <div class="row">
            <button type="submit" class="btn btn-info" name="addMeal">
                <span class="fa fa-plus"></span> Ajouter un article
            </button>
            <input type="submit" name="buttonSubmit" value="Enregister" class="btn btn-success"/>
        </div>
    </div>
</div> <!-- /.col-right -->
<!-- /page content -->

<?php $this->load->view('admin/partials/admin_footer'); ?>


<script>

    $(document).ready(function () {

        var gainRate = 1;
        var group = 0;
        var productsCount =1;


        $('input[name="buttonSubmit"]').on('click', function () {
            $('#loading').show();
            var mealsList = [];
            var prixTotal = 0;
            var name = $('input.mealName').val();
            var department = $('input[name=department]').val();
            for (var i = 1; i <= productsCount; i++) {

                var row = $('.product[data-id=' + i + ']');
                var l_panel = row.closest('.product');

                var quantityInMagazin = parseFloat(row.find('input[name="quantityInMagazin"]').val().replace(',', '.'));
                var quantityToSale = parseFloat(row.find('input[name="quantityToSale"]').val().replace(',', '.'));
                var meal = row.find('select[data-name=meal]').find('option:selected').val();
                var magazin = row.find('select[data-name=magazin]').find('option:selected').val();

                if (/*quantity > 0*/ true) {
                    var meal = {
                        'meal': meal,'magazin':magazin, 'quantityInMagazin': quantityInMagazin, 'quantityToSale': quantityToSale
                    };
                    mealsList.push(meal);
                }

            }
            console.log(mealsList);

            if (true) {
                $.ajax({
                    url: "<?php echo base_url('admin/department/apiMealsPrepared'); ?>",
                    type: "POST",
                    dataType: "json",
                    data: {'mealsList': mealsList,'department':department},
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

        var productSize = 1;


        $('button[name="addMeal"]').on('click', addMeal);
        function addMeal(event) {
            var productModel = $('.productModel').clone().removeAttr('hidden');
            productModel.removeClass('productModel');
            productsCount++;
            productModel.attr('data-id', productsCount);
            $('.mealComposition').append(productModel);
            $('.productsCount').html(productsCount);
        }

    });

</script>
