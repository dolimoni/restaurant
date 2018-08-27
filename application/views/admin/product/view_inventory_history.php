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
                <h3>Historique d'inventaire</h3>
            </div>
        </div>
        <div class="clearfix"></div>
        <hr>
         <!-- /row -->
        <div class="row table-responsive">
            <table id="datatable-purchase" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                <thead>
                <tr>
                    <th>Produit</th>
                    <th>Quantité initiale</th>
                    <th>Quantité finale</th>
                    <th>Différence</th>
                    <th>Quantité actuelle</th>
                    <th>Date d'inventaire</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tfoot>
                <tr>
                    <th>Produit</th>
                    <th>Quantité initiale</th>
                    <th>Quantité finale</th>
                    <th>Différence</th>
                    <th>Quantité actuelle</th>
                    <th>Date d'inventaire</th>
                    <th>Actions</th>
                </tr>
                </tfoot>
                <tbody>
                   <?php foreach ($products as $product) {
                       $status="success";
                       if($product['delta']<0){
                           $status="danger";
                       }
                       ?>
                       <tr class="<?php echo $status ?>">
                           <td><?php echo $product['name'];?></td>
                           <td><?php echo $product['initial_stock'];?></td>
                           <td><?php echo $product['final_stock'];?></td>
                           <td><?php echo $product['delta'];?></td>
                           <td><?php echo number_format($product['totalQuantity'], 2); ?></td>
                           <td><?php echo $product['inventory_date'];?></td>
                           <td>
                               <a href=" <?php echo base_url('admin/product/statistic/' . $product['product']); ?>"
                                  class="btn btn-warning btn-xs">Statistiques</a>
                           </td>
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
                    aaSorting: [[5, 'desc']],
                    responsive: true,
                    "lengthMenu": [[25, 50, 200, -1], [25, 50, 200, "Tout"]],
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

