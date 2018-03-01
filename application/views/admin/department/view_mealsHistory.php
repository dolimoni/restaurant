<?php $this->load->view('admin/partials/admin_header.php'); ?>
<!-- page content -->
<div class="right_col" role="main">
    <div class="productsList">

        <!-- /row -->

        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Historique des articles préparés</h2>
                        <ul class="nav navbar-right panel_toolbox">
                           <!-- <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                            <li><a class="close-link"><i class="fa fa-close"></i></a></li>-->
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content table-products">
                        <table id="datatable-products" class="table table-striped table-bordered dt-responsive nowrap"
                               cellspacing="0" width="100%">
                           <thead>
                               <tr>
                                   <th>Nom</th>
                                   <th>Quantité préparée</th>
                                   <th>Quantité vendu</th>
                                   <th>Quantité restante</th>
                                   <th>En Stock</th>
                                   <th>En vente</th>
                                   <th>Perte</th>
                                   <th>Date</th>
                                   <th>Actions</th>
                               </tr>
                           </thead>
                            <tfoot>
                               <tr>
                                   <th>Nom</th>
                                   <th>Quantité préparée</th>
                                   <th>Quantité vendu</th>
                                   <th>Quantité restante</th>
                                   <th>En Stock</th>
                                   <th>En vente</th>
                                   <th>Perte</th>
                                   <th>Date</th>
                                   <th>Actions</th>
                               </tr>
                           </tfoot>

                           </tbody>
                            <tbody>
                            <?php foreach ($mealsHistory as $meal) {


                                $remainingQuantity = number_format((float)$meal['prepared_quantity'], 0, '.', '') - number_format((float)$meal['consumption_quantity'], 0, '.', '');
                                $saleRemainingQuantity = number_format((float)($remainingQuantity - $meal['quantityInMagazin'] - $meal['lost_quantity']), 0, '.', '');
                                if ($remainingQuantity < 0) {
                                    $remainingQuantity = 0;
                                }
                                ?>
                                <tr>
                                    <td><?php echo $meal['name']; ?></td>
                                    <td><?php echo number_format((float)$meal['prepared_quantity'], 0, '.', '') ?></td>
                                    <td><?php echo number_format((float)$meal['consumption_quantity'], 0, '.', '') ?></td>
                                    <td><?php echo $remainingQuantity ?></td>
                                    <td><?php echo number_format((float)$meal['quantityInMagazin'], 0, '.', '') ?></td>
                                    <td><?php echo $saleRemainingQuantity ?></td>
                                    <td><?php echo $meal['lost_quantity'] ?></td>
                                    <td><?php echo $meal["date"]; ?></td>
                                    <td>
                                        <?php if($saleRemainingQuantity>0){ ?>
                                        <button data-id="<?php echo $meal['meal']; ?>" type="button"
                                                data-quantity="<?php echo $meal['quantityInMagazin']+$saleRemainingQuantity; ?>"
                                                data-report-date="<?php echo $meal["date"]; ?>"
                                                class="btn btn-danger btn-xs lostMeal">
                                            <i class="fa fa-long-arrow-right"> </i> Déclarer comme pertes
                                        </button>
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


<script>
    $(document).ready(function () {
        $('button.lostMeal').on('click', lostMeal);


        function lostMeal() {
            var meal_id = $(this).attr('data-id');
            var report_date = $(this).attr('data-report-date');
            var quantity = $(this).attr('data-quantity');
            swal({
                    title: "Attention ! ",
                    text: "Vous voulez vraiment déclarer cette quantité comme une perte ?",
                    type: "warning",
                    showConfirmButton: true,
                    showCancelButton: true,
                    cancelButtonText: 'Non',
                    confirmButtonText: 'Oui'
                },
                function () {
                    $('#loading').show();
                    var meal= {
                        'meal_id': meal_id,
                        'report_date': report_date,
                        'quantity': quantity,
                    };
                    console.log(meal);
                    $.ajax({
                        url: "<?php echo base_url('admin/department/apiAddLostQuantity'); ?>",
                        type: "POST",
                        dataType: "json",
                        data: {'meal': meal},
                        success: function (data) {
                            if (data.status === 'success') {
                                swal({
                                    title: "Success",
                                    text: "L'opération a été bien effecutées",
                                    type: "success",
                                    timer: 1500,
                                    showConfirmButton: false
                                });
                                location.reload();
                                $(this).closest('tr').hide();
                            }
                            else {
                                $('#loading').hide();
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
                        },
                        complete: function () {

                        }
                    });

                });


        }
    });
</script>
