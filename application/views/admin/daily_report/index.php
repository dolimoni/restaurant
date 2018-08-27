<?php $this->load->view('admin/partials/admin_header.php'); ?>
<style>
    tr{
        white-space: nowrap;
    }
    @media (max-width: 480px) {
        .dataTables_filter{
            width:100%;
        }
    }
</style>
    <!-- page content -->
    <div class="right_col" role="main">
        <div class="">
            <div class="page-title">
                <div class="title_left">
                    <h3>Rapports</h3>
                </div>
            </div>
            <div class="clearfix"></div>
            <hr>
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2>Liste des rapports</h2>
                            <ul class="nav navbar-right panel_toolbox">
                                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                                <li><a class="close-link"><i class="fa fa-close"></i></a></li>
                            </ul>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">
                            <a href="<?php echo base_url('/admin/reports/create'); ?>" class="btn btn-primary">Créer un rapport</a>
                            <br /><br />
                            <div class="table-responsive">
                                <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                                    <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Titre</th>
                                        <th>Date de création</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tfoot>
                                    <tr>
                                        <th>Id</th>
                                        <th>Titre</th>
                                        <th>Date de création</th>
                                        <th>Action</th>
                                    </tr>
                                    </tfoot>
                                    <tbody>
                                    <?php foreach ($reports as $report) {?>
                                        <tr>
                                            <?php $id = $report['id']; ?>
                                            <td><?php echo $id; ?></td>
                                            <td><?php echo $report['title'] ?></td>
                                            <td><?php echo date("d/m/Y",strtotime($report['createdAt'])); ?></td>
                                            <td>
                                                <a href="<?php echo base_url("/admin/reports/viewReport/$id"); ?>"
                                                   class="btn btn-primary  btn-xs"><i class="fa fa-eye"></i></a>
                                                <?php if (($this->session->userdata('id') == $report['user_id']) && $report['sent'] ==0) { ?>
                                                    <a href="<?php echo base_url("/admin/reports/editReport/$id"); ?>"
                                                       class="btn btn-primary  btn-xs"><i class="fa fa-pencil"></i></a>

                                                    <a href=""
                                                       class="sendBtn btn btn-primary  btn-xs"><i class="fa fa-send"></i></a>


                                                    <a class="deleteBtn btn btn-primary  btn-xs" data-toggle="modal" data-target="#myModal" data-id="<?php echo $id; ?>" ><i class="fa fa-trash" aria-hidden="true"></i></a>
                                                <?php } ?>

                                            </td>
                                        </tr>
                                    <?php } ?>
                                    </tbody>
                                </table>

                            </div>
                        </div> <!-- /content -->
                    </div><!-- /x-panel -->
                </div> <!-- /col -->
            </div> <!-- /row -->
        </div>
    </div> <!-- /.col-right -->
    <!-- /page content -->
    <!-- Modal -->
      <div class="modal fade" id="myModal" role="dialog">
        <div class="modal-dialog modal-sm">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              <h4 class="modal-title">Supprimer rapport</h4>
            </div>
            <div class="modal-body">
              <p>Vous êtes sur de vouloir supprimer le rapport.</p>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-danger deleteConfBtn">Supprimer</button>
              <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
            </div>
          </div>
        </div>
      </div>
    </div>

<?php $this->load->view('admin/partials/admin_footer'); ?>
<script src="<?php echo base_url("assets/vendors/datatables.net/js/jquery.dataTables.min.js"); ?>"></script>
<script>
    $(document).ready(function () {
        // var handleDataTableButtons = function () {
        //     if ($("#datatable-salary").length) {
        //         $("#datatable-salary").DataTable({
        //             aaSorting: [[0, 'desc']],
        //             responsive: true,
        //         });
        //     }
        // };

        // TableManageButtons = function () {
        //     "use strict";
        //     return {

        //         init: function () {
        //             handleDataTableButtons();
        //         }
        //     };
        // }();

        // TableManageButtons.init();

        $('#datatable-responsive').on('click', '.deleteBtn', function () {
            $('.deleteConfBtn').data('id',$(this).data('id'));
        });

        // Ajouter listener pour supprimer  
        $('#myModal').on('click', '.deleteConfBtn', function () {
            var id = $(this).data('id');
            console.log(id);
            var formData = {"id":id};

            $.ajax({
                type: 'POST',
                url: "./reports/delete",
                data: formData,
                dataType: "json",
                cache: false,
                success: function (data) {
                    if(data["report"]){
                        $('#myModal').modal('hide');
                        location.reload();
                    }
                },
                error: function (data) {
                    console.log("error");
                    console.log(data);
                }
            });
            // alert("delete !");
        });
    });
</script>