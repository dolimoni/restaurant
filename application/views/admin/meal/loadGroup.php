<?php $this->load->view('admin/partials/admin_header.php'); ?>
<!-- page content -->
<div class="right_col" role="main">

    <div class="row">

        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Importer des familles</h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <form id="addGroupsFileForm" enctype="multipart/form-data">
                        <fieldset>
                            <div class="row">
                                <div class="col-xs-4">
                                    <br>
                                    <label for="image">Importer le fichier de programmtion :</label>
                                    <input type="file" class="form-control" name="image" size="20485760">
                                </div>
                            </div>
                            <br/>

                            <div class="text-right">
                                <input class="btn btn-success" type="submit" name="addGroupsFile" value="Confirmer"/>
                            </div>

                        </fieldset>
                    </form>
                    <div>



                        <div class="text-center mealExists" hidden>Certain articles existent déjà ! Voulez-vous les
                            mettre à jour ? <a data-type="update">Oui</a></div>

                        <table class="table table-striped">
                            <tr>
                                <th>
                                    Numéro
                                </th>
                                <th>
                                    Nom
                                </th>
                            </tr>
                            <tbody id="tbodyid">
<!--
                            <?php /*foreach ($meals as $meal) { */?>
                                 <tr>
                            <td data-type="num"></td>
                            <td data-type="name"><?php /*echo $meal['name']; */?></td>
                              </tr>
                            --><?php /*} */?>
                            </tbody>


                        </table>

                        <button type="button" class="btn btn-primary" name="save">
                            Enregistrer
                        </button>
                    </div>
                </div> <!-- /content -->
            </div><!-- /x-panel -->
        </div> <!-- /col -->
    </div>
</div> <!-- /.col-right -->
<!-- /page content -->

<?php $this->load->view('admin/partials/admin_footer'); ?>
<script>

    $(document).ready(function () {
        $('#addGroupsFileForm').on('submit', function (e) {
            e.preventDefault();
            var formData = new FormData(this);
            $.ajax({
                type: 'POST',
                url: "<?php echo base_url('admin/meal/apiLoadFileGroup'); ?>",
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: function (data) {
                    console.log(data);
                    if (data.status == "success") {
                        swal({
                            title: "Success",
                            text: "OK",
                            type: "success",
                            timer: 1500,
                            showConfirmButton: false
                        });

                          $.each(data.response.groups, function (key, group) {
                               var row =  '<tr>'+
                                '<td data-type="num">'+group.num+'</td>'+
                                '<td data-type="name">'+group.name+'</td>'+
                                    '</tr>';
                               $("#tbodyid").append(row);
                            });

                    }else {
                        swal({
                            title: "Une erreur s'est produit",
                            text: "Veuillez réessayer plus tard",
                            type: "error",
                            timer: 1500
                        });
                    }
                },
                error: function (data) {
                    swal({
                        title: "Une erreur s'est produit",
                        text: "Veuillez réessayer plus tard",
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
        url: "<?php echo base_url(); ?>admin/meal/apiLoadGroups",
        type:'save'
    };
    var paramsUpdate={
        url: "<?php echo base_url(); ?>admin/meal/apiLoadGroups",
        type:'update'
    };
    $('button[name="save"]').on('click', paramsSave,save);
    $('a[data-type="update"]').on('click', paramsUpdate,save);
    function save(event){

        var groupsList=[];
        $('#tbodyid').find('tr').each(function () {
            num = $(this).find('td[data-type="num"]').text();
            name = $(this).find('td[data-type="name"]').text();
            var group={'num':num,'name':name};
            groupsList.push(group);
        });
        $.ajax({
            url: event.data.url,
            type: "POST",
            dataType: "json",
            data: {"groupsList": groupsList,"type":event.data.type},
            success: function (data) {
                if(data.status=="success"){
                    swal({
                        title: "Success",
                        text: "OK",
                        type: "success",
                        timer: 1500,
                        showConfirmButton: false
                    });
                    window.location.href = data.redirect;
                }else if(data.status == "warning"){
                    $('#tbodyid').empty();
                    $('.mealExists').fadeIn('1500');
                     $.each(data.groupsExist, function (key, group) {
                         swal({
                             title: "Certain groupe existent déjà ",
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
                                '<td data-type="num">'+group['num']+'</td> ' +
                                '<td data-type="name">'+ group['name']+'</td>' +
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

