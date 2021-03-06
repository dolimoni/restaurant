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
                    <div class="row">
                        <div class="col-md-4 col-sm-6 col-xs-12">
                            <br>
                            <label for="paid">Réglement :</label>
                            <select name="paid" class="form-control">
                                <option value="false">Impayé</option>
                                <option value="true">Payé</option>
                            </select>
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
        <div class="collapse" id="editPurchase">
            <form id="editPurchaseForm">
                <fieldset>

                    <div class="row">
                        <input type="hidden" name="id"/>
                        <div class="col-md-4 col-sm-6 col-xs-12">
                            <br>
                            <label for="name">Article :</label>
                            <input type="text" class="form-control" name="articleEdit"
                                   placeholder="article"
                                   required>
                        </div>
                        <div class="col-md-4 col-sm-6 col-xs-12">
                            <br>
                            <label for="name">Quantité :</label>
                            <input type="text" class="form-control" name="quantityEdit"
                                   placeholder="fournisseur" value="1"
                                   required>
                        </div>
                        <div class="col-md-4 col-sm-6 col-xs-12">
                            <br>
                            <label for="name">Prix total:</label>
                            <input type="text" step="any" class="form-control" name="priceEdit"
                                   placeholder="prix"
                                   required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 col-sm-6 col-xs-12">
                            <br>
                            <label for="name">Fournisseur :</label>
                            <input type="text" class="form-control" name="providerEdit"
                                   placeholder="Nom du fournisseur"
                            >
                        </div>
                        <div class="col-md-4 col-sm-6 col-xs-12">
                            <br>
                            <label for="name">Téléphone :</label>
                            <input type="text" class="form-control" name="telEdit"
                                   placeholder="Téléphone"
                            >
                        </div>
                        <div class="col-md-4 col-sm-6 col-xs-12">
                            <br>
                            <label for="name">Commentaire:</label>
                            <input type="text" step="any" class="form-control" name="commentEdit"
                                   placeholder="Commentaire"
                            >
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 col-sm-6 col-xs-12">
                            <br>
                            <label for="paid">Réglement :</label>
                            <select name="paid" class="form-control">
                                <option value="false">Impayé</option>
                                <option value="true">Payé</option>
                            </select>
                        </div>
                    </div>
                    <br/>

                    <div class="text-right">
                        <input class="btn btn-success" type="submit" name="addPurchase" value="Modifier"/>
                    </div>
                </fieldset>
            </form>
            <br>
        </div>
         <!-- /row -->
        <div class="row">
            <div class="x_panel">
                <div class="x_content">
                    <div class="table-responsive">
                        <table id="datatable-purchase" class="table table-striped table-bordered dt-responsive nowrap"
                               cellspacing="0" width="100%">
                            <thead>
                            <tr>
                                <th>Article</th>
                                <th>Quantité</th>
                                <th>Prix</th>
                                <th>Fournisseur</th>
                                <th>Téléphone</th>
                                <th>Commentaire</th>
                                <th>Réglement</th>
                                <th>Date de commande</th>
                                <th>Date de paiement</th>
                                <th>Actions</th>
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
                                <th>Réglement</th>
                                <th>Date de commande</th>
                                <th>Date de paiement</th>
                                <th>Actions</th>
                            </tr>
                            </tfoot>
                            <tbody>
                            <?php foreach ($purchases as $purchase) {
                                $paid = "Impayé";
                                if ($purchase['paid'] === "true") {
                                    $paid = "Payé";
                                }
                                ?>
                                <tr data-id="<?php echo $purchase["id"]; ?>">
                                    <td data-article="<?php echo $purchase['article']; ?>"><?php echo $purchase['article']; ?></td>
                                    <td data-quantity="<?php echo $purchase['quantity']; ?>"><?php echo $purchase['quantity']; ?></td>
                                    <td data-price="<?php echo $purchase['price']; ?>"><?php echo $purchase['price']; ?>
                                        DH
                                    </td>
                                    <td data-provider="<?php echo $purchase['provider']; ?>"><?php echo $purchase['provider']; ?></td>
                                    <td data-tel="<?php echo $purchase['tel']; ?>"><?php echo $purchase['tel']; ?></td>
                                    <td data-comment="<?php echo $purchase['comment']; ?>"><?php echo $purchase['comment']; ?></td>
                                    <td data-paid="<?php echo $purchase['paid']; ?>"><?php echo $paid; ?></td>
                                    <td><?php echo $purchase['created_at']; ?></td>
                                    <td><?php echo $purchase['paymentDate']; ?></td>
                                    <td>
                                        <button class="btn btn-info btn-xs action editPurchase small-button"
                                                data-type="edit"><span
                                                    class="glyphicon glyphicon-edit"></span></button>
                                        <button class="btn btn-danger btn-xs action deletePurchase small-button"
                                                data-type="delete"><span
                                                    class="fa fa-trash"></span></button>
                                    </td>
                                </tr>
                            <?php } ?>
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Historique
                            <small>Historique de commande</small>
                        </h2>
                        <div class="filter">
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <div class="col-xs-12">
                            <div class="demo-container" style="height:280px">
                                <div id="chart_plot_05" class="demo-placeholder"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<?php $this->load->view('admin/partials/admin_footer'); ?>
