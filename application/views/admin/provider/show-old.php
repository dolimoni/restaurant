<?php $this->load->view('admin/partials/admin_header.php'); ?>

<link href="<?php echo base_url('assets/vendors/bootstrap-daterangepicker/daterangepicker.css'); ?>" rel="stylesheet">
<link href="<?php echo base_url("assets/build2/css/custom.min.css"); ?>" rel="stylesheet">
<style>
    input.ordred{
        background: #6cc !important;
        color: white;
    }
    .orderPaid span{
        color:white;
        background:#6cc;
        padding: 5px 20px;
        border-radius: 5px;
    }
    .orderImpaid span{
        color:white;
        background:red;
        padding: 5px 8px;
        border-radius: 5px;
    }

    .x_panel{
        padding: 0px;
    }
    tr{
        white-space: nowrap;
    }
    @media (max-width: 480px) {
        #datatable-responsive5_filter{
            float: left !important;
            text-align: left !important;
        }

    }
    .list-unstyled.user_data li i::before{
        margin-right:10px;
    }
</style>
<!-- page content -->
<div class="right_col" role="main" style="min-height: auto;">
    <div class="productsList">
        <div class="page-title">
           <!-- <pre>
                <?php /*print_r($provider); */?>
            </pre>-->
            <div class="">
                <h3><?= lang('provider_profile') ?></h3>
            </div>
        </div>
        <div class="clearfix"></div>
        <hr>

        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2><?= lang('provider_report') ?>
                            <small><?= lang('activities_report') ?></small>
                        </h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                            </li>
                            <!--<li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
                                   aria-expanded="false"><i class="fa fa-wrench"></i></a>
                                <ul class="dropdown-menu" role="menu">
                                    <li><a href="#">Settings 1</a>
                                    </li>
                                    <li><a href="#">Settings 2</a>
                                    </li>
                                </ul>
                            </li>-->
                            <li><a class="close-link"><i class="fa fa-close"></i></a>
                            </li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <div class="col-md-3 col-sm-3 col-xs-12 profile_left">
                            <div class="profile_img">
                                <div id="crop-avatar">
                                    <!-- Current avatar -->
                                    <img class="img-responsive avatar-view" src="<?php echo base_url('assets/images/'.$provider['image']);?>" alt="Avatar"
                                         title="Change the avatar">
                                </div>
                            </div>
                            <h3><span class="provider-firstName"><?php echo ucfirst($provider['name']);?></span> <span class="provider-lastName"><?php echo strtolower($provider['prenom']); ?></span></h3>
                            <input type="hidden" value="<?php echo $provider['id']; ?>" id="provider_id" data-id="<?php echo $provider['id'] ;?>"/>
                            <ul class="list-unstyled user_data">
                                <li>
                                    <i class="fa fa-map-marker user-profile-icon"></i>
                                    <span class="provider-address">
                                        <?php echo ucfirst($provider['address']); ?>
                                    </span>
                                </li>

                                <li class="provider-title">
                                    <i class="fa fa-briefcase user-profile-icon"><?php echo $provider['title']; ?></i>
                                </li>

                                <li>
                                    <i class="fa fa-phone provider-phone"><?php echo $provider['phone']; ?></i>
                                </li>

                                <li >
                                    <i class="fa fa-envelope user-profile-icon provider-mail"><?php echo $provider['mail']; ?></i>
                                </li>
                                <li hidden>
                                    <i class="fa fa-envelope user-profile-icon provider-tva" data-tva="<?php echo $provider['tva']; ?>"> <?php echo $provider['tva']; ?></i>
                                </li>
                            </ul>

                            <!--<a class="btn btn-success editProfile">
                                <i class="fa fa-edit m-right-xs"></i>Modifier
                            </a>-->

                            <a class="btn btn-success saveProfile" style="display: none;">
                                Enregistrer
                            </a>


                            <br/>

                            <!-- start skills -->
                           <!-- <h4>Skills</h4>-->
                            <!--<ul class="list-unstyled user_data">
                                <li>
                                    <p>Web Applications</p>
                                    <div class="progress progress_sm">
                                        <div class="progress-bar bg-green" role="progressbar"
                                             data-transitiongoal="50"></div>
                                    </div>
                                </li>
                                <li>
                                    <p>Website Design</p>
                                    <div class="progress progress_sm">
                                        <div class="progress-bar bg-green" role="progressbar"
                                             data-transitiongoal="70"></div>
                                    </div>
                                </li>
                                <li>
                                    <p>Automation & Testing</p>
                                    <div class="progress progress_sm">
                                        <div class="progress-bar bg-green" role="progressbar"
                                             data-transitiongoal="30"></div>
                                    </div>
                                </li>
                                <li>
                                    <p>UI / UX</p>
                                    <div class="progress progress_sm">
                                        <div class="progress-bar bg-green" role="progressbar"
                                             data-transitiongoal="50"></div>
                                    </div>
                                </li>
                            </ul>-->
                            <!-- end of skills -->

                        </div>
                        <div class="col-md-9 col-sm-9 col-xs-12">

                            <div class="profile_title">
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <div class="x_panel">
                                        <div class="x_title">
                                            <h2><?= lang('orders_statistics') ?></h2>
                                            <ul class="nav navbar-right panel_toolbox">
                                                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                                </li>
                                                <!--<li class="dropdown">
                                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"
                                                       role="button"
                                                       aria-expanded="false"><i class="fa fa-wrench"></i></a>
                                                    <ul class="dropdown-menu" role="menu">
                                                        <li><a href="#">Settings 1</a>
                                                        </li>
                                                        <li><a href="#">Settings 2</a>
                                                        </li>
                                                    </ul>
                                                </li>-->
                                                <li><a class="close-link"><i class="fa fa-close"></i></a>
                                                </li>
                                            </ul>
                                            <div class="clearfix"></div>
                                        </div>
                                        <div class="x_content">

                                            <div id="echart_pie" style="height:350px;"></div>

                                        </div>
                                    </div>
                                </div>
                                    <!--<div id="reportrange" class="pull-right"
                                         style="margin-top: 5px; background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #E6E9ED">
                                        <i class="glyphicon glyphicon-calendar fa fa-calendar"></i>
                                        <span>December 30, 2014 - January 28, 2015</span> <b class="caret"></b>
                                    </div>-->

                            </div>
                            <?php include('include/quotationModal.php'); ?>
                            <?php include('include/quotationEditModal.php'); ?>
                            <div class="" role="tabpanel" data-example-id="togglable-tabs">

                                <ul id="myTab" class="nav nav-tabs bar_tabs sm-hidden" role="tablist">
                                    <li role="presentation" class="active"><a href="#tab_products" id="home1-tab"
                                                                              role="tab"
                                                                              data-toggle="tab" aria-expanded="true"><?= lang('products') ?></a>
                                    </li>
                                    <li role="presentation"><a href="#tab_productsToOrder" id="home-tab"
                                                                              role="tab"
                                                                              data-toggle="tab" aria-expanded="false"><?= lang('products_to_order') ?></a>
                                    </li>
                                    <li role="presentation" class=""><a href="#tab_orders" role="tab" id="profile-tab"
                                                                        data-toggle="tab" aria-expanded="false"><?= lang('history_of_orders') ?></a>
                                    </li>
                                    <!--<li role="presentation" class=""><a href="#tab_quotations" role="tab"
                                                                        id="profile-tab2"
                                                                        data-toggle="tab"
                                                                        aria-expanded="false">Devis</a>
                                    </li>-->
                                </ul>
                                <div class="col-md-3 col-sm-12 col-xs-12 md-hidden">
                                    <!-- required for floating -->
                                    <!-- Nav tabs -->
                                    <ul class="nav nav-tabs tabs-left">
                                        <li class="active"><a href="#tab_products" data-toggle="tab" aria-expanded="true"><?= lang('products') ?></a>
                                        </li>
                                        <li class=""><a href="#tab_productsToOrder" data-toggle="tab" aria-expanded="true"><?= lang('products_to_order') ?></a>
                                        </li>
                                        <li class=""><a href="#tab_orders" data-toggle="tab" aria-expanded="false"><?= lang('history_of_orders') ?></a>
                                        </li>
                                        <!--<li><a href="#tab_quotations" data-toggle="tab">Devis</a>
                                        </li>-->
                                    </ul>
                                </div>
                                <div id="myTabContent" class="tab-content col-md-12 col-sm-12 col-xs-12">

        <!--------------------------------------------Products Tab------------------------------------------------------>
                                    <div role="tabpanel" class="tab-pane fade active in" id="tab_products"
                                         aria-labelledby="home-tab">
                                        <table id="datatable-responsive1" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                                            <thead>
                                            <tr>
                                                <th>#</th>
                                                <th><?= lang('product') ?></th>
                                                <th class="hidden-phone"><?= lang('price') ?></th>
                                                <th >Actions</th>
                                            </tr>
                                            </thead>
                                            <tfoot>
                                            <tr>
                                                <th>#</th>
                                                <th><?= lang('product') ?></th>
                                                <th><?= lang('price') ?></th>
                                                <th>Action</th>
                                            </tr>
                                            </tfoot>
                                            <tbody>
                                            <?php foreach ($products as $product) { ?>
                                                <tr data-id="<?php echo $product['id']; ?>" data-quantity="<?php echo $product['q_id']; ?>">
                                                    <td> <?php echo $product['id']; ?></td>
                                                     <td><a href="<?php echo base_url('admin/product/edit/'. $product['id']); ?>"><?php echo $product['name']; ?></a></td>
                                                    <td> <?php echo $product['unit_price']; ?></td>
                                                    <!--<td class="vertical-align-mid">
                                                        <a class="btn btn-primary btn-xs editProductsModal"
                                                           data-toggle="modal"
                                                           data-target="#editProductsModal"
                                                           data-id="<?php /*echo $product['id']; */?>">Modifier</a>
                                                    </td>-->
                                                    <td class="vertical-align-mid">
                                                       <!-- <a class="btn btn-primary btn-xs editProductsModal"
                                                           data-toggle="modal"
                                                           data-target="#editProductsModal"
                                                           data-id="<?php /*echo $product['id']; */?>">Modifier</a>-->
                                                        <a data-id="<?php echo $product['id']; ?>"
                                                           class="btn btn-danger btn-xs deleteProduct"><?= lang('delete') ?></a>
                                                    </td>
                                                </tr>
                                            <?php } ?>
                                            </tbody>
                                        </table>
                                       <!-- <div>
                                            <br/>
                                            <input type="button" class="btn btn-info" value="Nouveau"
                                                   data-toggle="modal"
                                                   data-target="#addProductsModal"/>
                                         </div>-->
                                        <?php include('include/addProductsModal.php'); ?>
                                        <?php include('include/editProductsModal.php'); ?>
                                   </div>
        <!--------------------------------------------End Products Tab------------------------------------------------------>

        <!--------------------------------------------Products to order Tab------------------------------------------------------>

                                    <div role="tabpanel" class="tab-pane fade" id="tab_productsToOrder"
                                         aria-labelledby="home-tab">

                                        <table class="data table table-striped no-margin">
                                            <thead>
                                            <tr>
                                                <th>#</th>
                                                <th><?= lang('product') ?></th>
                                                <th><?= lang('min_quantity') ?></th>
                                                <th class="hidden-phone"><?= lang('price') ?></th>
                                                <!--<th>Actions</th>-->
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php foreach ($productsToOrder as $productToOrder) { ?>
                                                <tr>
                                                    <td><?php echo $productToOrder['id']; ?></td>
                                                    <td><?php echo $productToOrder['name']; ?></td>
                                                    <td><?php echo $productToOrder['min_quantity']- $productToOrder['quantity']; ?></td>
                                                    <td><?php echo $productToOrder['unit_price']; ?></td>
                                                    <!--<td class="vertical-align-mid">
                                                        <a class="btn btn-primary btn-xs editQuotation"
                                                           data-toggle="modal"
                                                           data-target="#quotationEditModal"
                                                           data-id="<?php /*echo $productToOrder['id']; */?>">Modifier</a>
                                                        <a onclick="return confirm('All records will be deleted, continue?')"
                                                           href=" <?php /*echo base_url(); */?>admin/employee/delete/{id}"
                                                           class="btn btn-danger btn-xs">Supprimer</a>
                                                    </td>-->
                                                </tr>
                                            <?php } ?>
                                            </tbody>
                                        </table>

                                        <!--<input type="button" class="btn btn-info" value="<?/*= lang('new_order') */?>"
                                               data-toggle="modal"
                                               data-target="#productToOrderModal"/>-->
                                        <?php include('include/productTorOrder.php'); ?>
                                    </div>
        <!--------------------------------------------End Products to Tab------------------------------------------------------>

        <!--------------------------------------------Orders History Tab------------------------------------------------------>
                                    <div role="tabpanel" class="tab-pane fade" id="tab_orders"
                                         aria-labelledby="profile-tab">

                                        <!-- start user projects -->
                                        <div class="table-responsive">
                                            <table id="datatable-responsive5"
                                                   class="data table table-striped no-margin ">
                                                <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th><?= lang('amount') ?></th>
                                                    <th><?= lang('date_order') ?></th>
                                                    <th><?= lang('date_payment') ?></th>
                                                    <th><?= lang('status') ?></th>
                                                    <th><?= lang('paiment') ?></th>
                                                    <th>Actions</th>
                                                </tr>
                                                </thead>
                                                <tfoot>
                                                <tr>
                                                    <th>#</th>
                                                    <th><?= lang('amount') ?></th>
                                                    <th><?= lang('date_order') ?></th>
                                                    <th><?= lang('date_payment') ?></th>
                                                    <th><?= lang('status') ?></th>
                                                    <th><?= lang('paiment') ?></th>
                                                    <th>Actions</th>
                                                </tr>
                                                </tfoot>
                                                <tbody>
                                                <?php
                                                $impaidAmount = 0;
                                                $paidAmount = 0;
                                                foreach ($orders as $order) {
                                                    $orderStatus = lang('pending');
                                                    $paid = lang('impaid');
                                                    $paidClass="orderImpaid";
                                                    $datetime = $order['paymentDate'];
                                                    $paymentDateTime = strtotime($datetime);
                                                    $paymentDate="";
                                                    if ($order['status'] === "canceled") {
                                                        $orderStatus = lang('canceled');
                                                    } else if ($order['status'] === "received") {
                                                        $orderStatus = lang('received');
                                                    }

                                                    if($order['paid']==="true"){
                                                        $paidAmount+=(float)$order['ttc'];
                                                        $paid= lang('paid');
                                                        $paidClass="orderPaid";
                                                        $paymentDate=date("d-m-Y", $paymentDateTime);
                                                    }else{
                                                        $impaidAmount+= (float)$order['ttc'];
                                                    }
                                                    $datetime = $order['created_at'];
                                                    $created_at = strtotime($datetime);


                                                    ?>
                                                    <tr data-id="<?php echo $order['id']; ?>">
                                                        <td><?php echo $order['id']; ?></td>
                                                        <td><?php echo $order['ttc']; ?></td>
                                                        <td><?php echo date("d-m-Y", strtotime($order['orderDate'])); ?></td>
                                                        <td data-paymentDate><?php echo $paymentDate; ?></td>
                                                        <td><?php echo $orderStatus; ?></td>
                                                        <td data-paid class="<?php echo $paidClass; ?>"><span><?php echo $paid; ?></span></td>
                                                        <td class="vertical-align-mid">
                                                            <a class="btn btn-primary btn-xs editOrderModal"
                                                               data-toggle="modal"
                                                               data-target="#editOrderModal"
                                                               data-id="<?php echo $order['id']; ?>"><?= lang('edit') ?></a>
                                                            <a data-id="<?php echo $order['id']; ?>"
                                                               class="btn btn-danger btn-xs deleteOrder"><?= lang('delete') ?></a>
                                                        </td>
                                                    </tr>
                                                <?php } ?>
                                                <tr>
                                                    <td>#</td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td><?= lang('paid') ?> : <?php echo $paidAmount; ?>Dh</td>
                                                    <td><?= lang('impaid') ?> : <?php echo $impaidAmount; ?>Dh</td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <br/>
                                        <div class="row">
                                            <input type="button" class="btn btn-info" value="<?= lang('new_order') ?>"
                                                   data-toggle="modal"
                                                   data-target="#orderModal"/>
                                        </div>
                                        <?php include('include/orderModal.php'); ?>
                                        <?php include('include/editOrderModal.php'); ?>
                                        <!-- end user projects -->

                                    </div>
        <!--------------------------------------------End Orders History Tab------------------------------------------------------>

        <!--------------------------------------------Quotation Tab------------------------------------------------------>
                                    <div role="tabpanel" class="tab-pane fade" id="tab_quotations"
                                         aria-labelledby="profile-tab">
                                        <table id="datatable-responsive4" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                                            <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Sujet</th>
                                                <th class="hidden-phone">Date</th>
                                                <th class="hidden-phone">Actions</th>
                                                <!--<th>Télécharger</th>-->

                                            </tr>
                                            </thead>
                                            <tfoot>
                                            <tr>
                                                <th>#</th>
                                                <th>Sujet</th>
                                                <th class="hidden-phone">Date</th>
                                                <th class="hidden-phone">Actions</th>
                                                <!--<th>Télécharger</th>-->
                                            </tr>
                                            </tfoot>
                                            <tbody>

                                            <?php foreach ($quotations as $key => $quotation) { ?>
                                                <tr>
                                                    <td><?php echo $key; ?></td>
                                                    <td><?php echo $quotation['number'] ?></td>
                                                    <td><?php echo $quotation['reception_date'] ?></td>
                                                    <td>
                                                        <a class="btn btn-primary btn-xs editQuotation"
                                                           data-toggle="modal"
                                                           data-target="#quotationEditModal"
                                                           data-id="<?php echo $quotation['id']; ?>">Modifier</a>
                                                        <a onclick="return confirm('All records will be deleted, continue?')"
                                                           href=" <?php echo base_url(); ?>admin/employee/delete/{id}"
                                                           class="btn btn-danger btn-xs">Supprimer</a>
                                                    </td>
                                                    <!-- <td class="vertical-align-mid">

                                                     </td>-->
                                                </tr>
                                            <?php } ?>

                                            </tbody>
                                        </table>

                                       <br/>
                                        <input type="button" class="btn btn-info" value="Nouveau"
                                               data-toggle="modal"
                                               data-target="#quotationModal"/>
                                    </div>
        <!--------------------------------------------End Quotation Tab------------------------------------------------------>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


    </div>
