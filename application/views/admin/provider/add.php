<?php $this->load->view('admin/partials/admin_header.php'); ?>
<style>
    .profile_details:nth-child(3n) {
        clear: none;
    }
    .showProvider{
        min-height: 178px;
    }
</style>
<!-- page content -->
<div class="right_col" role="main">
    <div class="productsList">
        <div class="clearfix"></div>


        <div class="" role="tabpanel" data-example-id="togglable-tabs">
            <ul id="myTab" class="nav nav-tabs bar_tabs sm-hidden" role="tablist">
                <li role="presentation" class="active"><a href="#tab_products" id="home-tab"
                                                          role="tab"
                                                          data-toggle="tab"
                                                          aria-expanded="false">Mes fournisseurs</a>
                </li>
                <li role="presentation"><a href="#tab_productsToOrder" id="home-tab"
                                           role="tab"
                                           data-toggle="tab" aria-expanded="true">Mes invitations (<?php echo count($invitations); ?>)</a>
                </li>
            </ul>
            <div class="col-md-3 col-sm-12 col-xs-12 md-hidden">
                <ul class="nav nav-tabs tabs-left">
                    <li class="active"><a href="#tab_products" data-toggle="tab" aria-expanded="true"><?= lang('details'); ?></a>
                    </li>
                    <li class=""><a href="#tab_productsToOrder" data-toggle="tab" aria-expanded="true"><?= lang('parameters'); ?></a>
                    </li>
                </ul>
            </div>
            <div class="tab-content">
                <div role="tabpanel" class="tab-pane fade active in" id="tab_products"
                     aria-labelledby="home-tab">
                    <div class="providersList">
                        <div class="article-title">
                            <div class="page-title">
                                <div class="row">
                                    <div class="col-xs-12 col-md-7">
                                        <div class="row">
                                            <div class="col-xs-12 col-sm-4 col-md-3"> <a class="btn btn-primary btn-block" data-toggle="collapse" href="#collapseExample" aria-expanded="false"
                                                                                         aria-controls="collapseExample"><?= lang("new") ?></a></div>
                                            <div class="col-xs-12 col-sm-4 col-md-6">
                                                <a class="btn btn-info btn-block" href="<?php echo base_url("admin/provider/allOrders");?>"><?= lang("allOrders") ?></a>
                                            </div>
                                            <div class="col-xs-12 col-sm-4 col-md-3">
                                                <a class="btn btn-warning btn-block" href="<?php echo base_url("admin/provider/statistic");?>"><?= lang("statistics") ?></a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-md-5">
                                        <div class="col-xs-12 col-md-12" style="padding: 0px;">
                                            <div>
                                                <input type="text" placeholder="<?= lang("search") ?>" class="form-control" id="searchInput"
                                                       onkeyup="myFunction()">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">

                        </div>
                        <div class="collapse" id="collapseExample">
                            <form id="addProviderForm" enctype="multipart/form-data">
                                <fieldset>
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-4 col-md-4">
                                            <br>
                                            <label for="name"><?= lang("group") ?> :</label>
                                            <select class="form-control" name="title">
                                                <option value="0"><?= lang("neither") ?></option>
                                                <?php foreach ($providerGroups as $providerGroup){ ?>
                                                    <option value="<?php echo $providerGroup["id"] ?>"><?php echo $providerGroup["title"] ?></option>
                                                <?php } ?>
                                            </select>
                                        </div><div class="col-xs-12 col-sm-4 col-md-4">
                                            <br>
                                            <label for="name"><?= lang("name") ?> :</label>
                                            <input type="text"  class="form-control" name="name"
                                                   placeholder="<?= lang("name") ?>" required>
                                        </div><div class="col-xs-12 col-sm-4 col-md-4">
                                            <br>
                                            <label for="name"><?= lang("last_name") ?> :</label>
                                            <input type="text" step="any" class="form-control" name="prenom"
                                                   placeholder="<?= lang("last_name") ?>"
                                            >
                                        </div>

                                    </div>
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-4 col-md-4">
                                            <br>
                                            <label for="name"><?= lang("address") ?> :</label>
                                            <input type="text"  class="form-control" name="address"
                                                   placeholder="Adresse"
                                            >
                                        </div><div class="col-xs-12 col-sm-4 col-md-4">
                                            <br>
                                            <label for="name"><?= lang("telephone") ?> :</label>
                                            <input type="text"  class="form-control" name="phone"
                                                   placeholder="Téléphone"
                                            >
                                        </div><div class="col-xs-12 col-sm-4 col-md-4">
                                            <br>
                                            <label for="name"><?= lang("email") ?> :</label>
                                            <input type="text"  class="form-control" name="mail"
                                                   placeholder="<?= lang("email") ?>"
                                            >
                                        </div>


                                    </div>
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-4 col-md-4">
                                            <br>
                                            <label for="tva"><?= lang("tva") ?> :</label>
                                            <input type="text" class="form-control" name="tva" value="0">
                                        </div>

                                        <div class="col-xs-12 col-sm-4 col-md-4">
                                            <br>
                                            <label for="image"><?= lang("image") ?> :</label>
                                            <input type="file" class="form-control" name="image" size="10485760">
                                        </div>
                                    </div>
                                    <br/>

                                    <div class="text-right">
                                        <input class="btn btn-success" type="submit" name="addProvider" value="<?= lang("confirme") ?>"/>
                                    </div>

                                </fieldset>
                            </form>
                            <br>
                        </div>


                        <div class="collapse" id="editProvider">
                            <form id="editProviderForm" enctype="multipart/form-data">
                                <fieldset>
                                    <div class="row">
                                        <input type="hidden" name="id"/>
                                        <div class="col-xs-12 col-sm-4 col-md-4">
                                            <br>
                                            <label for="name"><?= lang("group") ?> :</label>
                                            <select class="form-control" name="title">
                                                <option value="0"><?= lang("neither") ?></option>
                                                <?php foreach ($providerGroups as $providerGroup) { ?>
                                                    <option value="<?php echo $providerGroup["id"] ?>"><?php echo $providerGroup["title"] ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <div class="col-xs-12 col-sm-4 col-md-4">
                                            <br>
                                            <label for="name"><?= lang("name") ?> :</label>
                                            <input type="text" class="form-control" name="name"
                                                   placeholder="<?= lang("name") ?>" required>
                                        </div>
                                        <div class="col-xs-12 col-sm-4 col-md-4">
                                            <br>
                                            <label for="name"><?= lang("last_name") ?> :</label>
                                            <input type="text" step="any" class="form-control" name="prenom"
                                                   placeholder="<?= lang("last_name") ?>"
                                            >
                                        </div>

                                    </div>
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-4 col-md-4">
                                            <br>
                                            <label for="name"><?= lang("address") ?> :</label>
                                            <input type="text" class="form-control" name="address"
                                                   placeholder="<?= lang("address") ?>"
                                            >
                                        </div>
                                        <div class="col-xs-12 col-sm-4 col-md-4">
                                            <br>
                                            <label for="name"><?= lang("telephone") ?> :</label>
                                            <input type="text" class="form-control" name="phone"
                                                   placeholder="<?= lang("telephone") ?>"
                                            >
                                        </div>
                                        <div class="col-xs-12 col-sm-4 col-md-4">
                                            <br>
                                            <label for="name"><?= lang("email") ?> :</label>
                                            <input type="text" class="form-control" name="mail"
                                                   placeholder="<?= lang("email") ?>"
                                            >
                                        </div>


                                    </div>
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-4 col-md-4">
                                            <br>
                                            <label for="tva"><?= lang("tva") ?> :</label>
                                            <input type="text" class="form-control" name="tva">
                                        </div>

                                        <div class="col-xs-12 col-sm-4 col-md-4">
                                            <br>
                                            <label for="image"><?= lang("image") ?> :</label>
                                            <input type="file" class="form-control" name="image" size="10485760">
                                        </div>
                                    </div>
                                    <br/>

                                    <div class="text-right">
                                        <input class="btn btn-success" type="submit" name="editProvider" value="<?= lang("edit") ?>"/>
                                    </div>

                                </fieldset>
                            </form>
                            <br>
                        </div>

                        <?php
                        //Columns must be a factor of 12 (1,2,3,4,6,12)
                        $numOfCols = 3;
                        $rowCount = 0;
                        $bootstrapColWidth = 12 / $numOfCols;
                        ?>
                        <div class="container">
                            <div class="row">
                                <?php foreach ($providers as $provider) { ?>
                                    <div class="col-md-4 col-sm-6 col-xs-12 profile_details"
                                         data-name="<?php echo $provider['name'] . " " . $provider['prenom']; ?>" data-id="<?php echo $provider['id']; ?>">
                                        <div class="well profile_view">
                                            <div class="col-sm-12 showProvider" data-id="<?php echo $provider['id']; ?>">
                                                <h4 class="brief"><i> <?php echo $provider['title']; ?> </i></h4>
                                                <div class="left col-xs-7">
                                                    <h2><?php echo $provider['prenom']; ?> <?php echo $provider['name']; ?></h2>
                                                    <p><?php echo $provider['title']; ?></p>
                                                </div>
                                                <div class="right col-xs-5 text-center">
                                                    <img src="<?php echo base_url("assets/images/" . $provider['image']); ?>" alt=""
                                                         class="img-circle img-responsive">
                                                </div>
                                                <div class="left col-xs-12">
                                                    <ul class="list-unstyled">
                                                        <li><i class="fa fa-building"></i> Adresse: <?php echo $provider['address']; ?>
                                                        </li>
                                                        <li><i class="fa fa-phone"></i> Téléphone #:<?php echo $provider['phone']; ?>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="col-xs-12 bottom text-center">
                                                <div class="col-xs-12 col-sm-5 emphasis">
                                                    <p class="ratings">
                                                        <a>4.0</a>
                                                        <a href="#"><span class="fa fa-star"></span></a>
                                                        <a href="#"><span class="fa fa-star"></span></a>
                                                        <a href="#"><span class="fa fa-star"></span></a>
                                                        <a href="#"><span class="fa fa-star"></span></a>
                                                        <a href="#"><span class="fa fa-star-o"></span></a>
                                                    </p>
                                                </div>
                                                <div class="col-xs-12 col-sm-7 emphasis">
                                                    <button aria-expanded="false"
                                                            data-id="<?php echo $provider['id'] ?>"
                                                            data-name="<?php echo $provider['name'] ?>"
                                                            data-title="<?php echo $provider['pg_id'] ?>"
                                                            data-prenom="<?php echo $provider['prenom'] ?>"
                                                            data-address="<?php echo $provider['address'] ?>"
                                                            data-phone="<?php echo $provider['phone'] ?>"
                                                            data-mail="<?php echo $provider['mail'] ?>"
                                                            data-tva="<?php echo $provider['tva'] ?>"
                                                            type="button"
                                                            class="btn btn-info btn-xs editProvider">
                                                        <i class="fa fa-edit"> </i> Modifier
                                                    </button>

                                                    <button data-id="<?php echo $provider['id']; ?>" type="button"
                                                            class="btn btn-danger btn-xs deleteProvider">
                                                        <i class="fa fa-trash"> </i> Supprimer
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                    $rowCount++;
                                    if ($rowCount % $numOfCols == 0) echo '</div><div class="row">';
                                } ?>
                            </div> <!-- /row -->
                        </div>
                    </div>
                </div>







                <!--Tab invitations-->
                <div role="tabpanel" class="tab-pane fade" id="tab_productsToOrder"
                     aria-labelledby="home-tab">
                    <div class="providersList">

                        <?php
                        //Columns must be a factor of 12 (1,2,3,4,6,12)
                        $numOfCols = 1;
                        $rowCount = 0;
                        $bootstrapColWidth = 12 / $numOfCols;
                        ?>
                        <div class="container">
                            <div class="row">
                                <?php foreach ($invitations as $invitation) { ?>
                                    <div class="col-md-12 col-sm-6 col-xs-12 profile_details"
                                         data-name="<?php echo $invitation['first_name'] . " " . $invitation['last_name']; ?>" data-id="<?php echo $invitation['id']; ?>">
                                        <div class="well profile_view col-md-12">
                                            <div class="col-sm-12 showProvider" data-id="<?php echo $invitation['id']; ?>">
                                                <div class="right col-xs-2 text-center">
                                                    <img src="" alt=""
                                                         class="img-circle img-responsive">
                                                </div>

                                                <div class="left col-xs-10">
                                                    <h2><?php echo $invitation['first_name']; ?> <?php echo $invitation['last_name']; ?></h2>
                                                    <p><?php echo $invitation['title']; ?></p>
                                                </div>
                                                <div class="left col-xs-10">
                                                    <ul class="list-unstyled">
                                                        <li><i class="fa fa-building"></i> Adresse: <?php echo $invitation['address']; ?>
                                                        </li>
                                                        <li><i class="fa fa-phone"></i> Téléphone #:<?php echo $invitation['phone']; ?>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="col-xs-12 bottom">
                                                <div class="pull-right">
                                                    <button data-type="accepted" data-id="<?php echo $invitation['id']; ?>" aria-expanded="false"
                                                            type="button"
                                                            class="btn btn-info acceptOrRefuse">
                                                        Accepter
                                                    </button>

                                                    <button data-type="refused" data-id="<?php echo $invitation['id']; ?>" type="button"
                                                            class="btn btn-warning acceptOrRefuse">
                                                        Refuser
                                                    </button>
                                                    <button data-type="bloqued" data-id="<?php echo $invitation['id']; ?>" type="button"
                                                            class="btn btn-danger acceptOrRefuse">
                                                        Bloqué
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                    $rowCount++;
                                    if ($rowCount % $numOfCols == 0) echo '</div><div class="row">';
                                } ?>
                            </div> <!-- /row -->
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>


<?php $this->load->view('admin/partials/admin_footer'); ?>
<script>
    var add_provider_success_lang="<?= lang("add_provider_success"); ?>";
    var swal_error_lang="<?= lang("swal_error"); ?>";
    var swal_success_edit_lang="<?= lang("swal_success_edit"); ?>";
    var delete_provider_warning_lang="<?= lang("delete_provider_warning"); ?>";
    var success_delete_provider_lang="<?= lang("success_delete_provider"); ?>";

    var updateInvitationStatus_url="<?php echo base_url('admin/provider/apiUpdateInvitationStatus'); ?>";
</script>
<script>

    $(document).ready(function () {
        $('#addProviderForm').on('submit', function (e) {
            e.preventDefault();
            var formData = new FormData(this);
            $('#loading').show();
            $.ajax({
                type: 'POST',
                url: "<?php echo base_url("admin/provider/add"); ?>",
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: function (data) {
                    $('#loading').hide();
                    if (data.status === "success") {
                        swal({
                            title: "Success",
                            text: add_provider_success_lang,
                            type: "success",
                            timer: 1500,
                            showConfirmButton: false
                        });
                        location.reload();
                    } else {
                        swal({
                            title: "Erreur",
                            text: swal_error_lang,
                            type: "warning",
                            timer: 1500,
                            showConfirmButton: false
                        });
                    }
                },
                error: function (data) {
                    $('#loading').hide();
                    swal({
                        title: "Erreur",
                        text: swal_error_lang,
                        type: "warning",
                        timer: 1500,
                        showConfirmButton: false
                    });
                }
            });

        });

        $('#editProviderForm').on('submit', function (e) {
            e.preventDefault();
            var formData = new FormData(this);
            $('#loading').show();
            $.ajax({
                type: 'POST',
                url: "<?php echo base_url('admin/provider/apiEditMainProvider'); ?>",
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: function (data) {
                    $('#loading').hide();
                    if (data.status === "success") {
                        swal({
                            title: "Success",
                            text: swal_success_edit_lang,
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
                    $('#loading').hide();
                    swal({
                        title: "Erreur",
                        text: swal_error_lang,
                        type: "error",
                        timer: 1500,
                        showConfirmButton: false
                    });
                }
            });

        })

        $('.showProvider').on('click',function () {
            var id = $(this).attr('data-id');
            document.location.href= "<?php echo base_url('admin/provider/show/'); ?>"+"/"+id;
        });

        /*Edit group*/

        $(".editProvider").on('click', editProviderEvent);
        var l_id = -1;

        function editProviderEvent() {
            if ($(this).attr('data-id') === l_id || l_id === -1) {
                $('#editProvider').toggle('slow');
            }
            l_id = $(this).attr('data-id');

            var l_title=0;
            if($(this).attr('data-title')!==""){
                l_title= $(this).attr('data-title');
            }
            $('#editProvider input[name="name"]').val($(this).attr('data-name'));
            $('#editProvider select[name="title"]').val(l_title);
            $('#editProvider input[name="prenom"]').val($(this).attr('data-prenom'));
            $('#editProvider input[name="address"]').val($(this).attr('data-address'));
            $('#editProvider input[name="phone"]').val($(this).attr('data-phone'));
            $('#editProvider input[name="mail"]').val($(this).attr('data-mail'));
            $('#editProvider input[name="tva"]').val($(this).attr('data-tva'));
            $('#editProvider input[name="id"]').val($(this).attr('data-id'));

            scroll("editProvider");
        }

        // This is a functions that scrolls to #{blah}link
        function scroll(id) {
            // Scroll
            $('html,body').animate({scrollTop: $("#" + id).offset().top}, 'slow');
        }
    });

</script>


<script>
    $(document).ready(function () {
        $('button.deleteProvider').on('click', deleteProvider);


        function deleteProvider() {
            var provider_id = $(this).attr('data-id');
            $(this).closest('tr').hide();
            swal({
                    title: "Attention ! ",
                    text: delete_provider_warning_lang,
                    type: "warning",
                    showConfirmButton: true,
                    showCancelButton: true,
                    cancelButtonText: 'Non',
                    confirmButtonText: 'Oui'
                },
                function () {
                    $('#loading').show();
                    $.ajax({
                        url: "<?php echo base_url('admin/provider/apiDeleteProvider'); ?>",
                        type: "POST",
                        dataType: "json",
                        data: {'provider_id': provider_id},
                        success: function (data) {
                            if (data.status === 'success') {
                                swal({
                                    title: "Success",
                                    text: success_delete_provider_lang,
                                    type: "success",
                                    timer: 1500,
                                    showConfirmButton: false
                                });
                                location.reload();
                            }
                            else {
                                $('#loading').hide();
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
                            $('#loading').hide();
                            swal({
                                title: "Erreur",
                                text: swal_error_lang,
                                type: "error",
                                timer: 1500,
                                showConfirmButton: false
                            });
                        },
                        complete: function () {

                        }
                    });

                });


        }
    });
</script>


<!--Search in table-->
<script>
    function myFunction() {
        var input, filter, table, tr, td, i;
        input = document.getElementById("searchInput");
        filter = input.value.toUpperCase();
        profiles = document.getElementsByClassName("profile_details");
        for (i = 0; i < profiles.length; i++) {
            profile = profiles[i].getAttribute("data-name");
            if (profile) {
                if (profile.toUpperCase().indexOf(filter) > -1) {
                    profiles[i].style.display = "";
                } else {
                    profiles[i].style.display = "none";
                }
            }
        }
    }
</script>


<!--Accept or refuse provider-->
<script>
    $(document).ready(function () {
       $('button.acceptOrRefuse').on('click',function () {
           let status=$(this).attr('data-type');
           let id=$(this).attr('data-id');
           let data={
               'data':{
                   'status':status,
                   'id':id,
               }
           };

           console.log(data);
           apiRequest(updateInvitationStatus_url,data);
       }) ;
    });
</script>