<script src="<?php echo base_url('assets/build2/js/budget/purchase/variousPurchase.js'); ?>"></script>

<!-- bootstrap-daterangepicker -->
<script src="<?php echo base_url('assets/vendors/moment/min/moment.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/vendors/bootstrap-daterangepicker/daterangepicker.js'); ?>"></script>
<script>
    var base_url = "<?php echo base_url(); ?>";
    <?php
    $js_array = json_encode($report);
    echo "var report = " . $js_array . ";\n";
    ?>
</script>


<!-- Flot -->
<script src="<?php echo base_url('assets/vendors/Flot/jquery.flot.js'); ?>"></script>
<script src="<?php echo base_url('assets/vendors/Flot/jquery.flot.pie.js'); ?>"></script>
<script src="<?php echo base_url('assets/vendors/Flot/jquery.flot.time.js'); ?>"></script>
<script src="<?php echo base_url('assets/vendors/Flot/jquery.flot.stack.js'); ?>"></script>
<script src="<?php echo base_url('assets/vendors/Flot/jquery.flot.resize.js'); ?>"></script>

<!-- DateJS -->
<script src="<?php echo base_url('assets/vendors/DateJS/build/date.js'); ?>"></script>


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
            $('#loading').show();
            $.ajax({
                type: 'POST',
                url: "<?php echo base_url('admin/budget/apiAddPurchase'); ?>",
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: function (data) {
                    $('#loading').hide();
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
                    $('#loading').hide();
                    console.log("error");
                    console.log(data);
                }
            });

        });


        $('.profile_details').on('click', function () {
            var id = $(this).attr('data-id');
            document.location.href = "<?php echo base_url(); ?>admin/employee/show/" + id;
        });


        $('#editPurchaseForm').on('submit', function (e) {
            e.preventDefault();
            var validForm = true;

            var purchase = {
                'article': $("#editPurchaseForm input[name='articleEdit']").val(),
                'quantity': $("#editPurchaseForm input[name='quantityEdit']").val(),
                'price': $("#editPurchaseForm input[name='priceEdit']").val(),
                'provider': $("#editPurchaseForm input[name='providerEdit']").val(),
                'tel': $("#editPurchaseForm input[name='telEdit']").val(),
                'comment': $("#editPurchaseForm input[name='commentEdit']").val(),
                'paid': $("#editPurchaseForm select[name='paid']").val(),
            }
            if (validForm) {
                $('#loading').show();
                $.ajax({
                    type: 'POST',
                    url: "<?php echo base_url('admin/budget/apiEditPurchase'); ?>",
                    data: {purchase: purchase, 'id': $("#editPurchaseForm input[name='id']").val()},
                    dataType: "json",
                    success: function (data) {
                        $('#loading').hide();
                        if (data.status === "success") {
                            swal({
                                title: "Success",
                                text: "L'opération a été bien effectuée",
                                type: "success",
                                timer: 1500,
                                showConfirmButton: false
                            });
                            location.reload();
                        } else {
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
                        $('#loading').show();
                        swal({
                            title: "Erreur",
                            text: "Une erreur s'est produite",
                            type: "error",
                            timer: 1500,
                            showConfirmButton: false
                        });
                    }
                });
            }

        });


        /*Edit Alerte*/
        $(".editPurchase").on('click', editPurchaseEvent);
        var l_id = -1;

        function editPurchaseEvent() {
            if ($(this).attr('data-id') === l_id || l_id === -1) {
                $('#editPurchase').toggle('slow');
            }
            l_id = $(this).closest('tr').attr('data-id');
            var row = $(this).closest('tr');
            $('#editPurchase input[name="articleEdit"]').val(row.find("[data-article]").attr('data-article'));
            $('#editPurchase input[name="quantityEdit"]').val(row.find("[data-quantity]").attr('data-quantity'));
            $('#editPurchase input[name="priceEdit"]').val(row.find("[data-price]").attr('data-price'));
            $('#editPurchase input[name="providerEdit"]').val(row.find("[data-provider]").attr('data-provider'));
            $('#editPurchase input[name="telEdit"]').val(row.find("[data-tel]").attr('data-tel'));
            $('#editPurchase input[name="commentEdit"]').val(row.find("[data-comment]").attr('data-comment'));
            $('#editPurchase select[name="paid"]').val(row.find("[data-paid]").attr('data-paid'));
            $('#editPurchase input[name="id"]').val(l_id);
        }

        $('button.deletePurchase').on('click', deletePurchaseEvent);
        function deletePurchaseEvent() {
            var purchase_id = $(this).closest('tr').attr('data-id');
            swal({
                    title: "Attention ! ",
                    text: "Vous voulez vraiment supprimer ?",
                    type: "warning",
                    showConfirmButton: true,
                    showCancelButton: true,
                    cancelButtonText: 'Non',
                    confirmButtonText: 'Oui'
                },
                function () {
                    $('#loading').show();
                    $.ajax({
                        url: "<?php echo base_url('admin/budget/apiDeletePurchase'); ?>",
                        type: "POST",
                        dataType: "json",
                        data: {'purchase_id': purchase_id},
                        success: function (data) {
                            $('#loading').hide();
                            if (data.status === 'success') {
                                swal({
                                    title: "Success",
                                    text: "L'opération a été bien effectuée",
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
