<?php $this->load->view('admin/partials/admin_header.php'); ?>

<!-- page content -->
<div class="right_col" role="main">
    <div class="productsList">

        <div class="bg"></div>
       <!-- <img src="<?php /*echo base_url('assets/images/' . $department['image']); */?>" />-->
        <div class="page-title">
            <div class="title_left">
                <h3>Agence <?php echo $agency["name"]; ?></h3>
            </div>
            <div class="col-md-4">


            </div>
        </div>
        <div class="clearfix"></div>
        <hr>


        <div class="row">
            <div class="col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Stock des produits</h2>
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
                                <th>Id</th>
                                <th>Nom</th>
                                <th>Quantité</th>
                            </tr>
                            </thead>
                            <tfoot>
                            <tr>
                                <th>Id</th>
                                <th>Nom</th>
                                <th>Quantité</th>
                            </tr>
                            </tfoot>
                            <tbody>
                            <?php foreach ($products as $product) {
                                $quantity= $product['quantity'];
                                if($agency["type"]==="slave"){
                                    $quantity= $product['totalQuantity'];
                                }
                                ?>
                                <tr>
                                    <td><?php echo $product['id']; ?></td>
                                    <td><?php echo $product['name']; ?></td>
                                    <td><?php echo $quantity . ' ' . $product['unit']; ?></td>
                                </tr>
                            <?php } ?>
                            </tbody>
                        </table>

                    </div> <!-- /content -->
                </div><!-- /x-panel -->
            </div>
        </div>
      </div>
</div>


<?php $this->load->view('admin/partials/admin_footer'); ?>


<script>

    $(document).ready(function () {
        $('#addEmployeeForm').on('submit', function (e) {
            e.preventDefault();
            var formData = new FormData(this);
            $('#loading').show();
            $.ajax({
                type: 'POST',
                url: "<?php echo base_url('admin/department/apiAddMagazin'); ?>",
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: function (data) {
                    $('#loading').hide();
                    swal({
                        title: "Success",
                        text: "Le magazin a été bien ajouté",
                        type: "success",
                        timer: 1500,
                        showConfirmButton: false
                    });
                    location.reload();
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



        $('.profile_details-link').on('click', function () {
            var id = $(this).attr('data-id');
            document.location.href = "<?php echo base_url(); ?>admin/employee/show/" + id;
        });
    });

</script>

<script>

    $(document).ready(function () {
        $('button.backToStock').on('click', function (e) {

            var stock={
                "id":$(this).attr("data-id"),
                "quantity":$(this).attr("data-quantity"),
            };
            console.log(stock);
            $('#loading').show();
            $.ajax({
                url: "<?php echo base_url('admin/department/apiBackToStock'); ?>",
                type: "POST",
                dataType: "json",
                data: {'stock': stock},
                success: function (data) {
                    $('#loading').hide();
                    swal({
                        title: "Success",
                        text: "Le magazin a été bien ajouté",
                        type: "success",
                        timer: 1500,
                        showConfirmButton: false
                    });
                    location.reload();
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



        $('.profile_details-link').on('click', function () {
            var id = $(this).attr('data-id');
            document.location.href = "<?php echo base_url(); ?>admin/employee/show/" + id;
        });
    });

</script>


<script>
    $(document).ready(function () {
        $(".open").click(function () {
            $(this).closest("tr").next().toggle();
        });
        $('button.deleteEmployee').on('click', deleteEmployee);


        function deleteEmployee() {
            var employee_id = $(this).attr('data-id');
            $(this).closest('tr').hide();
            swal({
                    title: "Attention ! ",
                    text: "Vous voulez vraiment supprimer ce département ?",
                    type: "warning",
                    showConfirmButton: true,
                    showCancelButton: true,
                    cancelButtonText: 'Non',
                    confirmButtonText: 'Oui'
                },
                function () {
                    $.ajax({
                        url: "<?php echo base_url('admin/employee/apiDeleteEmployee'); ?>",
                        type: "POST",
                        dataType: "json",
                        data: {'employee_id': employee_id},
                        success: function (data) {
                            if (data.status === 'success') {
                                swal({
                                    title: "Success",
                                    text: "L'employée a été bien supprimé",
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

