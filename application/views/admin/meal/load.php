<?php $this->load->view('admin/partials/admin_header.php'); ?>
<!-- page content -->
<div class="right_col" role="main">

    <div class="row">

        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2><?= lang("meals_list"); ?></h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <form id="addSalesFileForm" enctype="multipart/form-data">
                        <fieldset>
                            <div class="row">
                                <div class="col-xs-4">
                                    <br>
                                    <label for="image"><?= lang("import_sales_file"); ?> :</label>
                                    <input type="file" class="form-control" name="image" size="20485760">
                                </div>
                            </div>
                            <br/>

                            <div class="text-right">
                                <input class="btn btn-success" type="submit" name="addSalesFile" value="<?= lang("confirme"); ?>"/>
                            </div>

                        </fieldset>
                    </form>

                    <div class="text-center mealExists" hidden><?= lang("meals_already_exists"); ?> ? <a data-type="update"><?= lang("yes"); ?>
                            "</a></div>

                    <table class="table table-striped">
                        <tr>
                            <th>
                                <?= lang("code"); ?>
                            </th>
                            <th>
                                <?= lang("name"); ?>
                            </th>
                            <th>
                                <?= lang("price"); ?>
                            </th>
                            <th>
                                <?= lang("group"); ?>
                            </th>
                        </tr>
                        <tbody id="tbodyid">

                        </tbody>


                    </table>

                    <button type="button" class="btn btn-primary" name="save">
                        <?= lang("save"); ?>
                    </button>
                </div> <!-- /content -->
            </div><!-- /x-panel -->
        </div> <!-- /col -->
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

<script>

    $(document).ready(function () {
        $('#addSalesFileForm').on('submit', function (e) {
            e.preventDefault();
            var formData = new FormData(this);
            $('#loading').show();
            $.ajax({
                type: 'POST',
                url: "<?php echo base_url('admin/meal/apiLoadFile'); ?>",
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: function (data) {
                    $('#loading').hide();
                    console.log(data);
                    if (data.status == "success") {
                        swal({
                            title: "Success",
                            text: "OK",
                            type: "success",
                            timer: 1500,
                            showConfirmButton: false
                        });

                        $("#tbodyid").empty();

                        $.each(data.response.meals, function (key, meal) {

                            var group= meal.group;
                            var group_id= 1;
                            if(findGroup(meal.group)[0]){
                                group=findGroup(meal.group)[0]['name'];
                                group_id=findGroup(meal.group)[0]['id'];
                            }

                            var row = '<tr>' +
                                '<td data-type="code">' + meal.code + '</td>' +
                                '<td data-type="name">' + meal.name + '</td>' +
                                '<td data-type="price">' + parseFloat(meal.price / 100).toFixed(2) + '</td>' +
                                '<td data-type="group" data-group="'+ group_id+'">' +group+ '</td>' +
                                '</tr>';
                            $("#tbodyid").append(row);
                        });

                        function findGroup(num) {
                            return $.grep(data.response.groups, function (item) {
                                return item.num == num;
                            });
                        };

                    } else {
                        swal({
                            title: "Erreur",
                            text: swal_error_lang,
                            type: "error",
                            timer: 1500
                        });
                    }
                },
                error: function (data) {
                    $('#loading').hide();
                    swal({
                        title: "Erreur",
                        text: swal_error_lang,
                        type: "error",
                        timer: 1500
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
    var paramsSave={
        url: "<?php echo base_url(); ?>admin/meal/apiLoadMeals",
        type:'save'
    };
    var paramsUpdate={
        url: "<?php echo base_url(); ?>admin/meal/apiLoadMeals",
        type:'update'
    };
    $('button[name="save"]').on('click', paramsSave,save);
    $('a[data-type="update"]').on('click', paramsUpdate,save);
    function save(event){

        var mealsList=[];
        $('#tbodyid').find('tr').each(function () {
            code = $(this).find('td[data-type="code"]').text();
            name = $(this).find('td[data-type="name"]').text();
            price = $(this).find('td[data-type="price"]').text();
            group = $(this).find('td[data-type="group"]').attr('data-group');
            var meal={'code':code,'name':name,'sellPrice':price,'group':group};
            mealsList.push(meal);
        });
        $('#loading').show();
        $.ajax({
            url: event.data.url,
            type: "POST",
            dataType: "json",
            data: {type: event.data.type, test: 'khalid',mealsList: mealsList},
            success: function (data) {
                $('#loading').hide();
                if(data.status=="success"){
                    swal({
                        title: "Success",
                        text: "<?php echo $this->session->flashdata('message'); ?>",
                        type: "success",
                        timer: 1500,
                        showConfirmButton: false
                    });
                    window.location.href = data.redirect;
                }else if(data.status == "warning"){
                    $('#tbodyid').empty();
                    $('.mealExists').fadeIn('1500');
                     $.each(data.mealsExist, function (key, meal) {
                         swal({
                             title: "Certain articles existent déjà ",
                             text: "Voulez - vous les mettre à jour ?",
                             type: "warning",
                             showConfirmButton: true,
                             showCancelButton:true,
                             cancelButtonText:'Non',
                             confirmButtonText:'Oui'
                         },
                         function () {
                             $("a[data-type='update']").trigger("click");
                         });
                        var tr='<tr> ' +
                                '<td data-type="code">'+meal['externalCode']+'</td> ' +
                                '<td data-type="name">'+ meal['name']+'</td>' +
                                '<td data-type="price">'+ meal['sellPrice']+'</td>' +
                                '<td data-type="group">'+ meal['group']+'</td>' +
                            '</tr>';
                         $('#tbodyid').append(tr);

                      });

                }else{
                    swal({
                        title: "Une erreur s'est produit",
                        text: "Veuillez réessayer plus tard",
                        type: "error",
                        timer:1500
                    });
                }
            },
            error: function (data) {
                $('#loading').hide();
            }
        });
    }
</script>

