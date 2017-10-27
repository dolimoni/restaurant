<?php $this->load->view('admin/partials/admin_header.php'); ?>
    <!-- page content -->
    <div class="right_col" role="main">
        <div class="">
            <div class="page-title">
                <div class="title_left">
                    <h3>Articles</h3>
                </div>
            </div>
            <div class="clearfix"></div>
            <hr>
            <div class="row">
                <?php foreach ($groups as $group) { ?>
                    <div class="col-md-2 col-sm-2 col-xs-12">
                        <div class="well" data-id="<?php echo $group['id'] ?>">
                            <img src="<?php echo base_url(); ?>assets/images/<?php echo $group['image'] ?>" alt=""
                                 class="img-responsive">
                            <h4 class="brief text-center"><?php echo $group['name'] ?></h4>
                        </div>
                    </div>
                <?php } ?>
            </div>
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2>Liste des articles</h2>
                            <ul class="nav navbar-right panel_toolbox">
                                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                                <li><a class="close-link"><i class="fa fa-close"></i></a></li>
                            </ul>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">
                            <table class="table table-striped">
                                <tr>
                                    <th>
                                        Id
                                    </th>
                                    <th>
                                        Nom
                                    </th>
                                    <th>
                                        Coût
                                    </th>
                                    <th>
                                        Prix de vente
                                    </th>
                                    <th>
                                        Bénifices
                                    </th>
                                    <th>
                                        Nombre de produits
                                    </th>
                                    <th colspan="2">
                                        Actions
                                    </th>
                                </tr>

                                <?php foreach ($meals as $meal){?>
                                <tr>
                                    <td><?php echo $meal['id'] ;?></td>
                                    <td><?php echo $meal['name']; ?></td>
                                    <td><?php echo $meal['cost']; ?></td>
                                    <td><?php echo $meal['sellPrice']; ?></td>
                                    <td><?php echo $meal['profit']; ?></td>
                                    <td><?php echo $meal['products_count']; ?></td>
                                    <td>
                                        <a href=" <?php echo base_url(); ?>admin/employee/edit/{id}"
                                           class="btn btn-primary btn-xs">Edit</a>
                                        <div class="btn btn-primary btn-xs open">Compositions</div>
                                        <a onclick="return confirm('All records will be deleted, continue?')"
                                           href=" <?php echo base_url(); ?>admin/employee/delete/{id}"
                                           class="btn btn-danger btn-xs">Delete</a>
                                       <!--<pre>
                                            <?php /*print_r($meals); */?>
                                       </pre>-->
                                    </td>
                                </tr>

                                <tr class="productsRow">
                                    <td colspan="7">
                                        <table class="table">
                                            <tr class="info">
                                                <th>
                                                    Id
                                                </th>
                                                <th>
                                                    Nom
                                                </th>
                                                <th>
                                                    Prix
                                                </th>
                                                <th>
                                                    Quantité
                                                </th>
                                                <th>
                                                    Bénifices
                                                </th>
                                                <th colspan="2">
                                                    Actions
                                                </th>
                                            </tr>
                                            <?php foreach ($meal['productsList'] as $product) { ?>
                                                <tr class="success">
                                                    <td>
                                                        <?php echo $product['id'];?>
                                                    </td>
                                                    <td>
                                                        <?php echo $product['name']; ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $product['quantity']; ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $product['quantity']; ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $product['quantity']; ?>
                                                    </td>
                                                    <td colspan="2">
                                                        <a href=" <?php echo base_url(); ?>admin/employee/edit/{id}"
                                                           class="btn btn-primary btn-xs">Edit</a>
                                                        <a onclick="return confirm('All records will be deleted, continue?')"
                                                           href=" <?php echo base_url(); ?>admin/employee/delete/{id}"
                                                           class="btn btn-danger btn-xs">Delete</a>
                                                    </td>
                                                </tr>
                                            <?php } ?>
                                        </table>
                                    </td>
                                </tr>
                               <?php } ?>
                            </table>
                        </div> <!-- /content -->
                    </div><!-- /x-panel -->
                </div> <!-- /col -->
            </div> <!-- /row -->
        </div>
    </div> <!-- /.col-right -->
    <!-- /page content -->

<?php $this->load->view('admin/partials/admin_footer'); ?>

<?php if ($this->session->flashdata('message') != NULL) : ?>
    <script>
        swal({
            title: "Success",
            text: "<?php echo $this->session->flashdata('message'); ?>",
            type: "success",
            timer: 1500,
            showConfirmButton: false
        });
    </script>
<?php endif ?>

<script>
    $(document).ready(function () {
        $(".open").click(function () {
            $(this).closest("tr").next().toggle();
        });
    });

</script>
