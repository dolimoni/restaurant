<?php $this->load->view('admin/partials/admin_header.php'); ?>
<style>
    .validate{
        background: #26b99a !important;
        color: white;
    }
    @media (max-width: 480px) {
        #datatable-sales_filter{
            float: left !important;
            text-align: left !important;
        }
        #reportrange{
            float:left !important;
        }
    }
</style>
    <!-- page content -->
    <div class="right_col" role="main">
        <div class="">
            <div class="page-title">
                <div class="title_left">
                    <h3><?= lang('products'); ?></h3>
                </div>
            </div>
            <div class="clearfix"></div>
            <hr>
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2><?= lang('sold_meals_list'); ?></h2>
                            <ul class="nav navbar-right panel_toolbox">
                                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                                <li><a class="close-link"><i class="fa fa-close"></i></a></li>
                            </ul>
                            <div class="clearfix"></div>
                        </div>


                        <div class="row">

                            <?php
                            $hidden = "hidden";
                            $addSalesFileWidh="col-xs-12 col-sm-6 col-md-12";
                            if ($params["editConsumptionDate"] === "true") {
                                $addSalesFileWidh="col-xs-12 col-sm-6 col-md-9";
                                $hidden = "";
                            }
                            ?>
                            <div class="col-xs-12 col-sm-6 col-md-3" <?php echo $hidden; ?>>
                                <label for="paiementDate">Date du rapport :</label>
                                <?php include('include/calender.php'); ?>
                            </div>
                            <div class="<?php echo $addSalesFileWidh; ?>">
                                <form id="addSalesFileForm" enctype="multipart/form-data">

                                    <fieldset>
                                        <div class="col-xs-8 col-sm-6">
                                            <label for="image"><?= lang('import_sales_file'); ?> :</label>
                                            <input type="file" class="form-control" name="image" size="20485760">
                                        </div>
                                    </fieldset>
                                    <input class="btn btn-success pull-right" type="submit" name="addSalesFile"
                                           value="<?= lang('confirme'); ?>"/>
                                </form>
                            </div>

                        </div>


                        <ul class="nav nav-tabs">
                            <li class="active"><a data-toggle="tab" href="#home"><?= lang('all_sales'); ?></a></li>
                            <li><a data-toggle="tab" href="#menu1" id="diffTab"><?= lang('differences'); ?></a></li>
                        </ul>




                        <div class="tab-content">
                            <div id="home" class="tab-pane fade in active">
                                <div class="x_content table-responsive">
                                    <table class="table table-striped">
                                        <tr>
                                            <th>
                                                Id
                                            </th>
                                            <th>
                                                <?= lang('code'); ?>
                                            </th>
                                            <th>
                                                <?= lang('description'); ?>
                                            </th>
                                            <th>
                                                <?= lang('quantity'); ?>
                                            </th>
                                            <th>
                                                <?= lang('amount'); ?>
                                            </th>
                                            <th>
                                                <?= lang('name'); ?>
                                            </th>
                                            <th>
                                                Actions
                                            </th>
                                        </tr>
                                        <tbody id="tbodyid"></tbody>

                                        <?php /*foreach ($rows as $row) { */ ?><!--
                                <tr data-id="<?php /*echo $row[0]; */ ?>">
                                    <td data-type="id"><?php /*echo $row['product']['id']; */ ?></td>
                                    <td data-type="externalCode"><?php /*echo $row[0];*/ ?></td>
                                    <td data-type="description"><?php /*echo $row[1]; */ ?></td>
                                    <td data-type="quantity"><?php /*echo $row[2]/1000; */ ?></td>
                                    <td data-type="amount"><?php /*echo $row[3]/100; */ ?></td>
                                    <td data-type="name"> <?php /*echo $row['product']['name']; */ ?></td>
                                    <td>

                                        <button class="btn btn-default btn-xs action" data-type="validate"><span class="glyphicon glyphicon-ok"></span></button>
                                    </td>
                                </tr>
                                --><?php /*} */ ?>

                                    </table>
                                    <input type="checkbox" name="deleteSales"/> <?= lang('delete_old_sales_for_day'); ?>
                                    <div class="text-right">
                                        <button type="button" class="btn btn-success " name="validate">
                                            <?= lang('validate'); ?>
                                        </button>
                                    </div>

                                </div> <!-- /content -->
                            </div>
                            <div id="menu1" class="tab-pane fade">
                                <div class="x_content">
                                    <table class="table table-striped">
                                        <tr>
                                            <th>
                                                <?= lang('system_number'); ?>
                                            </th>
                                            <th>
                                                <?= lang('code'); ?>
                                            </th>
                                            <th>
                                                <?= lang('description'); ?>
                                            </th>
                                            <th>
                                                <?= lang('quantity'); ?>
                                            </th>
                                            <th>
                                                <?= lang('amount'); ?>
                                            </th>
                                            <th>
                                                <?= lang('correction'); ?>
                                            </th>
                                            <th>
                                                <?= lang('system_name'); ?>
                                            </th>
                                            <th>
                                                <?= lang('price_system'); ?>
                                            </th>
                                            <th>
                                                Actions
                                            </th>
                                        </tr>
                                        <tbody id="tbodyDifference"></tbody>
                                    </table>
                                    <div class="text-right">
                                        <button type="button" class="btn btn-success " name="validate">
                                            <?= lang('validate'); ?>
                                        </button>
                                    </div>

                                </div>
                            </div>
                        </div>

                    </div><!-- /x-panel -->
                </div> <!-- /col -->
            </div> <!-- /row -->
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
</script>


