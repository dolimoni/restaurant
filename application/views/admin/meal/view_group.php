<?php $this->load->view('admin/partials/admin_header.php'); ?>
<!-- page content -->
<div class="right_col" role="main">
    <div class="productsList">
        <div class="page-title">
            <div class="title_left">
                <h3>Liste des familles</h3>
            </div>
        </div>

        <div class="clearfix"></div>
        <hr>
        <div class="article-title">

           <div class="row">
               <div class="col-md-9">
                   <a class="btn btn-primary" data-toggle="collapse" href="#collapseExample" aria-expanded="false"
                      aria-controls="collapseExample">Nouvelle famille</a>

                   <!--<button type="submit" class="btn btn-warning" name="Fichier"
                           onclick="window.location.href='<?php /*echo base_url('admin/meal/loadFileGroup/'); */?>'">
                       <span class="fa fa-print"></span> Importer
                   </button>-->
               </div>

               <div class="col-md-3">
                   <?php if (count($productsToOrder)) { ?>
                       <a href="<?= base_url('admin/product/toOrder'); ?>">
                           <h3 class="soldOut" style="color:#d9534f;">Stock Insuffisant</h3>
                       </a>
                   <?php } ?>
               </div>
           </div>
        </div>

        <div class="collapse" id="collapseExample">
            <?php echo validation_errors(); ?>
            <form id="addGroupForm" enctype="multipart/form-data">
                <fieldset>
                    <div class="row">
                        <div class="col-xs-6">
                            <br>
                            <label for="name">Nom :</label>
                            <input type="text" step="any" class="form-control" name="groupName" placeholder="Nom de la famille"
                                   required>
                        </div>

                        <div class="col-xs-6">
                            <br>
                            <label for="image">Image :</label>
                            <input type="file" class="form-control" name="image" size="10485760">
                        </div>
                    </div><br/>

                    <div class="text-right">
                        <input class="btn btn-success" type="submit" name="addGroup" value="Confirmer"/>
                    </div>

                </fieldset>
            </form>
            <br>
        </div>


        <div class="collapse" id="editGroup" >
            <form id="editGroupForm" enctype="multipart/form-data">
                <fieldset>
                    <div class="row">
                        <input type="hidden" name="id"/>
                        <div class="col-xs-6">
                            <br>
                            <label for="name">Nom :</label>
                            <input type="text" step="any" class="form-control" name="groupNameEdit" placeholder="Nom de la famille"
                                   required>
                        </div>

                        <div class="col-xs-6">
                            <br>
                            <label for="image">Image :</label>
                            <input type="file" class="form-control" name="image" size="10485760">
                        </div>
                    </div><br/>

                    <div class="text-right">
                        <input class="btn btn-success" type="submit" name="editGroupForm" value="Modifier"/>
                    </div>

                </fieldset>
            </form>
            <br>
        </div>
        <div class="row">

            <?php foreach ($groups as $group) { ?>

                <div class="col-md-4 col-sm-4 col-xs-12">
                    <div class="well profile_view" style="min-height:170px;">
                        <a href="<?php echo base_url('admin/meal/groupMeals/' . $group['g_id']); ?>">
                            <div class="col-sm-12">
                                <h4 class="brief"><i><?php echo $group['g_name'] ?></i></h4>
                                <div class="left col-xs-7">
                                    <p><strong>Nombre d'article: </strong><?php echo $group['groupCount'] ?> </p>
                                    <ul class="list-unstyled">
                                        <li><i class="fa"></i>Prix moyen: <?php echo round($group['avg_price']) ?>DH</li>
                                    </ul>
                                </div>
                                <div class="right col-xs-5 text-center">
                                    <img src="<?php echo base_url(); ?>assets/images/<?php echo $group['image'] ?>" alt=""
                                         class="img-circle img-responsive">
                                </div>
                            </div>
                          </a>
                        <div class="col-xs-12 bottom">
                            <button aria-expanded="false" data-id="<?php echo $group['g_id'] ?>" data-name="<?php echo $group['g_name'] ?>" type="button" class="btn btn-info btn-xs editGroup">
                                <i class="fa fa-edit" > </i> Modifier
                            </button>
                            <button data-id="<?php echo $group['g_id'] ?>" type="button" class="btn btn-danger btn-xs deleteGroup">
                                <i class="fa fa-trash"> </i> Supprimer
                            </button>
                        </div>
                    </div>
                </div>

            <?php } ?>
        </div> <!-- /row -->
    </div>
