<?php $this->load->view('admin/partials/admin_header.php'); ?>
<!-- page content -->
<div class="right_col" role="main">

    <div class="row">

        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Liste des Articles</h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <button type="button" class="btn btn-primary" name="save">
                        Enregistrer
                    </button>

                    <div class="text-center mealExists" hidden>Certain articles existent déjà ! Voulez-vous les mettre à jour ? <a data-type="update">Oui</a></div>

                    <table class="table table-striped">
                        <tr>
                            <th>
                                Code
                            </th>
                            <th>
                                Nom
                            </th>
                            <th>
                                Prix
                            </th>
                            <th>
                                Group
                            </th>
                        </tr>
                        <tbody id="tbodyid">

                        <?php foreach ($meals as $meal) { ?>
                        <tr>
                            <td data-type="code"><?php echo $meal['code'];?></td>
                            <td data-type="name"><?php echo $meal['name'];?></td>
                            <td data-type="price"><?php echo $meal['price'];?></td>
                            <td data-type="group"><?php echo $meal['group'];?></td>
                        </tr>
                        <?php } ?>
                        </tbody>


                    </table>
                </div> <!-- /content -->
            </div><!-- /x-panel -->
        </div> <!-- /col -->
    </div>
</div> <!-- /.col-right -->
<!-- /page content -->

<?php $this->load->view('admin/partials/admin_footer'); ?>

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
            group = $(this).find('td[data-type="group"]').text();
            var meal={'code':code,'name':name,'sellPrice':price,'group':group};
            mealsList.push(meal);
        });
        $.ajax({
            url: event.data.url,
            type: "POST",
            dataType: "json",
            data: {"mealsList": mealsList,"type":event.data.type},
            success: function (data) {
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
                // do something
            }
        });
    }
</script>