<script src="<?php echo base_url('assets/vendors/bootstrap-progressbar/bootstrap-progressbar.min.js'); ?>"></script>

<script src="<?php echo base_url('assets/vendors/moment/min/moment.min.js'); ?>"></script>

<script src="<?php echo base_url('assets/vendors/bootstrap-daterangepicker/daterangepicker.js'); ?>"></script>

<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

<script>

    $(document).ready(function () {
        var report_date = moment($("#single_cal3").val()).format("YYYY-MM-DD") + "T10";
        $('#addSalesFileForm').on('submit', function (e) {
            e.preventDefault();
            var formData = new FormData(this);
            $('#loading').show();
            $.ajax({
                type: 'POST',
                url: "<?php echo base_url('admin/Main/apiLoadSiogesFile'); ?>",
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: function (data) {
                    $('#loading').hide();

                    if (data.status == "success") {
                        swal({
                            title: "Success",
                            text: "OK",
                            type: "success",
                            timer: 1500,
                            showConfirmButton: false
                        });

                        $("#tbodyid").empty();
                        $("#tbodyDifference").empty();
                        var invalid= 0;
                        var validAmountTotal=0;
                        var validQuantityTotal=0;
                        //report_date=data.response.sales['dateTime'];
                        report_date = moment($("#single_cal3").val()).format("YYYY-MM-DD") + "T10";

                        console.log(data.response);
                        $.each(data.response.sales, function (key, sale) {
                            console.log(sale["externalCode"]);
                            var saleContent = '<tr data-id="'+key+'">' +
                                '<td data-type="id">' + sale['id'] + '</td>' +
                                '<td data-type="externalCode">' + sale["externalCode"] + '</td>' +
                                '<td data-type="description">' + sale["meal"] + '</td>' +
                                '<td data-type="quantity">' + sale["quantity"] + '</td>' +
                                '<td data-type="amount">' + sale["amount"] + '</td>' +
                                '<td data-type="name">' + sale["meal"]+ '</td>' +
                                '<td>' +
                                   '<button class="btn btn-default btn-xs action validationButton" data-type="validate"><span class="glyphicon glyphicon-ok"></span></button>'+
                                '</td>'+
                                '</tr>';

                            if(sale['status']==='Invalid'){
                                var saleContent = '<tr class="mealIncoherent" data-id="' + key + '">' +
                                    '<td data-type="id">' + sale['product']['id'] + '</td>' +
                                    '<td data-type="externalCode">' + sale["externalCode"] + '</td>' +
                                    '<td data-type="description">' + sale["meal"] + '</td>' +
                                    '<td data-type="quantity">' + sale["quantity"] + '</td>' +
                                    '<td data-type="amount">' +sale["amount"] + '</td>' +
                                    '<td data-type="correction">' +
                                    '<img class="arsale-left correctMeal" src="<?php echo base_url('assets/images/arrow-left.png'); ?>">' +
                                    '</td>' +
                                    '<td data-type="name">' + sale['product']['name'] + '</td>' +
                                    '<td data-type="sellPrice">' + sale['product']['sellPrice'] + '</td>' +
                                    '<td>' +
                                    '<button class="btn btn-default btn-xs action validationButton" data-type="validate"><span class="glyphicon glyphicon-ok"></span></button>' +
                                    '</td>' +
                                    '</tr>';
                                $("#tbodyDifference").append(rowContent);
                                invalid++;
                            }else{
                                validAmountTotal+= sale["amount"];
                                validQuantityTotal+= sale["quantity"];
                                $("#tbodyid").append(saleContent);
                            }
                        });

                        $("#diffTab").html('Différences('+invalid+')');

                        var rowContent = '<tr>' +
                            '<td data-type="id">-</td>' +
                            '<td data-type="externalCode">-</td>' +
                            '<td data-type="description">-</td>' +
                            '<td data-type="quantity">Total : ' + validQuantityTotal  +'</td>' +
                            '<td data-type="amount">Total :' + validAmountTotal  + '</td>' +
                            '<td data-type="name">-</td>' +
                            '<td>' +
                            '<button class="btn btn-default btn-xs action validationButtonAll" data-type="validate"><span class="glyphicon glyphicon-ok"></span></button>' +
                            '</td>' +
                            '</tr>';

                        $("#tbodyid").append(rowContent);


                        var rowContentDifference = '<tr class="mealIncoherent" data-id="">' +
                            '<td>-</td>' +
                            '<td data-type="externalCode">-</td>' +
                            '<td data-type="description">-</td>' +
                            '<td data-type="quantity">-</td>' +
                            '<td data-type="amount">-</td>' +
                            '<td data-type="correction">' +
                            '<img class="arrow-left correctAllMeals" src="<?php echo base_url('assets/images/arrow-left.png'); ?>">' +
                            '</td>' +
                            '<td data-type="name">-</td>' +
                            '<td data-type="sellPrice">-</td>' +
                            '<td>' +
                            '<button class="btn btn-default btn-xs action validationCorrectionButtonAll" data-type="validate"><span class="glyphicon glyphicon-ok"></span></button>' +
                            '</td>' +
                            '</tr>';
                        $("#tbodyDifference").append(rowContentDifference);

                    } else {
                        swal({
                            title: "Error",
                            text: swal_error_lang,
                            type: "error",
                            timer: 1500
                        });
                    }
                },
                error: function (data) {
                    $('#loading').hide();
                    swal({
                        title: "Error",
                        text: swal_error_lang,
                        type: "error",
                        timer: 1500
                    });
                }
            });

        });

        $('button[name="validate"]').on('click', function () {
            var mealsList = [];
            report_date = moment($("#single_cal3").val()).format("YYYY-MM-DD") + "T10";
            var deleteSales = $('input[name="deleteSales"]').is(':checked');
            var params={
                "deleteSales":deleteSales,
                "report_date": moment($("#single_cal3").val()).format("YYYY-MM-DD"),
            }
            $('tr.validate').each(function (i, obj) {
                var tr = $(this);
                var id = tr.find('td[data-type="id"]').text();
                var externalCode = tr.find('td[data-type="externalCode"]').text();
                var description = tr.find('td[data-type="description"]').text();
                var qunatity = tr.find('td[data-type="quantity"]').text();
                var amount = tr.find('td[data-type="amount"]').text();
                var name = tr.find('td[data-type="name"]').text();

                var meal = {
                    'id': id,
                    'externalCode': externalCode,
                    'description': description,
                    'quantity': qunatity,
                    'amount': amount,
                    'name': name,
                    'date': report_date.split('T')
                };
                if (id > 0) {
                    mealsList.push(meal);
                }
            });

            var myData = {'mealsList': mealsList,"params": params};
            $('#loading').show();
            $.ajax({
                url: "<?php echo base_url("admin/meal/apiConsumption"); ?>",
                type: "POST",
                dataType: "json",
                data: myData,
                success: function (data) {
                    $('#loading').hide();
                    if (data.status === 'success') {
                        swal({
                            title: "Success",
                            text: swal_success_operation_lang,
                            type: "success",
                            timer: 1500,
                            showConfirmButton: false
                        });
                    }
                    else {
                        var content = '';
                        $.each(data.productsList, function (key, product) {
                            content += product['name'] + ",";
                        });
                        swal({
                            title: "La quantité de certain produits est insuffisante",
                            type: "error",
                            showCloseButton: true,
                            html: true
                        });
                    }
                },
                error: function (data) {
                    $('#loading').hide();
                    swal({
                        title: "Erreur",
                        text: swal_error_lang,
                        type: "error",
                        timer: 1500,
                        showConfirmButton: false
                    });
                }
            });

        });

        $('.profile_details').on('click', function () {
            var id = $(this).attr('data-id');
            console.log(id);
            document.location.href = "<?php echo base_url('admin/provider/show/'); ?>" + "/" + id;
        });
    });