</div>


<?php $this->load->view('admin/partials/admin_footer'); ?>
<script>
    var swal_error_lang = "<?= lang("swal_error"); ?>";
    var swal_success_edit_lang = "<?= lang("swal_success_edit"); ?>";
    var swal_warning_delete_lang = "<?= lang("swal_warning_delete"); ?>";
    var swal_success_delete_lang = "<?= lang("swal_success_delete"); ?>";
    var swal_warining_obligatory_products_lang = "<?= lang("swal_warining_obligatory_products"); ?>";

    var paid_lang = "<?= lang("paid"); ?>";
    var impaid_lang = "<?= lang("impaid"); ?>";
    var received_lang = "<?= lang("received"); ?>";
    var pending_lang = "<?= lang("pending"); ?>";
    var canceled_lang = "<?= lang("canceled"); ?>";
    var order_paid_lang = "<?= lang("order_paid"); ?>";
    var order_impaid_lang = "<?= lang("order_impaid"); ?>";
    var impay_order_lang = "<?= lang("impay_order"); ?>";
    var pay_order_lang = "<?= lang("pay_order"); ?>";


    var apiOrder_url="<?php echo base_url("admin/provider/order") ?>";
    var apiEditOrder_url="<?php echo base_url("admin/provider/apiEditOrder") ?>";
    var apiPrintOrder_url="<?php echo base_url("admin/provider/apiPrintOrder") ?>";
    var apiPrintOrder_url="<?php echo base_url("admin/provider/apiPrintOrder") ?>";
    var apiGetOrder_url="<?php echo base_url("admin/provider/apiGetOrder") ?>";
</script>
<script src="<?php echo base_url("assets/vendors/datatables.net/js/jquery.dataTables.min.js"); ?>"></script>

