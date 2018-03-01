<?php $this->load->view('admin/partials/admin_header.php'); ?>
<style>
    .profile_details:nth-child(3n) {
        clear: none;
    }
    input[name=search]{
        height: 31px;
        margin-right: 11px;
    }

    .ui-datepicker-calendar {
        display: none;
    }
</style>
<!-- page content -->
<div class="right_col" role="main">
    <div class="productsList">
        <div class="page-title">
            <div class="title_left">
                <h3>Liste des employées</h3>
            </div>
        </div>
        <div class="clearfix"></div>
        <hr>
        <div class="container">
            <!-- /row -->

            <div class="col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Liste des employées</h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                            <li><a class="close-link"><i class="fa fa-close"></i></a></li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <label for="startDate">Date :</label>
                    <input name="startDate" id="startDate" class="date-picker"/>
                    <div class="x_content table-responsive">
                        <table id="datatable-bestPrice" class="table table-striped table-bordered dt-responsive nowrap"
                               cellspacing="0" width="100%">
                            <thead>
                            <tr>
                                <th>Nom</th>
                                <th>Prénom</th>
                                <th>Salaire</th>
                                <th>Avance</th>
                                <th>Reste</th>
                                <th>Absences</th>
                                <th>Soustraction</th>
                            </tr>
                            </thead>
                            <tfoot>
                            <tr>
                                <th>Nom</th>
                                <th>Prénom</th>
                                <th>Salaire</th>
                                <th>Avance</th>
                                <th>Reste</th>
                                <th>Absences</th>
                                <th>Soustraction</th>
                            </tr>
                            </tfoot>
                            <tbody>
                            <?php foreach ($salaries as $salary) { ?>
                                <tr>
                                    <td>
                                        <a href="<?php echo base_url("admin/employee/show/".$salary["id"]);?>">
                                            <?php echo $salary['name']; ?>
                                        </a>
                                    </td>
                                    <td><?php echo $salary['prenom']; ?></td>
                                    <td><?php echo $salary['salary']; ?></td>
                                    <td><?php echo $salary['advance']; ?></td>
                                    <td><?php echo $salary['remain']; ?></td>
                                    <td><?php echo $salary['absence']; ?></td>
                                    <td><?php echo $salary['substraction']; ?></td>
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

<script src="<?php echo base_url("assets/vendors/datatables.net/js/jquery.dataTables.min.js"); ?>"></script>
<script>
    $(document).ready(function () {
        var handleDataTableButtons = function () {
            if ($("#datatable-bestPrice").length) {
                $("#datatable-bestPrice").DataTable({
                    aaSorting: [[0, 'desc']],
                    responsive: true,
                    "language": {
                        "url": "<?php echo base_url("assets/vendors/datatables.net/French.json"); ?>"
                    }
                });
            }

            if ($("#datatable-allPrice").length) {
                $("#datatable-allPrice").DataTable({
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

<script type="text/javascript">
    $(function () {
        $('.date-picker').daterangepicker({
            changeMonth: true,
            changeYear: true,
            showButtonPanel: true,
            dateFormat: 'MM yy',
            onClose: function (dateText, inst) {
                var month = $("#ui-datepicker-div .ui-datepicker-month :selected").val();
                var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val();
                $(this).datepicker('setDate', new Date(year, month, 1));
            }
        });
    });
</script>

