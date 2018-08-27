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
                               <tr class="success" data-id="<?php echo $product['p_id']; ?>" data-sh-id="<?php echo $product['sh_id']; ?>">
                                   <td><?php echo $product['p_name']; ?></td>
                                   <td><?php echo $product['a_name']; ?></td>
                                   <td data-quantity="<?php echo $product['quantity'] ?>"><?php echo $product['quantity'] ?></td>
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
<script>
    var swal_success_operation_lang = "<?= lang("swal_success_operation"); ?>";
    var swal_error_lang = "<?= lang("swal_error"); ?>";
    var swal_success_edit_lang = "<?= lang("swal_success_edit"); ?>";
    var swal_warning_delete_lang = "<?= lang("swal_warning_delete"); ?>";
    var swal_success_delete_lang = "<?= lang("swal_success_delete"); ?>";
</script>
<script src="<?php echo base_url("assets/vendors/datatables.net/js/jquery.dataTables.min.js"); ?>"></script>
<script>
    $(document).ready(function () {
        var handleDataTableButtons = function () {
            if ($("#datatable-products").length) {
                $("#datatable-products").DataTable({
                    aaSorting: [[4, 'desc']],
                    responsive: true,
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
                    url: "<?php echo base_url('admin/agency/apiEditStockHistory'); ?>",
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

        $('button.deleteAlert').on('click', deleteAlertEvent);


        function deleteAlertEvent() {
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
                        url: "<?php echo base_url('admin/agency/apiDeleteStock'); ?>",
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

    });
</script>


<script>
    $(document).ready(function () {
        $(document).on('click', ".editAlert", editAlertEvent);
        var l_id = -1;

        function editAlertEvent() {
            if ($(this).attr('data-id') === l_id || l_id === -1) {
                $('#editAlert').toggle('slow');
            }
            l_id = $(this).closest('tr').attr('data-id');
            l_sh_id = $(this).closest('tr').attr('data-sh-id');
            var row = $(this).closest('tr');
            $('#editAlert select.productSelect').val($(this).closest('tr').attr('data-id'));
            $('#editAlert input[name="quantity"]').val(row.find("[data-quantity]").attr('data-quantity'));

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
