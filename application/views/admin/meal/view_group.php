<?php $this->load->view('admin/partials/admin_header.php'); ?>
<!-- page content -->
<div class="right_col" role="main">
    <div class="productsList">
        <div class="page-title">
            <div class="title_left">
                <h3><?= lang("groups_list"); ?></h3>
            </div>
        </div>

        <div class="clearfix"></div>
        <hr>
        <div class="article-title">

            <div class="row">
                <div class="col-md-9">
                    <a class="btn btn-primary" data-toggle="collapse" href="#collapseExample" aria-expanded="false"
                       aria-controls="collapseExample"><?= lang("new_group"); ?></a>

                    <!--<button type="submit" class="btn btn-warning" name="Fichier"
                           onclick="window.location.href='<?php /*echo base_url('admin/meal/loadFileGroup/'); */ ?>'">
                       <span class="fa fa-print"></span> Importer
                   </button>-->
                </div>

                <div class="col-md-3">
                    <?php if (count($productsToOrder)) { ?>
                        <a href="<?= base_url('admin/product/toOrder'); ?>">
                            <h3 class="soldOut" style="color:#d9534f;"><?= lang("stock_insufficient"); ?></h3>
                        </a>
                    <?php } ?>
                </div>
            </div>
        </div>

        <div class="collapse" id="collapseExample">
            <form id="addGroupForm" enctype="multipart/form-data">
                <fieldset>
                    <div class="row">
                        <div class="col-xs-12 col-sm-6 col-md-4">
                            <br>
                            <label for="name"><?= lang("name"); ?> :</label>
                            <input type="text" step="any" class="form-control" name="groupName"
                                   placeholder="<?= lang("group_name") ?>"
                                   required>
                        </div>

                        <?php if ($params['department'] === "true" and $params['showDepartmentContent'] === "true") { ?>
                        <div class="col-xs-12 col-sm-6 col-md-4">
                            <br>
                            <label for="name"><?= lang("department"); ?> :</label>
                            <select name="department" class="form-control departmentSelect  md-button-v">
                                <option value="0"><?= lang("neither"); ?></option>
                                <?php foreach ($departments as $department) { ?>
                                    <option value="<?php echo $department['id'] ?>">
                                        <?php echo $department['name'] ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>
                        <?php } ?>

                        <div class="col-xs-12 col-sm-6 col-md-4">
                            <br>
                            <label for="image"><?= lang("image"); ?> :</label>
                            <input type="file" class="form-control" name="image" size="10485760">
                        </div>
                    </div>
                    <br/>

                    <div class="text-right">
                        <input class="btn btn-success" type="submit" name="addGroup" value="<?= lang("confirme"); ?>"/>
                    </div>

                </fieldset>
            </form>
            <br>
        </div>


        <div class="collapse" id="editGroup">
            <form id="editGroupForm" enctype="multipart/form-data">
                <fieldset>
                    <div class="row">
                        <input type="hidden" name="id"/>
                        <div class="col-xs-12 col-sm-6 col-md-4">
                            <br>
                            <label for="name"><?= lang("name"); ?> :</label>
                            <input type="text" step="any" class="form-control" name="groupNameEdit"
                                   placeholder="<?= lang("group_name") ?>"
                                   required>
                        </div>

                        <?php if ($params['department'] === "true" and $params['showDepartmentContent'] === "true") { ?>
                        <div class="col-xs-12 col-sm-6 col-md-4">
                            <br>
                            <label for="name"><?= lang("department"); ?> :</label>
                            <select name="department" class="form-control departmentSelect  md-button-v">
                                <option value="0"><?= lang("neither"); ?></option>
                                <?php foreach ($departments as $department) { ?>
                                    <option value="<?php echo $department['id'] ?>">
                                        <?php echo $department['name'] ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>
                        <?php } ?>

                        <div class="col-xs-12 col-sm-6 col-md-4">
                            <br>
                            <label for="image"><?= lang("image"); ?> :</label>
                            <input type="file" class="form-control" name="image" size="10485760">
                        </div>
                    </div>
                    <br/>

                    <div class="text-right">
                        <input class="btn btn-success" type="submit" name="editGroupForm" value="<?= lang("edit"); ?>"/>
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
        <div class="row">

            <?php foreach ($groups as $group) { ?>

                <div class="col-md-4 col-sm-6 col-xs-12">
                    <div class="well profile_view">
                        <a href="<?php echo base_url('admin/meal/groupMeals/' . $group['g_id']); ?>">
                            <div class="col-sm-12">
                                <h4 class="brief"><i><?php echo $group['g_name'] ?></i></h4>
                                <div class="left col-xs-7">
                                    <p><strong><?= lang("article_count"); ?>: </strong><?php echo $group['groupCount'] ?> </p>
                                    <ul class="list-unstyled">
                                        <li><i class="fa"></i><?= lang("price_avg"); ?>: <?php echo round($group['avg_price']) ?>DH
                                        </li>
                                    </ul>
                                </div>
                                <div class="right col-xs-5 text-center">
                                    <img src="<?php echo base_url(); ?>assets/images/<?php echo $group['image'] ?>"
                                         alt=""
                                         class="img-circle img-responsive">
                                </div>
                            </div>
                        </a>
                        <div class="col-xs-12 bottom">
                            <button aria-expanded="false" data-id="<?php echo $group['g_id'] ?>"
                                    data-name="<?php echo $group['g_name'] ?>" data-department="<?php echo $group['department'] ?>" type="button"
                                    class="btn btn-info btn-xs editGroup">
                                <i class="fa fa-edit"> </i> <?= lang("edit"); ?>
                            </button>
                            <button data-id="<?php echo $group['g_id'] ?>" type="button"
                                    class="btn btn-danger btn-xs deleteGroup">
                                <i class="fa fa-trash"> </i> <?= lang("delete"); ?>
                            </button>
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


<?php $this->load->view('admin/partials/admin_footer'); ?>
<script>
    var swal_success_operation_lang = "<?= lang("swal_success_operation"); ?>";
    var swal_error_lang = "<?= lang("swal_error"); ?>";
    var swal_success_edit_lang = "<?= lang("swal_success_edit"); ?>";
    var swal_warning_delete_lang = "<?= lang("swal_warning_delete"); ?>";
    var swal_success_delete_lang = "<?= lang("swal_success_delete"); ?>";
    var swal_warning_obligatory_weight_lang = "<?= lang("swal_warning_obligatory_weight"); ?>";
</script>

<script>

    $(document).ready(function () {
        $('#addGroupForm').on('submit', function (e) {
            e.preventDefault();
            var formData = new FormData(this);
            $('#loading').show();
            $.ajax({
                type: 'POST',
                url: "<?php echo base_url(); ?>admin/meal/group",
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: function (data) {
                    if (data.status === "success") {
                        $('#loading').hide();
                        swal({
                            title: "Success",
                            text: swal_success_operation_lang,
                            type: "success",
                            timer: 1500,
                            showConfirmButton: false
                        });
                        location.reload();
                    } else {
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

        $('#editGroupForm').on('submit', function (e) {
            e.preventDefault();
            var formData = new FormData(this);
            $('#loading').show();
            $.ajax({
                type: 'POST',
                url: "<?php echo base_url('admin/meal/apiGroupEdit'); ?>",
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
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

        });


        /*Edit group*/

        $(".editGroup").on('click', editGroupEvent);
        var l_id = -1;

        function editGroupEvent() {
            if ($(this).attr('data-id') === l_id || l_id === -1) {
                $('#editGroup').toggle('slow');
            }
            l_id = $(this).attr('data-id');

            $('input[name="groupNameEdit"]').val($(this).attr('data-name'));
            $('input[name="id"]').val($(this).attr('data-id'));
            $('#editGroupForm select[name="department"]').val($(this).attr('data-department'));
            scroll("editGroup");
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
        $('button.deleteGroup').on('click', deleteGroupEvent);


        function deleteGroupEvent() {
            var group_id = $(this).attr('data-id');
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
                        url: "<?php echo base_url('admin/meal/apiDeleteGroup'); ?>",
                        type: "POST",
                        dataType: "json",
                        data: {'group_id': group_id},
                        success: function (data) {
                            if (data.status === 'success') {
                                swal({
                                    title: "Success",
                                    text: swal_success_delete_lang,
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
    });
</script>

<script>
    $(document).ready(function () {
        function blinker() {
            $('.soldOut').fadeOut(500);
            $('.soldOut').fadeIn(500);
        }

        setInterval(blinker, 1000); //Runs every second
    });
</script>