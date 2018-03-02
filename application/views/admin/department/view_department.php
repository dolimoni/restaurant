<?php $this->load->view('admin/partials/admin_header.php'); ?>

<!-- page content -->
<div class="right_col" role="main">
    <div class="productsList">

        <div class="bg"></div>
       <!-- <img src="<?php /*echo base_url('assets/images/' . $department['image']); */?>" />-->
        <div class="page-title">
            <div class="title_left">
                <h3>Département <?php echo $department['name']; ?></h3>
            </div>
            <div class="col-md-4">


            </div>
        </div>
        <div class="clearfix"></div>
        <hr>
        <div class="row">
            <div class="col-md-2 col-sm-3 col-xs-12">
                <a class="btn btn-primary" data-toggle="collapse" href="#collapseExample" aria-expanded="false"
                   aria-controls="collapseExample">Ajouter un magazin</a>
            </div>
            <div class="col-md-6 col-sm-6 col-xs-12 collapse" id="collapseExample">
                <form id="addEmployeeForm" enctype="multipart/form-data">
                    <fieldset>
                        <div class="row">
                            <div class="col-xs-8 col-sm-6 col-md-6">
                                <input type="hidden" name="department" value="<?php  echo $department['id']; ?>"/>
                                <input type="text" class="form-control" name="name"
                                       placeholder="Nom"
                                       required>
                            </div>
                            <div class="col-sm-6 col-md-6 col-xs-4">
                                <input class="btn btn-success" type="submit" name="addEmployee" value="Confirmer"/>
                            </div>
                        </div>
                    </fieldset>
                </form>
                <br>
            </div>
        </div>

        <div class="row">
            <div class="col-md-2 col-sm-6 col-xs-12">
                <button type="submit" class="btn btn-success" name="new"
                        onclick="window.location.href='<?php echo base_url('admin/department/stockMeal/' . $department['id']); ?>'">
                    <span></span> Ajouter des articles
                </button>
            </div>
        </div>

       <div class="row">
           <div class="col-xs-12">
               <div class="x_panel">
                   <div class="x_title">
                       <h2>Liste des magazins</h2>
                       <ul class="nav navbar-right panel_toolbox">
                           <li><a class="collapse-link"><i class="fa fa-chevron-down"></i></a></li>
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
                               <th>Action</th>
                           </tr>
                           </thead>
                           <tfoot>
                           <tr>
                               <th>Id</th>
                               <th>Nom</th>
                               <th>Action</th>
                           </tr>
                           </tfoot>
                           <tbody>
                           <?php foreach ($magazins as $magazin) { ?>
                               <tr>
                                   <td><?php echo $magazin['id']; ?></td>
                                   <td><?php echo $magazin['name']; ?></td>
                                   <td>
                                       <a href=" <?php echo base_url(); ?>admin/department/editMagazin/<?php echo $magazin['department'] . '/' . $magazin['id']; ?>"
                                          class="btn btn-warning btn-xs"><i class="fa fa-pencil"></i> Modifier</a>
                                       <div class="btn btn-primary btn-xs open"><i class="fa fa-plus-square"></i> Afficher</div>
                                   </td>
                               </tr>
                               <tr class="productsRow">
                                   <td colspan="8">
                                       <table class="table">
                                           <thead>
                                           <tr class="info">
                                               <th>Id</th>
                                               <th>Nom</th>
                                               <th>Quantity</th>
                                               <!--<th>En vente</th>-->
                                           </tr>
                                           </thead>
                                           <tfoot>
                                           <tr class="info">
                                               <th>Id</th>
                                               <th>Nom</th>
                                               <th>Quantity</th>
                                              <!-- <th>En vente</th>-->
                                           </tr>
                                           </tfoot>
                                           <tbody>
                                           <?php foreach ($magazin['mealsList'] as $meal) { ?>
                                               <tr class="success">
                                                   <td><?php echo $meal['id']; ?></td>
                                                   <td><?php echo $meal['name']; ?></td>
                                                   <th><?php echo $meal['quantityInMagazin']; ?></th>
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


        <?php if($params["department"]==="true"){ ?>
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
                           <?php foreach ($products as $product) { ?>
                               <tr>
                                   <td><?php echo $product['id']; ?></td>
                                   <td><?php echo $product['name']; ?></td>
                                   <td><?php echo $product['s_quantity'].' '. $product['unit']; ?></td>
                               </tr>
                           <?php } ?>
                           </tbody>
                       </table>

                   </div> <!-- /content -->
               </div><!-- /x-panel -->
           </div>
       </div>
        <?php } ?>
        <!-- /row -->
        <div class="row">
           <div class="col-xs-12">
               <div class="x_panel">
                   <div class="x_title">
                       <h2>Stock des articles</h2>
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
                               <th>Quantité préparée</th>
                               <th>Quantité vendu</th>
                               <th>Quantité restante</th>
                               <th>En Stock</th>
                               <th>Perte</th>
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
                               <th>Perte</th>
                               <th>Actions</th>
                           </tr>
                           </tfoot>
                           <tbody>
                           <?php foreach ($readyMeals as $readyMeal) {


                            $remainingQuantity= number_format((float)$readyMeal['prepared_quantity'], 0, '.', '')- number_format((float)$readyMeal['consumption_quantity'], 0, '.', '');
                            $saleRemainingQuantity= number_format((float)($readyMeal['prepared_quantity']-$readyMeal['lost_quantity']), 0, '.', '');
                            if($remainingQuantity<0){
                                $remainingQuantity=0;
                            }
                            ?>
                               <tr>
                                   <td><?php echo $readyMeal['name']; ?></td>
                                   <td><?php echo number_format((float)$readyMeal['prepared_quantity'], 0, '.', '') ?></td>
                                   <td><?php echo number_format((float)$readyMeal['consumption_quantity'], 0, '.', '')?></td>
                                   <td><?php echo $remainingQuantity?></td>
                                   <td><?php echo number_format((float)$readyMeal['quantityInMagazin'], 0, '.', '')?></td>
                                   <td><?php echo $readyMeal['lost_quantity'] ?></td>
                                   <td>
                                       <?php if ($saleRemainingQuantity > 0){ ?>
                                       <button data-id="<?php echo $readyMeal['meal']; ?>" type="button"
                                               data-quantity="<?php echo $saleRemainingQuantity; ?>"
                                               class="btn btn-info btn-xs backToStock">
                                           <i class="fa fa-long-arrow-right"> </i> Renvoyer au stock
                                       </button>
                                       <?php } ?>
                                   </td>
                               </tr>
                           <?php } ?>
                           </tbody>
                       </table>
                       <div class="col-md-2 col-sm-6 col-xs-12">
                           <button type="submit" class="btn btn-warning" name="new"
                                   onclick="window.location.href='<?php echo base_url('admin/department/mealsHistory/' . $department['id']); ?>'">
                               <span></span> Historique
                           </button>
                       </div>

                   </div> <!-- /content -->
               </div><!-- /x-panel -->
           </div>
       </div>
         <!-- /row -->


        <div class="row">
            <div class="col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Mes fiches techniques</h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li><a class="collapse-link" aria-expanded="false"><i class="fa fa-chevron-down"></i></a></li>
                            <li><a class="close-link"><i class="fa fa-close"></i></a></li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content table-responsive" style="display: none;">
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

