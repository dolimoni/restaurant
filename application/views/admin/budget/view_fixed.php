<?php $this->load->view('admin/partials/admin_header.php'); ?>
<link href="<?php echo base_url('assets/vendors/bootstrap-daterangepicker/daterangepicker.css'); ?>" rel="stylesheet">
<link href="<?php echo base_url("assets/build2/css/custom.min.css"); ?>" rel="stylesheet">
<link rel="stylesheet" href="<?php echo base_url("assets/vendors/jquery-ui/themes/overcast/jquery-ui.min.css"); ?>">
<link rel="stylesheet" href="<?php echo base_url("assets/vendors/jquery-ui-month-picker/src/MonthPicker.css"); ?>">
<style>
    .table-responsive {
        overflow-x: visible;
        margin: 0px;
    }
    .row{
        margin:0px;
    }
    tr{
        white-space: nowrap;
    }
    #datatable-alertes_filter{
        display: none;
    }
    @media (max-width: 480px) {
        #datatable-alertes_filter{
            float: left !important;
            text-align: left !important;
        }

    }
</style>

<!-- page content -->
<div class="right_col" role="main">
    <div class="productsList">
        <div class="page-title">
            <div class="col-md-6 col-sm-6 col-xs-12">
                <h3><?= lang("fixedCharge_list"); ?></h3>
            </div>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <h3><?= lang("breakEven"); ?> :
                    <span class="breakEven"><?= $breakEven; ?> DH</span></h3>
            </div>
            <!--<div class="text-dark col-md-4 col-sm-6 col-xs-12">
                <h3>Alertes SMS Restante : <?php /*echo $params['sms_available'] */?></h3>
            </div>-->
        </div>
        <div class="clearfix"></div>
        <hr>
        <div class="article-title">
            <a class="btn btn-primary" data-toggle="collapse" href="#collapseExample" aria-expanded="false"
               aria-controls="collapseExample"><?= lang("add"); ?></a>
        </div>
        <div class="collapse" id="collapseExample">
            <form id="addFixedCharge">
                <fieldset>
                    <div class="row">
                        <div class="col-xs-12 col-sm-6 col-md-4">
                            <br>
                            <label for="name"><?= lang("name"); ?> :</label>
                            <input type="text" class="form-control" name="name"
                                   placeholder="<?= lang("name"); ?>"
                                   required>
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-4">
                            <br>
                            <label for="name"><?= lang("amount"); ?> :</label>
                            <input type="number" step="any" class="form-control" name="amount"
                                   placeholder="<?= lang("amount"); ?>"
                                   required>
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-4">
                            <br>
                            <label for="startDate"><?= lang("date") ?> :</label>
                            <input name="startDate" id="charge_date" class="date-picker form-control"/>
                        </div>

                    </div>
                    <br/>
                    <br/>

                    <div class="text-right">
                        <input class="btn btn-success" type="submit" name="addFixedCharge" value="<?= lang("confirme"); ?>"/>
                    </div>

                </fieldset>
            </form>
            <br>
        </div>
         <!-- /row -->

        <div class="collapse" id="editFixedCharge">
            <form id="editFixedChargeForm">
                <fieldset>
                    <div class="row">
                        <input type="hidden" name="id" >
                        <div class="col-xs-12 col-sm-6 col-md-4">
                            <br>
                            <label for="name"><?= lang("name"); ?> :</label>
                            <input type="text" class="form-control" name="name"
                                   placeholder="<?= lang("name"); ?>"
                                   required>
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-4">
                            <br>
                            <label for="name"><?= lang("amount"); ?> :</label>
                            <input type="number" step="any" class="form-control" name="amount"
                                   placeholder="<?= lang("amount"); ?>"
                                   required>
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-4">
                            <br>
                            <label for="editCharge_date"><?= lang("date") ?> :</label>
                            <input name="editCharge_date" id="edit_charge_date" class="date-picker form-control"/>
                        </div>

                    </div>
                    <br/>
                    <br/>

                    <div class="text-right">
                        <input class="btn btn-info" type="submit" name="createEditFixedCharge" value="<?= lang("add"); ?>"/>
                        <input class="btn btn-success" type="submit" name="editFixedCharge" value="<?= lang("edit"); ?>"/>
                    </div>

                </fieldset>
            </form>
            <br>
        </div>
        <div class="row">
            <div class="table-responsive">
                <div class="col-md-6 col-md-offset-6 padding-0">
                    <div style="float:right">
                        <input placeholder="<?= lang("date") ?> " name="search_charge_date" id="search_charge_date" class="date-picker" disabled />
                        <input id="searchbox" placeholder="<?= lang("search"); ?>" />
                    </div>
                </div>
                <table id="datatable-alertes" class="table table-striped table-bordered dt-responsive nowrap"
                       cellspacing="0" width="100%">
                    <thead>
                    <tr>
                        <th><?= lang("name"); ?></th>
                        <th><?= lang("amount"); ?></th>
                        <th><?= lang("date"); ?></th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tfoot>
                    <tr>
                        <th><?= lang("name"); ?></th>
                        <th><?= lang("amount"); ?></th>
                        <th><?= lang("date"); ?></th>
                        <th>Actions</th>
                    </tr>
                    </tfoot>
                    <tbody>
                    <?php foreach ($fixed_charges as $fixed_charge){ ?>
                        <tr data-id="<?php echo $fixed_charge['id']; ?>">
                            <td data-name="<?php echo $fixed_charge['name']; ?>"> <?php echo $fixed_charge['name']; ?> </td>
                            <td data-amount="<?php echo $fixed_charge['amount']; ?>"> <?php echo $fixed_charge['amount']; ?> </td>
                            <td data-charge-date="<?php echo $fixed_charge['charge_date']; ?>"> <?php echo $fixed_charge['charge_date']; ?> </td>
                            <td>
                                <div>
                                    <button class="btn btn-info btn-xs action editChargeFixe"
                                            data-type="edit"><span
                                                class="glyphicon glyphicon-edit"></span></button>
                                    <button data-id="<?php echo $fixed_charge['id']; ?>" class="btn btn-danger btn-xs action deleteFixedCharge"
                                            data-type="delete"><span
                                                class="fa fa-trash"></span></button>
                                </div>
                            </td>
                        </tr>
                    <?php } ?>


                    </tbody>
                </table>

            </div>
        </div>
    </div>
