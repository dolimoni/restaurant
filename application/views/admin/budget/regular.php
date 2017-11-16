<?php $this->load->view('admin/partials/admin_header.php'); ?>
<link href="<?php echo base_url('assets/vendors/bootstrap-daterangepicker/daterangepicker.css'); ?>" rel="stylesheet">
<link href="<?php echo base_url("assets/build2/css/custom.min.css"); ?>" rel="stylesheet">
<!-- page content -->
<div class="right_col" role="main">
    <div class="productsList">
        <div class="page-title">
            <div class="title_left">
                <h3>Liste des dépenses régulières</h3>
            </div>
        </div>
        <div class="clearfix"></div>
        <hr>
        <div class="article-title">
            <a class="btn btn-primary" data-toggle="collapse" href="#collapseExample" aria-expanded="false"
               aria-controls="collapseExample">Ajouter</a>
        </div>
        <div class="collapse" id="collapseExample">
            <?php echo validation_errors(); ?>
            <form id="addRegularCostForm" enctype="multipart/form-data">
                <fieldset>
                    <div class="row">
                        <div class="col-xs-4">
                            <br>
                            <label for="name">Article :</label>
                            <input type="text" class="form-control" name="article"
                                   placeholder="article"
                                   required>
                        </div>
                        <div class="col-xs-4">
                            <br>
                            <label for="name">Prix :</label>
                            <input type="text" step="any" class="form-control" name="price"
                                   placeholder="prix"
                                   required>
                        </div>

                        <div class="col-xs-4">
                            <br>
                            <label for="name">Périodicité :</label>
                            <select name="periodicity" class="form-control">
                                <option value="daily">Quotidienne</option>
                                <option value="weekely">Hebdomadaire</option>
                                <option value="monthly">Mensuelle</option>
                            </select>
                        </div>


                    </div>
                    <div class="row">
                        <div class="col-xs-4">
                            <br>
                            <label for="name">Date du prochain rappel :</label>
                            <?php include ('include/calender.php');?>
                        </div>
                    </div>
                    <br/>

                    <div class="text-right">
                        <input class="btn btn-success" type="submit" name="addPurchase" value="Confirmer"/>
                    </div>

                </fieldset>
            </form>
            <br>
        </div>
         <!-- /row -->
        <div class="row">
            <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                <thead>
                <tr>
                    <th>Article</th>
                    <th>Prix</th>
                    <th>Périodicité</th>
                    <th>Date de rappel</th>
                </tr>
                </thead>
                <tfoot>
                <tr>
                    <th>Article</th>
                    <th>Prix</th>
                    <th>Périodicité</th>
                    <th>Date de rappel</th>
                </tr>
                </tfoot>
                <tbody>

                    <?php foreach ($regularCosts as $regularCost) { ?>
                       <tr>
                           <td> <?php echo $regularCost['article']; ?> </td>
                           <td> <?php echo $regularCost['price']; ?> </td>
                           <td> <?php echo $regularCost['periodicity']; ?> </td>
                           <td> <?php echo $regularCost['reminderDate']; ?> </td>
                       </tr>
                    <?php  } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>


<?php $this->load->view('admin/partials/admin_footer'); ?>

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


<script>

    $(document).ready(function () {
        $('#addRegularCostForm').on('submit', function (e) {
            e.preventDefault();
            var formData = new FormData(this);
            $.ajax({
                type: 'POST',
                url: "<?php echo base_url('admin/budget/apiAddRegularCostForm'); ?>",
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: function (data) {
                    swal({
                        title: "Success",
                        text: "L'article a été bien ajouté",
                        type: "success",
                        timer: 1500,
                        showConfirmButton: false
                    });
                },
                error: function (data) {
                    console.log("error");
                    console.log(data);
                }
            });

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
            $('#single_cal3').daterangepicker({
                singleDatePicker: true,
                singleClasses: "picker_3"
            }, function (start, end, label) {
                $('input[name="reminderDate"]').val(start.format('Y-M-D'));
            });
            $('input[name="reminderDate"]').val(moment().startOf('day').format('Y-M-D'));
        }

        init_daterangepicker_single_call();
    });
</script>


