<?php $this->load->view('admin/partials/admin_header.php'); ?>
<style>
    .table-responsive {
        overflow-x: visible;
    }
</style>
<!-- page content -->
<div class="right_col" role="main">
    <div class="productsList">
        <div class="page-title">
            <div class="title_left">
                <h3>Groupes de fournisseurs</h3>
            </div>
        </div>
        <div class="clearfix"></div>
        <hr>
        <div class="article-title">
            <a class="btn btn-primary" data-toggle="collapse" href="#collapseExample" aria-expanded="false"
               aria-controls="collapseExample">Ajouter</a>
        </div>
        <div class="collapse" id="collapseExample">
            <form id="addGroupForm">
                <fieldset>
                    <div class="row">
                        <div class="col-xs-4">
                            <br>
                            <label for="title">Article :</label>
                            <input type="text" class="form-control" name="title"
                                   placeholder="Titre"
                                   required>
                        </div>
                    </div>
                    <br/>
                    <div class="text-right">
                        <input class="btn btn-success" type="submit" name="addGroup" value="Confirmer"/>
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
                            <label for="title">Article :</label>
                            <input type="text" class="form-control" name="title"
                                   placeholder="Titre"
                                   required>
                        </div>

                    </div>
                    <br/>

                    <div class="text-right">
                        <input class="btn btn-success" type="submit" name="editGroup" value="Modifier"/>
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
                    <th>Article</th>
                    <th>Date de création</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tfoot>
                <tr>
                    <th>Article</th>
                    <th>Date de création</th>
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
                                               class="fa fa-eye"></span>Afficher
                                   </a>

                                   <button class="btn btn-info btn-sm action editGroup small-button"
                                           data-type="edit"><span
                                               class="glyphicon glyphicon-edit"></span>Modifer</button>

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
                        text: "Le groupe a été bien ajouté",
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
                                text: "L'opération a été bien effectuée",
                                type: "success",
                                timer: 1500,
                                showConfirmButton: false
                            });
                            location.reload();
                        } else {
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
                        $('#loading').show();
                        swal({
                            title: "Erreur",
                            text: "Une erreur s'est produite",
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
                    text: "Vous voulez vraiment supprimer cette réparation ?",
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
                        success: function (data) {
                            if (data.status === 'success') {
                                swal({
                                    title: "Success",
                                    text: "L'opération a été bien effectuée",
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