<?php $this->load->view('admin/partials/admin_header.php'); ?>
<style>

    /* Tabs container */
    .r-tabs {
        position: relative;

        background-color: #3c8dbc;

        border-top: 1px solid #3c8dbc;
        border-right: 1px solid #3c8dbc;
        border-left: 1px solid #3c8dbc;
        border-bottom: 4px solid #3c8dbc;
        border-radius: 4px;

    }

    /* Tab element */
    .r-tabs .r-tabs-nav .r-tabs-tab {
        position: relative;
        background-color: #3c8dbc;
    }

    /* Tab anchor */
    .r-tabs .r-tabs-nav .r-tabs-anchor {
        display: inline-block;
        padding: 10px 12px;

        text-decoration: none;
        text-shadow: 0 1px rgba(0, 0, 0, 0.4);
        font-size: 14px;
        font-weight: bold;
        color: #fff;
    }

    /* Disabled tab */
    .r-tabs .r-tabs-nav .r-tabs-state-disabled {
        opacity: 0.5;
    }

    /* Active state tab anchor */
    .r-tabs .r-tabs-nav .r-tabs-state-active .r-tabs-anchor {
        color: #3c8dbc;
        text-shadow: none;

        background-color: white;

        border-top-right-radius: 4px;
        border-top-left-radius: 4px;
    }

    /* Tab panel */
    .r-tabs .r-tabs-panel {
        background-color: white;

        border-bottom: 4px solid white;

        border-bottom-right-radius: 4px;
        border-bottom-left-radius: 4px;

    }

    /* Accordion anchor */
    .r-tabs .r-tabs-accordion-title .r-tabs-anchor {
        display: block;
        padding: 10px;

        background-color: #3c8dbc;
        color: #fff;
        font-weight: bold;
        text-decoration: none;
        text-shadow: 0 1px rgba(0, 0, 0, 0.4);
        font-size: 14px;

        border-top-right-radius: 4px;
        border-top-left-radius: 4px;
    }

    /* Active accordion anchor */
    .r-tabs .r-tabs-accordion-title.r-tabs-state-active .r-tabs-anchor {
        background-color: #fff;
        color: #3c8dbc;
        text-shadow: none;
    }

    /* Disabled accordion button */
    .r-tabs .r-tabs-accordion-title.r-tabs-state-disabled {
        opacity: 0.5;
    }

    .r-tabs .r-tabs-nav {
        margin: 0;
        padding: 0;
    }

    .r-tabs .r-tabs-tab {
        display: inline-block;
        margin: 0;
        list-style: none;
    }

    .r-tabs .r-tabs-panel {
        padding: 15px;
        display: none;
    }

    .r-tabs .r-tabs-accordion-title {
        display: none;
    }

    .r-tabs .r-tabs-panel.r-tabs-state-active {
        display: block;
    }

    .right_col{
        min-height: 1250px !important;
    }

    /* Accordion responsive breakpoint */
    @media only screen and (max-width: 768px) {
        .r-tabs .r-tabs-nav {
            display: none;
        }

        .r-tabs .r-tabs-accordion-title {
            display: block;
        }
    }

