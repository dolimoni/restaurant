<?php $this->load->view('admin/partials/admin_header.php'); ?>
<link href="<?php echo base_url('assets/vendors/bootstrap-daterangepicker/daterangepicker.css'); ?>" rel="stylesheet">
<link href="<?php echo base_url("assets/build2/css/custom.min.css"); ?>" rel="stylesheet">
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
            <div class="col-md-8 col-sm-6 col-xs-12">
                <h3><?= lang("alertes_list"); ?></h3>
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
            <form id="addRegularCostForm" enctype="multipart/form-data">
                <fieldset>
                    <div class="row">
                        <div class="col-xs-4">
                            <br>
                            <label for="name"><?= lang("subject"); ?> :</label>
                            <input type="text" class="form-control" name="article"
                                   placeholder="<?= lang("subject"); ?>"
                                   required>
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-4">
                            <br>
                            <label for="name"><?= lang("price"); ?> :</label>
                            <input type="number" step="any" class="form-control" name="price"
                                   placeholder="<?= lang("price"); ?>"
                                   required>
                        </div>

                        <div class="col-xs-12 col-sm-6 col-md-4">
                            <br>
                            <label for="name"><?= lang("periodicity"); ?> :</label>
                            <select name="periodicity" class="form-control">
                                <option value="none"><?= lang("simple_alert"); ?></option>
                                <option value="daily"><?= lang("daily"); ?></option>
                                <option value="weekly"><?= lang("weekly"); ?></option>
                                <option value="monthly"><?= lang("monthly"); ?></option>
                            </select>
                        </div>


                    </div>
                    <br/>
                    <div class="row">
                        <div class="col-xs-12 col-sm-6 col-md-4">
                            <label for="description"><?= lang("description"); ?> :</label>
                            <input type="text" step="any" class="form-control" name="description"
                                   placeholder="<?= lang("description"); ?>"
                                   required>
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-4">
                            <label for="paiementDate"><?= lang("date_of_payment"); ?> :</label>
                            <?php include ('include/calender.php');?>
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-4">
                            <label for="reminderDate"><?= lang("next_remember_date"); ?> :</label>
                            <?php include('include/calender2.php'); ?>
                        </div>
                    </div>
                    <br/>

                    <div class="text-right">
                        <input class="btn btn-success" type="submit" name="addPurchase" value="<?= lang("confirme"); ?>"/>
                    </div>

                </fieldset>
            </form>
            <br>
        </div>
         <!-- /row -->

        <div class="collapse" id="editAlert">
            <form id="editAlertForm">
                <fieldset>
                    <div class="row">
                        <input type="hidden" name="id"/>
                        <div class="col-xs-12 col-sm-6 col-md-4">
                            <br>
                            <label for="name"><?= lang("subject"); ?> :</label>
                            <input type="text" class="form-control" name="articleEdit"
                                   placeholder="<?= lang("subject"); ?>"
                                   required>
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-4">
                            <br>
                            <label for="name"><?= lang("price"); ?> :</label>
                            <input type="number" step="any" class="form-control" name="priceEdit"
                                   placeholder="<?= lang("price"); ?>"
                                   required>
                        </div>

                        <div class="col-xs-12 col-sm-6 col-md-4">
                            <br>
                            <label for="name"><?= lang("periodicity"); ?> :</label>
                            <select name="periodicityEdit" class="form-control">
                                <option value="none"><?= lang("simple_alert"); ?></option>
                                <option value="daily"><?= lang("daily"); ?></option>
                                <option value="weekly"><?= lang("weekly"); ?></option>
                                <option value="monthly"><?= lang("monthly"); ?></option>
                            </select>
                        </div>


                    </div>
                    <br/>
                    <div class="row">
                        <div class="col-xs-12 col-sm-6 col-md-4">
                            <label for="descriptionEdit"><?= lang("description"); ?> :</label>
                            <input type="text" step="any" class="form-control" name="descriptionEdit"
                                   placeholder="<?= lang("description"); ?>"
                                   required>
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-4">
                            <label for="paiementDateEdit"><?= lang("date_of_payment"); ?> :</label>
                            <?php include('include/calender.php'); ?>
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-4">
                            <label for="reminderDateEdit"><?= lang("next_remember_date"); ?> :</label>
                            <?php include('include/calender2.php'); ?>
                        </div>
                    </div>
                    <br/>

                    <div class="text-right">
                        <input class="btn btn-success" type="submit" name="editAlert" value="<?= lang("edit"); ?>"/>
                    </div>

                </fieldset>
            </form>
            <br>
        </div>
        <div class="row">
            <div class="table-responsive">
                <table id="datatable-alertes" class="table table-striped table-bordered dt-responsive nowrap"
                       cellspacing="0" width="100%">
                    <thead>
                    <tr>
                        <th><?= lang("subject"); ?></th>
                        <th><?= lang("description"); ?></th>
                        <th><?= lang("price"); ?></th>
                        <th><?= lang("periodicity"); ?></th>
                        <th><?= lang("date_of_payment"); ?></th>
                        <th><?= lang("remember_date"); ?></th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tfoot>
                    <tr>
                        <th><?= lang("subject"); ?></th>
                        <th><?= lang("description"); ?></th>
                        <th><?= lang("price"); ?></th>
                        <th><?= lang("periodicity"); ?></th>
                        <th><?= lang("date_of_payment"); ?></th>
                        <th><?= lang("remember_date"); ?></th>
                        <th>Actions</th>
                    </tr>
                    </tfoot>
                    <tbody>
                    <?php foreach ($regularCosts as $regularCost) {
                        $activeAlert = "";
                        $alertes_count = 0;
                        $periodicity = '';
                        if ($regularCost['status'] === 'active') {
                            $activeAlert = "active-alert";
                        }
                        if ($regularCost['periodicity'] === "daily") {
                            $periodicity = "Quotidienne";
                        } else if ($regularCost['periodicity'] === "weekly") {
                            $periodicity = "Hebdomadaire";
                        } else if ($regularCost['periodicity'] === "monthly") {
                            $periodicity = "Mensuelle";
                        }
                        $pdt = date('d-m-Y', strtotime($regularCost['paiementDate']));
                        $rdt = date('d-m-Y', strtotime($regularCost['reminderDate']));
                        ?>
                        <tr class=" <?php echo $activeAlert; ?>" data-id="<?php echo $regularCost['id']; ?>"
                            data-reminder="<?php echo $regularCost['reminderDate']; ?>" data-paiementDate="<?php echo $regularCost['paiementDate']; ?>">
                            <td data-article="<?php echo $regularCost['article']; ?>"> <?php echo $regularCost['article']; ?> </td>
                            <td data-description="<?php echo $regularCost['description']; ?>"> <?php echo $regularCost['description']; ?> </td>
                            <td data-price="<?php echo $regularCost['price']; ?>"> <?php echo $regularCost['price']; ?> </td>
                            <td data-periodicity="<?php echo $regularCost['periodicity']; ?>"> <?php echo $periodicity; ?> </td>
                            <td data-paiementDate="<?php echo $pdt; ?>"> <?php echo $pdt; ?> </td>
                            <td data-reminderDate="<?php echo $rdt; ?>"> <?php echo $rdt; ?> </td>
                            <td width="20%">
                                <div >
                                    <button class="btn btn-success btn-xs action validateAlert " data-type="edit"><span
                                                class="glyphicon glyphicon-ok"></span></button>
                                    <button class="btn btn-info btn-xs action editAlert " data-type="edit"><span
                                                class="glyphicon glyphicon-edit"></span></button>
                                    <button class="btn btn-danger btn-xs action deleteAlert " data-type="delete"><span
                                                class="fa fa-trash"></span></button>
                                </div>
                                <!-- <button class="btn btn-info btn-xs action validationButton" data-type="mute"><span
                                             class="glyphicon fa fa-bell-slash-o"></span></button>-->
                               <!--<div >
                                   <button class="btn btn-warning btn-xs action dayResport " data-type="day"><span
                                               class="glyphicon "></span>+1J
                                   </button>
                                   <button class="btn btn-warning btn-xs action weekResport " data-type="week"><span
                                               class="glyphicon"></span>+1S
                                   </button>
                                   <button class="btn btn-warning btn-xs action monthResport " data-type="month"><span
                                               class="glyphicon"></span>+1M
                                   </button>
                               </div>-->

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
    var addRegularCostForm_url="<?php echo base_url('admin/budget/apiAddRegularCostForm'); ?>";
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

<script src="<?php echo base_url("assets/vendors/datatables.net/js/jquery.dataTables.min.js"); ?>"></script>
<script src="<?php echo base_url('assets/vendors/bootstrap-daterangepicker/daterangepicker.js'); ?>"></script>



<script>
    $(document).ready(function () {
        var handleDataTableButtons = function () {
            if ($("#datatable-alertes").length) {
                $("#datatable-alertes").DataTable({
                   /* aaSorting: [[0, 'desc']],*/
                    responsive: true,
                    "bSort": false,
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
        $('#addRegularCostForm').on('submit', function (e) {
            e.preventDefault();
            let regularCost = {
                  'article':$(this).find('input[name=article]').val(),
                  'price':$(this).find('input[name=price]').val(),
                  'periodicity':$(this).find('select[name=periodicity]').val(),
                  'reminderDate':$(this).find('input[name=reminderDate]').val(),
                  'paiementDate':$(this).find('input[name=paiementDate]').val(),
                  'description':$(this).find('input[name=description]').val(),
            };
            apiRequest(addRegularCostForm_url,{'regularCost':regularCost});
        });

        $('#editAlertForm').on('submit', function (e) {
            e.preventDefault();
            var validForm=true;
            var pdt = new $("#editAlertForm #single_cal3").val().split('-');
            var rdt = new $("#editAlertForm #single_cal4").val().split('-');
            var pdtConvert="";
            var rdtConvert="";
            if(pdt.length===3 && rdt.length === 3){
                var pdtConvert = pdt[2] + '-' + pdt[1] + '-' + pdt[0].slice(-2);
                var rdtConvert = rdt[2] + '-' + rdt[1] + '-' + rdt[0].slice(-2);
            }else{
                swal({
                    title: "Erreur",
                    text: "Date invalide",
                    type: "error",
                    timer: 1500,
                    showConfirmButton: false
                });
                validForm=false;
            }

            var alert={
                'article':$("#editAlertForm input[name='articleEdit']").val(),
                'price':$("#editAlertForm input[name='priceEdit']").val(),
                'description':$("#editAlertForm input[name='descriptionEdit']").val(),
                'periodicity':$("#editAlertForm select[name='periodicityEdit']").val(),
                'reminderDate': rdtConvert,
                'paiementDate': pdtConvert,
            }
            if(validForm){
                $('#loading').show();
                $.ajax({
                    type: 'POST',
                    url: "<?php echo base_url('admin/budget/apiEditAlert'); ?>",
                    data: {alert: alert, 'id': $("#editAlertForm input[name='id']").val()},
                    dataType: "json",
                    success: function (data) {
                        $('#loading').hide();
                        if (data.status === "success") {
                            swal({
                                title: "Success",
                                text: swal_success_edit_lang,
                                type: "success",
                                timer: 1500,
                                showConfirmButton: false
                            });
                            location.reload();
                        } else {
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
                        $('#loading').show();
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


        $('.profile_details').on('click', function () {
            var id = $(this).attr('data-id');
            document.location.href = "<?php echo base_url(); ?>admin/employee/show/" + id;
        });
    });

</script>

<script>
    $(document).ready(function () {
        function init_daterangepicker_single_call() {

            if (typeof ($.fn.daterangepicker) === 'undefined') {
                return;
            }
            $('#single_cal4').daterangepicker({
                singleDatePicker: true,
                singleClasses: "picker_3"
            }, function (start, end, label) {
                $('input[name="reminderDate"]').val(start.format('Y-M-D'));
            });
            $('input[name="reminderDate"]').val(moment().startOf('day').format('Y-M-D'));

            $('#single_cal3').daterangepicker({
                singleDatePicker: true,
                singleClasses: "picker_3"
            }, function (start, end, label) {
                $('input[name="paiementDate"]').val(start.format('Y-M-D'));
            });
            $('input[name="paiementDate"]').val(moment().startOf('day').format('Y-M-D'));
        }

        init_daterangepicker_single_call();
    });
</script>

<!--Alertes actions-->
<script>
    $(document).ready(function () {
        $('.monthResport,.weekResport,.dayResport').on('click',reportAlertEvent);

         function reportAlertEvent(){
            var delay = $(this).attr('data-type');
            var id = $(this).closest('tr').attr('data-id');
            var reminderDate = $(this).closest('tr').attr('data-reminder');
            var alert={
                'id':id,
                'delay':delay,
                'reminderDate':reminderDate,
                'updatePaiementDate': false
            };
             reportAlert(alert);
        }

        function reportAlert(alert){
            $.ajax({
                type: 'POST',
                url: "<?php echo base_url('admin/budget/apiReportAlert'); ?>",
                data: {'alert': alert},
                dataType: "json",
                success: function (data) {
                    if (data.status === "success") {
                        swal({
                            title: "Success",
                            text: swal_success_report_alert_lang,
                            type: "success",
                            timer: 1500,
                            showConfirmButton: false
                        });
                        location.reload();
                    } else {
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

        $(".editAlert").on('click', editAlertEvent);
        var l_id = -1;

        function editAlertEvent() {
            if ($(this).attr('data-id') === l_id || l_id === -1) {
                $('#editAlert').toggle('slow');
            }
            l_id = $(this).closest('tr').attr('data-id');
            var row = $(this).closest('tr');
            $('#editAlert input[name="articleEdit"]').val(row.find("[data-article]").attr('data-article'));
            $('#editAlert input[name="descriptionEdit"]').val(row.find("[data-description]").attr('data-description'));
            $('#editAlert input[name="priceEdit"]').val(row.find("[data-price]").attr('data-price'));
            $('#editAlert select[name="periodicityEdit"]').val(row.find("[data-periodicity]").attr('data-periodicity'));
            $('#editAlert #single_cal3').val(row.find("[data-paiementDate]").attr('data-paiementDate'));
            $('#editAlert #single_cal4').val(row.find("[data-reminderDate]").attr('data-reminderDate'));

            $('#editAlert input[name="id"]').val(l_id);
        }

        $('button.deleteAlert').on('click', deleteAlertEvent);
        $('button.validateAlert').on('click', validateAlertEvent);


        function deleteAlertEvent() {
            var alert_id = $(this).closest('tr').attr('data-id');
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
                        url: "<?php echo base_url('admin/budget/apiDeleteAlert'); ?>",
                        type: "POST",
                        dataType: "json",
                        data: {'alert_id': alert_id},
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

        function validateAlertEvent() {
            var alert_id = $(this).closest('tr').attr('data-id');
            var delay = $(this).closest('tr').find('td[data-periodicity]').attr('data-periodicity');
            var reminderDate = $(this).closest('tr').attr('data-reminder');
            var paiementDate = $(this).closest('tr').attr('data-paiementDate');
            console.log(delay);
            var alert = {
                'id': alert_id,
                'delay': delay.slice(0,-2),
                'reminderDate': reminderDate,
                'updatePaiementDate':true,
                'paiementDate': paiementDate
            };
            reportAlert(alert);
        }
    });
</script>


