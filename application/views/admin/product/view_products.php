<?php $this->load->view('admin/partials/admin_header.php'); ?>
<style>

</style>
<!-- page content -->
<div class="right_col" role="main">
    <div class="">
        <div class="page-title">
            <div class="row">
                <div class="col-xs-12 col-sm-12">
                    <a href="<?php echo base_url("admin/product/consumption"); ?>" class="btn btn-info" name="printSalesReport">
                        <span class="fa fa-print"></span><?= lang("consumption_history"); ?>
                    </a>
                    <a href="<?php echo base_url("admin/product/inventoryHistory"); ?>" class="btn btn-success" name="printSalesReport" style="min-width: 220px;">
                        <span class="fa fa-print"></span><?= lang("inventory_history"); ?>
                    </a>
                    <a href="<?php echo base_url("admin/product/export"); ?>" class="btn btn-warning" style="min-width: 220px;">
                        <span class="fa fa-print"></span>Exporter
                    </a>
                </div>

            </div>
        </div>
        <div class="clearfix"></div>
        <hr>
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2><?= lang("list_products_stock"); ?></h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                            <li><a class="close-link"><i class="fa fa-close"></i></a></li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="row">
                        <div class="col-md-3 col-sm-6 col-xs-12">
                            <label for="exampleInputName2"><?= lang("search"); ?></label>
                            <input type="text" placeholder="<?= lang("productsName"); ?>" class="form-control" id="searchInput" onkeyup="myFunction()">
                        </div>
                    </div>
                    <div class="x_content table-responsive">
                        <table class="table table-striped" id="searchTable">
                            <tr>
                                <th width="5%">
                                    Id
                                </th>
                                <th width="10%">
                                    <?= lang("product"); ?>
                                </th>
                                <th>
                                    <?= lang("quantity"); ?>
                                </th>
                                <th>
                                    <?= lang("unit"); ?>
                                </th>
                                <th>
                                    <?= lang("unit_price"); ?>
                                </th>
                                <th width="5%">
                                    <?= lang("total_price"); ?>
                                </th>
                                <th width="5%">
                                    %
                                </th>
                                <th width="20%">
                                    Actions
                                </th>
                            </tr>
                            
                            <?php foreach ($products as $product) {
                                $status= $product['min_quantity'] > $product['totalQuantity']?'danger':'success';
                            ?>
                            <tr class="productsList <?php echo $status; ?>">
                                <td><?php echo $product['product'];?></td>
                                <td><?php echo $product['name']; ?>
                                    <?php if($params["multi_site"] === "false" && $product["id_master"] >0){ ?>
                                        <sup><i class='fa fa-star color-gold'></i></sup></td>
                                    <?php } ?>
                                <td>
                                    <?php echo number_format((float)($product['totalQuantity']), 2, '.', ''); ?>
                                </td>
                                <td><?php echo $product['unit']; ?></td>
                                <td><?php echo $product['unit_price']; ?></td>
                                <td><?php echo $product['sitting_money']; ?></td>
                                <td>0%</td>
                                <td>
                                    <?php if($params["acl_page"]["acl_write"] or $this->session->userdata('type') === "admin") :?>
                                    <a href=" <?php echo base_url('admin/product/edit/'. $product['product']); ?>" class="btn btn-primary btn-xs"><i class="fa fa-pencil"></i></a>
                                    <?php endif; ?>

                                    <?php if ($params["acl_page"]["acl_delete"] or $this->session->userdata('type') === "admin") : ?>
                                    <div class="btn btn-info btn-xs open"><i class="fa fa-cutlery"></i></div>
                                    <?php endif; ?>

                                    <?php if ($params["acl_page"]["statistic"] or $this->session->userdata('type') === "admin") : ?>
                                        <a href=" <?php echo base_url('admin/product/statistic/' . $product['product']); ?>"
                                           class="btn btn-warning btn-xs"><i class="fa fa-line-chart"></i></a>
                                    <?php endif; ?>

                                    <?php if (($params["acl_page"]["acl_delete"] or $this->session->userdata('type') === "admin") and ($params["multi_site"] === "true")) : ?>
                                    <a  class="btn btn-danger btn-xs deleteProduct" data-id="<?php echo $product['product']; ?>"><i class="fa fa-trash"></i></a>
                                    <?php endif; ?>

                                    <?php if ($product['min_quantity'] > $product['totalQuantity'] && $product['provider'] > 0 && ($params["acl_page"]["acl_write"] or $this->session->userdata('type') === "admin")) { ?>
                                        <a href=" <?php echo base_url('admin/provider/show/' . $product['provider']); ?>"
                                           class="btn btn-success btn-xs"><i class="fa fa-shopping-cart"></i></a>
                                    <?php } ?>
                                </td>
                            </tr>
                                <tr class="productsRow">
                                    <td colspan="8">
                                        <table class="table">
                                            <thead>
                                            <tr class="info">
                                                <th>Id</th>
                                                <th><?= lang("name"); ?></th>
                                                <th><?= lang("quantity"); ?></th>
                                                <th><?= lang("total_price"); ?></th>
                                                <th><?= lang("consumption rate"); ?></th>
                                                <th>Actions</th>
                                            </tr>
                                            </thead>
                                            <tfoot>
                                            <tr class="info">
                                                <th>Id</th>
                                                <th><?= lang("name"); ?></th>
                                                <th><?= lang("quantity"); ?></th>
                                                <th><?= lang("total_price"); ?></th>
                                                <th><?= lang("consumption rate"); ?></th>
                                                <th>Actions</th>
                                            </tr>
                                            </tfoot>
                                            <tbody>
                                            <?php foreach ($product['meals'] as $meal) { ?>
                                                <tr class="success">
                                                    <td>-</td>
                                                    <td><?php echo $meal['name']; ?></td>
                                                    <td><?php echo $meal['quantity'].' '. $meal['mp_unit']; ?></td>
                                                    <td><?php echo $meal['quantity'] * $product['unit_price'] * $meal['unitConvert']; ?></td>
                                                    <td><?php echo $meal['consumptionRate'] * 100; ?>%</td>

                                                     <td>
                                                         <a href=" <?php echo base_url('admin/meal/edit/' . $meal['meal']); ?>"
                                                            class="btn btn-primary btn-xs"><?= lang("edit"); ?></a>
                                                     </td>
                                                </tr>
                                            <?php } ?>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                            <?php } ?>


                            <tr>
                                <th>
                                    <?= lang("composition"); ?>
                                </th>
                                <th>
                                    <?= lang("name"); ?>
                                </th>
                                <th>
                                    <?= lang("quantity"); ?>
                                </th>
                                <th>
                                    <?= lang("unit"); ?>
                                </th>
                                <th>
                                    <?= lang("unit_price"); ?>
                                </th>
                                <th colspan="4">
                                    Actions
                                </th>
                            </tr>

                            <?php foreach ($productsComposition as $composition) {
                                $status= $composition['min_quantity'] > $composition['totalQuantity']?'danger':'warning';
                            ?>
                            <tr class="productsList <?php echo $status; ?>">
                                <td><?php echo $composition['product'];?></td>
                                <td><?php echo $composition['name']; ?></td>
                                <td>
                                    <?php echo number_format((float)($composition['totalQuantity']), 2, '.', ''); ?>
                                </td>
                                <td><?php echo $composition['unit']; ?></td>
                                <td><?php echo $composition['unit_price']; ?></td>
                                </td>
                                <td colspan="4">
                                <?php if ($params["acl_page"]["acl_write"] or $this->session->userdata('type') === "admin") : ?>
                                    <a href=" <?php echo base_url('admin/product/editComposition/'. $composition['product']); ?>" class="btn btn-primary btn-xs">Modifier</a>
                                <?php endif; ?>
                                <?php if ($params["acl_page"]["statistic"] or $this->session->userdata('type') === "admin") : ?>
                                    <a href=" <?php echo base_url('admin/product/statistic/' . $composition['product']); ?>"
                                       class="btn btn-warning btn-xs"><?= lang("statistics"); ?></a>
                                <?php endif; ?>
                                <?php if ($params["acl_page"]["acl_read"] or $this->session->userdata('type') === "admin") : ?>
                                    <div class="btn btn-info btn-xs open"><?= lang("articles"); ?></div>
                                <?php endif; ?>
                                <?php if (($params["acl_page"]["acl_delete"] or $this->session->userdata('type') === "admin") and ($params["multi_site"] === "true")) : ?>
                                    <a  class="btn btn-danger btn-xs deleteProduct" data-id="<?php echo $composition['product']; ?>">Supprimer</a>
                                <?php endif; ?>
                                </td>
                            </tr>
                                <tr class="productsRow">
                                    <td colspan="10">
                                        <table class="table">
                                            <thead>
                                            <tr class="info">
                                                <th>Id</th>
                                                <th><?= lang("name"); ?></th>
                                                <th><?= lang("quantity"); ?></th>
                                                <th><?= lang("total_price"); ?></th>
                                                <th><?= lang("consumption_rate"); ?></th>
                                                <th>Actions</th>
                                            </tr>
                                            </thead>
                                            <tfoot>
                                            <tr class="info">
                                                <th>Id</th>
                                                <th><?= lang("name"); ?></th>
                                                <th><?= lang("quantity"); ?></th>
                                                <th><?= lang("total_price"); ?></th>
                                                <th><?= lang("consumption_rate"); ?></th>
                                                <th>Actions</th>
                                            </tr>
                                            </tfoot>
                                            <tbody>
                                            <?php foreach ($composition['meals'] as $meal) { ?>
                                                <tr class="success">
                                                    <td></td>
                                                    <td><?php echo $meal['name']; ?></td>
                                                    <td><?php echo $meal['quantity'] . ' ' . $meal['mp_unit']; ?></td>
                                                    <td><?php echo $meal['quantity'] * $product['unit_price'] * $meal['unitConvert']; ?></td>
                                                    <td><?php echo $meal['consumptionRate'] * 100; ?>%</td>

                                                    <td>
                                                        <a href=" <?php echo base_url('admin/meal/edit/' . $meal['meal']); ?>"
                                                           class="btn btn-primary btn-xs"><?= lang("edit"); ?></a>
                                                    </td>
                                                </tr>
                                            <?php } ?>
                                            </tbody>
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

<script>
    var swal_success_operation_lang = "<?= lang("swal_success_operation"); ?>";
    var swal_error_lang = "<?= lang("swal_error"); ?>";
    var swal_success_edit_lang = "<?= lang("swal_success_edit"); ?>";
    var swal_warning_delete_lang = "<?= lang("swal_warning_delete"); ?>";
    var swal_success_delete_lang = "<?= lang("swal_success_delete"); ?>";
</script>

<script>
    $(document).ready(function () {
        $(".open").click(function () {
            $(this).closest("tr").next().toggle();
        });
        $(".deleteProduct").on('click', deleteProductEvent);

        function deleteProductEvent(){
            var myData={
                'id':$(this).attr('data-id')
            }
            swal({
                    title: "Attention ! ",
                    text: swal_warning_delete_lang,
                    type: "warning",
                    showConfirmButton: true,
                    showCancelButton: true,
                    cancelButtonText: 'Non',
                    confirmButtonText: 'Oui'
                },
                function () {
                    deleteProduct(myData);
            });
        }

        function deleteProduct(data){
            var myData={
                'id':data['id']
            };
            $.ajax({
                url: "<?php echo base_url('admin/product/apiDelete')?>",
                type: "POST",
                dataType: "json",
                data: myData,
                beforeSend: function () {
                    $('#loading').show();
                },
                complete: function () {
                    $('#loading').hide();
                },
                success: function (data) {
                    if (data.status === "success") {
                        swal({
                            title: "Success",
                            text: "Success",
                            type: "success",
                            timer: 1500,
                            showConfirmButton: false
                        });
                        location.reload();
                    }
                    else if(data.status === "warning") {
                        swal({
                            title: "Attention!",
                            text: data.message,
                            type: "warning",
                            timer: 2000,
                            showConfirmButton: false
                        });
                    }else{
                        swal({
                            title: "Erreur",
                            text: swal_error_lang,
                            type: "error",
                            timer: 1500,
                            showConfirmButton: false
                        });
                    }
                },
                error: function (data) {
                    swal({
                        title: "Erreur",
                        text: swal_error_lang,
                        type: "error",
                        timer: 1500,
                        showConfirmButton: false
                    });
                }
            });
        }
    });
</script>



<!--Search in table-->
<script>
    function myFunction() {
        var input, filter, table, tr, td, i;
        input = document.getElementById("searchInput");
        filter = input.value.toUpperCase();
        table = document.getElementById("searchTable");
        tr = table.getElementsByClassName("productsList");
        for (i = 0; i < tr.length; i++) {
            td = tr[i].getElementsByTagName("td")[1];
            console.log(td);
            if (td) {
                if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
                    tr[i].style.display = "";
                } else {
                    tr[i].style.display = "none";
                }
            }
        }
    }
</script>