</script>
<script>
$(document).on('click', '.validationButton', function () {
   var id = $(this).closest('tr').attr('data-id');
   var tr = $(this).closest('tr');
   console.log();
   if(tr.hasClass('validate')){
       tr.removeClass('validate');
   }else{
       if (tr.hasClass('mealIncoherent')) {
           swal({
               title: "Attention",
               text: "Les prix ne sont pas les mêmes",
               type: "warning",
               timer: 1500,
               showConfirmButton: false
           });
       }else{
           tr.addClass('validate');
       }
   }

});

$(document).on('click', '.validationButtonAll', function () {
   var tr = $('#tbodyid tr');

   if(tr.hasClass('validate')){
       tr.removeClass('validate');
   }else{
       tr.addClass('validate');
   }

});

$(document).on('click', '.validationCorrectionButtonAll', function () {
   var tr = $('#tbodyDifference tr');

   if(tr.hasClass('validate')){
       tr.removeClass('validate');
   }else{
       if (tr.hasClass('mealIncoherent')) {
           swal({
               title: "Attention",
               text: "Les prix ne sont pas les mêmes",
               type: "warning",
               timer: 1500,
               showConfirmButton: false
           });
       } else {
           tr.addClass('validate');
       }
   }

});

</script>

<script>
    $(document).ready(function () {
        $(document).on('click', '.correctMeal', correctMeal);
        $(document).on('click', '.correctAllMeals', correctAllMeals);

        function correctMeal() {
            var tr = $(this).closest('tr');
            if($(this).hasClass('arrow-left')){
                var name = tr.find('td[data-type="name"]').text();
                var sellPrice = tr.find('td[data-type="sellPrice"]').text();

                tr.find('td[data-type="description"]').html(name);
                tr.find('td[data-type="amount"]').html(sellPrice);

                if (tr.hasClass('mealIncoherent')) {
                    tr.removeClass('mealIncoherent');
                    tr.addClass('mealCoherent');
                }
           }
           if($(this).hasClass('arrow-right')){
               var description = tr.find('td[data-type="description"]').text();
               var amount = tr.find('td[data-type="amount"]').text();

               tr.find('td[data-type="name"]').html(description);
               tr.find('td[data-type="sellPrice"]').html(amount);



               var meal = {
                   'meal': getMeal(tr)
               };
               console.log(meal);
               $.ajax({
                       url: "",
                       type: "POST",
                       dataType: "json",
                       data: meal,
                       success: function (data) {
                           if (data.status === true) {

                           }
                           else {
                               console.log('Error');
                           }
                       },
                       error: function (data) {
                       }
                  });
           }

        }function correctAllMeals() {
            //var tr = $(this).closest('tr');
            if($(this).hasClass('arrow-left')){

                $('#tbodyDifference > tr').each(function (key,tr) {
                    $this = $(this);
                    var name = $this.find('td[data-type="name"]').text();
                    var sellPrice = $this.find('td[data-type="sellPrice"]').text();

                    $this.find('td[data-type="description"]').html(name);
                    $this.find('td[data-type="amount"]').html(sellPrice);

                    if ($this.hasClass('mealIncoherent')) {
                        $this.removeClass('mealIncoherent');
                        $this.addClass('mealCoherent');
                    }
                });
           }
        }

        function getMeal(tr) {
            var id = tr.find('td[data-type="id"]').text();
            var externalCode = tr.find('td[data-type="externalCode"]').text();
            var description = tr.find('td[data-type="description"]').text();
            var qunatity = tr.find('td[data-type="quantity"]').text();
            var amount = tr.find('td[data-type="amount"]').text();
            var name = tr.find('td[data-type="name"]').text();
            var sellPrice = tr.find('td[data-type="sellPrice"]').text();
            var meal = {
                'id': id,
                'externalCode': externalCode,
                'description': description,
                'quantity': qunatity,
                'amount': amount,
                'sellPrice': sellPrice,
                'name': name
            };
            return meal;

        }
    });
</script>
