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
                <h3><?= lang('agencies_list'); ?></h3>
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
                            <label for="name"><?= lang('name'); ?> :</label>
                            <input type="text" step="any" class="form-control" name="agencyNameEdit"
                                   placeholder="Nom du département"
                                   required>
                        </div>

                        <div class="col-xs-6">
                            <br>
                            <label for="image"><?= lang('image'); ?> :</label>
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
            <table class="table table-bordered table-striped">
                <tr>
                    <td>Nom</td>
                </th>
            <?php foreach ($agencies as $agency) { ?>
                <tr>
                    <td><?php echo $agency['name']; ?></td>
                </tr>
            <?php } ?>
            </table>

        </div> <!-- /row -->
    </div>
</div>


<?php $this->load->view('admin/partials/admin_footer'); ?>
<style>
    var activateAgency_url="<?php echo base_url('admin/agency/apiActivate'); ?>";
</style>

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

        $('.profile_details-link,.activateAgency').on('click', function () {
            var id = $(this).attr('data-id');
            var activateAgency=activateAgency_url;
            apiRequest(activateAgency,{'id':id});
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