</style>
<link href="<?php echo base_url("assets/build/css/main.css"); ?>" rel="stylesheet">
<!-- page content -->
<div class="right_col" role="main">
    <div class="productsList">
        <div class="page-title">
            <div class="title_left">
                <h3><?= lang('general_configuration'); ?></h3>
            </div>
        </div>
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <?= lang('my_informations'); ?>
                </div>
                <div class="x_content">
                    <div class="" role="tabpanel" data-example-id="togglable-tabs">

                        <ul id="myTab" class="nav nav-tabs bar_tabs sm-hidden" role="tablist">
                            <li role="presentation" class="active"><a href="#tab_products" id="home1-tab"
                                                                      role="tab"
                                                                      data-toggle="tab"
                                                                      aria-expanded="true"><?= lang('details'); ?></a>
                            </li>
                            <li role="presentation"><a href="#tab_productsToOrder" id="home-tab"
                                                       role="tab"
                                                       data-toggle="tab" aria-expanded="false"><?= lang('parameters'); ?></a>
                            </li>
                            <li role="presentation"><a href="#tab_support" id="home-tab"
                                                       role="tab"
                                                       data-toggle="tab" aria-expanded="false"><?= lang('support'); ?></a>
                            </li>
                        </ul>
                        <div class="col-md-3 col-sm-12 col-xs-12 md-hidden">

                            <ul class="nav nav-tabs tabs-left">
                                <li class="active"><a href="#tab_products" data-toggle="tab" aria-expanded="true"><?= lang('details'); ?></a>
                                </li>
                                <li class=""><a href="#tab_productsToOrder" data-toggle="tab" aria-expanded="true"><?= lang('parameters'); ?></a>
                                </li>
                                <li class=""><a href="#tab_support" data-toggle="tab" aria-expanded="true"><?= lang('support'); ?></a>
                                </li>
                            </ul>
                        </div>
                        <div id="myTabContent" class="tab-content col-md-12 col-sm-12 col-xs-12">

                            <!--------------------------------------------Products Tab------------------------------------------------------>
                            <div role="tabpanel" class="tab-pane fade active in" id="tab_products"
                                 aria-labelledby="home-tab">
                                <div class="row">
                                    <div class="col-md-6 col-sm-8 col-xs-12">
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <label><?= lang('name'); ?></label>
                                                </div>
                                                <div class="col-md-8">
                                                    <?php echo $user['last_name']; ?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <label><?= lang('last_name'); ?></label>
                                                </div>
                                                <div class="col-md-8">
                                                    <?php echo $user['first_name']; ?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <label><?= lang('telephone'); ?></label>
                                                </div>
                                                <div class="col-md-8">
                                                    <?php echo $user['mobile']; ?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <label><?= lang('email'); ?></label>
                                                </div>
                                                <div class="col-md-8">
                                                    <?php echo $user['email']; ?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <label><?= lang('address'); ?></label>
                                                </div>
                                                <div class="col-md-8">
                                                    <?php echo $user['address']; ?>
                                                </div>
                                            </div>
                                        </div>
                                        <br/>
                                        <!--<button class="btn btn-info action"
                                                onclick="window.location.href='<?php /*echo base_url("admin/config/editUser/" . $user['id']); */?>'">
                                            <span></span>Modifier
                                        </button>-->
                                    </div>
                                    <div class="col-md-6 col-sm-4 col-xs-12">
                                        <img src="<?= base_url('assets/images/' . $params['photo']); ?>" alt="icon">
                                    </div>
                                </div>
                                <div class="x_panel">
                                    <div class="x_title">
                                        <?= lang('users_list'); ?>
                                    </div>
                                    <div class="x_content">
                                        <div class="table-responsive">
                                            <table id="datatable-users"
                                                   class="table table-striped table-bordered dt-responsive nowrap"
                                                   cellspacing="0" width="100%">
                                                <thead>
                                                <tr>
                                                    <th><?= lang('name'); ?></th>
                                                    <th><?= lang('last_name'); ?></th>
                                                    <th><?= lang('telephone'); ?></th>
                                                    <th><?= lang('email'); ?></th>
                                                    <th><?= lang('role'); ?></th>
                                                    <th>Actions</th>
                                                </tr>
                                                </thead>
                                                <tfoot>
                                                <tr>
                                                    <th><?= lang('name'); ?></th>
                                                    <th><?= lang('last_name'); ?></th>
                                                    <th><?= lang('telephone'); ?></th>
                                                    <th><?= lang('email'); ?></th>
                                                    <th><?= lang('role'); ?></th>
                                                    <th>Actions</th>
                                                </tr>
                                                </tfoot>
                                                <tbody>
                                                <?php foreach ($allUsers as $user) { ?>
                                                    <tr>
                                                        <td><?php echo $user["first_name"]; ?></td>
                                                        <td><?php echo $user["last_name"]; ?></td>
                                                        <td><?php echo $user["mobile"]; ?></td>
                                                        <td><?php echo $user["email"]; ?></td>
                                                        <td><?php echo $user["type"]; ?></td>
                                                        <td>
                                                            <a href=" <?php echo base_url(); ?>admin/config/editUser/<?php echo $user['id']; ?>"
                                                               class="btn btn-primary  btn-xs"><i class="fa fa-pencil"></i></a>
                                                            <?php if ($user["type"] !== "admin") : ?>
                                                                <a data-id="<?php echo $user['id']; ?>"
                                                                   class="btn btn-danger btn-xs deleteUser"><i
                                                                            class="fa fa-trash"></i></a>
                                                            <?php endif; ?>
                                                            <a href=" <?php echo base_url(); ?>admin/email/compose/<?php echo $user['id']; ?>"
                                                               class="btn btn-success  btn-xs"><i class="fa fa-envelope-o"></i></a>
                                                        </td>
                                                    </tr>
                                                <?php } ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div> <!-- /content -->
                                    <?php if ($params["addUsers"] === "true") : ?>
                                        <button class="btn btn-info action"
                                                onclick="window.location.href='<?php echo base_url("admin/config/createUser"); ?>'">
                                            <span></span>Nouveau
                                        </button>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <!--------------------------------------------End Products Tab------------------------------------------------------>

                            <!--------------------------------------------Products to order Tab------------------------------------------------------>

                            <div role="tabpanel" class="tab-pane fade" id="tab_productsToOrder"
                                 aria-labelledby="home-tab">
                                <div class="row">
                                    <div class="col-xs-12">
                                        <label><input type="checkbox" name="orderReception" <?php echo $params["config_params"]["orderReception"] ?>/> <?= lang('auto_receive_orders'); ?></label>
                                    </div>
                                    <div class="col-xs-12">
                                        <label><input type="checkbox" name="orderPayment" <?php echo $params["config_params"]["orderPayment"] ?> /> <?= lang('auto_pay_orders'); ?></label>
                                    </div>
                                    <div class="col-xs-12">
                                        <label><input type="checkbox" name="editOrderDate" <?php echo $params["config_params"]["editOrderDate"] ?> /> <?= lang('edit_orders_date'); ?></label>
                                    </div>
                                    <div class="col-xs-12">
                                        <label><input type="checkbox" name="editConsumptionDate" <?php echo $params["config_params"]["editConsumptionDate"] ?> /> <?= lang('edit_meals_date_sales'); ?></label>
                                    </div>
                                    <div class="col-xs-12">
                                        <label><input type="checkbox" name="addStockAfterOrder" <?php echo $params["config_params"]["addStockAfterOrder"] ?> /> <?= lang('addStockAfterOrder'); ?></label>
                                    </div>
                                    <div class="col-xs-12">
                                        <label><input type="checkbox" name="disableConsumptionProducts" <?php echo $params["config_params"]["disableConsumptionProducts"] ?> /> <?= lang('disableConsumptionProducts'); ?></label>
                                    </div>
                                </div>
                                <br/>
                                <div class="row">
                                    <div class="col-xs-12">
                                        <input type="submit" value="<?= lang('edit'); ?>" name="editParameters"
                                               class="btn btn-success"/>
                                    </div>
                                </div>
                            </div>
                            <!--------------------------------------------End Products to order Tab------------------------------------------------------>
                            <div role="tabpanel" class="tab-pane fade" id="tab_support"
                                 aria-labelledby="home-tab">
                                <p>Besystem Help Desk vous permet de gérer entièrement le processus de support dans un seul outil, de l’enregistrement à la fermeture du ticket. Le système fournit aussi des statistiques et des rapports qui facilitent le suivi de votre gestion de support.</p>
                                <p>Toutes les informations relatives à un ticket sont sauvegardées et stockées au sein de HelpDesk. Notre solution, s'inspirant des meilleures pratiques ITIL, vous permet de gérer tous les incidents, questions et réclamations; des questions Ressources Humaines, questions Service Client (SAV, hotline, ...).
                                </p>
                                <div class="row">
                                    <div class="col-md-6 col-sm-8 col-xs-12">
                                        <div class="form-group"><b>Vos identifiants</b></div>
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <label><?= lang('email'); ?></label>
                                                </div>
                                                <div class="col-md-8">
                                                    <?php echo $params['hd_email']; ?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <label><?= lang('password'); ?></label>
                                                </div>
                                                <div class="col-md-8">
                                                    <?php echo $params['hd_password']; ?>
                                                </div>
                                            </div>
                                        </div>
                                        <a target="_blank" href="<?php echo prep_url('helpdesk.besystem.org');?>">Accéder à votre espace de support</a>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div><!-- /content -->
            </div>
        </div>
            <!-- /x-panel -->
    </div>
