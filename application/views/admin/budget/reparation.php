<?php $this->load->view('admin/partials/admin_header.php'); ?>
<style>
    .table-responsive {
        overflow-x: visible;
        margin: 0px;
    }
    tr{
        white-space: nowrap;
    }
    @media (max-width: 480px) {
        #datatable-reparation_filter{
            float: left !important;
            text-align: left !important;
        }

    }
</style>
<!-- page content -->
<div class="right_col" role="main">
    <div class="productsList">
        <div class="page-title">
            <div class="">
                <h3><?= lang("reparations_list") ?></h3>
            </div>
        </div>
        <div class="clearfix"></div>
        <hr>
        <div class="article-title">
            <a class="btn btn-primary" data-toggle="collapse" href="#collapseExample" aria-expanded="false"
               aria-controls="collapseExample"><?= lang("add") ?></a>
        </div>
        <div class="collapse" id="collapseExample">
            <?php echo validation_errors(); ?>
            <form id="addReparationForm" enctype="multipart/form-data">
                <fieldset>
                    <div class="row">
                        <div class="col-xs-12 col-sm-6 col-md-4">
                            <br>
                            <label for="name"><?= lang("article"); ?> :</label>
                            <input type="text" class="form-control" name="article"
                                   placeholder="<?= lang("article"); ?>"
                                   required>
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-4">
                            <br>
                            <label for="name"><?= lang("price"); ?> :</label>
                            <input type="text" step="any" class="form-control" name="price"
                                   placeholder="<?= lang("price"); ?>"
                                   required>
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-4">
                            <br>
                            <label for="name"><?= lang("problem"); ?> :</label>
                            <input type="text" class="form-control" name="problem"
                                   placeholder="<?= lang("problem"); ?>"
                                   required>
                        </div>

                        <div class="col-xs-12 col-sm-6 col-md-4">
                            <br>
                            <label for="name"><?= lang("repairer"); ?> :</label>
                            <input type="text" class="form-control" name="repairer"
                                   placeholder="<?= lang("repairer"); ?>"
                                   required>
                        </div>

                    </div>
                    <br/>

                    <div class="text-right">
                        <input class="btn btn-success" type="submit" name="addReparation" value="Confirmer"/>
                    </div>

                </fieldset>
            </form>
            <br>
        </div>

        <div class="collapse" id="editAlert">
            <form id="editAlertForm">
                <fieldset>
                    <input type="hidden" name="id"/>
                    <div class="row">
                        <div class="col-xs-12 col-sm-6 col-md-4">
                            <br>
                            <label for="name"><?= lang("article"); ?> :</label>
                            <input type="text" class="form-control" name="article"
                                   placeholder="<?= lang("article"); ?>"
                                   required>
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-4">
                            <br>
                            <label for="name"><?= lang("price"); ?> :</label>
                            <input type="text" step="any" class="form-control" name="price"
                                   placeholder="<?= lang("price"); ?>"
                                   required>
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-4">
                            <br>
                            <label for="name"><?= lang("problem"); ?> :</label>
                            <input type="text" class="form-control" name="problem"
                                   placeholder="<?= lang("problem"); ?>"
                                   required>
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-4">
                            <br>
                            <label for="name"><?= lang("repairer"); ?> :</label>
                            <input type="text" class="form-control" name="repairer"
                                   placeholder="<?= lang("repairer"); ?>"
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
         <!-- /row -->
        <div class="row table-responsive">
            <table id="datatable-reparation" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                <thead>
                <tr>
                    <th><?= lang("article"); ?></th>
                    <th><?= lang("price"); ?></th>
                    <th><?= lang("problem"); ?></th>
                    <th><?= lang("repairer"); ?></th>
                    <th><?= lang("date"); ?></th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tfoot>
                <tr>
                    <th><?= lang("article"); ?></th>
                    <th><?= lang("price"); ?></th>
                    <th><?= lang("problem"); ?></th>
                    <th><?= lang("repairer"); ?></th>
                    <th><?= lang("date"); ?></th>
                    <th>Actions</th>
                </tr>
                </tfoot>
                <tbody>
                   <?php foreach ($reparations as $reparation) { ?>
                       <tr data-id="<?php echo $reparation['id']; ?>">
                           <td data-article="<?php echo $reparation['article']; ?>"><?php echo $reparation['article'];?></td>
                           <td data-price="<?php echo $reparation['price']; ?>"><?php echo $reparation['price'];?></td>
                           <td data-problem="<?php echo $reparation['problem']; ?>"><?php echo $reparation['problem'];?></td>
                           <td data-repairer="<?php echo $reparation['repairer']; ?>"><?php echo $reparation['repairer'];?></td>
                           <td><?php echo $reparation['created_at'];?></td>
                           <td>
                               <div>
                                   <button class="btn btn-info btn-xs action editAlert"
                                           data-type="edit"><span
                                               class="glyphicon glyphicon-edit"></span></button>
                                   <button class="btn btn-danger btn-xs action deleteAlert"
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
            if ($("#datatable-reparation").length) {
                $("#datatable-reparation").DataTable({
                    aaSorting: [[0, 'desc']],
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
        $('#addReparationForm').on('submit', function (e) {
            e.preventDefault();
            var formData = new FormData(this);
            $.ajax({
                type: 'POST',
                url: "<?php echo base_url('admin/budget/apiAddRepartion'); ?>",
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                beforeSend: function () {
                    $('#loading').show();
                },
                complete: function () {
                    $('#loading').hide();
                },
                success: function (data) {
                    swal({
                        title: "Success",
                        text: swal_success_operation_lang,
                        type: "success",
                        timer: 1500,
                        showConfirmButton: false
                    });
                    location.reload();
                },
                error: function (data) {
                    console.log("error");
                    console.log(data);
                }
            });

        });

        $('#editAlertForm').on('submit', function (e) {
            e.preventDefault();

            var reparation = {
                'article': $("#editAlertForm input[name='article']").val(),
                'price': $("#editAlertForm input[name='price']").val(),
                'repairer': $("#editAlertForm input[name='repairer']").val(),
                'problem': $("#editAlertForm input[name='problem']").val()
            };
            var validForm=true;
            if (validForm) {
                $('#loading').show();
                $.ajax({
                    type: 'POST',
                    url: "<?php echo base_url('admin/budget/apiEditReparation'); ?>",
                    data: {reparation: reparation, 'id': $("#editAlertForm input[name='id']").val()},
                    dataType: "json",
                    beforeSend: function () {
                        $('#loading').show();
                    },
                    complete: function () {
                        $('#loading').hide();
                    },
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
            var reparation_id = $(this).closest('tr').attr('data-id');
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
                        url: "<?php echo base_url('admin/budget/apiDeleteReparation'); ?>",
                        type: "POST",
                        dataType: "json",
                        data: {'reparation_id': reparation_id},
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
                                    text: swal_error_lang,
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

        $('.profile_details').on('click', function () {
            var id = $(this).attr('data-id');
            document.location.href = "<?php echo base_url(); ?>admin/employee/show/" + id;
        });
    });

</script>

<script>
    $(document).ready(function () {
        $(".editAlert").on('click', editAlertEvent);
        var l_id = -1;
        function editAlertEvent() {
            if ($(this).attr('data-id') === l_id || l_id === -1) {
                $('#editAlert').toggle('slow');
            }
            l_id = $(this).closest('tr').attr('data-id');
            var row = $(this).closest('tr');
            $('#editAlert input[name="article"]').val(row.find("[data-article]").attr('data-article'));
            $('#editAlert input[name="problem"]').val(row.find("[data-problem]").attr('data-problem'));
            $('#editAlert input[name="price"]').val(row.find("[data-price]").attr('data-price'));
            $('#editAlert input[name="repairer"]').val(row.find("[data-repairer]").attr('data-repairer'));

            $('#editAlert input[name="id"]').val(l_id);
        }
    });
</script>