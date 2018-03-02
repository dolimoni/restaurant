<?php $this->load->view('admin/partials/admin_header.php'); ?>
<!-- page content -->
<div class="right_col" role="main">
    <div class="productsList">

         <!-- /row -->



        <div class="row">
            <div class="col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Mes fiches techniques</h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                            <li><a class="close-link"><i class="fa fa-close"></i></a></li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content table-responsive">
                        <table id="datatable-responsivee"
                               class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0"
                               width="100%">
                            <thead>
                            <tr>
                                <th>Nom</th>
                                <th>Famille</th>
                                <th>Nombre de produits</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tfoot>
                            <tr>
                                <th>Nom</th>
                                <th>Famille</th>
                                <th>Nombre de produits</th>
                                <th>Action</th>
                            </tr>
                            </tfoot>
                            <tbody>
                            <?php foreach ($meals as $meal) { ?>
                                <tr>
                                    <td><?php echo $meal['meal_name']; ?></td>
                                    <td><?php echo $meal['g_name']; ?></td>
                                    <td><?php echo $meal['products_count']; ?></td>
                                    <td>
                                        <a href=" <?php echo base_url(); ?>admin/meal/view/<?php echo $meal['meal_id']; ?>"
                                           class="btn btn-primary btn-xs"><i class="fa fa-eye"></i></a>

                                        <div class="btn btn-primary btn-xs open"><i class="fa fa-plus-square"></i></div>


                                    </td>
                                </tr>
                                <tr class="productsRow">
                                    <td colspan="8">
                                        <table class="table">
                                            <thead>
                                            <tr class="info">
                                                <th>Nom</th>
                                                <th>Quantité</th>
                                            </tr>
                                            </thead>
                                            <tfoot>
                                            <tr class="info">
                                                <th>Nom</th>
                                                <th>Quantité</th>
                                            </tr>
                                            </tfoot>
                                            <tbody>
                                            <?php foreach ($meal['productsList'] as $product) { ?>
                                                <tr class="success">
                                                    <td><?php echo $product['name']; ?></td>
                                                    <td><?php echo $product['mp_quantity'] . ' ' . $product['mp_unit']; ?></td>
                                                </tr>
                                            <?php } ?>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                            <?php } ?>
                            </tbody>
                        </table>

                    </div> <!-- /content -->
                </div><!-- /x-panel -->
            </div>
        </div>
    </div>
</div> <!-- /.col-right -->
<!-- /page content -->

<?php $this->load->view('admin/partials/admin_footer'); ?>



<script>

    $(document).ready(function () {
        $(".open").click(function () {
            $(this).closest("tr").next().toggle();
        });
    });


</script>
