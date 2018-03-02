<?php $this->load->view('admin/partials/admin_header.php'); ?>
<style>

    /* Tabs container */
    .r-tabs {
        position: relative;

        background-color: #3c8dbc;

        border-top: 1px solid #3c8dbc;
        border-right: 1px solid #3c8dbc;
        border-left: 1px solid #3c8dbc;
        border-bottom: 4px solid #3c8dbc;
        border-radius: 4px;

    }

    /* Tab element */
    .r-tabs .r-tabs-nav .r-tabs-tab {
        position: relative;
        background-color: #3c8dbc;
    }

    /* Tab anchor */
    .r-tabs .r-tabs-nav .r-tabs-anchor {
        display: inline-block;
        padding: 10px 12px;

        text-decoration: none;
        text-shadow: 0 1px rgba(0, 0, 0, 0.4);
        font-size: 14px;
        font-weight: bold;
        color: #fff;
    }

    /* Disabled tab */
    .r-tabs .r-tabs-nav .r-tabs-state-disabled {
        opacity: 0.5;
    }

    /* Active state tab anchor */
    .r-tabs .r-tabs-nav .r-tabs-state-active .r-tabs-anchor {
        color: #3c8dbc;
        text-shadow: none;

        background-color: white;

        border-top-right-radius: 4px;
        border-top-left-radius: 4px;
    }

    /* Tab panel */
    .r-tabs .r-tabs-panel {
        background-color: white;

        border-bottom: 4px solid white;

        border-bottom-right-radius: 4px;
        border-bottom-left-radius: 4px;

    }

    /* Accordion anchor */
    .r-tabs .r-tabs-accordion-title .r-tabs-anchor {
        display: block;
        padding: 10px;

        background-color: #3c8dbc;
        color: #fff;
        font-weight: bold;
        text-decoration: none;
        text-shadow: 0 1px rgba(0, 0, 0, 0.4);
        font-size: 14px;

        border-top-right-radius: 4px;
        border-top-left-radius: 4px;
    }

    /* Active accordion anchor */
    .r-tabs .r-tabs-accordion-title.r-tabs-state-active .r-tabs-anchor {
        background-color: #fff;
        color: #3c8dbc;
        text-shadow: none;
    }

    /* Disabled accordion button */
    .r-tabs .r-tabs-accordion-title.r-tabs-state-disabled {
        opacity: 0.5;
    }

    .r-tabs .r-tabs-nav {
        margin: 0;
        padding: 0;
    }

    .r-tabs .r-tabs-tab {
        display: inline-block;
        margin: 0;
        list-style: none;
    }

    .r-tabs .r-tabs-panel {
        padding: 15px;
        display: none;
    }

    .r-tabs .r-tabs-accordion-title {
        display: none;
    }

    .r-tabs .r-tabs-panel.r-tabs-state-active {
        display: block;
    }

    .right_col{
        min-height: 1250px !important;
    }

    /* Accordion responsive breakpoint */
    @media only screen and (max-width: 768px) {
        .r-tabs .r-tabs-nav {
            display: none;
        }

        .r-tabs .r-tabs-accordion-title {
            display: block;
        }
    }

