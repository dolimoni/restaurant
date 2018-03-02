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
           <!-- <pre>
                <?php /*print_r($products); */?>
            </pre>-->
            <div class="title_left">
                <h3>Liste des produits achetés</h3>
            </div>
        </div>
        <div class="clearfix"></div>
        <hr>
         <!-- /row -->
        <div class="row table-responsive">
            <table id="datatable-product" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                <thead>
                <tr>
                    <th>Produit</th>
                    <th>Quantité</th>
                    <th>Prix total</th>
                    <th>Fournisseur</th>
                    <th>Date</th>
                </tr>
                </thead>
                <tfoot>
                <tr>
                    <th>Produit</th>
                    <th>Quantité</th>
                    <th>Prix total</th>
                    <th>Fournisseur</th>
                    <th>Date</th>
                </tr>
                </tfoot>
                <tbody>
                   <?php foreach ($products as $product) { ?>
                       <tr>
                           <td><?php echo ucfirst($product['name']);?></td>
                           <td><?php echo $product['quantity']."". $product['unit'];?></td>
                           <td><?php echo $product['total'];?>DH</td>
                           <td><?php echo ucfirst($product['pv_name']);?></td>
                           <td><?php echo ucfirst($product['created_at']);?></td>
                           <!--<td data-purchase-id="<?php /*echo $product["sh_id"]; */?>"
                               data-product-id="<?php /*echo $product["p_id"]; */?>">
                               <button class="btn btn-danger btn-xs action deletePurchase small-button"
                                       data-type="delete"><span
                                           class="fa fa-trash"></span>Supprimer</button>
                           </td>-->
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
            if ($("#datatable-product").length) {
                $("#datatable-product").DataTable({
                    responsive: true,
                    "bSort": false,
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
        $('button.deletePurchase').on('click', deletePurchaseEvent);

        function deletePurchaseEvent() {
            var product_id = $(this).closest('tr').attr('data-product-id');
            var purchase_id = $(this).closest('tr').attr('data-purchase-id');
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
                    $.ajax({
                        url: "<?php echo base_url('admin/budget/apiDeletePurchase'); ?>",
                        type: "POST",
                        dataType: "json",
                        data: {'purchase_id': purchase_id,'product_id': product_id},
                        success: function (data) {
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

