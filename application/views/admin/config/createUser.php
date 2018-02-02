<?php $this->load->view('admin/partials/admin_header.php'); ?>
<title></title>

<link href="<?php echo base_url("assets/build2/css/kendo.common.min.css"); ?>" rel="stylesheet"/>
<link href="<?php echo base_url("assets/build2/css/kendo.default.min.css"); ?>" rel="stylesheet"/>
<link href="<?php echo base_url("assets/build2/css/kendo.mobile.all.min.css"); ?>" rel="stylesheet"/>
<link href="<?php echo base_url("assets/build2/css/font-awesome.min.css"); ?>" rel="stylesheet"/>

<!-- page content -->
<div class="right_col" role="main">

    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Configuration générale
                        <small>Modifier</small>
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
                        <span class="section">Information</span>

                        <div class="item form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Nom <span
                                        class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input id="last_name" class="form-control col-md-7 col-xs-12" data-validate-length-range="6"
                                       data-validate-words="2" name="last_name" placeholder="Nom"
                                       required="required" type="text">
                            </div>
                        </div>
                        <div class="item form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Prénom <span
                                        class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input id="first_name" class="form-control col-md-7 col-xs-12" data-validate-length-range="6"
                                       data-validate-words="2" name="first_name" placeholder="Prénom"
                                       required="required" type="text">
                            </div>
                        </div>
                        <div class="item form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="email">Email <span
                                        class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="email" id="email" name="email" required="required"
                                       class="form-control col-md-7 col-xs-12">
                            </div>
                        </div>
                        <div class="item form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="number">Téléphone <span
                                        class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="tel"id="number" name="mobile" required="required"
                                       data-validate-minmax="10,100" class="form-control col-md-7 col-xs-12">
                            </div>
                        </div>
                        <div class="item form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="number">Adresse <span
                                        class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="text" id="address" name="address" required="required"
                                       data-validate-minmax="10,100" class="form-control col-md-7 col-xs-12">
                            </div>
                        </div>
                        <div class="item form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="number">Role <span
                                        class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                               <select name="role" class="form-control col-md-7 col-xs-12">
                                   <option data-role="user">User</option>
                                   <?php if($params["department"]==="true") :?>
                                   <option data-role="department">Département</option>
                                   <option data-role="econome">Econome</option>
                                   <?php endif; ?>
                                   <option data-role="admin">Admin</option>
                               </select>
                            </div>
                        </div>
                        <div class="item form-group selectDepartment" hidden>
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="number">Département <span
                                        class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                               <select name="department" class="form-control col-md-7 col-xs-12">
                                   <?php foreach ($departments as $department) { ?>
                                   <option data-role="<?php echo $department["id"]?>"><?php echo $department["name"] ?></option>
                                   <?php } ?>
                               </select>
                            </div>
                        </div>
                        <div class="item form-group">
                            <label for="password" class="control-label col-md-3">Mot de passe</label>
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

                        <div class="item form-group aclList">
                            <label for="password2"
                                   class="control-label col-md-3 col-sm-3 col-xs-12">Droits d accèss</label>
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
                                <button type="submit" class="btn btn-primary">Annuler</button>
                                <button id="send" class="btn btn-success">Envoyer</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<?php $this->load->view('admin/partials/admin_footer'); ?>


<script src="<?php echo base_url("assets/build2/js/kendo.all.min.js"); ?>"></script>


<script>
    $(document).ready(function () {

        var role="user";
        $("select[name=role]").on("change",function(){
            var role = $(this).find("option:selected").attr("data-role");
            if(role==="department"){
                $(".selectDepartment").fadeIn();
            }else{
                $(".selectDepartment").fadeOut();
            }

            if(role==="user"){
                $(".aclList").fadeIn();
            }else{
                $(".aclList").fadeOut();
            }
        });

        <?php
        $js_array = json_encode($controllers);
        echo "var controllers = " . $js_array . ";\n";
        ?>

        var dataSource = [];
        $.each(controllers, function (key, controller) {
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

            console.log(actions);
            var myActions=[];
            $.each(actions, function (key, action) {
                var l_action={};
                if(!action["hasChildren"]){
                    l_action["action"]= action["action"];
                    l_action["controller"]= action["controller"];
                    myActions.push(l_action);
                }
            });
            console.log(myActions);
            var id = $("input[name=id]").val();
            var password = $("input[name=password]").val();
            var user = {
                "last_name": $("input[name=last_name]").val(),
                "first_name": $("input[name=first_name]").val(),
                "email": $("input[name=email]").val(),
                "mobile": $("input[name=mobile]").val(),
                "address": $("input[name=address]").val(),
                "type": role
            }
            var myData = {
                "id": id,
                "user": user,
                "password": password,
                "actions": myActions,
            }
            console.log(myData);
            $.ajax({
                url: "<?php echo base_url('admin/config/apiCreateUser'); ?>",
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
                            text: "L'opération a été bien effecuté",
                            type: "success",
                            timer: 1500,
                            showConfirmButton: false
                        });
                    } else {
                        swal({
                            title: "Erreur",
                            text: "Une erreur s'est produite",
                            type: "warning",
                            timer: 1500,
                            showConfirmButton: false
                        });
                    }
                    document.location.href = "<?php echo base_url("admin/config"); ?>";
                },
                error: function (data) {
                    document.location.href = "<?php echo base_url("admin/config"); ?>";
                    /*swal({
                        title: "Erreur",
                        text: "Une erreur s'est produite",
                        type: "error",
                        timer: 1500,
                        showConfirmButton: false
                    });*/
                }
            });

        });

    });
</script>


