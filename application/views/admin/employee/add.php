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
                <h3>Liste des employés</h3>
            </div>
        </div>
        <div class="clearfix"></div>
        <hr>
        <div class="article-title">
            <a class="btn btn-primary" data-toggle="collapse" href="#collapseExample" aria-expanded="false"
               aria-controls="collapseExample">Ajouter</a>
        </div>
        <div class="collapse" id="collapseExample">
            <?php echo validation_errors(); ?>
            <form id="addEmployeeForm" enctype="multipart/form-data">
                <fieldset>
                    <div class="row">
                        <div class="col-xs-4">
                            <br>
                            <label for="name">Nom :</label>
                            <input type="text" class="form-control" name="name"
                                   placeholder="Nom"
                                   required>
                        </div>
                        <div class="col-xs-4">
                            <br>
                            <label for="name">Prénom :</label>
                            <input type="text" step="any" class="form-control" name="prenom"
                                   placeholder="Prénom"
                                   required>
                        </div>
                        <div class="col-xs-4">
                            <br>
                            <label for="name">CIN :</label>
                            <input type="text" class="form-control" name="cin"
                                   placeholder="CIN"
                                   required>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-xs-4">
                            <br>
                            <label for="name">Adresse :</label>
                            <input type="text" class="form-control" name="address"
                                   placeholder="Adresse"
                                   required>
                        </div>
                        <div class="col-xs-4">
                            <br>
                            <label for="name">Téléphone :</label>
                            <input type="text" class="form-control" name="phone"
                                   placeholder="Téléphone"
                                   required>
                        </div>
                        <div class="col-xs-4">
                            <br>
                            <label for="name">Salaire :</label>
                            <input type="text" class="form-control" name="salary"
                                   placeholder="Salaire"
                                   required>
                        </div>


                    </div>
                    <div class="row">
                        <div class="col-xs-4">
                            <br>
                            <label for="name">Type de travail :</label>
                            <input type="text" class="form-control" name="workType"
                                   placeholder="Type de travail"
                                   required>
                        </div>
                        <div class="col-xs-4">
                            <br>
                            <label for="image">Photo :</label>
                            <input type="file" class="form-control" name="image" size="10485760">
                        </div>
                    </div>
                    <br/>

                    <div class="text-right">
                        <input class="btn btn-success" type="submit" name="addEmployee" value="Confirmer"/>
                    </div>

                </fieldset>
            </form>
            <br>
        </div>
        <div class="row">
            <?php foreach ($employees as $employee) { ?>
                <div class="col-md-4 col-sm-4 col-xs-12 profile_details" data-id="<?php echo $employee['id']; ?>">
                    <div class="well profile_view">
                        <div class="col-sm-12 profile_details-link" data-id="<?php echo $employee['id']; ?>">
                            <h4 class="brief"><i> <?php echo $employee['workType']; ?> </i></h4>
                            <div class="left col-xs-7">
                                <h2><?php echo $employee['name']; ?> <?php echo $employee['prenom']; ?></h2>
                                <p><?php echo $employee['workType']; ?></p>
                            </div>
                            <div class="right col-xs-5 text-center">
                                <img src="<?php echo base_url('assets/images/'. $employee['image']); ?>" alt=""
                                     class="img-circle img-responsive">
                            </div>
                            <div class="left col-xs-12">
                                <ul class="list-unstyled">
                                    <li><i class="fa fa-building"></i> Adresse: <?php echo $employee['address']; ?>
                                    </li>
                                    <li><i class="fa fa-phone"></i> Téléphone #:<?php echo $employee['phone']; ?></li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-xs-12 bottom text-left">
                           <!-- <div class="col-xs-12 col-sm-6 emphasis">
                                <p class="ratings">
                                    <a>4.0</a>
                                    <a href="#"><span class="fa fa-star"></span></a>
                                    <a href="#"><span class="fa fa-star"></span></a>
                                    <a href="#"><span class="fa fa-star"></span></a>
                                    <a href="#"><span class="fa fa-star"></span></a>
                                    <a href="#"><span class="fa fa-star-o"></span></a>
                                </p>
                            </div>-->
                            <div class="col-xs-12 col-sm-6 emphasis">
                                <button data-id="<?php echo $employee['id']; ?>" type="button"
                                        class="btn btn-danger btn-xs deleteEmployee">
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

<?php if ($this->session->flashdata('message') != NULL) : ?>
    <script>
        swal({
            title: "Success",
            text: "<?php echo $this->session->flashdata('message'); ?>",
            type: "success",
            timer: 1500,
            showConfirmButton: false
        });
    </script>

<?php endif ?>

<script>

    $(document).ready(function () {
        $('#addEmployeeForm').on('submit', function (e) {
            e.preventDefault();
            var formData = new FormData(this);
            $('#loading').show();
            $.ajax({
                type: 'POST',
                url: "<?php echo base_url('admin/employee/add'); ?>",
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: function (data) {
                    $('#loading').hide();
                    swal({
                        title: "Success",
                        text: "L'employée a été bien ajouté",
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



        $('.profile_details-link').on('click', function () {
            var id = $(this).attr('data-id');
            document.location.href = "<?php echo base_url(); ?>admin/employee/show/" + id;
        });
    });

</script>


<script>
    $(document).ready(function () {
        $('button.deleteEmployee').on('click', deleteEmployee);


        function deleteEmployee() {
            var employee_id = $(this).attr('data-id');
            $(this).closest('tr').hide();
            swal({
                    title: "Attention ! ",
                    text: "Vous voulez vraiment supprimer cet employée ?",
                    type: "warning",
                    showConfirmButton: true,
                    showCancelButton: true,
                    cancelButtonText: 'Non',
                    confirmButtonText: 'Oui'
                },
                function () {
                    $.ajax({
                        url: "<?php echo base_url('admin/employee/apiDeleteEmployee'); ?>",
                        type: "POST",
                        dataType: "json",
                        data: {'employee_id': employee_id},
                        success: function (data) {
                            if (data.status === 'success') {
                                swal({
                                    title: "Success",
                                    text: "L'employée a été bien supprimé",
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

