<?php $this->load->view('admin/partials/admin_header.php'); ?>
<!-- page content -->
<div class="right_col" role="main">
    <div class="productsList">

        <!-- /row -->

        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Historique des entrées sorties</h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                            <li><a class="close-link"><i class="fa fa-close"></i></a></li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content table-products">
                        <table id="datatable-products" class="table table-striped table-bordered dt-responsive nowrap"
                               cellspacing="0" width="100%">
                           <thead>
                               <tr>
                                   <th>
                                       Produit
                                   </th>
                                   <th>
                                       Département
                                   </th>
                                   <th>
                                       Quantité
                                   </th>
                                   <th>
                                       Date
                                   </th>
                                   <th>
                                       Type
                                   </th>
                               </tr>
                           </thead>
                            <tfoot>
                               <tr>
                                   <th>
                                       Produit
                                   </th>
                                   <th>
                                       Département
                                   </th>
                                   <th>
                                       Quantité
                                   </th>
                                   <th>
                                       Date
                                   </th>
                                   <th>
                                       Type
                                   </th>
                               </tr>
                           </tfoot>

                           <tbody>
                           <?php foreach ($products as $product) {?>
                               <tr class="success">
                                   <td><?php echo $product['p_name']; ?></td>
                                   <td><?php echo $product['d_name']; ?></td>
                                   <td><?php echo $product['quantity'] ?></td>
                                   <td><?php echo $product['date'] ?></td>
                                   <td>
                                       <?php if($product['type']==="out"){ ?>
                                           <img class="arrow-left correctMeal" src="<?php echo base_url('assets/images/arrow-right.png'); ?>" />
                                       <?php }else{ ?>
                                           <img class="arrow-left correctMeal" src="<?php echo base_url('assets/images/arrow-left.png'); ?>" />
                                       <?php } ?>
                                   </td>
                               </tr>
                           <?php } ?>
                           </tbody>
                        </table>
                    </div> <!-- /content -->
                </div><!-- /x-panel -->
            </div> <!-- /col -->
        </div>
    </div>
</div> <!-- /.col-right -->
<!-- /page content -->

<?php $this->load->view('admin/partials/admin_footer'); ?>

<script src="<?php echo base_url("assets/vendors/datatables.net/js/jquery.dataTables.min.js"); ?>"></script>
<script>
    $(document).ready(function () {
        var handleDataTableButtons = function () {
            if ($("#datatable-products").length) {
                $("#datatable-products").DataTable({
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
