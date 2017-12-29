<?php $this->load->view('admin/partials/admin_header.php'); ?>
<style>
    .validate{
        background: #26b99a !important;
        color: white;
    }
</style>
    <!-- page content -->
    <div class="right_col" role="main">
        <div class="">
            <div class="page-title">
                <div class="title_left">
                    <h3>Produits</h3>
                </div>
            </div>
            <div class="clearfix"></div>
            <hr>
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2>Liste des produits vendu aujoud'hui</h2>
                            <ul class="nav navbar-right panel_toolbox">
                                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                                <li><a class="close-link"><i class="fa fa-close"></i></a></li>
                            </ul>
                            <div class="clearfix"></div>
                        </div>

                        <form id="addSalesFileForm" enctype="multipart/form-data">

                            <fieldset>
                                <div class="row">
                                    <div class="col-xs-4">
                                        <br>
                                        <label for="image">Importer le fichier des ventes :</label>
                                        <input type="file" class="form-control" name="image" size="20485760">
                                    </div>
                                </div>
                                <br/>

                                <div class="text-right">
                                    <input class="btn btn-success" type="submit" name="addSalesFile" value="Confirmer"/>
                                </div>

                            </fieldset>
                        </form>

                        <ul class="nav nav-tabs">
                            <li class="active"><a data-toggle="tab" href="#home">Toutes les ventes</a></li>
                            <li><a data-toggle="tab" href="#menu1" id="diffTab">Différences</a></li>
                        </ul>

                        <div class="tab-content">
                            <div id="home" class="tab-pane fade in active">
                                <div class="x_content">
                                    <table class="table table-striped">
                                        <tr>
                                            <th>
                                                Id
                                            </th>
                                            <th>
                                                Code
                                            </th>
                                            <th>
                                                Description
                                            </th>
                                            <th>
                                                Quantité
                                            </th>
                                            <th>
                                                Montant
                                            </th>
                                            <th>
                                                Nom
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
                                    <div class="text-right">
                                        <button type="button" class="btn btn-success " name="validate">
                                            Valider
                                        </button>
                                    </div>

                                </div> <!-- /content -->
                            </div>
                            <div id="menu1" class="tab-pane fade">
                                <div class="x_content">
                                    <table class="table table-striped">
                                        <tr>
                                            <th>
                                                Numéro system
                                            </th>
                                            <th>
                                                Code
                                            </th>
                                            <th>
                                                Description
                                            </th>
                                            <th>
                                                Quantité
                                            </th>
                                            <th>
                                                Montant
                                            </th>
                                            <th>
                                                Correction
                                            </th>
                                            <th>
                                                Nom systèm
                                            </th>
                                            <th>
                                                Prix systèm
                                            </th>
                                            <th>
                                                Actions
                                            </th>
                                        </tr>
                                        <tbody id="tbodyDifference"></tbody>
                                    </table>
                                    <div class="text-right">
                                        <button type="button" class="btn btn-success " name="validate">
                                            Valider
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

    $(document).ready(function () {
        var report_date='';
        $('#addSalesFileForm').on('submit', function (e) {
            e.preventDefault();
            var formData = new FormData(this);
            $('#loading').show();
            $.ajax({
                type: 'POST',
                url: "<?php echo base_url('admin/Main/apiLoadFile'); ?>",
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
                        report_date=data.response.sales['dateTime'];

                        $.each(data.response.sales.rows, function (key, row) {
                            var rowContent = '<tr data-id="'+key+'">' +
                                '<td data-type="id">' + row['product']['id'] + '</td>' +
                                '<td data-type="externalCode">' + row[0] + '</td>' +
                                '<td data-type="description">' + row[1] + '</td>' +
                                '<td data-type="quantity">' + row[2]/1000 + '</td>' +
                                '<td data-type="amount">' + row[3]/100 + '</td>' +
                                '<td data-type="name">' + row['product']['name']+ '</td>' +
                                '<td>' +
                                   '<button class="btn btn-default btn-xs action validationButton" data-type="validate"><span class="glyphicon glyphicon-ok"></span></button>'+
                                '</td>'+
                                '</tr>';

                            if(row['status']==='Invalid'){
                                var rowContent = '<tr class="mealIncoherent" data-id="' + key + '">' +
                                    '<td data-type="id">' + row['product']['id'] + '</td>' +
                                    '<td data-type="externalCode">' + row[0] + '</td>' +
                                    '<td data-type="description">' + row[1] + '</td>' +
                                    '<td data-type="quantity">' + row[2] / 1000 + '</td>' +
                                    '<td data-type="amount">' + row[3] / 100 + '</td>' +
                                    '<td data-type="correction">' +
                                        /*'<img class="arrow-right correctMeal" src="<?php echo base_url('assets/images/arrow-right.png'); ?>">' +*/
                                    '<img class="arrow-left correctMeal" src="<?php echo base_url('assets/images/arrow-left.png'); ?>">' +
                                    '</td>' +
                                    '<td data-type="name">' + row['product']['name'] + '</td>' +
                                    '<td data-type="sellPrice">' + row['product']['sellPrice'] + '</td>' +
                                    '<td>' +
                                    '<button class="btn btn-default btn-xs action validationButton" data-type="validate"><span class="glyphicon glyphicon-ok"></span></button>' +
                                    '</td>' +
                                    '</tr>';
                                $("#tbodyDifference").append(rowContent);
                                invalid++;
                            }else{
                                validAmountTotal+= row[3] / 100;
                                validQuantityTotal+= row[2] / 1000;
                                $("#tbodyid").append(rowContent);
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
                            title: "Une erreur s'est produit",
                            text: "Veuillez réessayer plus tard",
                            type: "error",
                            timer: 1500
                        });
                    }
                },
                error: function (data) {
                    $('#loading').hide();
                    swal({
                        title: "Une erreur s'est produit",
                        text: "Veuillez réessayer plus tard",
                        type: "error",
                        timer: 1500
                    });
                }
            });

        });

        $('button[name="validate"]').on('click', function () {
            var mealsList = [];
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

            var myData = {'mealsList': mealsList};
            $('#loading').show();
            $.ajax({
                url: "<?php echo base_url(); ?>admin/meal/apiConsumption",
                type: "POST",
                dataType: "json",
                data: myData,
                success: function (data) {
                    $('#loading').hide();
                    if (data.status === 'success') {
                        swal({
                            title: "Success",
                            text: "L'opératon a été effectuée avec success",
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
                        text: "Une erreur s\'est produite",
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