</style>
<link href="<?php echo base_url("assets/build/css/main.css"); ?>" rel="stylesheet">
<!-- page content -->
<div class="right_col" role="main">
    <div class="productsList">
        <div class="page-title">
            <div class="title_left">
                <h3>Configuration générale</h3>
            </div>
        </div>
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    Mes informations
                </div>
                <div class="x_content">
                    <div id="responsiveTabsDemo" class="r-tabs">
                        <ul class="r-tabs-nav">
                            <li class="r-tabs-tab r-tabs-state-active"><a href="#tab-1" class="r-tabs-anchor">
                                    Détails </a>
                            </li>
                            <!-- <li class="r-tabs-tab r-tabs-state-default"><a href="#tab-3" class="r-tabs-anchor">
                                     Factures</a>
                             </li>-->
                        </ul>

                        <div class="r-tabs-accordion-title r-tabs-state-active"><a href="#tab-1" class="r-tabs-anchor">
                                Détails </a></div>
                        <div id="tab-1" class="r-tabs-panel r-tabs-state-active" style="display: block;">
                            <div class="row">
                                <div class="col-md-6 col-sm-8 col-xs-12">
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <label>Nom</label>
                                            </div>
                                            <div class="col-md-8">
                                                <?php echo $user['last_name']; ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <label>Prénom</label>
                                            </div>
                                            <div class="col-md-8">
                                                <?php echo $user['first_name']; ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <label>Téléphone</label>
                                            </div>
                                            <div class="col-md-8">
                                                <?php echo $user['mobile']; ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <label>Email</label>
                                            </div>
                                            <div class="col-md-8">
                                                <?php echo $user['email']; ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <label>Adresse</label>
                                            </div>
                                            <div class="col-md-8">
                                                <?php echo $user['address']; ?>
                                            </div>
                                        </div>
                                    </div>
                                    <br/>
                                    <button class="btn btn-info action"
                                            onclick="window.location.href='<?php echo base_url("admin/config/editUser/". $user['id']); ?>'">
                                        <span></span>Modifier
                                    </button>
                                </div>
                                <div class="col-md-6 col-sm-4 col-xs-12">
                                    <img src="<?= base_url('assets/images/' . $params['photo']); ?>" alt="icon">
                                </div>
                            </div>
                        </div>
                    </div>
                </div> <!-- /content -->
            </div>

            <div class="x_panel">
                <div class="x_title">
                    Liste des utilisateurs
                </div>
                <div class="x_content">
                    <table id="datatable-users" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                        <thead>
                        <tr>
                            <th>Nom</th>
                            <th>Prénom</th>
                            <th>Téléphone</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tfoot>
                        <tr>
                            <th>Nom</th>
                            <th>Prénom</th>
                            <th>Téléphone</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Actions</th>
                        </tr>
                        </tfoot>
                        <tbody>
                            <?php foreach ($allUsers as $user){ ?>
                            <tr>
                                <td><?php echo  $user["first_name"]; ?></td>
                                <td><?php echo  $user["last_name"]; ?></td>
                                <td><?php echo  $user["mobile"]; ?></td>
                                <td><?php echo  $user["email"]; ?></td>
                                <td><?php echo  $user["type"]; ?></td>
                                <td>
                                    <a href=" <?php echo base_url(); ?>admin/config/editUser/<?php echo $user['id']; ?>"
                                       class="btn btn-primary  btn-xs"><i class="fa fa-pencil"></i></a>
                                    <?php if($user["type"]!=="admin") :?>
                                    <a data-id="<?php echo $user['id']; ?>" class="btn btn-danger btn-xs deleteUser"><i class="fa fa-trash"></i></a>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div> <!-- /content -->
                <?php if($params["addUsers"]==="true") :?>
                <button class="btn btn-info action"
                        onclick="window.location.href='<?php echo base_url("admin/config/createUser"); ?>'">
                    <span></span>Nouveau
                </button>
                <?php endif; ?>
            </div><!-- /x-panel -->
        </div>
    </div>
</div>


<?php $this->load->view('admin/partials/admin_footer'); ?>
<script src="<?php echo base_url("assets/vendors/datatables.net/js/jquery.dataTables.min.js"); ?>"></script>
<script>
    $(document).ready(function () {
        var handleDataTableButtons = function () {
            if ($("#datatable-users").length) {
                $("#datatable-users").DataTable({
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
        $('a.deleteUser').on('click', deleteUser);


        function deleteUser() {
            var user_id = $(this).attr('data-id');
            $(this).closest('tr').hide();
            swal({
                    title: "Attention ! ",
                    text: "Vous voulez vraiment supprimer cet utilisateur ?",
                    type: "warning",
                    showConfirmButton: true,
                    showCancelButton: true,
                    cancelButtonText: 'Non',
                    confirmButtonText: 'Oui'
                },
                function () {
                    $('#loading').show();
                    $.ajax({
                        url: "<?php echo base_url('admin/config/apiDeleteUser'); ?>",
                        type: "POST",
                        dataType: "json",
                        data: {'user_id': user_id},
                        success: function (data) {
                            $('#loading').hide();
                            if (data.status === 'success') {
                                swal({
                                    title: "Success",
                                    text: "L'utilisateur a été bien supprimé",
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
                            $('#loading').hide();
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
    });
</script>






