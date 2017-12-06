<?php $this->load->view('admin/partials/admin_header.php'); ?>
<!-- page content -->
<div class="right_col" role="main">
    <div class="productsList">
        <div class="page-title">
            <div class="title_left">
                <h3>Liste des réparations</h3>
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
            <form id="addReparationForm" enctype="multipart/form-data">
                <fieldset>
                    <div class="row">
                        <div class="col-xs-4">
                            <br>
                            <label for="name">Article :</label>
                            <input type="text" class="form-control" name="article"
                                   placeholder="article"
                                   required>
                        </div>
                        <div class="col-xs-4">
                            <br>
                            <label for="name">Prix :</label>
                            <input type="text" step="any" class="form-control" name="price"
                                   placeholder="prix"
                                   required>
                        </div>
                        <div class="col-xs-4">
                            <br>
                            <label for="name">Problème :</label>
                            <input type="text" class="form-control" name="problem"
                                   placeholder="problème"
                                   required>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-xs-4">
                            <br>
                            <label for="name">Réparateur :</label>
                            <input type="text" class="form-control" name="repairer"
                                   placeholder="réparateur"
                                   required>
                        </div>
                    </div>
                    <br/>

                    <div class="text-right">
                        <input class="btn btn-success" type="submit" name="addReparation" value="Confirmer"/>
                    </div>

                </fieldset>
            </form>
            <br>
        </div>
         <!-- /row -->
        <div class="row">
            <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                <thead>
                <tr>
                    <th>Article</th>
                    <th>Prix</th>
                    <th>Problème</th>
                    <th>Réparateur</th>
                    <th>Date</th>
                </tr>
                </thead>
                <tfoot>
                <tr>
                    <th>Article</th>
                    <th>Prix</th>
                    <th>Problème</th>
                    <th>Réparateur</th>
                    <th>Date</th>
                </tr>
                </tfoot>
                <tbody>
                   <?php foreach ($reparations as $reparation) { ?>
                       <tr>
                           <td><?php echo $reparation['article'];?></td>
                           <td><?php echo $reparation['price'];?></td>
                           <td><?php echo $reparation['problem'];?></td>
                           <td><?php echo $reparation['repairer'];?></td>
                           <td><?php echo $reparation['created_at'];?></td>
                       </tr>
                   <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>


<?php $this->load->view('admin/partials/admin_footer'); ?>

<script src="<?php echo base_url("assets/vendors/datatables.net/js/jquery.dataTables.min.js"); ?>"></script>
<script>
    $(document).ready(function () {
        var handleDataTableButtons = function () {
            if ($("#datatable-salary").length) {
                $("#datatable-salary").DataTable({
                    aaSorting: [[0, 'desc']],
                    responsive: true,
                });
            }
        };

        TableManageButtons = function () {
            "use strict";
            return {

                init: function () {
                    handleDataTableButtons();
                }
            };
        }();

        TableManageButtons.init();
    });
</script>


<script>

    $(document).ready(function () {
        $('#addReparationForm').on('submit', function (e) {
            e.preventDefault();
            var formData = new FormData(this);
            $.ajax({
                type: 'POST',
                url: "<?php echo base_url('admin/budget/apiAddRepartion'); ?>",
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: function (data) {
                    swal({
                        title: "Success",
                        text: "La réparation a été bien ajouté",
                        type: "success",
                        timer: 1500,
                        showConfirmButton: false
                    });
                    location.reload();
                },
                error: function (data) {
                    console.log("error");
                    console.log(data);
                }
            });

        });


        $('.profile_details').on('click', function () {
            var id = $(this).attr('data-id');
            document.location.href = "<?php echo base_url(); ?>admin/employee/show/" + id;
        });
    });

</script>
