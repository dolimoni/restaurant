<?php $this->load->view('admin/partials/admin_header.php'); ?>
<style>
    .profile_details:nth-child(3n) {
        clear: none;
    }
    .profile_details-link{
        min-height: 178px;
    }
</style>
<!-- page content -->
<div class="right_col" role="main">
    <div class="productsList">
        <div class="page-title">

            <div class="title_left">
                <h3>Liste des employés</h3>
                <label for="exampleInputName2">Rechercher</label>
                <input type="text" placeholder="Nom de l'employé" class="form-control" id="searchInput"
                       onkeyup="myFunction()">
            </div>
        </div>
        <div class="clearfix"></div>
        <hr>
        <div class="article-title">
            <a class="btn btn-primary" data-toggle="collapse" href="#collapseExample" aria-expanded="false"
               aria-controls="collapseExample">Nouveau employée</a>
            <a class="btn btn-info" href="<?php echo base_url("admin/employee/all"); ?>">Liste des employées</a>
        </div>
        <div class="collapse" id="collapseExample">
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
                                   >
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-xs-4">
                            <br>
                            <label for="name">Adresse :</label>
                            <input type="text" class="form-control" name="address"
                                   placeholder="Adresse"
                                   >
                        </div>
                        <div class="col-xs-4">
                            <br>
                            <label for="name">Téléphone :</label>
                            <input type="text" class="form-control" name="phone"
                                   placeholder="Téléphone"
                                   >
                        </div>
                        <div class="col-xs-4">
                            <br>
                            <label for="name">Salaire :</label>
                            <input type="text" class="form-control" name="salary"
                                   placeholder="Salaire"
                                   >
                        </div>


                    </div>
                    <div class="row">
                        <div class="col-xs-4">
                            <br>
                            <label for="name">Type de travail :</label>
                            <input type="text" class="form-control" name="workType"
                                   placeholder="Type de travail"
                                   >
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
        <div class="collapse" id="editProvider">
            <form id="editProviderForm" enctype="multipart/form-data">
                <fieldset>
                    <div class="row">
                        <input type="hidden" name="id"/>
                        <div class="col-xs-4">
                            <br>
                            <label for="name">Nom :</label>
                            <input type="text" class="form-control" name="name"
                                   placeholder="Nom" required>
                        </div>
                        <div class="col-xs-4">
                            <br>
                            <label for="name">Prénom :</label>
                            <input type="text" step="any" class="form-control" name="prenom"
                                   placeholder="Prénom"
                            >
                        </div>
                        <div class="col-xs-4">
                            <br>
                            <label for="name">CIN :</label>
                            <input type="text" step="any" class="form-control" name="cin"
                                   placeholder="CIN"
                            >
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-xs-4">
                            <br>
                            <label for="name">Adresse :</label>
                            <input type="text" class="form-control" name="address"
                                   placeholder="Adresse"
                            >
                        </div>
                        <div class="col-xs-4">
                            <br>
                            <label for="name">Téléphone :</label>
                            <input type="text" class="form-control" name="phone"
                                   placeholder="Téléphone"
                            >
                        </div>
                        <div class="col-xs-4">
                            <br>
                            <label for="name">Salaire :</label>
                            <input type="text" class="form-control" name="salary"
                                   placeholder="Salaire"
                            >
                        </div>


                    </div>
                    <div class="row">
                        <div class="col-xs-4">
                            <br>
                            <label for="workType">Type de travail :</label>
                            <input type="text" class="form-control" name="workType">
                        </div>

                        <div class="col-xs-4">
                            <br>
                            <label for="image">Image :</label>
                            <input type="file" class="form-control" name="image" size="10485760">
                        </div>
                    </div>
                    <br/>

                    <div class="text-right">
                        <input class="btn btn-success" type="submit" name="editProvider" value="Modifier"/>
                    </div>

                </fieldset>
            </form>
            <br>
        </div>
        <div class="row">
            <?php foreach ($employees as $employee) { ?>
                <div class="col-md-4 col-sm-4 col-xs-12 profile_details" data-name="<?php echo $employee['name']." ". $employee['prenom']; ?>" data-id="<?php echo $employee['id']; ?>">
                    <div class="well profile_view">
                        <div class="col-sm-12 profile_details-link" data-id="<?php echo $employee['id']; ?>">
                            <h4 class="brief"><i> <?php echo $employee['workType']; ?> </i></h4>
                            <div class="left col-xs-7">
                                <h2><?php echo $employee['name']; ?> <?php echo $employee['prenom']; ?></h2>
                                <p><?php echo $employee['cin']; ?></p>
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
                        <div class="col-xs-12 bottom text-right">
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
                            <div class="col-xs-12 col-sm-7 emphasis">
                                <button aria-expanded="false"
                                        data-id="<?php echo $employee['id'] ?>"
                                        data-name="<?php echo $employee['name'] ?>"
                                        data-prenom="<?php echo $employee['prenom'] ?>"
                                        data-cin="<?php echo $employee['cin'] ?>"
                                        data-address="<?php echo $employee['address'] ?>"
                                        data-phone="<?php echo $employee['phone'] ?>"
                                        data-salary="<?php echo $employee['salary'] ?>"
                                        data-workType="<?php echo $employee['workType'] ?>"
                                        type="button"
                                        class="btn btn-info btn-xs editProvider">
                                    <i class="fa fa-edit"> </i> Modifier
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

        $('#editProviderForm').on('submit', function (e) {
            e.preventDefault();
            var formData = new FormData(this);
            $('#loading').show();
            $.ajax({
                type: 'POST',
                url: "<?php echo base_url('admin/employee/apiEditMainEmployee'); ?>",
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: function (data) {
                    $('#loading').hide();
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
                },
                error: function (data) {
                    $('#loading').hide();
                    swal({
                        title: "Erreur",
                        text: "Une erreur s'est produit",
                        type: "error",
                        timer: 1500,
                        showConfirmButton: false
                    });
                }
            });

        })

        $('.showProvider').on('click', function () {
            var id = $(this).attr('data-id');
            document.location.href = "<?php echo base_url('admin/provider/show/'); ?>" + "/" + id;
        });

        /*Edit group*/

        $(".editProvider").on('click', editProviderEvent);
        var l_id = -1;

        function editProviderEvent() {
            if ($(this).attr('data-id') === l_id || l_id === -1) {
                $('#editProvider').toggle('slow');
            }
            l_id = $(this).attr('data-id');

            var l_title = 0;
            if ($(this).attr('data-title') !== "") {
                l_title = $(this).attr('data-title');
            }
            $('#editProvider input[name="name"]').val($(this).attr('data-name'));
            $('#editProvider input[name="prenom"]').val($(this).attr('data-prenom'));
            $('#editProvider input[name="cin"]').val($(this).attr('data-cin'));
            $('#editProvider input[name="address"]').val($(this).attr('data-address'));
            $('#editProvider input[name="phone"]').val($(this).attr('data-phone'));
            $('#editProvider input[name="salary"]').val($(this).attr('data-salary'));
            $('#editProvider input[name="workType"]').val($(this).attr('data-workType'));
            $('#editProvider input[name="id"]').val($(this).attr('data-id'));

            scroll("editProvider");
        }

        // This is a functions that scrolls to #{blah}link
        function scroll(id) {
            // Scroll
            $('html,body').animate({scrollTop: $("#" + id).offset().top}, 'slow');
        }

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
                    $('#loading').show();
                    $.ajax({
                        url: "<?php echo base_url('admin/employee/apiDeleteEmployee'); ?>",
                        type: "POST",
                        dataType: "json",
                        data: {'employee_id': employee_id},
                        success: function (data) {
                            $('#loading').hide();
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


        }
    });
</script>


<!--Search in table-->
<script>
    function myFunction() {
        var input, filter, table, tr, td, i;
        input = document.getElementById("searchInput");
        filter = input.value.toUpperCase();
        profiles = document.getElementsByClassName("profile_details");
        for (i = 0; i < profiles.length; i++) {
            profile = profiles[i].getAttribute("data-name");
            if (profile) {
                if (profile.toUpperCase().indexOf(filter) > -1) {
                    profiles[i].style.display = "";
                } else {
                    profiles[i].style.display = "none";
                }
            }
        }
    }
</script>
