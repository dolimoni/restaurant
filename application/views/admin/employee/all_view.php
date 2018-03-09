<link rel="stylesheet" href="<?php echo base_url("assets/vendors/jquery-ui/themes/overcast/jquery-ui.min.css"); ?>">
<link rel="stylesheet" href="<?php echo base_url("assets/vendors/jquery-ui-month-picker/src/MonthPicker.css"); ?>">
<?php $this->load->view('admin/partials/admin_header.php'); ?>
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
                                <th>Payé</th>
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
                                <th>Payé</th>
                            </tr>
                            </tfoot>
                            <tbody id="tbody">
                            <?php foreach ($salaries as $salary) {
                                $paidFr="Oui";
                                if($salary["paid"]==="false"){
                                    $paidFr="Non";
                                }
                                ?>
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
                                    <td><?php echo $paidFr ?></td>
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
<script src="<?php echo base_url('assets/vendors/moment/min/moment.min.js'); ?>"></script>

<script src="<?php echo base_url("assets/vendors/datatables.net/js/jquery.dataTables.min.js"); ?>"></script>
<script src="<?php echo base_url("assets/vendors/jquery-ui/jquery-ui.min.js"); ?>"></script>
<script src="<?php echo base_url("assets/vendors/jquery-ui-month-picker/src/MonthPicker.js"); ?>"></script>
<script>
    $(document).ready(function () {
        var table;
        var handleDataTableButtons = function () {
            if ($("#datatable-bestPrice").length) {
                table=$("#datatable-bestPrice").DataTable({
                    aaSorting: [[0, 'desc']],
                    "columns": [
                        {"data": "name"},
                        {"data": "prenom"},
                        {"data": "salary"},
                        {"data": "advance"},
                        {"data": "remain"},
                        {"data": "absence"},
                        {"data": "substraction"},
                        {"data": "paid"}
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

        $('#startDate').MonthPicker({
            i18n: {
                year: "année",
                prevYear: "l'année dernière",
                nextYear: "l'année prochaine",
                months: ["Jan", "Fév", "Mar", "Avr", "Mai", "Jui", "Jul", "Aou", "Sep", "Oct", "Nov", "Dec"]
            },
            Button: '<button type="button" class="ui-datepicker-trigger">...</button>',
            OnAfterChooseMonth: function (selectedDate) {
                var myData = {
                    "startDate": formattedDate(selectedDate)
                };
                $.ajax({
                    url: "<?php echo base_url("admin/employee/apiAll"); ?>",
                    type: "POST",
                    dataType: "json",
                    data: myData,
                    beforeSend: function () {
                        $('#loading').show();
                    },
                    complete: function () {
                        $('#loading').hide();
                    },
                    success: function (data) {
                        if (data.status === "success") {
                            table.clear();
                              $.each(data.salaries, function (key,salary) {
                                  var paidFr="Oui";
                                  if(salary["paid"]==="false"){
                                      paidFr="Non";
                                  }
                                  table.row.add({
                                      "name": "<a href='<?php echo base_url('admin/employee/show/'); ?>" + salary.id + "'>" + salary.name + "</a>",
                                      "prenom": salary.prenom,
                                      "advance": salary.advance,
                                      "salary": salary.salary,
                                      "remain": salary.remain,
                                      "absence": salary.absence,
                                      "substraction": salary.substraction,
                                      "paid": paidFr
                                  }).draw();
                               });

                        }
                        else {
                            console.log('Error');
                        }
                    },
                    error: function (data) {
                    }
                });
            }
        });

        function formattedDate(d) {
            let month = String(d.getMonth() + 1);
            let day = String(d.getDate());
            const year = String(d.getFullYear());

            if (month.length < 2) month = '0' + month;
            if (day.length < 2) day = '0' + day;

            return `${year}-${month}-${day}`;
        }

        TableManageButtons.init();
    });
</script>
