<?php $this->load->view('admin/partials/admin_header.php'); ?>
<style>
    .table-responsive {
        overflow-x: visible;
    }
    @media (max-width: 480px) {
        .dataTables_filter{
            width:100%;
        }
    }
</style>
<!-- page content -->
<div class="right_col" role="main">
    <div class="productsList">
        <div class="page-title">
            <div class="title_left">
                <h3><?= lang('providers_groupes'); ?></h3>
            </div>
        </div>
        <div class="clearfix"></div>
        <hr>
        <div class="row">
            <div class="col-xs-12 col-sm-2 col-md-2">
                <div class="article-title">
                    <a class="btn btn-primary form-control" data-toggle="collapse" href="#collapseExample" aria-expanded="false"
                       aria-controls="collapseExample"><?= lang('add'); ?></a>
                </div>
            </div>
        </div>
        <div class="collapse" id="collapseExample">
            <form id="addGroupForm">
                <fieldset>
                    <div class="row">
                        <div class="col-xs-4">
                            <br>
                            <label for="title"><?= lang('group'); ?> :</label>
                            <input type="text" class="form-control" name="title"
                                   placeholder="<?= lang('title'); ?>"
                                   required>
                        </div>
                    </div>
                    <br/>
                    <div class="text-right">
                        <input class="btn btn-success" type="submit" name="addGroup" value="<?= lang('confirme'); ?>"/>
                    </div>

                </fieldset>
            </form>
            <br>
        </div>

        <div class="collapse" id="editGroup">
            <form id="editGroupForm">
                <fieldset>
                    <input type="hidden" name="id"/>
                    <div class="row">
                        <div class="col-xs-4">
                            <br>
                            <label for="title"><?= lang('group'); ?> :</label>
                            <input type="text" class="form-control" name="title"
                                   placeholder="Titre"
                                   required>
                        </div>

                    </div>
                    <br/>

                    <div class="text-right">
                        <input class="btn btn-success" type="submit" name="editGroup" value="<?= lang('edit'); ?>"/>
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
                    <th><?= lang('group'); ?></th>
                    <th><?= lang('creation_date'); ?></th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tfoot>
                <tr>
                    <th><?= lang('group'); ?></th>
                    <th><?= lang('creation_date'); ?></th>
                    <th>Actions</th>
                </tr>
                </tfoot>
                <tbody>
                   <?php foreach ($providerGroups as $providerGroup) { ?>
                       <tr data-id="<?php echo $providerGroup['id']; ?>">
                           <td width="40%" data-title="<?php echo $providerGroup['title']; ?>"><?php echo $providerGroup['title'];?></td>
                           <td width="40%" ><?php echo $providerGroup['created_at'];?></td>
                           <td>
                               <div>

                                   <a href="<?php echo base_url("admin/provider/group/". $providerGroup['id']); ?>" class="btn btn-success btn-sm action small-button"><span
                                               class="fa fa-eye"></span><?= lang('show'); ?>
                                   </a>

                                   <button class="btn btn-info btn-sm action editGroup small-button"
                                           data-type="edit"><span
                                               class="glyphicon glyphicon-edit"></span><?= lang('edit'); ?></button>

                                  <!-- <button class="btn btn-danger btn-xs action deleteAlert small-button"
                                           data-type="delete"><span
                                               class="fa fa-trash"></span></button>-->
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
        $('#addGroupForm').on('submit', function (e) {
            e.preventDefault();
            var group={
                "title":$(this).find("input[name=title]").val()
            }
            $.ajax({
                url: "<?php echo base_url("admin/provider/apiAddGroup"); ?>",
                type: "POST",
                dataType: "json",
                data: {"group": group},
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

        $('#editGroupForm').on('submit', function (e) {
            e.preventDefault();

            var group = {
                'title': $("#editGroupForm input[name='title']").val(),
            };
            var validForm=true;
            if (validForm) {
                $('#loading').show();
                $.ajax({
                    type: 'POST',
                    url: "<?php echo base_url('admin/provider/apiEditGroup'); ?>",
                    data: {"group": group, 'id': $("#editGroupForm input[name='id']").val()},
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
                                text: swal_success_operation,
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

        $('.profile_details').on('click', function () {
            var id = $(this).attr('data-id');
            document.location.href = "<?php echo base_url(); ?>admin/employee/show/" + id;
        });
    });

</script>

<script>
    $(document).ready(function () {
        $(".editGroup").on('click', editGroupEvent);
        var l_id = -1;
        function editGroupEvent() {
            if ($(this).attr('data-id') === l_id || l_id === -1) {
                $('#editGroup').toggle('slow');
            }
            l_id = $(this).closest('tr').attr('data-id');
            var row = $(this).closest('tr');
            $('#editGroup input[name="title"]').val(row.find("[data-title]").attr('data-title'));

            $('#editGroup input[name="id"]').val(l_id);
        }
    });
</script>