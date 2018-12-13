<?php $this->load->view('admin/partials/admin_header.php'); ?>
<link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
<style>
    tr{
        white-space: nowrap;
    }


    ul,
    li {
        list-style: none;
        margin: 0;
        padding: 0;
    }

    .tg-list {
        text-align: center;
        display: flex;
        align-items: center;
    }

    .tg-list-item {
        margin: 0 1em;
    }

    h2 {
        color: #777;
    }

    h4 {
        color: #999;
    }

    .tgl {
        display: none;
    }
    .tgl, .tgl:after, .tgl:before, .tgl *, .tgl *:after, .tgl *:before, .tgl + .tgl-btn {
        box-sizing: border-box;
    }
    .tgl::-moz-selection, .tgl:after::-moz-selection, .tgl:before::-moz-selection, .tgl *::-moz-selection, .tgl *:after::-moz-selection, .tgl *:before::-moz-selection, .tgl + .tgl-btn::-moz-selection {
        background: none;
    }
    .tgl::selection, .tgl:after::selection, .tgl:before::selection, .tgl *::selection, .tgl *:after::selection, .tgl *:before::selection, .tgl + .tgl-btn::selection {
        background: none;
    }
    .tgl + .tgl-btn {
        outline: 0;
        display: block;
        width: 9em;
        height: 2.2em;
        position: relative;
        top: 2px;
        cursor: pointer;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
    }
    .tgl + .tgl-btn:after, .tgl + .tgl-btn:before {
        position: relative;
        display: block;
        content: "";
        width: 50%;
        height: 100%;
    }
    .tgl + .tgl-btn:after {
        left: 0;
    }
    .tgl + .tgl-btn:before {
        display: none;
    }
    .tgl:checked + .tgl-btn:after {
        left: 50%;
    }

    .tgl-light + .tgl-btn {
        background: #f0f0f0;
        border-radius: 2em;
        padding: 2px;
        transition: all .4s ease;
    }
    .tgl-light + .tgl-btn:after {
        border-radius: 50%;
        background: #fff;
        transition: all .2s ease;
    }
    .tgl-light:checked + .tgl-btn {
        background: #9FD6AE;
    }

    .tgl-ios + .tgl-btn {
        background: #fbfbfb;
        border-radius: 2em;
        padding: 2px;
        transition: all .4s ease;
        border: 1px solid #e8eae9;
    }
    .tgl-ios + .tgl-btn:after {
        border-radius: 2em;
        background: #fbfbfb;
        transition: left 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275), padding 0.3s ease, margin 0.3s ease;
        box-shadow: 0 0 0 1px rgba(0, 0, 0, 0.1), 0 4px 0 rgba(0, 0, 0, 0.08);
    }
    .tgl-ios + .tgl-btn:hover:after {
        will-change: padding;
    }
    .tgl-ios + .tgl-btn:active {
        box-shadow: inset 0 0 0 2em #e8eae9;
    }
    .tgl-ios + .tgl-btn:active:after {
        padding-right: .8em;
    }
    .tgl-ios:checked + .tgl-btn {
        background: #86d993;
    }
    .tgl-ios:checked + .tgl-btn:active {
        box-shadow: none;
    }
    .tgl-ios:checked + .tgl-btn:active:after {
        margin-left: -.8em;
    }

    .tgl-skewed + .tgl-btn {
        overflow: hidden;
        -webkit-backface-visibility: hidden;
        backface-visibility: hidden;
        transition: all .2s ease;
        font-family: sans-serif;
        background: #888;
    }
    .tgl-skewed + .tgl-btn:after, .tgl-skewed + .tgl-btn:before {
        -webkit-transform: skew(10deg);
        transform: skew(10deg);
        display: inline-block;
        transition: all .2s ease;
        width: 100%;
        text-align: center;
        position: absolute;
        line-height: 2em;
        font-weight: bold;
        color: #fff;
        text-shadow: 0 1px 0 rgba(0, 0, 0, 0.4);
    }
    .tgl-skewed + .tgl-btn:after {
        left: 100%;
        content: attr(data-tg-on);
    }
    .tgl-skewed + .tgl-btn:before {
        left: 0;
        content: attr(data-tg-off);
    }
    .tgl-skewed + .tgl-btn:active {
        background: #888;
    }
    .tgl-skewed + .tgl-btn:active:before {
        left: -10%;
    }
    .tgl-skewed:checked + .tgl-btn {
        background: #86d993;
    }
    .tgl-skewed:checked + .tgl-btn:before {
        left: -100%;
    }
    .tgl-skewed:checked + .tgl-btn:after {
        left: 0;
    }
    .tgl-skewed:checked + .tgl-btn:active:after {
        left: 10%;
    }

    .tgl-flat + .tgl-btn {
        padding: 2px;
        transition: all .2s ease;
        background: #fff;
        border: 4px solid #f2f2f2;
        border-radius: 2em;
    }
    .tgl-flat + .tgl-btn:after {
        transition: all .2s ease;
        background: #f2f2f2;
        content: "";
        border-radius: 1em;
    }
    .tgl-flat:checked + .tgl-btn {
        border: 4px solid #7FC6A6;
    }
    .tgl-flat:checked + .tgl-btn:after {
        left: 50%;
        background: #7FC6A6;
    }

    .tgl-flip + .tgl-btn {
        padding: 2px;
        transition: all .2s ease;
        font-family: sans-serif;
        -webkit-perspective: 100px;
        perspective: 100px;
    }
    .tgl-flip + .tgl-btn:after, .tgl-flip + .tgl-btn:before {
        display: inline-block;
        transition: all .4s ease;
        width: 100%;
        text-align: center;
        position: absolute;
        line-height: 2em;
        font-weight: bold;
        color: #fff;
        position: absolute;
        top: 0;
        left: 0;
        -webkit-backface-visibility: hidden;
        backface-visibility: hidden;
        border-radius: 4px;
    }
    .tgl-flip + .tgl-btn:after {
        content: attr(data-tg-on);
        background: #02C66F;
        -webkit-transform: rotateY(-180deg);
        transform: rotateY(-180deg);
    }
    .tgl-flip + .tgl-btn:before {
        background: #FF3A19;
        content: attr(data-tg-off);
    }
    .tgl-flip + .tgl-btn:active:before {
        -webkit-transform: rotateY(-20deg);
        transform: rotateY(-20deg);
    }
    .tgl-flip:checked + .tgl-btn:before {
        -webkit-transform: rotateY(180deg);
        transform: rotateY(180deg);
    }
    .tgl-flip:checked + .tgl-btn:after {
        -webkit-transform: rotateY(0);
        transform: rotateY(0);
        left: 0;
        background: #7FC6A6;
    }
    .tgl-flip:checked + .tgl-btn:active:after {
        -webkit-transform: rotateY(20deg);
        transform: rotateY(20deg);
    }