<script>
    $(document).ready(function () {
        var handleDataTableButtons = function () {
            if ($("#datatable-responsive1").length) {
                $("#datatable-responsive").DataTable({
                    aaSorting: [[0, 'desc']],
                    responsive: true,
                    "language": {
                        "url": "<?php echo base_url("assets/vendors/datatables.net/French.json"); ?>"
                    }
                });
            }
            if ($("#datatable-responsive4").length) {
                $("#datatable-responsive4").DataTable({
                    aaSorting: [[0, 'desc']],
                    responsive: true,
                    "language": {
                        "url": "<?php echo base_url("assets/vendors/datatables.net/French.json"); ?>"
                    }
                });
            }
            if ($("#datatable-responsive5").length) {
                $("#datatable-responsive5").DataTable({
                    aaSorting: [[0, 'desc']],
                    "ordering": false,
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




<!-- NProgress -->
<script src="<?php echo base_url('assets/vendors/bootstrap-progressbar/bootstrap-progressbar.min.js'); ?>"></script>

<!-- bootstrap-wysiwyg -->
<script src="<?php echo base_url('assets/vendors/bootstrap-wysiwyg/js/bootstrap-wysiwyg.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/vendors//jquery.hotkeys/jquery.hotkeys.js'); ?>"></script>
<script src="<?php echo base_url('assets/vendors/google-code-prettify/src/prettify.js'); ?>"></script>

<!-- ECharts -->

<script src="<?php echo base_url('assets/vendors/echarts/dist/echarts.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/vendors/moment/min/moment.min.js'); ?>"></script>

<script src="<?php echo base_url('assets/vendors/bootstrap-daterangepicker/daterangepicker.js'); ?>"></script>
<script src="<?php echo base_url('assets/build2/js/provider/newOrder.js'); ?>"></script>
<script src="<?php echo base_url('assets/build2/js/provider/editOrder.js'); ?>"></script>
<script src="<?php echo base_url('assets/build2/js/provider/productsToOrder.js'); ?>"></script>
<script src="<?php echo base_url('assets/build2/js/provider/getOrder.js'); ?>"></script>
<script>
    $('#payment_date_field').daterangepicker({
        locale: {
            format: 'DD/MM/YYYY'
        },
        singleDatePicker: true,
        singleClasses: "picker_3",
    });
    $('#order_date_field').daterangepicker({
        locale: {
            format: 'DD/MM/YYYY'
        },
        singleDatePicker: true,
        singleClasses: "picker_3",
    });
    $('#edit_order_date_field').daterangepicker({
        locale: {
            format: 'DD/MM/YYYY'
        },
        singleDatePicker: true,
        singleClasses: "picker_3",
    });
    $('#edit_payment_date_field').daterangepicker({
        locale: {
            format: 'DD/MM/YYYY'
        },
        singleDatePicker: true,
        singleClasses: "picker_3",
    });
</script>
<!--Search in table-->
<script>
    function myFunction() {
        var input, filter, table, tr, td, i;
        input = document.getElementById("searchInput");
        filter = input.value.toUpperCase();
        productsOrder = document.getElementById("productsOrder");
        profiles = productsOrder.getElementsByClassName("product");
        for (i = 0; i < profiles.length; i++) {
            profile = profiles[i].getAttribute("data-name");
            console.log(profile);
            if (profile) {
                if (profile.toUpperCase().indexOf(filter) > -1) {
                    profiles[i].style.display = "";
                } else {
                    profiles[i].style.display = "none";
                }
            }
        }
    }
</script>


<script>
    var $RIGHT_COL = $('.right_col');
</script>


<script>

    var productsCount=1;
    var productsQuotationCount=1;

    var url = document.location.toString();
    if (url.match('#')) {
        $('.nav-tabs a[href="#' + url.split('#')[1] + '"]').tab('show');
    }

    function addForm(){
        productsCount++;
        var form = $('#addProductProviderForm').clone().attr('data-id', productsCount);
        $('#addProductsModal .formList').append(form);
    }

    //add new produdct to quotation
    function addFormQuotation(product){
        productsQuotationCount++;
        var form = $('#quotationEditModal .addProviderQuotationForm[data-id="1"]').clone().attr('data-id', productsQuotationCount);
        form.addClass('toHide');
        form.removeClass('hide');

        //if we add products to be changed
        if(product){
            form.find("input[name='product_id']").val(product.id);
            form.find("input[name='name']").val(product.name);
            form.find("input[name='price']").val(product.unit_price);
        }else{
            form.find("input[name='name']").val("");
            form.find("input[name='price']").val("");
            form.find("input[name='product_id']").val("");
        }

        console.log(form);
        $('#quotationEditModal .formList').append(form);
    }

    var eventSaveData = {
        'p_productsCount': productsQuotationCount,
        'p_quotation': false,
        'status': 'active',
        'form':'addProduct'
    };

    var eventQuotationData = {
        'p_productsCount': productsQuotationCount,
        'p_quotation': true,
        'status': 'quotation',
        'form': 'quotation'
    };

    var eventApplyData = {
        'p_productsCount': productsQuotationCount,
        'p_quotation': true,
        'status': 'active',
        'form': 'quotation'
    };

    $('#saveProviderProducts').on('click', eventSaveData, saveProviderPoducts);
    $('#saveProviderQuotation,#editProviderQuotation').on('click', eventQuotationData, saveProviderPoducts);
    $('#applyProviderQuotation,#applyEditProviderQuotation').on('click', eventApplyData, saveProviderPoducts);

    function saveProviderPoducts(event){
        var productsList = [];
        var provider = $('#provider_id').attr('data-id');
        var quotation_id = $('#quotationEditModal #quotation_id').val();
        if(!quotation_id){
            quotation_id="";
        }
        var p_productsCount= productsCount;
        if(event.data.p_quotation){
            p_productsCount= productsQuotationCount;
        }
        var formSelect= '#addProductsModal form[data-id=';

        if(event.data.form==='quotation'){
            // if its edit quotation
            if (event.data.p_quotation && quotation_id) {
                formSelect = '#quotationEditModal .addProviderQuotationForm[data-id=' ;
            }

            // if its add quotation
            if (!quotation_id) {
                formSelect = '.addProviderQuotationForm[data-id=';
            }
        }
        for (i = 1; i <= p_productsCount; i++) {
            var product = '';

            // if its only add simple product price
            var form = $(formSelect + i + ']');
            console.log(form);
            var id =  form.find('input[name="product_id"]').val();
            var name =  form.find('input[name="name"]').val();
            var price = form.find('input[name="price"]').val();
            console.log(name);
            if(price && name){
                product = {"provider": provider, 'id': id, "name": name, "price": price, "status": event.data.status};
                productsList.push(product);
            }

        }
        var quotation='';
        if(quotation_id){
            var quotationNumber = $('#quotationEditModal #quotationNumber').val();
            var reception_date = $('#quotationEditModal #single_cal1').val();
            quotation= {
                'id': quotation_id,
                'provider': provider,
                'reception_date': reception_date,
                'number': quotationNumber
            };
        }

        var myData= {
                'productsList': productsList,
                'quotation': quotation
            };
        console.log(myData);
        $.ajax({
            url: "<?php echo base_url(); ?>admin/provider/apiAddProducts",
            type: "POST",
            dataType: "json",
            data: myData,
            success: function (data) {
                if (data.status === "success") {
                    swal({
                        title: "Success",
                        text: swal_success_edit_lang,
                        type: "success",
                        timer: 1500,
                        showConfirmButton: false
                    });
                    location.reload();
                }
                else {
                    console.log('Error');
                }
            },
            error: function (data) {
            }
        });
    }

    $('.editQuotation').on('click',function () {
        $.ajax({
            url: "<?php echo base_url('admin/provider/apiGetQuotation'); ?>",
            type: "POST",
            dataType: "json",
            data: {'id': $(this).attr('data-id')},
            success: function (data) {
                if (data.status === "success") {
                    var firstProduct = data.quotation[0];
                    $('#quotationEditModal #quotation_id').val(firstProduct.quotation_id);
                    $('#quotationEditModal #single_cal1').val(firstProduct.reception_date);

                    $('#quotationEditModal #quotationNumber').val(firstProduct.number);


                    $('#quotationEditModal input[name="product_id"]').val(firstProduct.id);

                    $('.addProviderQuotationForm[data-id="1"] input[name="name"]').val(firstProduct.name);
                    $('.addProviderQuotationForm[data-id="1"] input[name="price"]').val(firstProduct.unit_price);
                    data.quotation.splice(0,1);
                    $.each(data.quotation, function (key, product) {
                        addFormQuotation(product);
                        $(".infosQuotation input[name='quotation_id']").val(product.quotation_id);
                    });
                }
                else {
                    console.log('ko');
                }
            },
            error: function (data) {
                // do something
            }
        })
    });

    $('.editOrderModal').on('click',{url: apiGetOrder_url},getOrder);

    $(".payOrder").on("click",function(){

       $.ajax({
               url: "<?php echo base_url('admin/provider/apiPayOrder'); ?>",
               type: "POST",
               dataType: "json",
               data: {'id': $('.orderId').val()},
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
                              text: swal_success_edit_lang,
                              type: "success",
                              timer: 1500,
                              showConfirmButton: false
                          });
                          if(data.paid==="true"){
                              $("#tab_orders table tbody tr[data-id=" + $('.orderId').val() + "] td[data-paid] span").html(paid_lang);
                              $("#tab_orders table tbody tr[data-id=" + $('.orderId').val() + "] td[data-paymentDate]").html(data.paymentDate);
                              $("#tab_orders table tbody tr[data-id=" + $('.orderId').val() + "] td[data-paid]").addClass("orderPaid");
                              $("#tab_orders table tbody tr[data-id=" + $('.orderId').val() + "] td[data-paid]").removeClass("orderImpaid");
                              $("#editOrderModal .modal-title span").html(order_paid_lang);
                              $("#editOrderModal .modal-title").addClass("orderPaid");
                              $("#editOrderModal .modal-title").removeClass("orderImpaid");
                          }else{
                              $("#tab_orders table tbody tr[data-id=" + $('.orderId').val() + "] td[data-paid] span").html(impaid_lang);
                              $("#tab_orders table tbody tr[data-id=" + $('.orderId').val() + "] td[data-paymentDate]").html("");
                              $("#tab_orders table tbody tr[data-id=" + $('.orderId').val() + "] td[data-paid]").removeClass("orderPaid");
                              $("#tab_orders table tbody tr[data-id=" + $('.orderId').val() + "] td[data-paid]").addClass("orderImpaid");
                              $("#editOrderModal .modal-title span").html(order_impaid_lang);
                              $("#editOrderModal .modal-title").removeClass("orderPaid");
                              $("#editOrderModal .modal-title").addClass("orderImpaid");
                          }
                          $('#editOrderModal').modal('toggle');
                      }else{
                              swal({
                                  title: "Erreur",
                                  text: swal_error_lang,
                                  type: "warning",
                                  timer: 1500,
                                  showConfirmButton: false
                              });
                           }
                       },
                       error: function (data) {
                           swal({
                               title: "Erreur",
                               text: swal_error_lang,
                               type: "warning",
                               timer: 1500,
                               showConfirmButton: false
                       });
               }
       });
    });

    $("#quotationEditModal").on("hidden.bs.modal", function () {
        $("#quotationEditModal .addProviderQuotationForm.toHide").remove();
    });

    $('button[name=print]').on('click', {url: apiPrintOrder_url,sub_url:'admin/provider/apiPrintOrder'}, newOrder);
    $('button[name=printOrderProducts]').on('click', {url: apiPrintOrder_url}, productsToOrder);

    $("input[type='text'][name='quantity'],input[type='text'][name='unit_price']").keyup({productSelector:'product',quantitySelector:'quantity',priceSelector:'unit_price'},calulProductPrice);
    $("input[type='text'][name='quantityToOrder']").keyup({productSelector: 'productToOrder', quantitySelector: 'quantityToOrder'},calulProductPrice);

    function calulProductPrice(event) {
        var row = $(this).closest('.row');
        var quantity   = parseFloat(row.find('input[name="'+event.data.quantitySelector+'"]').val().replace(',', '.'));
        //var unit_price = parseFloat(row.find('input[name="' + event.data.productSelector + '"]').attr('data-price').replace(',', '.'));
        var unit_price = parseFloat(row.find('input[name="' + event.data.priceSelector + '"]').val().replace(',', '.'));
        if(quantity>0){
            row.find('.productCost').html((quantity * unit_price).toFixed(2) + 'DH');
        }else{
            row.find('.productCost').html('0 DH');
        }


    };

    $('button[name="save"]').on('click', {url: apiOrder_url,sub_url:''}, newOrder);
    $('button[name="orderProducts"]').on('click', {url: apiOrder_url,sub_url:''}, productsToOrder);

    $('button[name=editOrder]').on('click', {url: apiEditOrder_url,sub_url:''}, editOrder);
    $('button[name=editPrint]').on('click', {url: apiPrintOrder_url,sub_url:'admin/provider/apiPrintOrder'}, editOrder);



    function validate(order) {
        var validate = true;
        if (!order['productsList'].length) {
            swal({
                title: "Attention",
                text: swal_warining_obligatory_products_lang,
                type: "warning",
                timer: 2000,
                showConfirmButton: false
            });
            validate = false;
        }
        return validate;
    }




</script>



<!-- Change order status -->
<script>
    $("#changeStatus").on('click','button',changeStatusEvent);
    function changeStatusEvent(){
        var newStatus = $(this).attr("data-type");
        changeStatus("event",newStatus);
    }

    function changeStatus(type,newStatus) {
        if (type === "request" && newStatus==="received") {
            $(".orderActualStatus").attr("data-toggle", null);
            $("#changeStatus").removeClass("in");
        } else {
            $(".orderActualStatus").attr("data-toggle", "collapse");
        }
        switch (newStatus) {
            case 'received':
                $('#changeStatus').empty();
                var b1 = '<button data-toggle="collapse" data-type="pending" href="#changeStatus" type="button" class="btn btn-round btn-info">' + pending_lang + '</button>';
                var b2 = '<button data-toggle="collapse" data-type="canceled" href="#changeStatus" type="button" class="btn btn-round btn-warning">' + canceled_lang + '</button>';
                $('#changeStatus').append(b1);
                $('#changeStatus').append(b2);
                $(".orderActualStatus").html(received_lang);
                $(".orderActualStatus").addClass("btn-success");
                $(".orderActualStatus").removeClass("btn-warning");
                $(".orderActualStatus").removeClass("btn-info");
                break;
            case 'canceled':
                $('#changeStatus').empty();
                var b1 = '<button data-toggle="collapse" data-type="received" href="#changeStatus" type="button" class="btn btn-round btn-success">' + received_lang + '</button>';
                var b2 = '<button data-toggle="collapse" data-type="pending" href="#changeStatus" type="button" class="btn btn-round btn-info">' + pending_lang + '</button>';
                $('#changeStatus').append(b1);
                $('#changeStatus').append(b2);
                $(".orderActualStatus").html(canceled_lang);
                $(".orderActualStatus").addClass("btn-warning");
                $(".orderActualStatus").removeClass("btn-info");
                $(".orderActualStatus").removeClass("btn-success");
                break;
            case 'pending':
                console.log("case 3");
                $('#changeStatus').empty();
                var b1 = '<button data-toggle="collapse" data-type="received" href="#changeStatus" type="button" class="btn btn-round btn-success">'+received_lang+'</button>';
                var b2 = '<button data-toggle="collapse" data-type="canceled" href="#changeStatus" type="button" class="btn btn-round btn-warning">'+canceled_lang+'</button>';
                $('#changeStatus').append(b1);
                $('#changeStatus').append(b2);
                $(".orderActualStatus").html(pending_lang);
                $(".orderActualStatus").addClass("btn-info");
                $(".orderActualStatus").removeClass("btn-warning");
                $(".orderActualStatus").removeClass("btn-success");
                break;
            default:
            //
        }

    }
</script>

<!--Edit Profile-->

<script>
    $(document).ready(function () {
        $('.editProfile').on('click',editProfileEvent);
        function editProfileEvent(){
            $(window).scrollTop($('.provider-firstName').offset().top);
            $('.saveProfile').show();

            editProviderData(true);
            $('.provider-firstName').focus();

        }

        $('.saveProfile').on('click', saveProfileEvent);
        function saveProfileEvent(){
            var provider = {
                'title': $.trim($('.provider-title').text()),
                'name': $.trim($('.provider-firstName').text()),
                'prenom':$.trim($('.provider-lastName').text()),
                'address':$.trim($('.provider-address').text()),
                'mail':$.trim($('.provider-mail').text()),
                'phone':$.trim($('.provider-phone').text()),
                'id':$('#provider_id').attr('data-id')
            };
            $('#loading').show();
            $.ajax({
                url: "<?php echo base_url('admin/provider/apiUpdate'); ?>",
                type: "POST",
                dataType: "json",
                data: {'provider': provider},
                success: function (data) {
                    if (data.status === 'success') {
                        $('#loading').hide();
                        $('.saveProfile').hide();
                        editProviderData(false);
                        swal({
                            title: "Success",
                            text: swal_success_edit_lang,
                            type: "success",
                            timer: 1500,
                            showConfirmButton: false
                        });
                        location.reload();
                    }
                    else {
                        $('#loading').hide();
                        swal({
                                title: "Erreur",
                                text: swal_error_lang,
                                type: "error",
                                timer:1500
                            });
                        }

                },
                error: function (data) {
                    $('#loading').hide();
                    swal({
                        title: "Erreur",
                        text: swal_error_lang,
                        type: "error",
                        timer: 1500
                    });
                }
            });
        }


        function editProviderData(edit){
            $('.provider-firstName').attr('contenteditable', edit);
            $('.provider-lastName').attr('contenteditable', edit);
            $('.provider-title').attr('contenteditable', edit);
            $('.provider-address').attr('contenteditable', edit);
            $('.provider-phone').attr('contenteditable', edit);
            $('.provider-mail').attr('contenteditable', edit);
        }
    });
</script>



<!--Edit Product-->

<script>
    $(document).ready(function () {
        $('.editProductsModal').on('click',getProduct);
        $('#editProviderProducts').on('click', editProductProviderForm);
        function editProductProviderForm() {
            var row = $(this).closest('.modal-content');
            var product={
              'id':     row.find('input[name=id]').val(),
              'name':   row.find('input[name=name]').val(),
              'unit_price':  row.find('input[name=price]').val()
            };
            $.ajax({
                    url: "<?php echo base_url('admin/product/apiEditForProvider'); ?>",
                    type: "POST",
                    dataType: "json",
                    data: {'product':product},
                    success: function (data) {
                        if (data.status === 'success') {
                            swal({
                                title: "Success",
                                text: swal_success_edit_lang,
                                type: "success",
                                timer: 1500,
                                showConfirmButton: false
                            });
                            location.reload();
                        }
                        else {
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
        function getProduct() {
            var product = $(this).attr('data-id');
            $.ajax({
                    url: "<?php echo base_url('admin/product/apiGetByProvider'); ?>",
                    type: "POST",
                    dataType: "json",
                    data: {'product':product,'provider': $('#provider_id').attr('data-id')},
                    success: function (data) {
                        if (data.status === 'success') {
                            console.log(data['product']['name']);
                            $('#editProductsModal input[name=id]').val(data['product']['id']);
                            $('#editProductsModal input[name=name]').val(data['product']['name']);
                            $('#editProductsModal input[name=price]').val(data['product']['unit_price']);
                        }
                        else {

                        }
                    },
                    error: function (data) {
                    }
               });
        }
    });
</script>
<script>
    $(document).ready(function () {
        $('a.deleteProduct').on('click', deleteProductEvent);

        function deleteProductEvent() {
            var product_id = $(this).closest('tr').attr('data-id');
            var quantity_id = $(this).closest('tr').attr('data-quantity');
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
                    $.ajax({
                        url: "<?php echo base_url('admin/provider/apiDeleteProduit'); ?>",
                        type: "POST",
                        dataType: "json",
                        data: {'product_id': product_id,"quantity_id": quantity_id},
                        success: function (data) {
                            if (data.status === 'success') {
                                swal({
                                    title: "Success",
                                    text: swal_success_delete_lang,
                                    type: "success",
                                    timer: 1500,
                                    showConfirmButton: false
                                });
                                location.reload();
                            }
                            else {
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

                });


        }
    });
</script>
<script>
    $(document).ready(function () {
        $('a.deleteOrder').on('click', deleteOrder);


        function deleteOrder() {
            var order_id = $(this).attr('data-id');
            $(this).closest('tr').hide();
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
                    $.ajax({
                        url: "<?php echo base_url('admin/provider/apiDeleteOrder'); ?>",
                        type: "POST",
                        dataType: "json",
                        data: {'order_id': order_id},
                        success: function (data) {
                            if (data.status === 'success') {
                                swal({
                                    title: "Success",
                                    text: swal_success_delete_lang,
                                    type: "success",
                                    timer: 1500,
                                    showConfirmButton: false
                                });
                                location.reload();
                            }
                            else {
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

                });


        }
    });
</script>

<!--init_echarts-->
<script>
    $(document).ready(function () {
        function init_echarts() {

            if (typeof (echarts) === 'undefined') {
                return;
            }
            console.log('init_echarts');


            var theme = {
                color: [
                    '#26B99A', '#34495E', '#BDC3C7', '#3498DB',
                    '#9B59B6', '#8abb6f', '#759c6a', '#bfd3b7'
                ],

                title: {
                    itemGap: 8,
                    textStyle: {
                        fontWeight: 'normal',
                        color: '#408829'
                    }
                },

                dataRange: {
                    color: ['#1f610a', '#97b58d']
                },

                toolbox: {
                    color: ['#408829', '#408829', '#408829', '#408829']
                },

                tooltip: {
                    backgroundColor: 'rgba(0,0,0,0.5)',
                    axisPointer: {
                        type: 'line',
                        lineStyle: {
                            color: '#408829',
                            type: 'dashed'
                        },
                        crossStyle: {
                            color: '#408829'
                        },
                        shadowStyle: {
                            color: 'rgba(200,200,200,0.3)'
                        }
                    }
                },

                dataZoom: {
                    dataBackgroundColor: '#eee',
                    fillerColor: 'rgba(64,136,41,0.2)',
                    handleColor: '#408829'
                },
                grid: {
                    borderWidth: 0
                },

                categoryAxis: {
                    axisLine: {
                        lineStyle: {
                            color: '#408829'
                        }
                    },
                    splitLine: {
                        lineStyle: {
                            color: ['#eee']
                        }
                    }
                },

                valueAxis: {
                    axisLine: {
                        lineStyle: {
                            color: '#408829'
                        }
                    },
                    splitArea: {
                        show: true,
                        areaStyle: {
                            color: ['rgba(250,250,250,0.1)', 'rgba(200,200,200,0.1)']
                        }
                    },
                    splitLine: {
                        lineStyle: {
                            color: ['#eee']
                        }
                    }
                },
                timeline: {
                    lineStyle: {
                        color: '#408829'
                    },
                    controlStyle: {
                        normal: {color: '#408829'},
                        emphasis: {color: '#408829'}
                    }
                },

                k: {
                    itemStyle: {
                        normal: {
                            color: '#68a54a',
                            color0: '#a9cba2',
                            lineStyle: {
                                width: 1,
                                color: '#408829',
                                color0: '#86b379'
                            }
                        }
                    }
                },
                map: {
                    itemStyle: {
                        normal: {
                            areaStyle: {
                                color: '#ddd'
                            },
                            label: {
                                textStyle: {
                                    color: '#c12e34'
                                }
                            }
                        },
                        emphasis: {
                            areaStyle: {
                                color: '#99d2dd'
                            },
                            label: {
                                textStyle: {
                                    color: '#c12e34'
                                }
                            }
                        }
                    }
                },
                force: {
                    itemStyle: {
                        normal: {
                            linkStyle: {
                                strokeColor: '#408829'
                            }
                        }
                    }
                },
                chord: {
                    padding: 4,
                    itemStyle: {
                        normal: {
                            lineStyle: {
                                width: 1,
                                color: 'rgba(128, 128, 128, 0.5)'
                            },
                            chordStyle: {
                                lineStyle: {
                                    width: 1,
                                    color: 'rgba(128, 128, 128, 0.5)'
                                }
                            }
                        },
                        emphasis: {
                            lineStyle: {
                                width: 1,
                                color: 'rgba(128, 128, 128, 0.5)'
                            },
                            chordStyle: {
                                lineStyle: {
                                    width: 1,
                                    color: 'rgba(128, 128, 128, 0.5)'
                                }
                            }
                        }
                    }
                },
                gauge: {
                    startAngle: 225,
                    endAngle: -45,
                    axisLine: {
                        show: true,
                        lineStyle: {
                            color: [[0.2, '#86b379'], [0.8, '#68a54a'], [1, '#408829']],
                            width: 8
                        }
                    },
                    axisTick: {
                        splitNumber: 10,
                        length: 12,
                        lineStyle: {
                            color: 'auto'
                        }
                    },
                    axisLabel: {
                        textStyle: {
                            color: 'auto'
                        }
                    },
                    splitLine: {
                        length: 18,
                        lineStyle: {
                            color: 'auto'
                        }
                    },
                    pointer: {
                        length: '90%',
                        color: 'auto'
                    },
                    title: {
                        textStyle: {
                            color: '#333'
                        }
                    },
                    detail: {
                        textStyle: {
                            color: 'auto'
                        }
                    }
                },
                textStyle: {
                    fontFamily: 'Arial, Verdana, sans-serif'
                }
            };


            //echart Bar

            if ($('#mainb').length) {

                var echartBar = echarts.init(document.getElementById('mainb'), theme);

                echartBar.setOption({
                    title: {
                        text: 'Graph title',
                        subtext: 'Graph Sub-text'
                    },
                    tooltip: {
                        trigger: 'axis'
                    },
                    legend: {
                        data: ['sales', 'purchases']
                    },
                    toolbox: {
                        show: false
                    },
                    calculable: false,
                    xAxis: [{
                        type: 'category',
                        data: ['1?', '2?', '3?', '4?', '5?', '6?', '7?', '8?', '9?', '10?', '11?', '12?']
                    }],
                    yAxis: [{
                        type: 'value'
                    }],
                    series: [{
                        name: 'sales',
                        type: 'bar',
                        data: [2.0, 4.9, 7.0, 23.2, 25.6, 76.7, 135.6, 162.2, 32.6, 20.0, 6.4, 3.3],
                        markPoint: {
                            data: [{
                                type: 'max',
                                name: '???'
                            }, {
                                type: 'min',
                                name: '???'
                            }]
                        },
                        markLine: {
                            data: [{
                                type: 'average',
                                name: '???'
                            }]
                        }
                    }, {
                        name: 'purchases',
                        type: 'bar',
                        data: [2.6, 5.9, 9.0, 26.4, 28.7, 70.7, 175.6, 182.2, 48.7, 18.8, 6.0, 2.3],
                        markPoint: {
                            data: [{
                                name: 'sales',
                                value: 182.2,
                                xAxis: 7,
                                yAxis: 183,
                            }, {
                                name: 'purchases',
                                value: 2.3,
                                xAxis: 11,
                                yAxis: 3
                            }]
                        },
                        markLine: {
                            data: [{
                                type: 'average',
                                name: '???'
                            }]
                        }
                    }]
                });

            }


            //echart Radar

            if ($('#echart_sonar').length) {

                var echartRadar = echarts.init(document.getElementById('echart_sonar'), theme);

                echartRadar.setOption({
                    title: {
                        text: 'Budget vs spending',
                        subtext: 'Subtitle'
                    },
                    tooltip: {
                        trigger: 'item'
                    },
                    legend: {
                        orient: 'vertical',
                        x: 'right',
                        y: 'bottom',
                        data: ['Allocated Budget', 'Actual Spending']
                    },
                    toolbox: {
                        show: true,
                        feature: {
                            restore: {
                                show: true,
                                title: "Restore"
                            },
                            saveAsImage: {
                                show: true,
                                title: "Save Image"
                            }
                        }
                    },
                    polar: [{
                        indicator: [{
                            text: 'Sales',
                            max: 6000
                        }, {
                            text: 'Administration',
                            max: 16000
                        }, {
                            text: 'Information Techology',
                            max: 30000
                        }, {
                            text: 'Customer Support',
                            max: 38000
                        }, {
                            text: 'Development',
                            max: 52000
                        }, {
                            text: 'Marketing',
                            max: 25000
                        }]
                    }],
                    calculable: true,
                    series: [{
                        name: 'Budget vs spending',
                        type: 'radar',
                        data: [{
                            value: [4300, 10000, 28000, 35000, 50000, 19000],
                            name: 'Allocated Budget'
                        }, {
                            value: [5000, 14000, 28000, 31000, 42000, 21000],
                            name: 'Actual Spending'
                        }]
                    }]
                });

            }

            //echart Funnel

            if ($('#echart_pyramid').length) {

                var echartFunnel = echarts.init(document.getElementById('echart_pyramid'), theme);

                echartFunnel.setOption({
                    title: {
                        text: 'Echart Pyramid Graph',
                        subtext: 'Subtitle'
                    },
                    tooltip: {
                        trigger: 'item',
                        formatter: "{a} <br/>{b} : {c}%"
                    },
                    toolbox: {
                        show: true,
                        feature: {
                            restore: {
                                show: true,
                                title: "Restore"
                            },
                            saveAsImage: {
                                show: true,
                                title: "Save Image"
                            }
                        }
                    },
                    legend: {
                        data: ['Something #1', 'Something #2', 'Something #3', 'Something #4', 'Something #5'],
                        orient: 'vertical',
                        x: 'left',
                        y: 'bottom'
                    },
                    calculable: true,
                    series: [{
                        name: '漏斗图',
                        type: 'funnel',
                        width: '40%',
                        data: [{
                            value: 60,
                            name: 'Something #1'
                        }, {
                            value: 40,
                            name: 'Something #2'
                        }, {
                            value: 20,
                            name: 'Something #3'
                        }, {
                            value: 80,
                            name: 'Something #4'
                        }, {
                            value: 100,
                            name: 'Something #5'
                        }]
                    }]
                });

            }

            //echart Gauge

            if ($('#echart_gauge').length) {

                var echartGauge = echarts.init(document.getElementById('echart_gauge'), theme);

                echartGauge.setOption({
                    tooltip: {
                        formatter: "{a} <br/>{b} : {c}%"
                    },
                    toolbox: {
                        show: true,
                        feature: {
                            restore: {
                                show: true,
                                title: "Restore"
                            },
                            saveAsImage: {
                                show: true,
                                title: "Save Image"
                            }
                        }
                    },
                    series: [{
                        name: 'Performance',
                        type: 'gauge',
                        center: ['50%', '50%'],
                        startAngle: 140,
                        endAngle: -140,
                        min: 0,
                        max: 100,
                        precision: 0,
                        splitNumber: 10,
                        axisLine: {
                            show: true,
                            lineStyle: {
                                color: [
                                    [0.2, 'lightgreen'],
                                    [0.4, 'orange'],
                                    [0.8, 'skyblue'],
                                    [1, '#ff4500']
                                ],
                                width: 30
                            }
                        },
                        axisTick: {
                            show: true,
                            splitNumber: 5,
                            length: 8,
                            lineStyle: {
                                color: '#eee',
                                width: 1,
                                type: 'solid'
                            }
                        },
                        axisLabel: {
                            show: true,
                            formatter: function (v) {
                                switch (v + '') {
                                    case '10':
                                        return 'a';
                                    case '30':
                                        return 'b';
                                    case '60':
                                        return 'c';
                                    case '90':
                                        return 'd';
                                    default:
                                        return '';
                                }
                            },
                            textStyle: {
                                color: '#333'
                            }
                        },
                        splitLine: {
                            show: true,
                            length: 30,
                            lineStyle: {
                                color: '#eee',
                                width: 2,
                                type: 'solid'
                            }
                        },
                        pointer: {
                            length: '80%',
                            width: 8,
                            color: 'auto'
                        },
                        title: {
                            show: true,
                            offsetCenter: ['-65%', -10],
                            textStyle: {
                                color: '#333',
                                fontSize: 15
                            }
                        },
                        detail: {
                            show: true,
                            backgroundColor: 'rgba(0,0,0,0)',
                            borderWidth: 0,
                            borderColor: '#ccc',
                            width: 100,
                            height: 40,
                            offsetCenter: ['-60%', 10],
                            formatter: '{value}%',
                            textStyle: {
                                color: 'auto',
                                fontSize: 30
                            }
                        },
                        data: [{
                            value: 50,
                            name: 'Performance'
                        }]
                    }]
                });

            }

            //echart Line

            if ($('#echart_line').length) {

                var echartLine = echarts.init(document.getElementById('echart_line'), theme);

                echartLine.setOption({
                    title: {
                        text: 'Line Graph',
                        subtext: 'Subtitle'
                    },
                    tooltip: {
                        trigger: 'axis'
                    },
                    legend: {
                        x: 220,
                        y: 40,
                        data: ['Intent', 'Pre-order', 'Deal']
                    },
                    toolbox: {
                        show: true,
                        feature: {
                            magicType: {
                                show: true,
                                title: {
                                    line: 'Line',
                                    bar: 'Bar',
                                    stack: 'Stack',
                                    tiled: 'Tiled'
                                },
                                type: ['line', 'bar', 'stack', 'tiled']
                            },
                            restore: {
                                show: true,
                                title: "Restore"
                            },
                            saveAsImage: {
                                show: true,
                                title: "Save Image"
                            }
                        }
                    },
                    calculable: true,
                    xAxis: [{
                        type: 'category',
                        boundaryGap: false,
                        data: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun']
                    }],
                    yAxis: [{
                        type: 'value'
                    }],
                    series: [{
                        name: 'Deal',
                        type: 'line',
                        smooth: true,
                        itemStyle: {
                            normal: {
                                areaStyle: {
                                    type: 'default'
                                }
                            }
                        },
                        data: [10, 12, 21, 54, 260, 830, 710]
                    }, {
                        name: 'Pre-order',
                        type: 'line',
                        smooth: true,
                        itemStyle: {
                            normal: {
                                areaStyle: {
                                    type: 'default'
                                }
                            }
                        },
                        data: [30, 182, 434, 791, 390, 30, 10]
                    }, {
                        name: 'Intent',
                        type: 'line',
                        smooth: true,
                        itemStyle: {
                            normal: {
                                areaStyle: {
                                    type: 'default'
                                }
                            }
                        },
                        data: [1320, 1132, 601, 234, 120, 90, 20]
                    }]
                });

            }

            //echart Scatter

            if ($('#echart_scatter').length) {

                var echartScatter = echarts.init(document.getElementById('echart_scatter'), theme);

                echartScatter.setOption({
                    title: {
                        text: 'Scatter Graph',
                        subtext: 'Heinz  2003'
                    },
                    tooltip: {
                        trigger: 'axis',
                        showDelay: 0,
                        axisPointer: {
                            type: 'cross',
                            lineStyle: {
                                type: 'dashed',
                                width: 1
                            }
                        }
                    },
                    legend: {
                        data: ['Data2', 'Data1']
                    },
                    toolbox: {
                        show: true,
                        feature: {
                            saveAsImage: {
                                show: true,
                                title: "Save Image"
                            }
                        }
                    },
                    xAxis: [{
                        type: 'value',
                        scale: true,
                        axisLabel: {
                            formatter: '{value} cm'
                        }
                    }],
                    yAxis: [{
                        type: 'value',
                        scale: true,
                        axisLabel: {
                            formatter: '{value} kg'
                        }
                    }],
                    series: [{
                        name: 'Data1',
                        type: 'scatter',
                        tooltip: {
                            trigger: 'item',
                            formatter: function (params) {
                                if (params.value.length > 1) {
                                    return params.seriesName + ' :<br/>' + params.value[0] + 'cm ' + params.value[1] + 'kg ';
                                } else {
                                    return params.seriesName + ' :<br/>' + params.name + ' : ' + params.value + 'kg ';
                                }
                            }
                        },
                        data: [
                            [161.2, 51.6],
                            [167.5, 59.0],
                            [159.5, 49.2],
                            [157.0, 63.0],
                            [155.8, 53.6],
                            [170.0, 59.0],
                            [159.1, 47.6],
                            [166.0, 69.8],
                            [176.2, 66.8],
                            [160.2, 75.2],
                            [172.5, 55.2],
                            [170.9, 54.2],
                            [172.9, 62.5],
                            [153.4, 42.0],
                            [160.0, 50.0],
                            [147.2, 49.8],
                            [168.2, 49.2],
                            [175.0, 73.2],
                            [157.0, 47.8],
                            [167.6, 68.8],
                            [159.5, 50.6],
                            [175.0, 82.5],
                            [166.8, 57.2],
                            [176.5, 87.8],
                            [170.2, 72.8],
                            [174.0, 54.5],
                            [173.0, 59.8],
                            [179.9, 67.3],
                            [170.5, 67.8],
                            [160.0, 47.0],
                            [154.4, 46.2],
                            [162.0, 55.0],
                            [176.5, 83.0],
                            [160.0, 54.4],
                            [152.0, 45.8],
                            [162.1, 53.6],
                            [170.0, 73.2],
                            [160.2, 52.1],
                            [161.3, 67.9],
                            [166.4, 56.6],
                            [168.9, 62.3],
                            [163.8, 58.5],
                            [167.6, 54.5],
                            [160.0, 50.2],
                            [161.3, 60.3],
                            [167.6, 58.3],
                            [165.1, 56.2],
                            [160.0, 50.2],
                            [170.0, 72.9],
                            [157.5, 59.8],
                            [167.6, 61.0],
                            [160.7, 69.1],
                            [163.2, 55.9],
                            [152.4, 46.5],
                            [157.5, 54.3],
                            [168.3, 54.8],
                            [180.3, 60.7],
                            [165.5, 60.0],
                            [165.0, 62.0],
                            [164.5, 60.3],
                            [156.0, 52.7],
                            [160.0, 74.3],
                            [163.0, 62.0],
                            [165.7, 73.1],
                            [161.0, 80.0],
                            [162.0, 54.7],
                            [166.0, 53.2],
                            [174.0, 75.7],
                            [172.7, 61.1],
                            [167.6, 55.7],
                            [151.1, 48.7],
                            [164.5, 52.3],
                            [163.5, 50.0],
                            [152.0, 59.3],
                            [169.0, 62.5],
                            [164.0, 55.7],
                            [161.2, 54.8],
                            [155.0, 45.9],
                            [170.0, 70.6],
                            [176.2, 67.2],
                            [170.0, 69.4],
                            [162.5, 58.2],
                            [170.3, 64.8],
                            [164.1, 71.6],
                            [169.5, 52.8],
                            [163.2, 59.8],
                            [154.5, 49.0],
                            [159.8, 50.0],
                            [173.2, 69.2],
                            [170.0, 55.9],
                            [161.4, 63.4],
                            [169.0, 58.2],
                            [166.2, 58.6],
                            [159.4, 45.7],
                            [162.5, 52.2],
                            [159.0, 48.6],
                            [162.8, 57.8],
                            [159.0, 55.6],
                            [179.8, 66.8],
                            [162.9, 59.4],
                            [161.0, 53.6],
                            [151.1, 73.2],
                            [168.2, 53.4],
                            [168.9, 69.0],
                            [173.2, 58.4],
                            [171.8, 56.2],
                            [178.0, 70.6],
                            [164.3, 59.8],
                            [163.0, 72.0],
                            [168.5, 65.2],
                            [166.8, 56.6],
                            [172.7, 105.2],
                            [163.5, 51.8],
                            [169.4, 63.4],
                            [167.8, 59.0],
                            [159.5, 47.6],
                            [167.6, 63.0],
                            [161.2, 55.2],
                            [160.0, 45.0],
                            [163.2, 54.0],
                            [162.2, 50.2],
                            [161.3, 60.2],
                            [149.5, 44.8],
                            [157.5, 58.8],
                            [163.2, 56.4],
                            [172.7, 62.0],
                            [155.0, 49.2],
                            [156.5, 67.2],
                            [164.0, 53.8],
                            [160.9, 54.4],
                            [162.8, 58.0],
                            [167.0, 59.8],
                            [160.0, 54.8],
                            [160.0, 43.2],
                            [168.9, 60.5],
                            [158.2, 46.4],
                            [156.0, 64.4],
                            [160.0, 48.8],
                            [167.1, 62.2],
                            [158.0, 55.5],
                            [167.6, 57.8],
                            [156.0, 54.6],
                            [162.1, 59.2],
                            [173.4, 52.7],
                            [159.8, 53.2],
                            [170.5, 64.5],
                            [159.2, 51.8],
                            [157.5, 56.0],
                            [161.3, 63.6],
                            [162.6, 63.2],
                            [160.0, 59.5],
                            [168.9, 56.8],
                            [165.1, 64.1],
                            [162.6, 50.0],
                            [165.1, 72.3],
                            [166.4, 55.0],
                            [160.0, 55.9],
                            [152.4, 60.4],
                            [170.2, 69.1],
                            [162.6, 84.5],
                            [170.2, 55.9],
                            [158.8, 55.5],
                            [172.7, 69.5],
                            [167.6, 76.4],
                            [162.6, 61.4],
                            [167.6, 65.9],
                            [156.2, 58.6],
                            [175.2, 66.8],
                            [172.1, 56.6],
                            [162.6, 58.6],
                            [160.0, 55.9],
                            [165.1, 59.1],
                            [182.9, 81.8],
                            [166.4, 70.7],
                            [165.1, 56.8],
                            [177.8, 60.0],
                            [165.1, 58.2],
                            [175.3, 72.7],
                            [154.9, 54.1],
                            [158.8, 49.1],
                            [172.7, 75.9],
                            [168.9, 55.0],
                            [161.3, 57.3],
                            [167.6, 55.0],
                            [165.1, 65.5],
                            [175.3, 65.5],
                            [157.5, 48.6],
                            [163.8, 58.6],
                            [167.6, 63.6],
                            [165.1, 55.2],
                            [165.1, 62.7],
                            [168.9, 56.6],
                            [162.6, 53.9],
                            [164.5, 63.2],
                            [176.5, 73.6],
                            [168.9, 62.0],
                            [175.3, 63.6],
                            [159.4, 53.2],
                            [160.0, 53.4],
                            [170.2, 55.0],
                            [162.6, 70.5],
                            [167.6, 54.5],
                            [162.6, 54.5],
                            [160.7, 55.9],
                            [160.0, 59.0],
                            [157.5, 63.6],
                            [162.6, 54.5],
                            [152.4, 47.3],
                            [170.2, 67.7],
                            [165.1, 80.9],
                            [172.7, 70.5],
                            [165.1, 60.9],
                            [170.2, 63.6],
                            [170.2, 54.5],
                            [170.2, 59.1],
                            [161.3, 70.5],
                            [167.6, 52.7],
                            [167.6, 62.7],
                            [165.1, 86.3],
                            [162.6, 66.4],
                            [152.4, 67.3],
                            [168.9, 63.0],
                            [170.2, 73.6],
                            [175.2, 62.3],
                            [175.2, 57.7],
                            [160.0, 55.4],
                            [165.1, 104.1],
                            [174.0, 55.5],
                            [170.2, 77.3],
                            [160.0, 80.5],
                            [167.6, 64.5],
                            [167.6, 72.3],
                            [167.6, 61.4],
                            [154.9, 58.2],
                            [162.6, 81.8],
                            [175.3, 63.6],
                            [171.4, 53.4],
                            [157.5, 54.5],
                            [165.1, 53.6],
                            [160.0, 60.0],
                            [174.0, 73.6],
                            [162.6, 61.4],
                            [174.0, 55.5],
                            [162.6, 63.6],
                            [161.3, 60.9],
                            [156.2, 60.0],
                            [149.9, 46.8],
                            [169.5, 57.3],
                            [160.0, 64.1],
                            [175.3, 63.6],
                            [169.5, 67.3],
                            [160.0, 75.5],
                            [172.7, 68.2],
                            [162.6, 61.4],
                            [157.5, 76.8],
                            [176.5, 71.8],
                            [164.4, 55.5],
                            [160.7, 48.6],
                            [174.0, 66.4],
                            [163.8, 67.3]
                        ],
                        markPoint: {
                            data: [{
                                type: 'max',
                                name: 'Max'
                            }, {
                                type: 'min',
                                name: 'Min'
                            }]
                        },
                        markLine: {
                            data: [{
                                type: 'average',
                                name: 'Mean'
                            }]
                        }
                    }, {
                        name: 'Data2',
                        type: 'scatter',
                        tooltip: {
                            trigger: 'item',
                            formatter: function (params) {
                                if (params.value.length > 1) {
                                    return params.seriesName + ' :<br/>' + params.value[0] + 'cm ' + params.value[1] + 'kg ';
                                } else {
                                    return params.seriesName + ' :<br/>' + params.name + ' : ' + params.value + 'kg ';
                                }
                            }
                        },
                        data: [
                            [174.0, 65.6],
                            [175.3, 71.8],
                            [193.5, 80.7],
                            [186.5, 72.6],
                            [187.2, 78.8],
                            [181.5, 74.8],
                            [184.0, 86.4],
                            [184.5, 78.4],
                            [175.0, 62.0],
                            [184.0, 81.6],
                            [180.0, 76.6],
                            [177.8, 83.6],
                            [192.0, 90.0],
                            [176.0, 74.6],
                            [174.0, 71.0],
                            [184.0, 79.6],
                            [192.7, 93.8],
                            [171.5, 70.0],
                            [173.0, 72.4],
                            [176.0, 85.9],
                            [176.0, 78.8],
                            [180.5, 77.8],
                            [172.7, 66.2],
                            [176.0, 86.4],
                            [173.5, 81.8],
                            [178.0, 89.6],
                            [180.3, 82.8],
                            [180.3, 76.4],
                            [164.5, 63.2],
                            [173.0, 60.9],
                            [183.5, 74.8],
                            [175.5, 70.0],
                            [188.0, 72.4],
                            [189.2, 84.1],
                            [172.8, 69.1],
                            [170.0, 59.5],
                            [182.0, 67.2],
                            [170.0, 61.3],
                            [177.8, 68.6],
                            [184.2, 80.1],
                            [186.7, 87.8],
                            [171.4, 84.7],
                            [172.7, 73.4],
                            [175.3, 72.1],
                            [180.3, 82.6],
                            [182.9, 88.7],
                            [188.0, 84.1],
                            [177.2, 94.1],
                            [172.1, 74.9],
                            [167.0, 59.1],
                            [169.5, 75.6],
                            [174.0, 86.2],
                            [172.7, 75.3],
                            [182.2, 87.1],
                            [164.1, 55.2],
                            [163.0, 57.0],
                            [171.5, 61.4],
                            [184.2, 76.8],
                            [174.0, 86.8],
                            [174.0, 72.2],
                            [177.0, 71.6],
                            [186.0, 84.8],
                            [167.0, 68.2],
                            [171.8, 66.1],
                            [182.0, 72.0],
                            [167.0, 64.6],
                            [177.8, 74.8],
                            [164.5, 70.0],
                            [192.0, 101.6],
                            [175.5, 63.2],
                            [171.2, 79.1],
                            [181.6, 78.9],
                            [167.4, 67.7],
                            [181.1, 66.0],
                            [177.0, 68.2],
                            [174.5, 63.9],
                            [177.5, 72.0],
                            [170.5, 56.8],
                            [182.4, 74.5],
                            [197.1, 90.9],
                            [180.1, 93.0],
                            [175.5, 80.9],
                            [180.6, 72.7],
                            [184.4, 68.0],
                            [175.5, 70.9],
                            [180.6, 72.5],
                            [177.0, 72.5],
                            [177.1, 83.4],
                            [181.6, 75.5],
                            [176.5, 73.0],
                            [175.0, 70.2],
                            [174.0, 73.4],
                            [165.1, 70.5],
                            [177.0, 68.9],
                            [192.0, 102.3],
                            [176.5, 68.4],
                            [169.4, 65.9],
                            [182.1, 75.7],
                            [179.8, 84.5],
                            [175.3, 87.7],
                            [184.9, 86.4],
                            [177.3, 73.2],
                            [167.4, 53.9],
                            [178.1, 72.0],
                            [168.9, 55.5],
                            [157.2, 58.4],
                            [180.3, 83.2],
                            [170.2, 72.7],
                            [177.8, 64.1],
                            [172.7, 72.3],
                            [165.1, 65.0],
                            [186.7, 86.4],
                            [165.1, 65.0],
                            [174.0, 88.6],
                            [175.3, 84.1],
                            [185.4, 66.8],
                            [177.8, 75.5],
                            [180.3, 93.2],
                            [180.3, 82.7],
                            [177.8, 58.0],
                            [177.8, 79.5],
                            [177.8, 78.6],
                            [177.8, 71.8],
                            [177.8, 116.4],
                            [163.8, 72.2],
                            [188.0, 83.6],
                            [198.1, 85.5],
                            [175.3, 90.9],
                            [166.4, 85.9],
                            [190.5, 89.1],
                            [166.4, 75.0],
                            [177.8, 77.7],
                            [179.7, 86.4],
                            [172.7, 90.9],
                            [190.5, 73.6],
                            [185.4, 76.4],
                            [168.9, 69.1],
                            [167.6, 84.5],
                            [175.3, 64.5],
                            [170.2, 69.1],
                            [190.5, 108.6],
                            [177.8, 86.4],
                            [190.5, 80.9],
                            [177.8, 87.7],
                            [184.2, 94.5],
                            [176.5, 80.2],
                            [177.8, 72.0],
                            [180.3, 71.4],
                            [171.4, 72.7],
                            [172.7, 84.1],
                            [172.7, 76.8],
                            [177.8, 63.6],
                            [177.8, 80.9],
                            [182.9, 80.9],
                            [170.2, 85.5],
                            [167.6, 68.6],
                            [175.3, 67.7],
                            [165.1, 66.4],
                            [185.4, 102.3],
                            [181.6, 70.5],
                            [172.7, 95.9],
                            [190.5, 84.1],
                            [179.1, 87.3],
                            [175.3, 71.8],
                            [170.2, 65.9],
                            [193.0, 95.9],
                            [171.4, 91.4],
                            [177.8, 81.8],
                            [177.8, 96.8],
                            [167.6, 69.1],
                            [167.6, 82.7],
                            [180.3, 75.5],
                            [182.9, 79.5],
                            [176.5, 73.6],
                            [186.7, 91.8],
                            [188.0, 84.1],
                            [188.0, 85.9],
                            [177.8, 81.8],
                            [174.0, 82.5],
                            [177.8, 80.5],
                            [171.4, 70.0],
                            [185.4, 81.8],
                            [185.4, 84.1],
                            [188.0, 90.5],
                            [188.0, 91.4],
                            [182.9, 89.1],
                            [176.5, 85.0],
                            [175.3, 69.1],
                            [175.3, 73.6],
                            [188.0, 80.5],
                            [188.0, 82.7],
                            [175.3, 86.4],
                            [170.5, 67.7],
                            [179.1, 92.7],
                            [177.8, 93.6],
                            [175.3, 70.9],
                            [182.9, 75.0],
                            [170.8, 93.2],
                            [188.0, 93.2],
                            [180.3, 77.7],
                            [177.8, 61.4],
                            [185.4, 94.1],
                            [168.9, 75.0],
                            [185.4, 83.6],
                            [180.3, 85.5],
                            [174.0, 73.9],
                            [167.6, 66.8],
                            [182.9, 87.3],
                            [160.0, 72.3],
                            [180.3, 88.6],
                            [167.6, 75.5],
                            [186.7, 101.4],
                            [175.3, 91.1],
                            [175.3, 67.3],
                            [175.9, 77.7],
                            [175.3, 81.8],
                            [179.1, 75.5],
                            [181.6, 84.5],
                            [177.8, 76.6],
                            [182.9, 85.0],
                            [177.8, 102.5],
                            [184.2, 77.3],
                            [179.1, 71.8],
                            [176.5, 87.9],
                            [188.0, 94.3],
                            [174.0, 70.9],
                            [167.6, 64.5],
                            [170.2, 77.3],
                            [167.6, 72.3],
                            [188.0, 87.3],
                            [174.0, 80.0],
                            [176.5, 82.3],
                            [180.3, 73.6],
                            [167.6, 74.1],
                            [188.0, 85.9],
                            [180.3, 73.2],
                            [167.6, 76.3],
                            [183.0, 65.9],
                            [183.0, 90.9],
                            [179.1, 89.1],
                            [170.2, 62.3],
                            [177.8, 82.7],
                            [179.1, 79.1],
                            [190.5, 98.2],
                            [177.8, 84.1],
                            [180.3, 83.2],
                            [180.3, 83.2]
                        ],
                        markPoint: {
                            data: [{
                                type: 'max',
                                name: 'Max'
                            }, {
                                type: 'min',
                                name: 'Min'
                            }]
                        },
                        markLine: {
                            data: [{
                                type: 'average',
                                name: 'Mean'
                            }]
                        }
                    }]
                });

            }

            //echart Bar Horizontal

            if ($('#echart_bar_horizontal').length) {

                var echartBar = echarts.init(document.getElementById('echart_bar_horizontal'), theme);

                echartBar.setOption({
                    title: {
                        text: 'Bar Graph',
                        subtext: 'Graph subtitle'
                    },
                    tooltip: {
                        trigger: 'axis'
                    },
                    legend: {
                        x: 100,
                        data: ['2015', '2016']
                    },
                    toolbox: {
                        show: true,
                        feature: {
                            saveAsImage: {
                                show: true,
                                title: "Save Image"
                            }
                        }
                    },
                    calculable: true,
                    xAxis: [{
                        type: 'value',
                        boundaryGap: [0, 0.01]
                    }],
                    yAxis: [{
                        type: 'category',
                        data: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun']
                    }],
                    series: [{
                        name: '2015',
                        type: 'bar',
                        data: [18203, 23489, 29034, 104970, 131744, 630230]
                    }, {
                        name: '2016',
                        type: 'bar',
                        data: [19325, 23438, 31000, 121594, 134141, 681807]
                    }]
                });

            }

            //echart Pie Collapse

            if ($('#echart_pie2').length) {

                var echartPieCollapse = echarts.init(document.getElementById('echart_pie2'), theme);

                echartPieCollapse.setOption({
                    tooltip: {
                        trigger: 'item',
                        formatter: "{a} <br/>{b} : {c} ({d}%)"
                    },
                    legend: {
                        x: 'center',
                        y: 'bottom',
                        data: ['rose1', 'rose2', 'rose3', 'rose4', 'rose5', 'rose6']
                    },
                    toolbox: {
                        show: true,
                        feature: {
                            magicType: {
                                show: true,
                                type: ['pie', 'funnel']
                            },
                            restore: {
                                show: true,
                                title: "Restore"
                            },
                            saveAsImage: {
                                show: true,
                                title: "Save Image"
                            }
                        }
                    },
                    calculable: true,
                    series: [{
                        name: 'Area Mode',
                        type: 'pie',
                        radius: [25, 90],
                        center: ['50%', 170],
                        roseType: 'area',
                        x: '50%',
                        max: 40,
                        sort: 'ascending',
                        data: [{
                            value: 10,
                            name: 'rose1'
                        }, {
                            value: 5,
                            name: 'rose2'
                        }, {
                            value: 15,
                            name: 'rose3'
                        }, {
                            value: 25,
                            name: 'rose4'
                        }, {
                            value: 20,
                            name: 'rose5'
                        }, {
                            value: 35,
                            name: 'rose6'
                        }]
                    }]
                });

            }

            //echart Donut

            if ($('#echart_donut').length) {

                var echartDonut = echarts.init(document.getElementById('echart_donut'), theme);

                echartDonut.setOption({
                    tooltip: {
                        trigger: 'item',
                        formatter: "{a} <br/>{b} : {c} ({d}%)"
                    },
                    calculable: true,
                    legend: {
                        x: 'center',
                        y: 'bottom',
                        data: ['Direct Access', 'E-mail Marketing', 'Union Ad', 'Video Ads', 'Search Engine']
                    },
                    toolbox: {
                        show: true,
                        feature: {
                            magicType: {
                                show: true,
                                type: ['pie', 'funnel'],
                                option: {
                                    funnel: {
                                        x: '25%',
                                        width: '50%',
                                        funnelAlign: 'center',
                                        max: 1548
                                    }
                                }
                            },
                            restore: {
                                show: true,
                                title: "Restore"
                            },
                            saveAsImage: {
                                show: true,
                                title: "Save Image"
                            }
                        }
                    },
                    series: [{
                        name: 'Access to the resource',
                        type: 'pie',
                        radius: ['35%', '55%'],
                        itemStyle: {
                            normal: {
                                label: {
                                    show: true
                                },
                                labelLine: {
                                    show: true
                                }
                            },
                            emphasis: {
                                label: {
                                    show: true,
                                    position: 'center',
                                    textStyle: {
                                        fontSize: '14',
                                        fontWeight: 'normal'
                                    }
                                }
                            }
                        },
                        data: [{
                            value: 335,
                            name: 'Direct Access'
                        }, {
                            value: 310,
                            name: 'E-mail Marketing'
                        }, {
                            value: 234,
                            name: 'Union Ad'
                        }, {
                            value: 135,
                            name: 'Video Ads'
                        }, {
                            value: 1548,
                            name: 'Search Engine'
                        }]
                    }]
                });

            }

            //echart Pie

            if ($('#echart_pie').length) {

                var echartPie = echarts.init(document.getElementById('echart_pie'), theme);

                $(window).on('resize', function () {
                    if (echartPie != null && echartPie != undefined) {
                        echartPie.resize();
                    }
                });

                var myData= [];

                <?php
                $php_array = $statistics;
                $js_array = json_encode($php_array);
                echo "var javascript_statistics = " . $js_array . ";\n";
                ?>

                $.each(javascript_statistics, function (key, value) {
                    var element={
                        value: value.s_od_totalPrice,
                        name: ''+value.name+''
                    }
                    myData.push(element);
                });

                echartPie.setOption({
                    tooltip: {
                        trigger: 'item',
                        formatter: "{a} <br/>{b} : {c} ({d}%)"
                    },
                    legend: {
                        x: 'center',
                        y: 'bottom',
                        data: [
                            <?php
                                foreach ($statistics as $item){
                                    echo '"'.$item['name'].'",';
                                }
                            ?>
                        ]
                    },
                    toolbox: {
                        show: true,
                        feature: {
                            magicType: {
                                show: true,
                                type: ['pie', 'funnel'],
                                option: {
                                    funnel: {
                                        x: '25%',
                                        width: '50%',
                                        funnelAlign: 'left',
                                        max: 1548
                                    }
                                }
                            },
                           /* restore: {
                                show: true,
                                title: "Restore"
                            },
                            saveAsImage: {
                                show: true,
                                title: "Save Image"
                            }*/
                        }
                    },
                    calculable: true,
                    series: [{
                        name: 'Montant d\'achat (DH)',
                        type: 'pie',
                        radius: '55%',
                        center: ['50%', '48%'],
                        data: myData
                    }]
                });

                var dataStyle = {
                    normal: {
                        label: {
                            show: false
                        },
                        labelLine: {
                            show: false
                        }
                    }
                };

                var placeHolderStyle = {
                    normal: {
                        color: 'rgba(0,0,0,0)',
                        label: {
                            show: false
                        },
                        labelLine: {
                            show: false
                        }
                    },
                    emphasis: {
                        color: 'rgba(0,0,0,0)'
                    }
                };

            }

            //echart Mini Pie

            if ($('#echart_mini_pie').length) {

                var echartMiniPie = echarts.init(document.getElementById('echart_mini_pie'), theme);

                echartMiniPie.setOption({
                    title: {
                        text: 'Chart #2',
                        subtext: 'From ExcelHome',
                        sublink: 'http://e.weibo.com/1341556070/AhQXtjbqh',
                        x: 'center',
                        y: 'center',
                        itemGap: 20,
                        textStyle: {
                            color: 'rgba(30,144,255,0.8)',
                            fontFamily: '微软雅黑',
                            fontSize: 35,
                            fontWeight: 'bolder'
                        }
                    },
                    tooltip: {
                        show: true,
                        formatter: "{a} <br/>{b} : {c} ({d}%)"
                    },
                    legend: {
                        orient: 'vertical',
                        x: 170,
                        y: 45,
                        itemGap: 12,
                        data: ['68%Something #1', '29%Something #2', '3%Something #3'],
                    },
                    toolbox: {
                        show: true,
                        feature: {
                            mark: {
                                show: true
                            },
                            dataView: {
                                show: true,
                                title: "Text View",
                                lang: [
                                    "Text View",
                                    "Close",
                                    "Refresh",
                                ],
                                readOnly: false
                            },
                            restore: {
                                show: true,
                                title: "Restore"
                            },
                            saveAsImage: {
                                show: true,
                                title: "Save Image"
                            }
                        }
                    },
                    series: [{
                        name: '1',
                        type: 'pie',
                        clockWise: false,
                        radius: [105, 130],
                        itemStyle: dataStyle,
                        data: [{
                            value: 68,
                            name: '68%Something #1'
                        }, {
                            value: 32,
                            name: 'invisible',
                            itemStyle: placeHolderStyle
                        }]
                    }, {
                        name: '2',
                        type: 'pie',
                        clockWise: false,
                        radius: [80, 105],
                        itemStyle: dataStyle,
                        data: [{
                            value: 29,
                            name: '29%Something #2'
                        }, {
                            value: 71,
                            name: 'invisible',
                            itemStyle: placeHolderStyle
                        }]
                    }, {
                        name: '3',
                        type: 'pie',
                        clockWise: false,
                        radius: [25, 80],
                        itemStyle: dataStyle,
                        data: [{
                            value: 3,
                            name: '3%Something #3'
                        }, {
                            value: 97,
                            name: 'invisible',
                            itemStyle: placeHolderStyle
                        }]
                    }]
                });

            }

            //echart Map

            if ($('#echart_world_map').length) {

                var echartMap = echarts.init(document.getElementById('echart_world_map'), theme);


                echartMap.setOption({
                    title: {
                        text: 'World Population (2010)',
                        subtext: 'from United Nations, Total population, both sexes combined, as of 1 July (thousands)',
                        x: 'center',
                        y: 'top'
                    },
                    tooltip: {
                        trigger: 'item',
                        formatter: function (params) {
                            var value = (params.value + '').split('.');
                            value = value[0].replace(/(\d{1,3})(?=(?:\d{3})+(?!\d))/g, '$1,') + '.' + value[1];
                            return params.seriesName + '<br/>' + params.name + ' : ' + value;
                        }
                    },
                    toolbox: {
                        show: true,
                        orient: 'vertical',
                        x: 'right',
                        y: 'center',
                        feature: {
                            mark: {
                                show: true
                            },
                            dataView: {
                                show: true,
                                title: "Text View",
                                lang: [
                                    "Text View",
                                    "Close",
                                    "Refresh",
                                ],
                                readOnly: false
                            },
                            restore: {
                                show: true,
                                title: "Restore"
                            },
                            saveAsImage: {
                                show: true,
                                title: "Save Image"
                            }
                        }
                    },
                    dataRange: {
                        min: 0,
                        max: 1000000,
                        text: ['High', 'Low'],
                        realtime: false,
                        calculable: true,
                        color: ['#087E65', '#26B99A', '#CBEAE3']
                    },
                    series: [{
                        name: 'World Population (2010)',
                        type: 'map',
                        mapType: 'world',
                        roam: false,
                        mapLocation: {
                            y: 60
                        },
                        itemStyle: {
                            emphasis: {
                                label: {
                                    show: true
                                }
                            }
                        },
                        data: [{
                            name: 'Afghanistan',
                            value: 28397.812
                        }, {
                            name: 'Angola',
                            value: 19549.124
                        }, {
                            name: 'Albania',
                            value: 3150.143
                        }, {
                            name: 'United Arab Emirates',
                            value: 8441.537
                        }, {
                            name: 'Argentina',
                            value: 40374.224
                        }, {
                            name: 'Armenia',
                            value: 2963.496
                        }, {
                            name: 'French Southern and Antarctic Lands',
                            value: 268.065
                        }, {
                            name: 'Australia',
                            value: 22404.488
                        }, {
                            name: 'Austria',
                            value: 8401.924
                        }, {
                            name: 'Azerbaijan',
                            value: 9094.718
                        }, {
                            name: 'Burundi',
                            value: 9232.753
                        }, {
                            name: 'Belgium',
                            value: 10941.288
                        }, {
                            name: 'Benin',
                            value: 9509.798
                        }, {
                            name: 'Burkina Faso',
                            value: 15540.284
                        }, {
                            name: 'Bangladesh',
                            value: 151125.475
                        }, {
                            name: 'Bulgaria',
                            value: 7389.175
                        }, {
                            name: 'The Bahamas',
                            value: 66402.316
                        }, {
                            name: 'Bosnia and Herzegovina',
                            value: 3845.929
                        }, {
                            name: 'Belarus',
                            value: 9491.07
                        }, {
                            name: 'Belize',
                            value: 308.595
                        }, {
                            name: 'Bermuda',
                            value: 64.951
                        }, {
                            name: 'Bolivia',
                            value: 716.939
                        }, {
                            name: 'Brazil',
                            value: 195210.154
                        }, {
                            name: 'Brunei',
                            value: 27.223
                        }, {
                            name: 'Bhutan',
                            value: 716.939
                        }, {
                            name: 'Botswana',
                            value: 1969.341
                        }, {
                            name: 'Central African Republic',
                            value: 4349.921
                        }, {
                            name: 'Canada',
                            value: 34126.24
                        }, {
                            name: 'Switzerland',
                            value: 7830.534
                        }, {
                            name: 'Chile',
                            value: 17150.76
                        }, {
                            name: 'China',
                            value: 1359821.465
                        }, {
                            name: 'Ivory Coast',
                            value: 60508.978
                        }, {
                            name: 'Cameroon',
                            value: 20624.343
                        }, {
                            name: 'Democratic Republic of the Congo',
                            value: 62191.161
                        }, {
                            name: 'Republic of the Congo',
                            value: 3573.024
                        }, {
                            name: 'Colombia',
                            value: 46444.798
                        }, {
                            name: 'Costa Rica',
                            value: 4669.685
                        }, {
                            name: 'Cuba',
                            value: 11281.768
                        }, {
                            name: 'Northern Cyprus',
                            value: 1.468
                        }, {
                            name: 'Cyprus',
                            value: 1103.685
                        }, {
                            name: 'Czech Republic',
                            value: 10553.701
                        }, {
                            name: 'Germany',
                            value: 83017.404
                        }, {
                            name: 'Djibouti',
                            value: 834.036
                        }, {
                            name: 'Denmark',
                            value: 5550.959
                        }, {
                            name: 'Dominican Republic',
                            value: 10016.797
                        }, {
                            name: 'Algeria',
                            value: 37062.82
                        }, {
                            name: 'Ecuador',
                            value: 15001.072
                        }, {
                            name: 'Egypt',
                            value: 78075.705
                        }, {
                            name: 'Eritrea',
                            value: 5741.159
                        }, {
                            name: 'Spain',
                            value: 46182.038
                        }, {
                            name: 'Estonia',
                            value: 1298.533
                        }, {
                            name: 'Ethiopia',
                            value: 87095.281
                        }, {
                            name: 'Finland',
                            value: 5367.693
                        }, {
                            name: 'Fiji',
                            value: 860.559
                        }, {
                            name: 'Falkland Islands',
                            value: 49.581
                        }, {
                            name: 'France',
                            value: 63230.866
                        }, {
                            name: 'Gabon',
                            value: 1556.222
                        }, {
                            name: 'United Kingdom',
                            value: 62066.35
                        }, {
                            name: 'Georgia',
                            value: 4388.674
                        }, {
                            name: 'Ghana',
                            value: 24262.901
                        }, {
                            name: 'Guinea',
                            value: 10876.033
                        }, {
                            name: 'Gambia',
                            value: 1680.64
                        }, {
                            name: 'Guinea Bissau',
                            value: 10876.033
                        }, {
                            name: 'Equatorial Guinea',
                            value: 696.167
                        }, {
                            name: 'Greece',
                            value: 11109.999
                        }, {
                            name: 'Greenland',
                            value: 56.546
                        }, {
                            name: 'Guatemala',
                            value: 14341.576
                        }, {
                            name: 'French Guiana',
                            value: 231.169
                        }, {
                            name: 'Guyana',
                            value: 786.126
                        }, {
                            name: 'Honduras',
                            value: 7621.204
                        }, {
                            name: 'Croatia',
                            value: 4338.027
                        }, {
                            name: 'Haiti',
                            value: 9896.4
                        }, {
                            name: 'Hungary',
                            value: 10014.633
                        }, {
                            name: 'Indonesia',
                            value: 240676.485
                        }, {
                            name: 'India',
                            value: 1205624.648
                        }, {
                            name: 'Ireland',
                            value: 4467.561
                        }, {
                            name: 'Iran',
                            value: 240676.485
                        }, {
                            name: 'Iraq',
                            value: 30962.38
                        }, {
                            name: 'Iceland',
                            value: 318.042
                        }, {
                            name: 'Israel',
                            value: 7420.368
                        }, {
                            name: 'Italy',
                            value: 60508.978
                        }, {
                            name: 'Jamaica',
                            value: 2741.485
                        }, {
                            name: 'Jordan',
                            value: 6454.554
                        }, {
                            name: 'Japan',
                            value: 127352.833
                        }, {
                            name: 'Kazakhstan',
                            value: 15921.127
                        }, {
                            name: 'Kenya',
                            value: 40909.194
                        }, {
                            name: 'Kyrgyzstan',
                            value: 5334.223
                        }, {
                            name: 'Cambodia',
                            value: 14364.931
                        }, {
                            name: 'South Korea',
                            value: 51452.352
                        }, {
                            name: 'Kosovo',
                            value: 97.743
                        }, {
                            name: 'Kuwait',
                            value: 2991.58
                        }, {
                            name: 'Laos',
                            value: 6395.713
                        }, {
                            name: 'Lebanon',
                            value: 4341.092
                        }, {
                            name: 'Liberia',
                            value: 3957.99
                        }, {
                            name: 'Libya',
                            value: 6040.612
                        }, {
                            name: 'Sri Lanka',
                            value: 20758.779
                        }, {
                            name: 'Lesotho',
                            value: 2008.921
                        }, {
                            name: 'Lithuania',
                            value: 3068.457
                        }, {
                            name: 'Luxembourg',
                            value: 507.885
                        }, {
                            name: 'Latvia',
                            value: 2090.519
                        }, {
                            name: 'Morocco',
                            value: 31642.36
                        }, {
                            name: 'Moldova',
                            value: 103.619
                        }, {
                            name: 'Madagascar',
                            value: 21079.532
                        }, {
                            name: 'Mexico',
                            value: 117886.404
                        }, {
                            name: 'Macedonia',
                            value: 507.885
                        }, {
                            name: 'Mali',
                            value: 13985.961
                        }, {
                            name: 'Myanmar',
                            value: 51931.231
                        }, {
                            name: 'Montenegro',
                            value: 620.078
                        }, {
                            name: 'Mongolia',
                            value: 2712.738
                        }, {
                            name: 'Mozambique',
                            value: 23967.265
                        }, {
                            name: 'Mauritania',
                            value: 3609.42
                        }, {
                            name: 'Malawi',
                            value: 15013.694
                        }, {
                            name: 'Malaysia',
                            value: 28275.835
                        }, {
                            name: 'Namibia',
                            value: 2178.967
                        }, {
                            name: 'New Caledonia',
                            value: 246.379
                        }, {
                            name: 'Niger',
                            value: 15893.746
                        }, {
                            name: 'Nigeria',
                            value: 159707.78
                        }, {
                            name: 'Nicaragua',
                            value: 5822.209
                        }, {
                            name: 'Netherlands',
                            value: 16615.243
                        }, {
                            name: 'Norway',
                            value: 4891.251
                        }, {
                            name: 'Nepal',
                            value: 26846.016
                        }, {
                            name: 'New Zealand',
                            value: 4368.136
                        }, {
                            name: 'Oman',
                            value: 2802.768
                        }, {
                            name: 'Pakistan',
                            value: 173149.306
                        }, {
                            name: 'Panama',
                            value: 3678.128
                        }, {
                            name: 'Peru',
                            value: 29262.83
                        }, {
                            name: 'Philippines',
                            value: 93444.322
                        }, {
                            name: 'Papua New Guinea',
                            value: 6858.945
                        }, {
                            name: 'Poland',
                            value: 38198.754
                        }, {
                            name: 'Puerto Rico',
                            value: 3709.671
                        }, {
                            name: 'North Korea',
                            value: 1.468
                        }, {
                            name: 'Portugal',
                            value: 10589.792
                        }, {
                            name: 'Paraguay',
                            value: 6459.721
                        }, {
                            name: 'Qatar',
                            value: 1749.713
                        }, {
                            name: 'Romania',
                            value: 21861.476
                        }, {
                            name: 'Russia',
                            value: 21861.476
                        }, {
                            name: 'Rwanda',
                            value: 10836.732
                        }, {
                            name: 'Western Sahara',
                            value: 514.648
                        }, {
                            name: 'Saudi Arabia',
                            value: 27258.387
                        }, {
                            name: 'Sudan',
                            value: 35652.002
                        }, {
                            name: 'South Sudan',
                            value: 9940.929
                        }, {
                            name: 'Senegal',
                            value: 12950.564
                        }, {
                            name: 'Solomon Islands',
                            value: 526.447
                        }, {
                            name: 'Sierra Leone',
                            value: 5751.976
                        }, {
                            name: 'El Salvador',
                            value: 6218.195
                        }, {
                            name: 'Somaliland',
                            value: 9636.173
                        }, {
                            name: 'Somalia',
                            value: 9636.173
                        }, {
                            name: 'Republic of Serbia',
                            value: 3573.024
                        }, {
                            name: 'Suriname',
                            value: 524.96
                        }, {
                            name: 'Slovakia',
                            value: 5433.437
                        }, {
                            name: 'Slovenia',
                            value: 2054.232
                        }, {
                            name: 'Sweden',
                            value: 9382.297
                        }, {
                            name: 'Swaziland',
                            value: 1193.148
                        }, {
                            name: 'Syria',
                            value: 7830.534
                        }, {
                            name: 'Chad',
                            value: 11720.781
                        }, {
                            name: 'Togo',
                            value: 6306.014
                        }, {
                            name: 'Thailand',
                            value: 66402.316
                        }, {
                            name: 'Tajikistan',
                            value: 7627.326
                        }, {
                            name: 'Turkmenistan',
                            value: 5041.995
                        }, {
                            name: 'East Timor',
                            value: 10016.797
                        }, {
                            name: 'Trinidad and Tobago',
                            value: 1328.095
                        }, {
                            name: 'Tunisia',
                            value: 10631.83
                        }, {
                            name: 'Turkey',
                            value: 72137.546
                        }, {
                            name: 'United Republic of Tanzania',
                            value: 44973.33
                        }, {
                            name: 'Uganda',
                            value: 33987.213
                        }, {
                            name: 'Ukraine',
                            value: 46050.22
                        }, {
                            name: 'Uruguay',
                            value: 3371.982
                        }, {
                            name: 'United States of America',
                            value: 312247.116
                        }, {
                            name: 'Uzbekistan',
                            value: 27769.27
                        }, {
                            name: 'Venezuela',
                            value: 236.299
                        }, {
                            name: 'Vietnam',
                            value: 89047.397
                        }, {
                            name: 'Vanuatu',
                            value: 236.299
                        }, {
                            name: 'West Bank',
                            value: 13.565
                        }, {
                            name: 'Yemen',
                            value: 22763.008
                        }, {
                            name: 'South Africa',
                            value: 51452.352
                        }, {
                            name: 'Zambia',
                            value: 13216.985
                        }, {
                            name: 'Zimbabwe',
                            value: 13076.978
                        }]
                    }]
                });

            }

        }

        init_echarts();
    });
</script>


