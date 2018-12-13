<?php $this->load->view('admin/partials/admin_header.php'); ?>
<link href="<?php echo base_url('assets/vendors/bootstrap-daterangepicker/daterangepicker.css'); ?>" rel="stylesheet">
<style>
    .profile_details:nth-child(3n) {
        clear: none;
    }
    input[name=search]{
        height: 31px;
        margin-right: 11px;
    }
</style>
<!-- page content -->
<div class="right_col" role="main">
    <div class="productsList">
        <div class="page-title">
            <div class="title_left">
                <h3><?= lang("history_of_orders") ?></h3>
            </div>
        </div>
        <div class="clearfix"></div>
        <hr>
        <div class="container">
            <!-- /row -->


            <div class="col-xs-12 col-sm-12" style="padding:  0px; margin-bottom: 10px">
                <div id="reportrange" class="pull-right"
                     style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc">
                    <i class="glyphicon glyphicon-calendar fa fa-calendar"></i>
                    <span>December 30, 2014 - January 28, 2015</span> <b class="caret"></b>
                </div>
            </div>
            <div class="col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2><?= lang("orders_list") ?></h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                            <li><a class="close-link"><i class="fa fa-close"></i></a></li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content table-responsive">
                        <table id="datatable-orders" class="table table-striped table-bordered dt-responsive nowrap"
                               cellspacing="0" width="100%">
                            <thead>
                            <tr>
                                <th><?= lang("number_of_order") ?></th>
                                <th><?= lang("provider") ?></th>
                                <th><?= lang("amount") ?></th>
                                <th><?= lang("status") ?></th>
                                <th><?= lang("regulation") ?></th>
                                <th><?= lang("date_of_order") ?></th>
                            </tr>
                            </thead>
                            <tfoot>
                            <tr>
                                <th>Numéro de la commande</th>
                                <th>Fournisseur</th>
                                <th>Montant</th>
                                <th>Status</th>
                                <th>Réglement</th>
                                <th>Date de la commande</th>
                            </tr>
                            </tfoot>
                            <tbody>
                            <?php foreach ($orders as $order) {
                                $status= lang('pending');
                                $paid= lang('impaid');
                                if(strtoupper($order['status'])==="RECEIVED"){
                                    $status= lang('received');
                                }else if(strtoupper($order['status']) === "CANCELED"){
                                    $status = lang('canceled');
                                }

                                if(strtoupper($order['paid'])==="TRUE"){
                                    $paid= lang('paid');
                                }
                            ?>
                                <tr>
                                    <td><?php echo $order['id']; ?></td>
                                    <td><a href="<?php echo base_url('admin/provider/show/'.$order['pv_id']);?>"><?php echo $order['pv_name']; ?></a> </td>
                                    <td><?php echo $order['amount']; ?></td>
                                    <td><?php echo $status; ?></td>
                                    <td><?php echo $paid; ?></td>
                                    <td><?php echo $order['orderDate']; ?></td>
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
    var getAllOrders_url="<?php echo base_url('admin/api/provider/getAllOrders'); ?>";
</script>


<script src="<?php echo base_url("assets/vendors/datatables.net/js/jquery.dataTables.min.js"); ?>"></script>
<script src="<?php echo base_url('assets/vendors/moment/min/moment.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/vendors/bootstrap-daterangepicker/daterangepicker.js'); ?>"></script>
<script>
    var tableOrders;
    $(document).ready(function () {
        var handleDataTableButtons = function () {
            if ($("#datatable-orders").length) {
                tableOrders=$("#datatable-orders").DataTable({
                    aaSorting: [[0, 'desc']],
                    "columns": [
                        { "data": "id" },
                        { "data": "provider" },
                        { "data": "amount" },
                        { "data": "status" },
                        { "data": "paid" },
                        { "data": "order_date" }
                    ],
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

        init_daterangepicker();

        function handleOrdersData(data) {
            tableOrders.rows()
                .remove()
                .draw();
            $.each(data.orders, function (key,order) {
                tableOrders.row.add({
                    "id": order['id'],
                    "provider": order['pv_name'],
                    "amount": parseFloat(order['amount']).toFixed(2),
                    "status": parseFloat(order['amount']).toFixed(2),
                    "paid": parseFloat(order['amount']).toFixed(2),
                    "order_date": order['orderDate']
                }).draw();
            });
        }

        function init_daterangepicker() {

            if (typeof ($.fn.daterangepicker) === 'undefined') {
                return;
            }
            console.log('init_daterangepicker');

            var cb = function (start, end, label) {
                $('#reportrange span').html(start.format('YYYY/MM/DD') + ' - ' + end.format('MMMM D, YYYY'));

                startDate= start.format('YYYY/MM/DD');
                endDate= end.format('YYYY/MM/DD');
                let myData = {'id':$('#provider_id').attr('data-id'),'startDate': startDate, 'endDate': endDate};
                let params={'callable':true,'swal':'false','reload':false};
                apiRequest(getAllOrders_url,myData,params,handleOrdersData);
            };


            var optionSet1 = {
                startDate: moment().subtract(365, 'days'),
                endDate: moment(),
                minDate: '01/01/2017',
                maxDate: '12/31/2027',
                dateLimit: {
                    days: 365
                },
                showDropdowns: true,
                showWeekNumbers: true,
                timePicker: false,
                timePickerIncrement: 1,
                timePicker12Hour: true,
                ranges: {
                    'Aujourd\'hui': [moment(), moment()],
                    'Hier': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    'Dernier 7 jours': [moment().subtract(6, 'days'), moment()],
                    'Dernier 30 jours': [moment().subtract(29, 'days'), moment()],
                    'Ce mois': [moment().startOf('month'), moment().endOf('month')],
                    'Mois précédent': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                },
                opens: 'left',
                buttonClasses: ['btn btn-default'],
                applyClass: 'btn-small btn-primary',
                cancelClass: 'btn-small',
                format: 'DD/MM/YYYY',
                separator: ' to ',
                locale: {
                    applyLabel: 'Envoyer',
                    cancelLabel: 'Annuler',
                    fromLabel: 'From',
                    toLabel: 'To',
                    customRangeLabel: 'Personnalier',
                    daysOfWeek: ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa'],
                    monthNames: ['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre'],
                    firstDay: 1
                }

            };

            $('#reportrange span').html(moment().subtract(365, 'days').format('MMMM D, YYYY') + ' - ' + moment().format('MMMM D, YYYY'));
            startDate=moment().subtract(29, 'days').format('YYYY-MM-DD');
            endDate= moment().format('YYYY-MM-DD');
            $('#reportrange').daterangepicker(optionSet1, cb);

            $('#reportrange').on('show.daterangepicker', function () {
                console.log("show event firedd");
            });
            $('#reportrange').on('hide.daterangepicker', function () {
                console.log("hide event fired");
            });
            $('#reportrange').on('apply.daterangepicker', function (ev, picker) {
                console.log("apply event fired, start/end dates are " + picker.startDate.format('MMMM D, YYYY') + " to " + picker.endDate.format('MMMM D, YYYY'));
            });
            $('#reportrange').on('cancel.daterangepicker', function (ev, picker) {
                console.log("cancel event fired");
            });
            $('#options1').click(function () {
                $('#reportrange').data('daterangepicker').setOptions(optionSet1, cb);
            });
            $('#options2').click(function () {
                $('#reportrange').data('daterangepicker').setOptions(optionSet2, cb);
            });
            $('#destroy').click(function () {
                $('#reportrange').data('daterangepicker').remove();
            });

        }
    });
</script>

