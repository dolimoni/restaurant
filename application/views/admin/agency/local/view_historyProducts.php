<?php $this->load->view('admin/partials/admin_header.php'); ?>
<!-- page content -->
<div class="right_col" role="main">
    <div class="productsList">

        <!-- /row -->
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="collapse" id="editAlert">
                    <form id="editAlertForm">
                        <fieldset>
                            <input type="hidden" name="id"/>
                            <div class="row">
                                <div class="col-xs-6">
                                    <br>
                                    <label for="name"><?= lang('quantity'); ?> :</label>
                                    <select disabled="true"  name="product" class="productSelect form-control md-button-v">
                                        <?php foreach ($productsList as $product) { ?>
                                            <option value="<?php echo $product['id'] ?>"
                                                    data-unit="<?php echo $product['unit'] ?>"
                                                    data-price="<?php echo $product['unit_price'] ?>"
                                                    data-weightByUnit="<?php echo $product['weightByUnit'] ?>">
                                                <?php echo $product['name'] ?>
                                            </option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="col-xs-6">
                                    <br>
                                    <label for="name"><?= lang('quantity'); ?> :</label>
                                    <input type="text" step="any" class="form-control" name="quantity"
                                           placeholder="<?= lang('quantity'); ?>"
                                           required>
                                </div>
                            </div>
                            <br/>
                            <div class="text-right">
                                <input class="btn btn-success" type="submit" name="editAlert" value="Modifier"/>
                            </div>

                        </fieldset>
                    </form>
                    <br>
                </div>
                <div class="x_panel">
                    <div class="x_title">
                        <h2><?= lang('history'); ?></h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                            <li><a class="close-link"><i class="fa fa-close"></i></a></li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="col-xs-12 col-sm-12">
                        <div id="reportrange" class="pull-right full-width"
                             style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc">
                            <div class="pull-right">
                                <i class="glyphicon glyphicon-calendar fa fa-calendar"></i>
                                <span>December 30, 2014 - January 28, 2015</span> <b class="caret"></b>
                            </div>
                        </div>
                        <div class="pull-right mgrt10">
                            <select class="form-control agency">
                                <option value="0">Toutes les agences</option>
                               <?php foreach ($agencies as $agency){ ?>
                                   <option value="<?php echo $agency['id'] ?>"><?php echo  $agency['name'] ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="pull-right mgrt10"><button data-group="true" class="btn btn-info form-control groupProducts">Grouper les produits</button></div>
                    </div>
                    <div class="x_content table-products table-responsive">
                        <table id="datatable-products" class="table table-striped table-bordered dt-responsive nowrap"
                               cellspacing="0" width="100%">
                           <thead>
                               <tr>
                                   <th>
                                       <?= lang('product'); ?>
                                   </th>
                                   <th>
                                       <?= lang('agency'); ?>
                                   </th>
                                   <th>
                                       <?= lang('quantity'); ?>
                                   </th>
                                   <th>
                                       <?= lang('unit'); ?>
                                   </th>
                                   <th>
                                       <?= lang('transfert_type'); ?>
                                   </th>
                                   <th>
                                       <?= lang('date'); ?>
                                   </th>
                                   <th>
                                       Actions
                                   </th>
                               </tr>
                           </thead>
                            <tfoot>
                               <tr>
                                   <th>
                                       <?= lang('product'); ?>
                                   </th>
                                   <th>
                                       <?= lang('agency'); ?>
                                   </th>
                                   <th>
                                       <?= lang('quantity'); ?>
                                   </th>
                                   <th>
                                       <?= lang('unit'); ?>
                                   </th>
                                   <th>
                                       <?= lang('transfert_type'); ?>
                                   </th>
                                   <th>
                                       <?= lang('date'); ?>
                                   </th>
                                   <th>
                                       Actions
                                   </th>
                               </tr>
                           </tfoot>

                           <tbody>
                           <?php foreach ($products as $product) {?>
                               <tr class="success" data-quantity="<?php echo $product['quantity'] ?>" data-id="<?php echo $product['p_id']; ?>" data-sh-id="<?php echo $product['sh_id']; ?>">
                                   <td><?php echo $product['p_name']; ?></td>
                                   <td><?php echo $product['a_name']; ?></td>
                                   <td><?php echo $product['quantity'] ?></td>
                                   <td><?php echo $product['unit'] ?></td>
                                   <td><?php echo $product['removal'] ?></td>
                                   <td><?php echo $product['date'] ?></td>
                                   <td>
                                       <?php if($product['removal']==="manuel"){ ?>
                                       <div>
                                           <button class="btn btn-info btn-xs action editAlert small-button"
                                                   data-type="edit"><span
                                                       class="glyphicon glyphicon-edit"></span></button>
                                           <button class="btn btn-danger btn-xs action deleteAlert small-button"
                                                   data-type="delete"><span
                                                       class="fa fa-trash"></span></button>
                                       </div>
                                       <?php }?>
                                   </td>
                               </tr>
                           <?php } ?>
                           </tbody>
                        </table>
                    </div> <!-- /content -->
                </div><!-- /x-panel -->
            </div> <!-- /col -->
        </div>
    </div>
</div> <!-- /.col-right -->
<!-- /page content -->

<?php $this->load->view('admin/partials/admin_footer'); ?>
<script src="<?php echo base_url('assets/vendors/moment/min/moment.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/vendors/bootstrap-daterangepicker/daterangepicker.js'); ?>"></script>
<script>
    var swal_success_operation_lang = "<?= lang("swal_success_operation"); ?>";
    var swal_error_lang = "<?= lang("swal_error"); ?>";
    var swal_success_edit_lang = "<?= lang("swal_success_edit"); ?>";
    var swal_warning_delete_lang = "<?= lang("swal_warning_delete"); ?>";
    var swal_success_delete_lang = "<?= lang("swal_success_delete"); ?>";
    var apiFilterProducts_url="<?= base_url('admin/localAgency/apiFilterHistoryProducts'); ?>";
    var productsTable;
</script>
<script src="<?php echo base_url("assets/vendors/datatables.net/js/jquery.dataTables.min.js"); ?>"></script>
<script>
    $(document).ready(function () {
        var handleDataTableButtons = function () {
            if ($("#datatable-products").length) {
                productsTable=$("#datatable-products").DataTable({
                    aaSorting: [[4, 'desc']],
                    responsive: true,
                    "columns": [
                        {"data": "product"},
                        {"data": "agency"},
                        {"data": "quantity"},
                        {"data": "unit"},
                        {"data": "transfertType"},
                        {"data": "date"},
                        {"data": "actions"},
                    ],
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

        var groupProducts=$(this).attr('data-group');
        var startDate='';
        var endDate='';
        $('#editAlertForm').on('submit', function (e) {
            e.preventDefault();

            var stock_history = {
                'id': $("#editAlertForm input[name='id']").val(),
                'quantity': $("#editAlertForm input[name='quantity']").val(),
            };
            var validForm = true;
            if (validForm) {
                $('#loading').show();
                $.ajax({
                    type: 'POST',
                    url: "<?php echo base_url('admin/localAgency/apiEditStockHistory'); ?>",
                    data: {"stock_history": stock_history},
                    dataType: "json",
                    success: function (data) {
                        $('#loading').hide();
                        if (data.status === "success") {
                            swal({
                                title: "Success",
                                text: swal_success_operation_lang,
                                type: "success",
                                timer: 1500,
                                showConfirmButton: false
                            });
                            location.reload();
                        }else if (data.status === "warning") {
                            swal({
                                title: "Attention",
                                text: data.msg,
                                type: "warning",
                                timer: 1500,
                                showConfirmButton: false
                            });
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

        })

        $(document).on('click','button.deleteAlert', deleteAlertEvent);


        function deleteAlertEvent() {
            if(groupProducts==='true'){
                swal({
                    title: "Attention",
                    text: 'Vous devez annuler le groupement pour supprimer',
                    type: "warning",
                    timer: 1500,
                    showConfirmButton: false
                });
                return false;
            }
            var stock_history_id = $(this).closest('tr').attr('data-sh-id');
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
                        url: "<?php echo base_url('admin/localAgency/apiDeleteStock'); ?>",
                        type: "POST",
                        dataType: "json",
                        data: {'stock_history_id': stock_history_id},
                        beforeSend: function () {
                            $('#loading').show();
                        },
                        complete: function () {
                            $('#loading').hide();
                        },
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


        function init_daterangepicker() {

            if (typeof ($.fn.daterangepicker) === 'undefined') {
                return;
            }
            console.log('init_daterangepicker');

            var cb = function (start, end, label) {
                $('#reportrange span').html(start.format('YYYY/MM/DD') + ' - ' + end.format('MMMM D, YYYY'));
                startDate= start.format('YYYY/MM/DD');
                endDate= end.format('YYYY/MM/DD');
                filterProducts();
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

            $('#reportrange span').html(moment().subtract(29, 'days').format('MMMM D, YYYY') + ' - ' + moment().format('MMMM D, YYYY'));
            startDate=moment().subtract(365, 'days').format('YYYY-MM-DD');
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

        function handleProductsData(data) {
            productsTable.clear().draw();
            $.each(data.response.products, function (key,product) {

                var editAction='<div>\n' +
                    '                                           <button class="btn btn-info btn-xs action editAlert small-button"\n' +
                    '                                                   data-type="edit"><span\n' +
                    '                                                       class="glyphicon glyphicon-edit"></span></button>\n' +
                    '                                           <button class="btn btn-danger btn-xs action deleteAlert small-button"\n' +
                    '                                                   data-type="delete"><span\n' +
                    '                                                       class="fa fa-trash"></span></button>\n' +
                    '                                       </div>'



                var row={
                    "product": product.p_name,
                    "agency": product.a_name,
                    "quantity": product.quantity,
                    "unit": product.unit,
                    "transfertType": product.removal,
                    "date": product.date,
                    "actions": editAction,
                };
                var node = productsTable.row.add(row).draw().node();
                $(node).addClass("success");
                $(node).attr('data-id',product.p_id);
                $(node).attr('data-sh-id',product.sh_id);
                $(node).attr('data-quantity',product.quantity);

            });

            /*var row={
                "id": '#',
                "ref": '',
                "amount": '',
                "advance": '',
                "remain": '',
                "global_remain": '',
                "orderDate": '',
                "paymentDate": '',
                "status": '',
                "payment":paidAmount,
                "actions":impaidAmount
            };
            var node = dataTableOrders.row.add(row).draw().node();*/
        }



        $('button.groupProducts').on('click',filterProducts);
        $('.agency').on('change',filterProducts);

        function filterProducts(){
            let agency=$('select.agency').val();
            groupProducts=$(this).attr('data-group');
            if(groupProducts==='true'){
                 $('button.groupProducts').attr('data-group','false');
                 $('button.groupProducts').html('Annuler le groupement');
            }else{
                 $('button.groupProducts').attr('data-group','true');
                 $('button.groupProducts').html('Grouper les produits');
            }

            let myData = {'agency':agency,'groupProducts':groupProducts,'startDate': startDate, 'endDate': endDate};
            let params={'callable':true,'swal':'false','reload':false};
            console.log(myData);
            apiRequest(apiFilterProducts_url,myData,params,handleProductsData);
        }

        init_daterangepicker();

    });
</script>


<script>
    $(document).ready(function () {
        $(document).on('click', ".editAlert", editAlertEvent);
        var l_id = -1;

        function editAlertEvent() {
            let groupProducts = $('button.groupProducts').attr('data-group');
            console.log(groupProducts);
            if(groupProducts==='false'){
                swal({
                    title: "Attention",
                    text: 'Vous devez annuler le groupement pour modifier',
                    type: "warning",
                    timer: 1500,
                    showConfirmButton: false
                });
                return false;
            }

            if ($(this).attr('data-id') === l_id || l_id === -1) {
                $('#editAlert').toggle('slow');
            }
            l_id = $(this).closest('tr').attr('data-id');
            l_sh_id = $(this).closest('tr').attr('data-sh-id');
            var row = $(this).closest('tr');
            $('#editAlert select.productSelect').val($(this).closest('tr').attr('data-id'));
            $('#editAlert input[name="quantity"]').val(row.attr('data-quantity'));

            $('#editAlert input[name="id"]').val(l_sh_id);

           /* $('#editGroupForm select[name="department"]').val($(this).attr('data-department'));*/
            scroll("editAlert");
        }

        // This is a functions that scrolls to #{blah}link
        function scroll(id) {
            // Scroll
            $('html,body').animate({scrollTop: $("#" + id).offset().top}, 'slow');
        }

    });
</script>