</div>


<?php $this->load->view('admin/partials/admin_footer'); ?>



<script>

    $(document).ready(function () {
        $('#addGroupForm').on('submit', function (e) {
            e.preventDefault();
            var formData = new FormData(this);
            $('#loading').show();
            $.ajax({
                type: 'POST',
                url: "<?php echo base_url(); ?>admin/meal/group",
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: function (data) {
                    if (data.status === "success") {
                        $('#loading').hide();
                        swal({
                            title: "Success",
                            text: "La famille a été bien ajouté",
                            type: "success",
                            timer: 1500,
                            showConfirmButton: false
                        });
                    } else {
                        $('#loading').hide();
                        swal({
                            title: "Erreur",
                            text: "Une erreur s'est produit",
                            type: "error",
                            timer: 1500,
                            showConfirmButton: false
                        });
                    }
                },
                error: function (data) {
                    swal({
                        title: "Erreur",
                        text: "Une erreur s'est produit",
                        type: "error",
                        timer: 1500,
                        showConfirmButton: false
                    });
                }
            });

        });

        $('#editGroupForm').on('submit', function (e) {
            e.preventDefault();
            var formData = new FormData(this);
            $.ajax({
                type: 'POST',
                url: "<?php echo base_url('admin/meal/apiGroupEdit'); ?>",
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: function (data) {
                   if(data.status==="success"){
                       swal({
                           title: "Success",
                           text: "La modification a été bien effectuée",
                           type: "success",
                           timer: 1500,
                           showConfirmButton: false
                       });
                   }else{
                        swal({
                             title: "Erreur",
                             text: "Une erreur s'est produit",
                             type: "error",
                             timer: 1500,
                             showConfirmButton: false
                         });
                   }
                },
                error: function (data) {
                    swal({
                        title: "Erreur",
                        text: "Une erreur s'est produit",
                        type: "error",
                        timer: 1500,
                        showConfirmButton: false
                    });
                }
            });

        });
        
        
        /*Edit group*/
        
        $(".editGroup").on('click', editGroupEvent);
        var l_id=-1;
        function editGroupEvent() {
            if($(this).attr('data-id')===l_id || l_id===-1){
                $('#editGroup').toggle('slow');
            }
            l_id = $(this).attr('data-id');

            $('input[name="groupNameEdit"]').val($(this).attr('data-name'));
            $('input[name="id"]').val($(this).attr('data-id'));
        }

    });

</script>


<script>
    $(document).ready(function () {
        $('button.deleteGroup').on('click', deleteGroupEvent);


        function deleteGroupEvent() {
            var group_id = $(this).attr('data-id');
            swal({
                    title: "Attention ! ",
                    text: "Vous voulez vraiment supprimer ce group ?",
                    type: "warning",
                    showConfirmButton: true,
                    showCancelButton: true,
                    cancelButtonText: 'Non',
                    confirmButtonText: 'Oui'
                },
                function () {
                    $.ajax({
                        url: "<?php echo base_url('admin/meal/apiDeleteGroup'); ?>",
                        type: "POST",
                        dataType: "json",
                        data: {'group_id': group_id},
                        success: function (data) {
                            if (data.status === 'success') {
                                swal({
                                    title: "Success",
                                    text: "Le group a été bien supprimé",
                                    type: "success",
                                    timer: 1500,
                                    showConfirmButton: false
                                });
                            }
                            else {
                                swal({
                                    title: "Erreur",
                                    text: "Une erreur s'est produuite",
                                    type: "error",
                                    timer: 1500,
                                    showConfirmButton: false
                                });
                            }
                        },
                        error: function (data) {
                            swal({
                                title: "Erreur",
                                text: "Une erreur s'est produuite",
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

<script>
    $(document).ready(function () {
        function blinker() {
            $('.soldOut').fadeOut(500);
            $('.soldOut').fadeIn(500);
        }

        setInterval(blinker, 1000); //Runs every second
    });
</script>