</style>

<!-- page content -->
<div class="right_col" role="main">
    <div class="productsList">
       <!-- <pre>
            <?php /*print_r($report); */?>
        </pre>-->
        <div class="page-title">
            <div class="title_left">
                <h3><?= lang("edit_product"); ?> : <?php echo $product['name']; ?></h3>
            </div>
        </div>
        <div class="clearfix"></div>
        <hr>








        <div class="col-xs-12 " >
            <div class="x_panel">
                <div class="x_title">
                    <h2><?= lang("quantities_detail"); ?></h2>
                    <ul class="nav navbar-right panel_toolbox">
                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                        <li><a class="close-link"><i class="fa fa-close"></i></a></li>
                    </ul>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">

                    <h4><?= lang("quantity"); ?>/<?= lang("price"); ?></h4>
                    <div class="table-responsive">
                        <table id="datatable-quantityy" class="table table-striped table-bordered dt-responsive nowrap"
                               cellspacing="0" width="100%">
                            <thead>
                            <tr>
                                <th><?= lang("quantity"); ?></th>
                                <th><?= lang("price"); ?></th>
                                <th><?= lang("provider"); ?></th>
                                <th><?= lang("status"); ?></th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tfoot>
                            <tr>
                                <th><?= lang("quantity"); ?></th>
                                <th><?= lang("price"); ?></th>
                                <th><?= lang("provider"); ?></th>
                                <th><?= lang("status"); ?></th>
                                <th>Action</th>
                            </tr>
                            </tfoot>
                            <tbody>
                            <?php foreach ($quantities as $quantity) {
                                $validate = "";
                                /* if($quantity['status'] === "active"){
                                     $validate="validate";
                                 }*/
                                ?>
                                <tr class="<?php echo $validate; ?>">
                                    <td><?php echo $quantity['quantity'] ?></td>
                                    <td><?php echo $quantity['unit_price'] ?></td>
                                    <td><?php echo ucfirst($quantity['pv_name']) ?></td>
                                    <td><?php echo ucfirst($quantity['status']) ?></td>
                                    <td width="13%">
                                        <?php if ($quantity['status'] !== "active") { ?>
                                            <button data-id="<?php echo $quantity['id'] ?>"
                                                    class="btn btn-info btn-xs action activate"><span
                                                        class="glyphicon glyphicon-ok"></span></button>
                                        <?php } ?>
                                        <button data-id="<?php echo $quantity['id'] ?>"
                                                data-quantity="<?php echo $quantity['unit_price'] ?>"
                                                data-provider="<?php echo $quantity['pv_id'] ?>"
                                                class="btn btn-warning btn-xs action edit"><span
                                                    class="glyphicon glyphicon-edit"></span></button>
                                        <a href="<?php echo base_url("admin/provider/show/". $quantity["pv_id"]); ?>" class="btn btn-success btn-xs action edit"><span
                                                    class="glyphicon glyphicon-shopping-cart"></span></a>
                                        <?php if ($quantity['status'] !== "active") { ?>
                                        <button data-id="<?php echo $quantity['id'] ?>"  class="btn btn-danger btn-xs deleteQuantity"><span
                                                    class="glyphicon glyphicon-trash"></span></button>
                                        <?php } ?>

                                    </td>
                                </tr>
                            <?php } ?>
                            </tbody>
                        </table>
                    </div>

                    <?php if ($params['department'] === "true" and $params['showDepartmentContent'] === "true") { ?>
                    <h4><?= lang("quantity"); ?>/<?= lang("department"); ?></h4>
                    <div class="row"></div>
                    <div class="row"></div>
                    <table id="datatable-department" class="table table-striped table-bordered dt-responsive nowrap"
                           cellspacing="0" width="100%">
                        <thead>
                        <tr>
                            <th><?= lang("department"); ?></th>
                            <th><?= lang("quantity"); ?></th>
                        </tr>
                        </thead>
                        <tfoot>
                        <tr>
                            <th><?= lang("department"); ?></th>
                            <th><?= lang("quantity"); ?></th>
                        </tr>
                        </tfoot>
                        <tbody>
                        <?php foreach ($departments as $department) {
                            ?>
                            <tr>
                                <td><?php echo $department['name'] ?></td>
                                <td><?php echo $department['quantity'] ?></td>
                            </tr>
                        <?php } ?>
                       <!-- <tr>
                            <td>Économat</td>
                            <td><?php /*echo array_sum(array_column($quantities, 'quantity')) - array_sum(array_column($departments, 'quantity')); */?></td>
                        </tr>-->
                        </tbody>
                    </table>
                    <?php } ?>

                </div> <!-- /content -->
            </div><!-- /x-panel -->
        </div>



        <div class="row productsListContent">
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12 productItem" id="productPanel" data-id="1">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2><?= lang("product"); ?></h2>
                            <ul class="nav navbar-right panel_toolbox">
                                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                                <!-- <li><a class="close-link"><i class="fa fa-close"></i></a></li>-->
                            </ul>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">
                            <label><?php /*echo $message;*/ ?></label>
                            <form method="post" id="editProductForm">

                                  <div class="row">
                                      <div class="col-md-6">
                                          <input name="id" type="hidden" value="<?php echo $product['id']; ?>"/>
                                          <input name="quantity_id" type="hidden" value="<?php echo $product['q_id']; ?>"/>
                                          <div class="form-group">
                                              <?= lang("product"); ?> : <input value="<?php echo $product['name']; ?>" class="form-control"
                                                                               placeholder="<?= lang("product"); ?>" name="name"
                                                                               id="username" type="text">
                                          </div>
                                          <div class="form-group" hidden>
                                              Nouvelle marque : <input class="form-control" placeholder="Quantité"
                                                                       name="quantity" value="0"
                                                                       type="text" >
                                          </div>
                                          <div class="form-group">
                                              <?= lang("unit_of_measure"); ?> :
                                              <select class="form-control" name="unit">
                                                  <option name="unit"
                                                          value="kg" <?php if ($product['unit'] === "kg") echo "selected"; ?>>
                                                      Kg
                                                  </option>
                                                  <option name="unit"
                                                          value="L" <?php if ($product['unit'] === "L") echo "selected"; ?>>L
                                                  </option>
                                                  <option name="unit"
                                                          value="pcs" <?php if ($product['unit'] === "pcs") echo "selected"; ?> >
                                                      Pcs
                                                  </option>
                                              </select>
                                          </div>

                                          <div class="form-group">
                                              <?= lang("provider"); ?> :
                                              <select class="form-control" name="provider">
                                                  <option value="0"><?= lang("neither"); ?></option>
                                                  <?php foreach ($providers as $provider) {
                                                      $selected = '';
                                                      if ($provider['id'] === $product['provider']) {
                                                          $selected = "selected";
                                                      }
                                                      $providerName = $provider['name'];
                                                      if ($providerName === "") {
                                                          $providerName = $provider['title'];
                                                      }
                                                      ?>
                                                      ?>
                                                      <option name="provider"
                                                              value="<?php echo $provider['id']; ?>" <?php echo $selected; ?>><?php echo $providerName; ?></option>
                                                  <?php } ?>
                                              </select>
                                          </div>
                                          <div class="form-group">
                                              <?= lang("unit_price"); ?> : <input value="<?php echo $product['unit_price']; ?>"
                                                                                  class="form-control" placeholder="Prix unitaire"
                                                                                  name="unit_price" type="text">
                                          </div>



                                          <label>Perte à la commande : </label>

                                          <div class="form-group">

                                              <ul class="tg-list">

                                                  <?php

                                                  $sub_unit='';
                                                  $lost_type_checked='';
                                                  if(strtoupper($product['unit'])==='KG'){
                                                      $sub_unit='gr';
                                                  }else if(strtoupper($product['unit'])==='L'){
                                                      $sub_unit='cl';
                                                  }else if(strtoupper($product['unit'])==='PCS'){
                                                      $sub_unit='pièce';
                                                  }

                                                  if($product['lost_type']==='quantity'){
                                                      $lost_type_checked='checked';
                                                  }

                                                  ?>
                                                  <input value="<?php echo $product['lost_value']; ?>"
                                                                                      class="form-control" placeholder="Perte à la commande"
                                                                                      name="lost_value" type="text">
                                                  <li class="tg-list-item">
                                                      <input name="lost_type" class="tgl tgl-skewed" id="cb3" <?php echo $lost_type_checked; ?> type="checkbox"/>
                                                      <label class="tgl-btn lost_type" data-tg-off="%" data-tg-on="<?php echo $sub_unit; ?>" for="cb3"></label>
                                                  </li>

                                              </ul>
                                          </div>


                                      </div>

                                      <div class="col-md-6">
                                          <div class="form-group">
                                              <?= lang("weightByUnit"); ?> <?= lang("in_gr"); ?><input value="<?php echo $product['weightByUnit']; ?>"
                                                                                                       class="form-control" placeholder=" <?= lang("weightByUnit"); ?>"
                                                                                                       name="weightByUnit">
                                          </div>
                                          <div class="form-group">
                                              <?= lang("min_stock_quantity"); ?> : <input
                                                      value="<?php echo $product['min_quantity']; ?>" class="form-control"
                                                      placeholder="<?= lang("min_stock_quantity"); ?>"
                                                      name="min_quantity" type="text">
                                          </div>
                                          <div class="form-group">
                                              <?= lang("daily_consumption"); ?> : <input value="<?php echo $product['daily_quantity']; ?>"
                                                                                         class="form-control" placeholder="<?= lang("quantity"); ?>"
                                                                                         name="daily_quantity"
                                                                                         type="text">
                                          </div>
                                          <div class="form-group">
                                              <?= lang("lost"); ?> : <input class="form-control" placeholder="<?= lang("quantity"); ?>"
                                                                            name="lostQuantity"
                                                                            type="number">
                                          </div>
                                          <br/>
                                      </div>
                                  </div>


                                    <div class="row">
                                        <?php
                                        $packNotHidden='hidden';
                                        $checked='';
                                        $packCBDisabled='';
                                        if ($product['pack'] === "true"){
                                            $checked='checked';
                                            $packNotHidden='';
                                        }
                                        if(strtoupper($product['unit'])!=='PCS'){
                                            $packCBDisabled='disabled';
                                        }
                                        ?>
                                        <div class="form-group">
                                            <label>
                                                <input type="checkbox" checked="checked" name="newUserQuantity"> <?= lang("create_new_stock"); ?>
                                            </label>
                                        </div>

                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label>
                                                        <input id='pack' type="checkbox" <?php echo $checked; ?>  <?php echo $packCBDisabled;?> name="pack">
                                                        Commander le produit par pack
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group piecesByPack" <?php echo $packNotHidden ?>>
                                                    Nombre de pièces par pack:
                                                    <input value="<?php echo $product['piecesByPack'] ?>" class="form-control" placeholder="Nombre de pièces"
                                                           name="piecesByPack">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                <div class="text-center">
                                    <?php if($params["multi_site"] === "true"){ ?>
                                        <input type="submit" name="buttonSubmit" value="<?= lang("save"); ?>"
                                               class="btn btn-success "/>
                                        <input type="button" name="saveAndGo" value="<?= lang("save_and_go"); ?>"
                                               class="btn btn-info "/>
                                    <?php } ?>
                                </div>
                            </form>
                        </div> <!-- /content -->
                    </div><!-- /x-panel -->
                </div>
                <div class="col-xs-12 " >
                    <div class="x_panel">
                        <div class="x_title">
                            <h2>Liste des marques</h2>
                            <ul class="nav navbar-right panel_toolbox">
                                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                                <li><a class="close-link"><i class="fa fa-close"></i></a></li>
                            </ul>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">
                            <button class="btn btn-primary" data-toggle="modal"
                                    data-target="#addMarkModal">Ajouter une marque</button>

                            <div class="table-responsive">
                                <table id="datatable-quantityy" class="table table-striped table-bordered dt-responsive nowrap"
                                       cellspacing="0" width="100%">
                                    <thead>
                                    <tr>
                                        <th>Marque</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tfoot>
                                    <tr>
                                        <th>Marque</th>
                                        <th>Action</th>
                                    </tr>
                                    </tfoot>
                                    <tbody>
                                    <?php foreach ($marks as $mark) { ?>
                                        <tr>
                                            <td width="50%"><?php echo $mark['name'] ?></td>
                                            <td>
                                                <button data-id="<?php echo $mark['id'] ?>"
                                                        data-name="<?php echo $mark['name'] ?>"
                                                        data-m_unit="<?php echo $mark['m_unit'] ?>"
                                                        data-m_unit_price="<?php echo $mark['m_unit_price'] ?>"
                                                        data-m_weightByUnit="<?php echo $mark['m_weightByUnit'] ?>"
                                                        data-toggle="modal"
                                                        data-target="#editMarkModal"
                                                        class="btn btn-warning btn-xs action editMak"><span
                                                            class="glyphicon glyphicon-edit"></span> <?= lang("edit"); ?></button>
                                                <button data-id="<?php echo $mark['id'] ?>"  class="btn btn-danger btn-xs deleteMark"><span
                                                            class="glyphicon glyphicon-trash"></span> <?= lang("delete"); ?></button>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                    </tbody>
                                </table>
                            </div>

                            <?php if ($params['department'] === "true" and $params['showDepartmentContent'] === "true") { ?>
                                <h4><?= lang("quantity"); ?>/<?= lang("department"); ?></h4>
                                <div class="row"></div>
                                <div class="row"></div>
                                <table id="datatable-department" class="table table-striped table-bordered dt-responsive nowrap"
                                       cellspacing="0" width="100%">
                                    <thead>
                                    <tr>
                                        <th><?= lang("department"); ?></th>
                                        <th><?= lang("quantity"); ?></th>
                                    </tr>
                                    </thead>
                                    <tfoot>
                                    <tr>
                                        <th><?= lang("department"); ?></th>
                                        <th><?= lang("quantity"); ?></th>
                                    </tr>
                                    </tfoot>
                                    <tbody>
                                    <?php foreach ($departments as $department) {
                                        ?>
                                        <tr>
                                            <td><?php echo $department['name'] ?></td>
                                            <td><?php echo $department['quantity'] ?></td>
                                        </tr>
                                    <?php } ?>
                                    <!-- <tr>
                            <td>Économat</td>
                            <td><?php /*echo array_sum(array_column($quantities, 'quantity')) - array_sum(array_column($departments, 'quantity')); */?></td>
                        </tr>-->
                                    </tbody>
                                </table>
                            <?php } ?>

                        </div> <!-- /content -->
                    </div><!-- /x-panel -->
                </div>
            </div>
        </div>
        <?php include('include/addMagazinModal.php'); ?>
        <?php include('include/editMarkModal.php'); ?>

    </div>

</div> <!-- /.col-right -->
<!-- /page content -->

<?php $this->load->view('admin/partials/admin_footer'); ?>
<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
<script>
    var swal_success_operation_lang = "<?= lang("swal_success_operation"); ?>";
    var swal_error_lang = "<?= lang("swal_error"); ?>";
    var swal_success_edit_lang = "<?= lang("swal_success_edit"); ?>";
    var swal_warning_delete_lang = "<?= lang("swal_warning_delete"); ?>";
    var swal_success_delete_lang = "<?= lang("swal_success_delete"); ?>";
    var swal_warning_obligatory_weight_lang = "<?= lang("swal_warning_obligatory_weight"); ?>";

    var deleteQuantity_url = "<?php echo base_url('admin/product/apiDeleteQuantity'); ?>"
    var deleteMark_url = "<?php echo base_url('admin/product/apiDeleteMark'); ?>"
</script>
<script src="<?php echo base_url("assets/vendors/datatables.net/js/jquery.dataTables.min.js"); ?>"></script>


<script>
    $(document).ready(function () {
        var handleDataTableButtons = function () {
            if ($("#datatable-quantity").length) {
                $("#datatable-quantity").DataTable({

                    responsive: true,
                    "lengthMenu": [[5, 10, 50, -1], [5, 10, 50, "Tout"]],
                    "language": {
                        "url": "<?php echo base_url("assets/vendors/datatables.net/French.json"); ?>"
                    },
                   /* "bPaginate": false,*/
                    "bLengthChange": false,
                    "bFilter": true,
                    "bInfo": false,
                    "bAutoWidth": false,
                    "searching":false

                });
            }
            if ($("#datatable-department").length) {
                $("#datatable-department").DataTable({

                    responsive: true,
                    "lengthMenu": [[5, 10, 50, -1], [5, 10, 50, "Tout"]],
                    "language": {
                        "url": "<?php echo base_url("assets/vendors/datatables.net/French.json"); ?>"
                    },
                    "bPaginate": false,
                    "bLengthChange": false,
                    "bFilter": true,
                    "bInfo": false,
                    "bAutoWidth": false,
                    "searching": false

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

    var old_unit="<?php echo $product["unit"]; ?>";
    console.log(old_unit);
    $(document).ready(function () {
        $("input[name=saveAndGo]").on("click", {saveType: "saveAndGo"},save)
        $('#editProductForm').submit({saveType:"simple"},save);

        function save(e) {
            e.preventDefault();
            var newUserQuantity = true;
            var pack='false';
            var lost_type='percent';
            var id = $('input[name="id"]').val();
            var quantity_id = $('input[name="quantity_id"]').val();
            var name = $('input[name="name"]').val();
            var quantity = $('input[name="quantity"]').val();
            var unit = $('select[name="unit"]').val();
            var unit_price = $('input[name="unit_price"]').val();
            var weightByUnit = $('input[name="weightByUnit"]').val();
            var daily_quantity = $('input[name="daily_quantity"]').val();
            var min_quantity = $('input[name="min_quantity"]').val();
            var lostQuantity = $('input[name="lostQuantity"]').val();
            var piecesByPack = $('input[name="piecesByPack"]').val();
            var lost_value = $('input[name="lost_value"]').val();
            newUserQuantity = $('input[name="newUserQuantity"]').is(':checked');
            pack = $('#pack').is(':checked');
            let lost_type_checked = $('input[name="lost_type"]').is(':checked');
            if (lostQuantity == "") lostQuantity = 0;
            if (lost_type_checked  && unit!=='pcs') lost_type = "quantity";
            var provider = $('select[name=provider]').val();

            var product = {
                'id': id,
                'name': name,
                'quantity': quantity,
                'unit': unit,
                'unit_price': unit_price,
                'weightByUnit': weightByUnit,
                'provider': provider,
                'min_quantity': min_quantity,
                'daily_quantity': daily_quantity,
                'lostQuantity': lostQuantity,
                "newUserQuantity": newUserQuantity,
                'status': 'active',
                'quantity_id':quantity_id,
                'piecesByPack':piecesByPack,
                'pack':pack,
                'lost_value':lost_value,
                'lost_type':lost_type,
            };

            console.log(product);

            if(validate(product)){
                $.ajax({
                    url: "<?php echo base_url('admin/product/apiEdit'); ?>",
                    type: "POST",
                    dataType: "json",
                    data: {"product": product},
                    beforeSend: function () {
                        $('#loading').show();
                    },
                    complete: function () {
                        $('#loading').hide();
                    },
                    success: function (data) {
                        if (data.status = "success") {
                            swal({
                                title: "Success",
                                text: "Success",
                                type: "success",
                                timer: 1500,
                                showConfirmButton: false
                            });
                            var nextId = parseInt(id) + parseInt(1);
                            if (e.data.saveType === "saveAndGo") {
                                window.location.href = "<?php echo base_url("admin/product/edit/"); ?>" + nextId;
                            } else {
                                window.location.href = "<?php echo base_url("admin/product/index/"); ?>";
                            }
                        }
                    },
                    error: function (data) {

                    }
                });
            }
        }

        function validate(product){
            var validate=false;
            if(product["pack"]===true && product["piecesByPack"]==0){
                swal({
                    title: "Attention",
                    text: "Le nombre de pièces par pack est incorrect",
                    type: "warning",
                    timer: 2000,
                    showConfirmButton: false
                });
                validate = false;
            }else if(old_unit!==product["unit"] && product["weightByUnit"]<=0){
                swal({
                    title: "Attention",
                    text: swal_warning_obligatory_weight_lang,
                    type: "warning",
                    timer: 2000,
                    showConfirmButton: false
                });
                validate = false;
            }else{
                validate=true;
            }
            return validate;
        }
    });


</script>


<script>
    $(document).ready(function () {
        $('button.activate').on('click', activateEvent);
        $('button.edit').on('click', editEvent);

        function editEvent(){
            var quantity = $(this).attr('data-quantity');
            var provider = $(this).attr('data-provider');
            var quantity_id = $(this).attr('data-id');
            $('input[name="unit_price"]').val(quantity);
            $('input[name="quantity_id"]').val(quantity_id);
            $('select[name=provider]').val(provider);
            scroll("productPanel")

        }

        function scroll(id) {
            // Scroll
            $('html,body').animate({scrollTop: $("#" + id).offset().top}, 'slow');
        }
        function activateEvent(event) {
            var id = $(this).attr('data-id');
            $('#loading').show();
            $.ajax({
                    url: "<?php echo base_url('admin/product/apiActivateQuantity'); ?>",
                    type: "POST",
                    dataType: "json",
                    data: {'quantity_id':id},
                    success: function (data) {

                        $('#loading').hide();
                        if (data.status === 'success') {
                            swal({
                                title: "Success",
                                text: "Success",
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
                                text: "Erreur",
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
                            text: "Erreur",
                            type: "error",
                            timer: 1500,
                            showConfirmButton: false
                        });
                    }
               });
        }
    });
</script>

<!-- bootstrap-daterangepicker -->
<script src="<?php echo base_url('assets/vendors/moment/min/moment.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/vendors/bootstrap-daterangepicker/daterangepicker.js'); ?>"></script>
<script>
    var rangeLink = "<?php echo base_url('admin/report/apiRange'); ?>";
    var addMark_url = "<?php echo base_url('admin/product/apiAddMark'); ?>";
    var editMark_url = "<?php echo base_url('admin/product/apiEditMark'); ?>";
</script>

<script src="<?php echo base_url('assets/vendors/bootstrap-daterangepicker/daterangepicker.js'); ?>"></script>

<script src="<?php echo base_url('assets/vendors/moment/min/moment.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/vendors/bootstrap-daterangepicker/daterangepicker.js'); ?>"></script>


<script src="<?php echo base_url('assets/build2/js/product/edit.js'); ?>"></script>