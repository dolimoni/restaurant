<?php $this->load->view('admin/partials/admin_header.php'); ?>
    <!-- page content -->
    <div class="right_col" role="main">
        <div class="">
            <div class="page-title">
                <div class="title_left">
                    <h3>Clients</h3>
                </div>
            </div>
            <div class="clearfix"></div>
            <hr>
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2>Liste des mes clients</h2>
                            <ul class="nav navbar-right panel_toolbox">
                                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                                <li><a class="close-link"><i class="fa fa-close"></i></a></li>
                            </ul>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">
                            <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                                <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Nom</th>
                                    <th>Adresse</th>
                                    <th>Actions</th>
                                </tr>
                                </thead>
                                <tfoot>
                                <tr>
                                    <th>Id</th>
                                    <th>Nom</th>
                                    <th>Adresse</th>
                                    <th>Actions</th>
                                </tr>
                                </tfoot>
                                <tbody>
                                    <?php foreach ($customers as $customer) {?>
                                    <tr>
                                        <td><?php echo $customer['id']; ?></td>
                                        <td><?php echo $customer['name']; ?></td>
                                        <td><?php echo $customer['address']; ?></td>
                                        <td>
                                            <a href=" <?php echo base_url('admin/customer/edit'.'/'.$customer['id']); ?>"
                                               class="btn btn-primary btn-xs">Edit</a>
                                            <a onclick="return confirm('All records will be deleted, continue?')"
                                               href=" <?php echo base_url('admin/customer/delete' . '/' . $customer['id']); ?>"
                                               class="btn btn-danger btn-xs">Delete</a>
                                        </td>
                                    </tr>
                                  <?php } ?>
                                </tbody>
                            </table>
                        </div> <!-- /content -->
                    </div><!-- /x-panel -->
                </div> <!-- /col -->
            </div> <!-- /row -->
        </div>
    </div> <!-- /.col-right -->
    <!-- /page content -->

<?php $this->load->view('admin/partials/admin_footer'); ?>
<script src="<?php echo base_url("assets/vendors/datatables.net/js/jquery.dataTables.min.js"); ?>"></script>
<script>
    $(document).ready(function () {
        var handleDataTableButtons = function () {
            if ($("#datatable-salary").length) {
                $("#datatable-salary").DataTable({
                    aaSorting: [[0, 'desc']],
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