</div>


<?php $this->load->view('admin/partials/admin_footer'); ?>
<script src="<?php echo base_url("assets/vendors/datatables.net/js/jquery.dataTables.min.js"); ?>"></script>
<script>
    $(document).ready(function () {
        var handleDataTableButtons = function () {
            if ($("#datatable-users").length) {
                $("#datatable-users").DataTable({
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


<script>
    $(document).ready(function () {
        $('a.deleteUser').on('click', deleteUser);


        function deleteUser() {
            var user_id = $(this).attr('data-id');
            $(this).closest('tr').hide();
            swal({
                    title: "Attention ! ",
                    text: "Vous voulez vraiment supprimer cet utilisateur ?",
                    type: "warning",
                    showConfirmButton: true,
                    showCancelButton: true,
                    cancelButtonText: 'Non',
                    confirmButtonText: 'Oui'
                },
                function () {
                    $('#loading').show();
                    $.ajax({
                        url: "<?php echo base_url('admin/config/apiDeleteUser'); ?>",
                        type: "POST",
                        dataType: "json",
                        data: {'user_id': user_id},
                        success: function (data) {
                            $('#loading').hide();
                            if (data.status === 'success') {
                                swal({
                                    title: "Success",
                                    text: "L'utilisateur a été bien supprimé",
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


        }
    });
</script>



<script>
    $(document).ready(function () {
        $("input[name=editParameters]").on("click",editParametersEvent);
        function editParametersEvent(){
            var orderReception = $('input[name="orderReception"]').is(':checked');
            var orderPayment = $('input[name="orderPayment"]').is(':checked');
            var editOrderDate = $('input[name="editOrderDate"]').is(':checked');
            var editConsumptionDate = $('input[name="editConsumptionDate"]').is(':checked');
            var addStockAfterOrder = $('input[name="addStockAfterOrder"]').is(':checked');
            var disableConsumptionProducts = $('input[name="disableConsumptionProducts"]').is(':checked');

            var parameters={
                "orderReception": orderReception,
                "orderPayment": orderPayment,
                "editOrderDate": editOrderDate,
                "editConsumptionDate": editConsumptionDate,
                "addStockAfterOrder": addStockAfterOrder,
                "disableConsumptionProducts": disableConsumptionProducts,
            };
            console.log(parameters);
            $.ajax({
                    url: "<?php echo base_url("admin/config/apiEditParameters"); ?>",
                    type: "POST",
                    dataType: "json",
                    data: {'parameters': parameters},
                    beforeSend: function () {
                        $('#loading').show();
                    },
                    complete: function () {
                        $('#loading').hide();
                    },
                    success: function (data) {
                           if(data.status==="success"){
                               swal({
                                   title: "Success",
                                   text: "L'opération a été bien effecuté",
                                   type: "success",
                                   timer: 1500,
                                   showConfirmButton: false
                               });
                           }else{
                                   swal({
                                       title: "Erreur",
                                       text: "Une erreur s'est produite",
                                       type: "warning",
                                       timer: 1500,
                                       showConfirmButton: false
                                   });
                                }
                            },
                            error: function (data) {
                                swal({
                                    title: "Erreur",
                                    text: "Une erreur s'est produite",
                                    type: "warning",
                                    timer: 1500,
                                    showConfirmButton: false
                            });
                    }
            });
        }
    });
</script>


