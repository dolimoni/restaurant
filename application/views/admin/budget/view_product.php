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
                           <td><?php echo $product['name'];?></td>
                           <td><?php echo $product['quantity']."". $product['unit'];?></td>
                           <td><?php echo $product['total'];?>DH</td>
                           <td><?php echo $product['pv_name'];?></td>
                           <td><?php echo $product['created_at'];?></td>
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

