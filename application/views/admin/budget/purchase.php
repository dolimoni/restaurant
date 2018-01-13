<?php $this->load->view('admin/partials/admin_header.php'); ?>
<style>
    .table-responsive {
        overflow-x: visible;
    }
</style>
<!-- page content -->
<div class="right_col" role="main">
    <div class="productsList">
        <div class="page-title">
            <div class="title_left">
                <h3>Liste des achats</h3>
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
            <form id="addPurchaseForm" enctype="multipart/form-data">
                <fieldset>
                    <div class="row">
                        <div class="col-md-4 col-sm-6 col-xs-12">
                            <br>
                            <label for="name">Article :</label>
                            <input type="text" class="form-control" name="article"
                                   placeholder="article"
                                   required>
                        </div>
                        <div class="col-md-4 col-sm-6 col-xs-12">
                            <br>
                            <label for="name">Quantité :</label>
                            <input type="text" class="form-control" name="quantity"
                                       placeholder="fournisseur" value="1"
                                   required>
                        </div>
                        <div class="col-md-4 col-sm-6 col-xs-12">
                            <br>
                            <label for="name">Prix total:</label>
                            <input type="text" step="any" class="form-control" name="price"
                                   placeholder="prix"
                                   required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 col-sm-6 col-xs-12">
                            <br>
                            <label for="name">Fournisseur :</label>
                            <input type="text" class="form-control" name="provider"
                                   placeholder="Nom du fournisseur"
                                   >
                        </div>
                        <div class="col-md-4 col-sm-6 col-xs-12">
                            <br>
                            <label for="name">Téléphone :</label>
                            <input type="text" class="form-control" name="tel"
                                   placeholder="Téléphone"
                                   >
                        </div>
                        <div class="col-md-4 col-sm-6 col-xs-12">
                            <br>
                            <label for="name">Commentaire:</label>
                            <input type="text" step="any" class="form-control" name="comment"
                                   placeholder="Commentaire"
                                   >
                        </div>
                    </div>
                    <br/>

                    <div class="text-right">
                        <input class="btn btn-success" type="submit" name="addPurchase" value="Confirmer"/>
                    </div>

                </fieldset>
            </form>
            <br>
        </div>
         <!-- /row -->
        <div class="row table-responsive">
            <table id="datatable-purchase" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                <thead>
                <tr>
                    <th>Article</th>
                    <th>Quantité</th>
                    <th>Prix</th>
                    <th>Fournisseur</th>
                    <th>Téléphone</th>
                    <th>Commentaire</th>
                    <th>Date</th>
                </tr>
                </thead>
                <tfoot>
                <tr>
                    <th>Article</th>
                    <th>Quantité</th>
                    <th>Prix</th>
                    <th>Fournisseur</th>
                    <th>Téléphone</th>
                    <th>Commentaire</th>
                    <th>Date</th>
                </tr>
                </tfoot>
                <tbody>
                   <?php foreach ($purchases as $purchase) { ?>
                       <tr>
                           <td><?php echo $purchase['article'];?></td>
                           <td><?php echo $purchase['quantity'];?></td>
                           <td><?php echo $purchase['price'];?>DH</td>
                           <td><?php echo $purchase['provider'];?></td>
                           <td><?php echo $purchase['tel'];?></td>
                           <td><?php echo $purchase['comment'];?></td>
                           <td><?php echo $purchase['created_at'];?></td>
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
            if ($("#datatable-purchase").length) {
                $("#datatable-purchase").DataTable({
                    aaSorting: [[0, 'desc']],
                    responsive: true,
                    "language": {
                        "url": "<?php echo base_url("assets/vendors/datatables.net/French.json"); ?>"
                    }
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
        $('#addPurchaseForm').on('submit', function (e) {
            e.preventDefault();
            var formData = new FormData(this);
            $.ajax({
                type: 'POST',
                url: "<?php echo base_url('admin/budget/apiAddPurchase'); ?>",
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: function (data) {
                    swal({
                        title: "Success",
                        text: "L'article a été bien ajouté",
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
