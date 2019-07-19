<style>
    .modal-footer {
        border-top: 0px solid #e5e5e5;
    }

    #tab_config_edit_order .row {
        margin-bottom: 10px;
    }
</style>
    <div class="modal fade" id="editOrderModal" tabindex="-1" role="dialog"
     aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <button type="button" class="close"
                        data-dismiss="modal">
                    <span aria-hidden="true">&times;</span>
                    <span class="sr-only">Close</span>
                </button>
                <h4 class="modal-title" id="myModalLabel">
                    <span></span>
                </h4>
            </div>

            <!-- Modal Body -->
            <div class="modal-body">


                <div class="" role="tabpanel" data-example-id="togglable-tabs-newOrder">
                    <ul id="tabNewOrder" class="nav nav-tabs bar_tabs sm-hidden" role="tablist">
                        <li role="presentation" class="active"><a href="#tab_products_edit_order"
                                                                  role="tab"
                                                                  data-toggle="tab"
                                                                  aria-expanded="true"><?= lang('products') ?></a>
                        </li>
                        <li role="presentation"><a href="#tab_config_edit_order"
                                                   role="tab"
                                                   data-toggle="tab"
                                                   aria-expanded="false"><?= lang('parameters') ?></a>
                        </li>
                        <li role="presentation"><a href="#tab_advance_edit_order"
                                                   role="tab"
                                                   data-toggle="tab"
                                                   aria-expanded="false"><?= lang('advances') ?></a>
                        </li>
                    </ul>
                    <ul class="nav nav-tabs tabs-left md-hidden">
                        <li role="presentation" class="active"><a href="#tab_products_edit_order"
                                                                  role="tab"
                                                                  data-toggle="tab"
                                                                  aria-expanded="true"><?= lang('products') ?></a>
                        </li>
                        <li role="presentation"><a href="#tab_config_edit_order"
                                                   role="tab"
                                                   data-toggle="tab"
                                                   aria-expanded="false"><?= lang('parameters') ?></a>
                        </li>
                        <li role="presentation"><a href="#tab_advance_edit_order"
                                                   role="tab"
                                                   data-toggle="tab"
                                                   aria-expanded="false"><?= lang('advances') ?></a>
                        </li>
                    </ul>
                    <div id="tab-editOrder" class="tab-content col-md-12 col-sm-12 col-xs-12" style="margin-bottom:20px">
                        <!--------------------------------------------Products Tab------------------------------------------------------>
                        <div role="tabpanel" class="tab-pane fade active in" id="tab_products_edit_order"
                             aria-labelledby="home-tab">


                            <h4 class="text-center">
                                Status de la commande
                            </h4>
                            <div class="text-center">
                                <div data-toggle="collapse" data-status="" href="#changeStatus"
                                     class="btn btn-round btn-info orderActualStatus"></div>
                            </div>
                            <div class="collapse text-center" id="changeStatus">
                                <button data-toggle="collapse" data-type="received" href="#changeStatus" type="button"
                                        class="btn btn-round btn-success">Reçue
                                </button>
                                <button data-toggle="collapse" data-type="canceled" href="#changeStatus" type="button"
                                        class="btn btn-round btn-warning">Annulée
                                </button>
                            </div>
                            <form class="form-horizontal" role="form">
                                <input type="hidden" class="orderId">
                                <div class="form-group" id="editProductsOrder">
                                    <?php foreach ($products as $key => $product) {
                                        $unit=$product['unit'];
                                        $unit_price=$product['unit_price'];
                                        if($product['pack']==='true'){
                                            $unit='Pack de '.$product['piecesByPack'].' pièces';
                                            $unit_price*=$product['piecesByPack'];
                                        }
                                        ?>
                                        <div class="row product" data-index="<?php echo $key; ?>"
                                             data-id="<?php echo $product['id']; ?>"
                                             data-id-quantity="<?php echo $product['q_id']; ?>">

                                            <div class="col-md-6 col-sm-4 col-xs-12">

                                                <select
                                                        name="product"
                                                        data-product="<?php echo $product['id']; ?>"
                                                        data-id="<?php echo $product['id']; ?>"
                                                        data-price="<?php echo $product['unit_price']; ?>"
                                                        data-name="<?php echo $product['name']; ?>"
                                                        data-unit="<?php echo $product['unit']; ?>"
                                                        data-pack="<?php echo $product['pack']; ?>"
                                                        data-piecesByPack="<?php echo $product['piecesByPack']; ?>"
                                                        data-pack-order="<?php echo $product['pack']; ?>"
                                                        data-piecesByPack-order="<?php echo $product['piecesByPack']; ?>"
                                                        class="form-control">
                                                    <option data-mark='0' value="0" data-mark-name=''><?php echo $product['name'] . " (" . $unit . ")"; ?></option>
                                                    <?php foreach ($product['marks'] as $key1 => $mark) { ?>
                                                        <option
                                                                data-mark-name='<?php echo $mark['name']; ?>'
                                                                data-mark-unit_price='<?php echo $mark['m_unit_price']; ?>'
                                                                data-mark-unit='<?php echo $mark['m_unit']; ?>'
                                                                data-mark-weightByUnit='<?php echo $mark['m_weightByUnit']; ?>'
                                                                value="<?php echo $mark['id']; ?>"
                                                                data-mark="<?php echo $mark['id']; ?>">
                                                            Marque <?php echo $product['name'].' - '.$mark['name'].' ('.$mark['m_unit'].')';?>
                                                        </option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                            <div class="col-md-3 col-sm-4 col-xs-12">
                                                <input type="text" name="quantity" class="form-control"/><span
                                                        class="productCost"> 0DH</span>
                                            </div>
                                            <div class="col-md-3 col-sm-4 col-xs-12">
                                                <input type="text" name="unit_price" value="<?php echo $unit_price; ?>" class="form-control"/>
                                            </div>

                                        </div>
                                    <?php } ?>
                                    <!-- <hr/>-->

                                </div>
                            </form>


                            <!--  <div class="col-sm-12">
                                  <button type="button" class="selected"
                                          id="price" placeholder="Oui" style="width: 250px;" data-toggle="collapse"
                                          href="#email" aria-expanded="false" aria-controls="emailEdit">Envoyer la commande
                                      par email
                                  </button>
                              </div>


                              <br/>-->
                            <div class="col-md-12 col-sm-12 col-xs-12" class="collapse" id="emailEdit" hidden>
                                <div class="x_panel">
                                    <div class="x_title">
                                        <h2>Contenu
                                            <small>Sessions</small>
                                        </h2>
                                        <ul class="nav navbar-right panel_toolbox">
                                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                            </li>
                                            <li class="dropdown">
                                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
                                                   aria-expanded="false"><i class="fa fa-wrench"></i></a>
                                                <ul class="dropdown-menu" role="menu">
                                                    <li><a href="#">Settings 1</a>
                                                    </li>
                                                    <li><a href="#">Settings 2</a>
                                                    </li>
                                                </ul>
                                            </li>
                                            <li><a class="close-link"><i class="fa fa-close"></i></a>
                                            </li>
                                        </ul>
                                        <div class="clearfix"></div>
                                    </div>
                                    <div class="x_content">
                                        <div id="alerts"></div>
                                        <div class="btn-toolbar editor" data-role="editor-toolbar"
                                             data-target="#editor-one">
                                            <div class="btn-group">
                                                <a class="btn dropdown-toggle" data-toggle="dropdown" title="Font"><i
                                                            class="fa fa-font"></i><b class="caret"></b></a>
                                                <ul class="dropdown-menu">
                                                </ul>
                                            </div>

                                            <div class="btn-group">
                                                <a class="btn dropdown-toggle" data-toggle="dropdown" title="Font Size"><i
                                                            class="fa fa-text-height"></i>&nbsp;<b
                                                            class="caret"></b></a>
                                                <ul class="dropdown-menu">
                                                    <li>
                                                        <a data-edit="fontSize 5">
                                                            <p style="font-size:17px">Huge</p>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a data-edit="fontSize 3">
                                                            <p style="font-size:14px">Normal</p>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a data-edit="fontSize 1">
                                                            <p style="font-size:11px">Small</p>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>

                                            <div class="btn-group">
                                                <a class="btn" data-edit="bold" title="Bold (Ctrl/Cmd+B)"><i
                                                            class="fa fa-bold"></i></a>
                                                <a class="btn" data-edit="italic" title="Italic (Ctrl/Cmd+I)"><i
                                                            class="fa fa-italic"></i></a>
                                                <a class="btn" data-edit="strikethrough" title="Strikethrough"><i
                                                            class="fa fa-strikethrough"></i></a>
                                                <a class="btn" data-edit="underline" title="Underline (Ctrl/Cmd+U)"><i
                                                            class="fa fa-underline"></i></a>
                                            </div>

                                            <div class="btn-group">
                                                <a class="btn" data-edit="insertunorderedlist" title="Bullet list"><i
                                                            class="fa fa-list-ul"></i></a>
                                                <a class="btn" data-edit="insertorderedlist" title="Number list"><i
                                                            class="fa fa-list-ol"></i></a>
                                                <a class="btn" data-edit="outdent" title="Reduce indent (Shift+Tab)"><i
                                                            class="fa fa-dedent"></i></a>
                                                <a class="btn" data-edit="indent" title="Indent (Tab)"><i
                                                            class="fa fa-indent"></i></a>
                                            </div>

                                            <div class="btn-group">
                                                <a class="btn" data-edit="justifyleft"
                                                   title="Align Left (Ctrl/Cmd+L)"><i
                                                            class="fa fa-align-left"></i></a>
                                                <a class="btn" data-edit="justifycenter" title="Center (Ctrl/Cmd+E)"><i
                                                            class="fa fa-align-center"></i></a>
                                                <a class="btn" data-edit="justifyright"
                                                   title="Align Right (Ctrl/Cmd+R)"><i
                                                            class="fa fa-align-right"></i></a>
                                                <a class="btn" data-edit="justifyfull" title="Justify (Ctrl/Cmd+J)"><i
                                                            class="fa fa-align-justify"></i></a>
                                            </div>

                                            <div class="btn-group">
                                                <a class="btn dropdown-toggle" data-toggle="dropdown" title="Hyperlink"><i
                                                            class="fa fa-link"></i></a>
                                                <div class="dropdown-menu input-append">
                                                    <input class="span2" placeholder="URL" type="text"
                                                           data-edit="createLink"/>
                                                    <button class="btn" type="button">Add</button>
                                                </div>
                                                <a class="btn" data-edit="unlink" title="Remove Hyperlink"><i
                                                            class="fa fa-cut"></i></a>
                                            </div>

                                            <div class="btn-group">
                                                <a class="btn" title="Insert picture (or just drag & drop)"
                                                   id="pictureBtn"><i
                                                            class="fa fa-picture-o"></i></a>
                                                <input type="file" data-role="magic-overlay" data-target="#pictureBtn"
                                                       data-edit="insertImage"/>
                                            </div>

                                            <div class="btn-group">
                                                <a class="btn" data-edit="undo" title="Undo (Ctrl/Cmd+Z)"><i
                                                            class="fa fa-undo"></i></a>
                                                <a class="btn" data-edit="redo" title="Redo (Ctrl/Cmd+Y)"><i
                                                            class="fa fa-repeat"></i></a>
                                            </div>
                                        </div>

                                        <div id="editor-one" class="editor-wrapper"></div>

                                        <textarea name="descr" id="descr" style="display:none;"></textarea>


                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--------------------------------------------End Products Tab------------------------------------------------------>

                        <!--------------------------------------------Config Tab------------------------------------------------------>
                        <div role="tabpanel" class="tab-pane" id="tab_config_edit_order"
                             aria-labelledby="home-tab">
                            <div class="row">

                                <div class="row">
                                    <label class="col-md-2 col-sm-2 col-xs-12 control-label"><?= lang('reference') ?></label>
                                    <div class="col-md-4 col-sm-4 col-xs-12">
                                        <input class="form-control" type="text" name="reference"/>
                                    </div>
                                    <label class="col-md-2 col-sm-2 col-xs-12 control-label"><?= lang('payment') ?></label>
                                    <div class="col-md-4 col-sm-4 col-xs-12">
                                        <select class="form-control" name="paymentType">
                                            <option value="species">Espèce</option>
                                            <option value="check">Chèque</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="row">
                                    <label class="col-md-2 col-sm-2 col-xs-12 control-label"><?= lang('tva') ?></label>
                                    <div class="col-md-4 col-sm-4 col-xs-12">
                                        <input class="form-control" type="text" name="order_tva"/>
                                    </div>
                                    <label class="col-md-2 col-sm-2 col-xs-12 control-label"><?= lang('discount') ?></label>
                                    <div class="col-md-4 col-sm-4 col-xs-12">
                                        <input type="text" class="form-control"
                                               name="discount" placeholder="Remise" value="0">
                                    </div>
                                </div>
                                <div class="row">
                                    <label class="col-md-2 col-sm-2 col-xs-12 control-label"><?= lang('date_of_payment') ?></label>
                                    <div class="col-md-4 col-sm-4 col-xs-12">
                                        <?php include('order_calender.php'); ?>
                                        <input type="text" class="form-control has-feedback-left"
                                               id="edit_payment_date_field" placeholder="Date"
                                               aria-describedby="inputSuccess2Status3">
                                        <span class="fa fa-calendar-o form-control-feedback left"
                                              aria-hidden="true"></span>
                                        <span id="inputSuccess2Status3" class="sr-only">(success)</span>
                                        <input type="hidden" name="edit_payment_date_field">
                                    </div>
                                    <?php if($params['editOrderDate']==='true'){ ?>
                                    <label class="col-md-2 col-sm-2 col-xs-12 control-label"><?= lang('date_order') ?></label>
                                    <div class="col-md-4 col-sm-4 col-xs-12">
                                        <?php include('order_calender.php'); ?>
                                        <input type="text" class="form-control has-feedback-left" id="edit_order_date_field"
                                               placeholder="Date"
                                               aria-describedby="inputSuccess2Status3">
                                        <span class="fa fa-calendar-o form-control-feedback left"
                                              aria-hidden="true"></span>
                                        <span id="inputSuccess2Status3" class="sr-only">(success)</span>
                                        <input type="hidden" name="edit_order_date_field">
                                    </div>
                                    <?php } ?>
                                </div>

                            </div>
                        </div>
                        <!--------------------------------------------End Products Tab------------------------------------------------------>

                        <!--------------------------------------------Config Tab------------------------------------------------------>
                        <div role="tabpanel" class="tab-pane" id="tab_advance_edit_order"
                             aria-labelledby="home-tab">
                            <div class="row">
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered">
                                        <thead>
                                        <tr>
                                            <th hidden>Id</th>
                                            <th><?= lang('amount'); ?></th>
                                            <th><?= lang('date'); ?></th>
                                            <th><?= lang('remain'); ?></th>
                                        </tr>
                                        </thead>
                                        <tbody id="advancesBody">
                                        <tr class="advanceModel" hidden>
                                            <td hidden>
                                                <div data-type="id">0</div>
                                            </td>
                                            <td>
                                                <div data-type="amount" class="advanceAmount" contenteditable></div>
                                            </td>
                                            <td>
                                                <div class="datepick" data-type="date" contenteditable></div>
                                            </td>
                                            <td>
                                                <div data-type="remain"></div>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>

                                </div>

                                <div>
                                    <button type="button" class="btn btn-success newAvanceEdit" name="newAvanceEdit">+</button>
                                </div>
                            </div>
                        </div>
                        <!--------------------------------------------End Config Tab------------------------------------------------------>

                    </div>
                </div>
            </div>

            <!-- Modal Footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-default small-button"
                        data-dismiss="modal">
                    Annuler
                </button>
                <input type="button" class="btn btn-success payOrder small-button" value="Payer la commande">
                </input>
                <button type="submit" class="btn btn-warning small-button" name="editPrint">
                    <span class="fa fa-print"></span> Imprimer
                </button>
                <?php if($provider['stockitmain']==='0'){?>
                    <button type="button" class="btn btn-primary small-button" name="editOrder">
                        <?= lang('save') ?>
                    </button>
                <?php }else{ ?>
                    <button type="button" class="btn btn-primary small-button" name="editOrder">
                       Répondre
                    </button>
                <?php } ?>
            </div>
        </div>
    </div>
</div>