</div>


<?php $this->load->view('admin/partials/admin_footer'); ?>
<script>
    var swal_success_operation_lang = "<?= lang("swal_success_operation"); ?>";
    var swal_error_lang = "<?= lang("swal_error"); ?>";
    var swal_success_edit_lang = "<?= lang("swal_success_edit"); ?>";
    var swal_warning_delete_lang = "<?= lang("swal_warning_delete"); ?>";
    var swal_success_delete_lang = "<?= lang("swal_success_delete"); ?>";
    var swal_success_report_alert_lang = "<?= lang("swal_success_report_alert"); ?>";

    var datatable_fr_url="<?php echo base_url("assets/vendors/datatables.net/French.json"); ?>";
    var addCharge_url="<?php echo base_url('admin/budget/apiAddFixedCharge'); ?>";
    var editCharge_url="<?php echo base_url('admin/budget/apiEditFixedCharge'); ?>";
    var deleteCharge_url="<?php echo base_url('admin/budget/apiDeleteFixedCharge'); ?>";
    var search_charge_url="<?php echo base_url('admin/budget/apiGetFixedCharge'); ?>";
</script>
<!-- NProgress -->
<script src="<?php echo base_url("assets/vendors/datatables.net/js/jquery.dataTables.min.js"); ?>"></script>
<script src="<?php echo base_url("assets/vendors/jquery-ui/jquery-ui.min.js"); ?>"></script>
<script src="<?php echo base_url("assets/vendors/jquery-ui-month-picker/src/MonthPicker.js"); ?>"></script>
<script src="<?php echo base_url('assets/build2/js/budget/fixedCharge.js'); ?>"></script>