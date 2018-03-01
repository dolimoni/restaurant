<?php $this->load->view('admin/partials/admin_header.php'); ?>
<!-- page content -->
<div class="right_col" role="main">
    <div class="">
        <div class="page-title">
            <div class="row">
                <div class="col-xs-8 col-sm-12">
                    <div id="reportrange" class="pull-right"
                         style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc">
                        <i class="glyphicon glyphicon-calendar fa fa-calendar"></i>
                        <span>December 30, 2014 - January 28, 2015</span> <b class="caret"></b>
                    </div>
                </div>
            </div>
        </div>
        <div class="clearfix"></div>
        <hr>
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Quantité de consummation</h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                            <li><a class="close-link"><i class="fa fa-close"></i></a></li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="row">
                        <div class="col-md-3 col-sm-6 col-xs-12">
                            <label for="exampleInputName2">Rechercher</label>
                            <input type="text" placeholder="Nom du produit" class="form-control" id="searchInput" onkeyup="myFunction()">
                        </div>
                    </div>
                    <div class="x_content table-responsive">
                        <table class="table table-striped" id="searchTable">
                            <tr>
                                <th width="15%">
                                    Id
                                </th>
                                <th width="20%">
                                    Produit
                                </th>
                                <th>
                                    Quantité
                                </th>
                                <th width="40%">
                                    Actions
                                </th>
                            </tr>
                            <tbody id="tbody">
                            <?php foreach ($products as $product) {?>
                                <tr class="productsList success">
                                    <td><?php echo $product['p_id']; ?></td>
                                    <td><?php echo $product['name']; ?></td>
                                    <td>
                                        <?php echo number_format((float)($product['cp_quantity']), 2, '.', ''); ?>
                                    </td>
                                    <td>
                                        <?php if ($params["acl_page"]["acl_write"] or $this->session->userdata('type') === "admin") : ?>
                                            <a href="<?php echo base_url('admin/product/edit/' . $product['p_id']); ?>"
                                               class="btn btn-primary btn-xs">Modifier</a>
                                        <?php endif; ?>

                                        <?php if ($params["acl_page"]["statistic"] or $this->session->userdata('type') === "admin") : ?>
                                            <a href="<?php echo base_url('admin/product/statistic/' . $product['p_id']); ?>"class="btn btn-warning btn-xs">Statistiques</a>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php } ?>
                            </tbody>

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
    var consumptionLink = "<?php echo base_url("admin/product/apiConsumption"); ?>";
    var baseUrl = "<?php echo base_url(); ?>";
</script>
<script src="<?php echo base_url('assets/vendors/moment/min/moment.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/vendors/bootstrap-daterangepicker/daterangepicker.js'); ?>"></script>
<script src="<?php echo base_url('assets/build2/js/product/consumption.js'); ?>"></script>


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
                    text: "Vous voulez vraiment supprimer ce produit ?",
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
