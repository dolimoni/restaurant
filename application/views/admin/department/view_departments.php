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
            <pre>
                <?php print_r($departments); ?>
            </pre>
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
        <div class="row">
            <?php foreach ($departments as $department) { ?>
                <div class="col-md-3 col-sm-4 col-xs-12 profile_details" data-id="<?php echo $department['id']; ?>">
                    <div class="well profile_view">
                        <div class="col-sm-12 profile_details-link" data-id="<?php echo $department['id']; ?>">
                            <h4 class="brief"><i> <?php echo $department['name']; ?> </i></h4>

                            <div class="right col-xs-12 text-center">
                                <img src="<?php echo base_url('assets/images/'. $department['image']); ?>" alt=""
                                     class="img-responsive">
                            </div>
                        </div>
                        <div class="col-xs-12 bottom text-left">
                            <div class="col-xs-12 col-sm-6 emphasis">
                                <!--<button data-id="<?php /*echo $department['id']; */?>" type="button"
                                        class="btn btn-danger btn-xs deleteEmployee">
                                    <i class="fa fa-trash"> </i> Supprimer
                                </button>-->

                                <button data-id="<?php echo $department['id']; ?>" type="button"
                                        class="btn btn-info btn-xs editDepartment">
                                    <i class="fa fa-edit"> </i> modifier
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



        $('.profile_details-link').on('click', function () {
            var id = $(this).attr('data-id');
            document.location.href = "<?php echo base_url(); ?>admin/department/show/" + id;
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
                    text: "Vous voulez vraiment supprimer ce département ?",
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

