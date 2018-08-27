<?php $this->load->view('admin/partials/admin_header.php'); ?>
<title></title>

<link href="<?php echo base_url("assets/build2/css/kendo.common.min.css"); ?>" rel="stylesheet"/>
<link href="<?php echo base_url("assets/build2/css/kendo.default.min.css"); ?>" rel="stylesheet"/>
<link href="<?php echo base_url("assets/build2/css/kendo.mobile.all.min.css"); ?>" rel="stylesheet"/>

<!-- page content -->
<div class="right_col" role="main">

    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2><?= lang('general_configuration'); ?>
                        <small><?= lang('edit'); ?></small>
                    </h2>
                    <ul class="nav navbar-right panel_toolbox">
                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                        </li>
                        <li><a class="close-link"><i class="fa fa-close"></i></a>
                        </li>
                    </ul>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">

                    <div class="form-horizontal form-label-left" novalidate>
                        <span class="section"><?= lang('informations'); ?></span>

                        <input type="hidden" name="id" value="<?php echo $user['id']; ?>"/>
                        <div class="item form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name"><?= lang('name'); ?> <span
                                        class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input id="last_name" value="<?php echo $user['last_name']; ?>" class="form-control col-md-7 col-xs-12" data-validate-length-range="6"
                                       data-validate-words="2" name="last_name" placeholder="<?= lang('name'); ?>"
                                       required="required" type="text">
                            </div>
                        </div>
                        <div class="item form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name"><?= lang("last_name"); ?> <span
                                        class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input id="first_name" value="<?php echo $user['first_name']; ?>" class="form-control col-md-7 col-xs-12" data-validate-length-range="6"
                                       data-validate-words="2" name="first_name" placeholder="<?= lang("last_name"); ?>"
                                       required="required" type="text">
                            </div>
                        </div>
                        <div class="item form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="email"><?= lang('email'); ?> <span
                                        class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="email" value="<?php echo $user['email']; ?>" id="email" name="email" required="required"
                                       class="form-control col-md-7 col-xs-12">
                            </div>
                        </div>
                        <div class="item form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="number"><?= lang('telephone'); ?> <span
                                        class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="tel" value="<?php echo $user['mobile']; ?>" id="number" name="mobile" required="required"
                                       data-validate-minmax="10,100" class="form-control col-md-7 col-xs-12">
                            </div>
                        </div>
                        <div class="item form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="number"><?= lang('address'); ?> <span
                                        class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="text" value="<?php echo $user['address']; ?>" id="address" name="address" required="required"
                                       data-validate-minmax="10,100" class="form-control col-md-7 col-xs-12">
                            </div>
                        </div>
                        <div class="item form-group">
                            <label for="password" class="control-label col-md-3"><?= lang('password'); ?></label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input id="password" type="password" name="password" data-validate-length="6,8"
                                       class="form-control col-md-7 col-xs-12" required="required">
                            </div>
                        </div>

                        <!--<div class="item form-group">
                            <label for="password2" class="control-label col-md-3 col-sm-3 col-xs-12">Confirmation</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input id="password2" type="password" name="password2" data-validate-linked="password"
                                       class="form-control col-md-7 col-xs-12" required="required">
                            </div>
                        </div>-->

                        <div class="ln_solid"></div>

                        <?php
                        $hidden="";
                        if($user["position"]==="Super Admin")
                            $hidden="hidden";
                        ?>
                        <div class="item form-group" <?php echo $hidden ?>>
                            <label for="password2"
                                   class="control-label col-md-3 col-sm-3 col-xs-12"><?= lang('access_right'); ?></label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <div class="demo-section k-content">
                                    <div>
                                        <div id="treeview"></div>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-3">
                                <!--<button type="submit" class="btn btn-primary">Annuler</button>-->
                                <button id="send" class="btn btn-success"><?= lang('send'); ?></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
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

<script src="<?php echo base_url("assets/build2/js/kendo.all.min.js"); ?>"></script>


<script>
    $(document).ready(function () {


        <?php
        $js_array = json_encode($controllers);
        echo "var controllers = " . $js_array . ";\n";
        ?>

        var dataSource = [];
        console.log(controllers);
        $.each(controllers, function (key, controller) {
              $.each(controller["actions"], function (key, action) {
                if(action["checked"]==="false") {
                    action["checked"] = false;
                }else{
                    action["checked"] = true;
                }
             });
            var dataSourceElement = {
                text: controller["controller_label"],
                items: controller["actions"]
            };
            dataSource.push(dataSourceElement);
        });
        $("#treeview").kendoTreeView({
            checkboxes: {
                checkChildren: true
            },
            check: onCheck,
            dataSource: dataSource
        });

        // function that gathers IDs of checked nodes
        function checkedNodeIds(nodes, checkedNodes) {
            for (var i = 0; i < nodes.length; i++) {
                if (nodes[i].checked) {
                    checkedNodes.push(nodes[i].id);
                }

                if (nodes[i].hasChildren) {
                    checkedNodeIds(nodes[i].children.view(), checkedNodes);
                }
            }
        }

        // show checked node IDs on datasource change
        function onCheck() {
            var checkedNodes = [],
                treeView = $("#treeview").data("kendoTreeView"),
                message;

            console.log("kkkk");

            checkedNodeIds(treeView.dataSource.view(), checkedNodes);

            if (checkedNodes.length > 0) {
                message = "IDs of checked nodes: " + checkedNodes.join(",");
            } else {
                message = "No nodes checked.";
            }

            $("#result").html(message);

            console.log(checkedNodes);
        }

        function getCheckedItems(treeview) {
            var nodes = treeview.dataSource.view();
            return getCheckedNodes(nodes);
        }

        function getCheckedNodes(nodes) {
            var node, childCheckedNodes;
            var checkedNodes = [];

            for (var i = 0; i < nodes.length; i++) {
                node = nodes[i];
                if (node.checked) {
                    checkedNodes.push(node);
                }

                // to understand recursion, first
                // you must understand recursion
                if (node.hasChildren) {
                    childCheckedNodes = getCheckedNodes(node.children.view());
                    if (childCheckedNodes.length > 0) {
                        checkedNodes = checkedNodes.concat(childCheckedNodes);
                    }
                }

            }

            return checkedNodes;
        }

        // getCheckedItems(tree);
        treeView = $("#treeview").data("kendoTreeView");
        console.log((treeView));
        $("#send").on("click", function (e) {
            e.preventDefault();
            var treeView = $("#treeview").data("kendoTreeView");
            var actions = getCheckedItems(treeView);

            var myActions = [];
            $.each(actions, function (key, action) {
                var l_action = {};
                if (!action["hasChildren"]) {
                    l_action["action"] = action["action"];
                    l_action["controller"] = action["controller"];
                    myActions.push(l_action);
                }
            });

            var id = $("input[name=id]").val();
            var password = $("input[name=password]").val();
            var user = {
                "last_name": $("input[name=last_name]").val(),
                "first_name": $("input[name=first_name]").val(),
                "email": $("input[name=email]").val(),
                "mobile": $("input[name=mobile]").val(),
                "address": $("input[name=address]").val(),
            }
            var myData = {
                "id": id,
                "user": user,
                "password": password,
                "actions": myActions,
            }
            $.ajax({
                url: "<?php echo base_url('admin/config/apiEditUser'); ?>",
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
                        swal({
                            title: "Success",
                            text:swal_success_operation_lang,
                            type: "success",
                            timer: 1500,
                            showConfirmButton: false
                        });
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

    });
</script>


