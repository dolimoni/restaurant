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
                <h3>Liste des agences</h3>
            </div>
        </div>
        <div class="clearfix"></div>
        <hr>

        <div class="collapse" id="editAgency">
            <form id="editAgencyForm" enctype="multipart/form-data">
                <fieldset>
                    <div class="row">
                        <input type="hidden" name="id"/>
                        <div class="col-xs-6">
                            <br>
                            <label for="name">Nom :</label>
                            <input type="text" step="any" class="form-control" name="agencyNameEdit"
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
                        <input class="btn btn-success" type="submit" name="editAgencyForm" value="Modifier"/>
                    </div>

                </fieldset>
            </form>
            <br>
        </div>

        <div class="row">
            <?php foreach ($agencies as $agency) { ?>
                <div class="col-md-4 col-sm-6 col-ms-6 col-xs-12 profile_details" data-id="<?php echo $agency['id']; ?>">
                    <div class="profile_view">
                        <div class="col-sm-12 profile_details-link" data-id="<?php echo $agency['id']; ?>">
                            <h4 class=""><i> <?php echo $agency['name']; ?> </i></h4>

                            <div class="right col-xs-12 text-center">
                                <img src="<?php echo base_url('assets/images/'. $agency['image']); ?>" alt=""
                                     class="img-responsive" style="width:100%;height:140px;">
                            </div>
                        </div>
                        <div class="col-xs-12 bottom text-right">
                            <div class="col-xs-12 col-sm-12 emphasis">
                                <!--<button data-id="<?php /*echo $agency['id']; */?>" type="button"
                                        class="btn btn-danger btn-xs deleteEmployee">
                                    <i class="fa fa-trash"> </i> Supprimer
                                </button>-->

                                <button data-id="<?php echo $agency['id']; ?>" type="button"
                                        data-name="<?php echo $agency['name'] ?>"
                                        class="btn btn-success btn-xs showAgency">
                                    <i class="fa fa-eye"> </i> Afficher
                                </button>

                                <button data-id="<?php echo $agency['id']; ?>" type="button"
                                        data-name="<?php echo $agency['name'] ?>"
                                        class="btn btn-info btn-xs editAgency">
                                    <i class="fa fa-edit"> </i> modifier
                                </button>

                                <button data-id="<?php echo $agency['id']; ?>" type="button"
                                        class="btn btn-danger btn-xs deleteAgency hidden" >
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


        $('#editAgencyForm').on('submit', function (e) {
            e.preventDefault();
            $('#loading').show();
            var formData = new FormData(this);
            $.ajax({
                type: 'POST',
                url: "<?php echo base_url('admin/agency/apiEditAgency'); ?>",
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
                            $('#loading').hide();
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

        $(".editAgency").on('click', editAgencyEvent);
        var l_id = -1;

        function editAgencyEvent() {
            if ($(this).attr('data-id') === l_id || l_id === -1) {
                $('#editAgency').toggle('slow');
            }
            l_id = $(this).attr('data-id');

            $('input[name="agencyNameEdit"]').val($(this).attr('data-name'));
            $('input[name="id"]').val($(this).attr('data-id'));
        }

        $('.profile_details-link,.showAgency').on('click', function () {
            var id = $(this).attr('data-id');
            document.location.href = "<?php echo base_url(); ?>admin/agency/show/" + id;
        });
    });

</script>





<script>
    $(document).ready(function () {
        $('button.deleteAgency').on('click', deleteAgency);


        function deleteAgency() {
            var agency_id = $(this).attr('data-id');
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
                        url: "<?php echo base_url('admin/agency/apiDeleteAgency'); ?>",
                        type: "POST",
                        dataType: "json",
                        data: {'agency_id': agency_id},
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

