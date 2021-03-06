<div class="modal fade" id="orderModal" tabindex="-1" role="dialog"
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
                    Nouvelle commande
                    <div class="pull-right" style="margin-right:5px">
                        <input type="text" placeholder="Rechercher" class="form-control" id="searchInput"
                               onkeyup="myFunction()">
                    </div>
                </h4>
            </div>

            <!-- Modal Body -->
            <div class="modal-body">

                <form class="form-horizontal" role="form">
                    <div class="form-group" id="productsOrder">
                        <?php foreach ($products as $key => $product) { ?>
                        <div class="row product" data-name="<?php echo $product['name']; ?>" data-index="<?php echo $key; ?>">

                            <label class="col-md-2 col-sm-2 col-xs-12 control-label">Produit</label>
                            <div class="col-md-4 col-sm-4 col-xs-12">
                               <input name="product"
                                      value="<?php echo $product['name'] . " (" . $product['unit_price'] . "DH/" . $product['unit'] . ")"; ?>" disabled
                                      data-id="<?php echo $product['id']; ?>"
                                      data-price="<?php echo $product['unit_price']; ?>"
                                      data-name="<?php echo $product['name'];?>"
                                      data-id-quantity="<?php echo $product['q_id']; ?>"
                                      data-unit="<?php echo $product['unit'];?>">
                            </div>
                            <label class="col-md-2 col-sm-2 col-xs-12 control-label">Quantité</label>
                            <div class="col-md-4 col-sm-4 col-xs-12">
                                <input type="text" name="quantity" /><span class="productCost"> 0DH</span>
                            </div>

                        </div>
                        <?php } ?>

                    </div>
                </form>

                <div class="col-sm-12 col-md-offset-3">
                    <button type="button" class="selected"
                            id="price" placeholder="Oui" style="width: 250px;" data-toggle="collapse"
                            href="#email" aria-expanded="false" aria-controls="email">Envoyer la commande
                        par email
                    </button>
                </div>


                <br/>
                <div class="col-md-12 col-sm-12 col-xs-12" class="collapse" id="email" hidden>
                    <div class="x_panel">
                        <div class="x_title">
                            <h2>Contenu
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
                            <div class="btn-toolbar editor" data-role="editor-toolbar" data-target="#editor-newOrder">
                                <div class="btn-group">
                                    <a class="btn dropdown-toggle" data-toggle="dropdown" title="Font"><i
                                                class="fa fa-font"></i><b class="caret"></b></a>
                                    <ul class="dropdown-menu">
                                    </ul>
                                </div>

                                <div class="btn-group">
                                    <a class="btn dropdown-toggle" data-toggle="dropdown" title="Font Size"><i
                                                class="fa fa-text-height"></i>&nbsp;<b class="caret"></b></a>
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
                                    <a class="btn" data-edit="bold" title="Bold (Ctrl/Cmd+B)"><i class="fa fa-bold"></i></a>
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
                                    <a class="btn" data-edit="indent" title="Indent (Tab)"><i class="fa fa-indent"></i></a>
                                </div>

                                <div class="btn-group">
                                    <a class="btn" data-edit="justifyleft" title="Align Left (Ctrl/Cmd+L)"><i
                                                class="fa fa-align-left"></i></a>
                                    <a class="btn" data-edit="justifycenter" title="Center (Ctrl/Cmd+E)"><i
                                                class="fa fa-align-center"></i></a>
                                    <a class="btn" data-edit="justifyright" title="Align Right (Ctrl/Cmd+R)"><i
                                                class="fa fa-align-right"></i></a>
                                    <a class="btn" data-edit="justifyfull" title="Justify (Ctrl/Cmd+J)"><i
                                                class="fa fa-align-justify"></i></a>
                                </div>

                                <div class="btn-group">
                                    <a class="btn dropdown-toggle" data-toggle="dropdown" title="Hyperlink"><i
                                                class="fa fa-link"></i></a>
                                    <div class="dropdown-menu input-append">
                                        <input class="span2" placeholder="URL" type="text" data-edit="createLink"/>
                                        <button class="btn" type="button">Add</button>
                                    </div>
                                    <a class="btn" data-edit="unlink" title="Remove Hyperlink"><i class="fa fa-cut"></i></a>
                                </div>

                                <div class="btn-group">
                                    <a class="btn" title="Insert picture (or just drag & drop)" id="pictureBtn"><i
                                                class="fa fa-picture-o"></i></a>
                                    <input type="file" data-role="magic-overlay" data-target="#pictureBtn"
                                           data-edit="insertImage"/>
                                </div>

                                <div class="btn-group">
                                    <a class="btn" data-edit="undo" title="Undo (Ctrl/Cmd+Z)"><i class="fa fa-undo"></i></a>
                                    <a class="btn" data-edit="redo" title="Redo (Ctrl/Cmd+Y)"><i
                                                class="fa fa-repeat"></i></a>
                                </div>
                            </div>

                            <div id="editor-newOrder" class="editor-wrapper"></div>

                            <textarea name="descr" id="descr" style="display:none;"></textarea>


                        </div>
                    </div>
                </div>


            </div>

            <!-- Modal Footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-default small-button"
                        data-dismiss="modal">
                    Annuler
                </button>
                <button type="submit" class="btn btn-warning small-button" name="print">
                    <span class="fa fa-print"></span> Imprimer
                </button>
                <button type="button" class="btn btn-primary small-button" name="save">
                    Enregistrer
                </button>
            </div>
        </div>
    </div>
</div>

