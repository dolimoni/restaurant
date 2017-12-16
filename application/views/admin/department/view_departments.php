<?php $this->load->view('admin/partials/admin_header.php'); ?>
<style>
    .profile_details:nth-child(3n) {
        clear: none;
    }
</style>
<!-- page content -->
<div class="right_col" role="main">
    <div class="productsList">
        <div class="page-title">
            <div class="title_left">
                <h3>Liste des départements</h3>
            </div>
        </div>
        <div class="clearfix"></div>
        <hr>
        <div class="article-title">
            <a class="btn btn-primary" data-toggle="collapse" href="#collapseExample" aria-expanded="false"
               aria-controls="collapseExample">Nouveau</a>
        </div>
        <div class="collapse" id="collapseExample">
            <form id="addEmployeeForm" enctype="multipart/form-data">
                <fieldset>
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-6">
                            <br>
                            <label for="name">Nom :</label>
                            <input type="text" class="form-control" name="name"
                                   placeholder="Nom"
                                   required>
                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-6">
                            <br>
                            <label for="image">Image :</label>
                            <input type="file" class="form-control" name="image" size="10485760">
                        </div>

                    </div>

                    <div class="text-right">
                        <input class="btn btn-success" type="submit" name="addEmployee" value="Confirmer"/>
                    </div>

                </fieldset>
            </form>
            <br>
        </div>

        <div class="collapse" id="editDepartment">
            <form id="editDepartmentForm" enctype="multipart/form-data">
                <fieldset>
                    <div class="row">
                        <input type="hidden" name="id"/>
                        <div class="col-xs-6">
                            <br>
                            <label for="name">Nom :</label>
                            <input type="text" step="any" class="form-control" name="departmentNameEdit"
                                   placeholder="Nom du département"
                                   required>
                        </div>

                        <div class="col-xs-6">
                            <br>
                            <label for="image">Image :</label>
                            <input type="file" class="form-control" name="image" size="10485760">
                        </div>
                    </div>
                    <br/>

                    <div class="text-right">
                        <input class="btn btn-success" type="submit" name="editDepartmentForm" value="Modifier"/>
                    </div>

                </fieldset>
            </form>
            <br>
        </div>

        <div class="row">
            <?php foreach ($departments as $department) { ?>
                <div class="col-md-4 col-sm-6 col-ms-6 col-xs-12 profile_details" data-id="<?php echo $department['id']; ?>">
                    <div class="profile_view">
                        <div class="col-sm-12 profile_details-link" data-id="<?php echo $department['id']; ?>">
                            <h4 class=""><i> <?php echo $department['name']; ?> </i></h4>

                            <div class="right col-xs-12 text-center">
                                <img src="<?php echo base_url('assets/images/'. $department['image']); ?>" alt=""
                                     class="img-responsive" style="width:100%;height:140px;">
                            </div>
                        </div>
                        <div class="col-xs-12 bottom text-right">
                            <div class="col-xs-12 col-sm-12 emphasis">
                                <!--<button data-id="<?php /*echo $department['id']; */?>" type="button"
                                        class="btn btn-danger btn-xs deleteEmployee">
                                    <i class="fa fa-trash"> </i> Supprimer
                                </button>-->

                                <button data-id="<?php echo $department['id']; ?>" type="button"
                                        data-name="<?php echo $department['name'] ?>"
                                        class="btn btn-success btn-xs showDepartment">
                                    <i class="fa fa-eye"> </i> modifier
                                </button>

                                <button data-id="<?php echo $department['id']; ?>" type="button"
                                        data-name="<?php echo $department['name'] ?>"
                                        class="btn btn-info btn-xs editDepartment">
                                    <i class="fa fa-edit"> </i> modifier
                                </button>

                                <button data-id="<?php echo $department['id']; ?>" type="button"
                                        class="btn btn-danger btn-xs deleteDepartment hidden" >
                                    <i class="fa fa-trash"> </i> Supprimer
                                </button>
                            </div>
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
        $('#addEmployeeForm').on('submit', function (e) {
            e.preventDefault();
            var formData = new FormData(this);
            $('#loading').show();
            $.ajax({
                type: 'POST',
                url: "<?php echo base_url('admin/department/apiAddDepartment'); ?>",
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: function (data) {
                    $('#loading').hide();
                    swal({
                        title: "Success",
                        text: "Le département a été bien ajouté",
                        type: "success",
                        timer: 1500,
                        showConfirmButton: false
                    });
                    location.reload();
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

        });

        $('#editDepartmentForm').on('submit', function (e) {
            e.preventDefault();
            var formData = new FormData(this);
            $.ajax({
                type: 'POST',
                url: "<?php echo base_url('admin/department/apiEditDepartment'); ?>",
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: function (data) {
                    if (data.status === "success") {
                        swal({
                            title: "Success",
                            text: "La modification a été bien effectuée",
                            type: "success",
                            timer: 1500,
                            showConfirmButton: false
                        });
                        location.reload();
                    } else {
                        if (data.status === "success") {
                            swal({
                                title: "Success",
                                text: "La modification a été bien effectuée",
                                type: "success",
                                timer: 1500,
                                showConfirmButton: false
                            });
                            location.reload();
                        } else {
                            swal({
                                title: "Erreur",
                                text: "Une erreur s'est produit",
                                type: "error",
                                timer: 1500,
                                showConfirmButton: false
                            });
                        }
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

        $(".editDepartment").on('click', editDepartmentEvent);
        var l_id = -1;

        function editDepartmentEvent() {
            if ($(this).attr('data-id') === l_id || l_id === -1) {
                $('#editDepartment').toggle('slow');
            }
            l_id = $(this).attr('data-id');

            $('input[name="departmentNameEdit"]').val($(this).attr('data-name'));
            $('input[name="id"]').val($(this).attr('data-id'));
        }

        $('.profile_details-link,.showDepartment').on('click', function () {
            var id = $(this).attr('data-id');
            document.location.href = "<?php echo base_url(); ?>admin/department/show/" + id;
        });
    });

</script>





<script>
    $(document).ready(function () {
        $('button.deleteDepartment').on('click', deleteDepartment);


        function deleteDepartment() {
            var department_id = $(this).attr('data-id');
            swal({
                    title: "Attention ! ",
                    text: "Vous voulez vraiment supprimer ce département ?",
                    type: "warning",
                    showConfirmButton: true,
                    showCancelButton: true,
                    cancelButtonText: 'Non',
                    confirmButtonText: 'Oui'
                },
                function () {
                    $.ajax({
                        url: "<?php echo base_url('admin/department/apiDeleteDepartment'); ?>",
                        type: "POST",
                        dataType: "json",
                        data: {'department_id': department_id},
                        success: function (data) {
                            if (data.status === 'success') {
                                swal({
                                    title: "Success",
                                    text: "Le département a été bien supprimé",
                                    type: "success",
                                    timer: 1500,
                                    showConfirmButton: false
                                });
                                location.reload();
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
                                text: "Vous devez vider le départment avant de le supprimer",
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

