<?php $this->load->view('admin/partials/admin_header.php'); ?>
<!-- page content -->
<div class="right_col" role="main">
    <div class="productsList">
        <div class="page-title">
            <div class="title_left">
                <h3>Ajouter des produits</h3>
            </div>
        </div>
        <div class="clearfix"></div>
        <hr>
        <h4 style="display: inline;">Nombre de produit à ajouter : </h4> <input type="text" name="productSize" />
        <div value="Nouveau produit" class="btn btn-info productSize">Ajouter</div>
        <div class="row" data-id="1">
            <div class="col-md-6 col-sm-6 col-xs-6 left-product">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Produit</h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                            <li><a class="close-link"><i class="fa fa-close"></i></a></li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <label><?php echo $message; ?></label>
                        <form method="post">
                            <fieldset>
                                <div class="form-group">
                                    Produit : <input class="form-control" placeholder="Produit" name="name" id="username" type="text" >
                                </div>
                                <div class="form-group">
                                    Quantité : <input class="form-control" placeholder="Quantité" name="quantity" type="text" >
                                </div>
                                <div class="form-group">
                                    Unité de mesure :
                                    <select class="form-control" name="unit">
                                        <option name="unit" value="gr">Gr</option>
                                        <option name="unit" value="kg">Kg</option>
                                        <option name="unit" value="pcs">Pcs</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    Prix unitaire : <input class="form-control" placeholder="Prix unitaire" name="unit_price" type="text" >
                                </div>
                                <br/>
                               <!-- <input type="submit" name="buttonSubmit" value="Confirmer" class="btn btn-success" />
                                <div value="Nouveau produit" class="btn btn-info newProduct" >Nouveau produit</div>-->
                            </fieldset>
                        </form>
                    </div> <!-- /content -->
                </div><!-- /x-panel -->
            </div>
            <div class="col-md-6 col-sm-6 col-xs-6 right-product" hidden>
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Produit</h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                            <li><a class="close-link"><i class="fa fa-close"></i></a></li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <label><?php echo $message; ?></label>
                        <form method="post">
                            <fieldset>
                                <div class="form-group">
                                    Produit : <input class="form-control" placeholder="Produit" name="name" id="username" type="text"  >
                                </div>
                                <div class="form-group">
                                    Quantité : <input class="form-control" placeholder="Quantité" name="quantity" type="text" >
                                </div>
                                <div class="form-group">
                                    Unité de mesure :
                                    <select class="form-control" name="unit">
                                        <option name="unit" value="gr">Gr</option>
                                        <option name="unit" value="kg">Kg</option>
                                        <option name="unit" value="pcs">Pcs</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    Prix unitaire : <input class="form-control" placeholder="Prix unitaire" name="unit_price" type="text" >
                                </div>
                                <br/>
                            </fieldset>
                        </form>
                    </div> <!-- /content -->
                </div><!-- /x-panel -->
            </div> <!-- /col -->
             <!-- /col -->
        </div> <!-- /row -->
        <div class="row" hidden data-id="2">
            <div class="col-md-6 col-sm-6 col-xs-6 left-product">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Produit</h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                            <li><a class="close-link"><i class="fa fa-close"></i></a></li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <label><?php echo $message; ?></label>
                        <form method="post">
                            <fieldset>
                                <div class="form-group">
                                    Produit : <input class="form-control" placeholder="Produit" name="name" id="username" type="text"  >
                                </div>
                                <div class="form-group">
                                    Quantité : <input class="form-control" placeholder="Quantité" name="quantity" type="text" >
                                </div>
                                <div class="form-group">
                                    Unité de mesure :
                                    <select class="form-control">
                                        <option>Gr</option>
                                        <option>Kg</option>
                                        <option>Pcs</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    Prix unitaire : <input class="form-control" placeholder="Prix unitaire" name="prix_unit" type="text" >
                                </div>
                                <br/>
                            </fieldset>
                        </form>
                    </div> <!-- /content -->
                </div><!-- /x-panel -->
            </div>
            <div class="col-md-6 col-sm-6 col-xs-6 right-product" hidden>
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Produit</h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                            <li><a class="close-link"><i class="fa fa-close"></i></a></li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <label><?php echo $message; ?></label>
                        <form method="post">
                            <fieldset>
                                <div class="form-group">
                                    Produit : <input class="form-control" placeholder="Produit" name="name" id="username" type="text"  >
                                </div>
                                <div class="form-group">
                                    Quantité : <input class="form-control" placeholder="Quantité" name="quantity" type="text" >
                                </div>
                                <div class="form-group">
                                    Unité de mesure :
                                    <select class="form-control">
                                        <option>Gr</option>
                                        <option>Kg</option>
                                        <option>Pcs</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    Prix unitaire : <input class="form-control" placeholder="Prix unitaire" name="prix_unit" type="text" >
                                </div>
                                <br/>
                            </fieldset>
                        </form>
                    </div> <!-- /content -->
                </div><!-- /x-panel -->
            </div> <!-- /col -->
             <!-- /col -->
        </div> <!-- /row -->
        <div class="row" hidden data-id="3">
            <div class="col-md-6 col-sm-6 col-xs-6">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Produit</h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                            <li><a class="close-link"><i class="fa fa-close"></i></a></li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <label><?php echo $message; ?></label>
                        <form method="post">
                            <fieldset>
                                <div class="form-group">
                                    Produit : <input class="form-control" placeholder="Produit" name="name" id="username" type="text"  >
                                </div>
                                <div class="form-group">
                                    Quantité : <input class="form-control" placeholder="Quantité" name="quantity" type="text" >
                                </div>
                                <div class="form-group">
                                    Unité de mesure :
                                    <select class="form-control">
                                        <option>Gr</option>
                                        <option>Kg</option>
                                        <option>Pcs</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    Prix unitaire : <input class="form-control" placeholder="Prix unitaire" name="prix_unit" type="text" >
                                </div>
                                <br/>
                                <input type="submit" name="buttonSubmit" value="Confirmer" class="btn btn-success" />
                                <div value="Nouveau produit" class="btn btn-info newProduct" >Nouveau produit</div>
                            </fieldset>
                        </form>
                    </div> <!-- /content -->
                </div><!-- /x-panel -->
            </div>
            <div class="col-md-6 col-sm-6 col-xs-6 right-product" hidden>
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Produit</h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                            <li><a class="close-link"><i class="fa fa-close"></i></a></li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <label><?php echo $message; ?></label>
                        <form method="post">
                            <fieldset>
                                <div class="form-group">
                                    Produit : <input class="form-control" placeholder="Produit" name="name" id="username" type="text"  >
                                </div>
                                <div class="form-group">
                                    Quantité : <input class="form-control" placeholder="Quantité" name="quantity" type="text" >
                                </div>
                                <div class="form-group">
                                    Unité de mesure :
                                    <select class="form-control">
                                        <option>Gr</option>
                                        <option>Kg</option>
                                        <option>Pcs</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    Prix unitaire : <input class="form-control" placeholder="Prix unitaire" name="prix_unit" type="text" >
                                </div>
                                <br/>
                                <input type="submit" name="buttonSubmit" value="Confirmer" class="btn btn-success" />
                                <div value="Nouveau produit" class="btn btn-info newProduct" >Nouveau produit</div>
                            </fieldset>
                        </form>
                    </div> <!-- /content -->
                </div><!-- /x-panel -->
            </div> <!-- /col -->
             <!-- /col -->
        </div> <!-- /row -->
        <div class="row" hidden data-id="4">
            <div class="col-md-6 col-sm-6 col-xs-6">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Produit</h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                            <li><a class="close-link"><i class="fa fa-close"></i></a></li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <label><?php echo $message; ?></label>
                        <form method="post">
                            <fieldset>
                                <div class="form-group">
                                    Produit : <input class="form-control" placeholder="Produit" name="name" id="username" type="text"  >
                                </div>
                                <div class="form-group">
                                    Quantité : <input class="form-control" placeholder="Quantité" name="quantity" type="text" >
                                </div>
                                <div class="form-group">
                                    Unité de mesure :
                                    <select class="form-control">
                                        <option>Gr</option>
                                        <option>Kg</option>
                                        <option>Pcs</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    Prix unitaire : <input class="form-control" placeholder="Prix unitaire" name="prix_unit" type="text" >
                                </div>
                                <br/>
                                <input type="submit" name="buttonSubmit" value="Confirmer" class="btn btn-success" />
                                <div value="Nouveau produit" class="btn btn-info newProduct" >Nouveau produit</div>
                            </fieldset>
                        </form>
                    </div> <!-- /content -->
                </div><!-- /x-panel -->
            </div><div class="col-md-6 col-sm-6 col-xs-6 right-product" hidden>
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Produit</h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                            <li><a class="close-link"><i class="fa fa-close"></i></a></li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <label><?php echo $message; ?></label>
                        <form method="post">
                            <fieldset>
                                <div class="form-group">
                                    Produit : <input class="form-control" placeholder="Produit" name="name" id="username" type="text"  >
                                </div>
                                <div class="form-group">
                                    Quantité : <input class="form-control" placeholder="Quantité" name="quantity" type="text" >
                                </div>
                                <div class="form-group">
                                    Unité de mesure :
                                    <select class="form-control">
                                        <option>Gr</option>
                                        <option>Kg</option>
                                        <option>Pcs</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    Prix unitaire : <input class="form-control" placeholder="Prix unitaire" name="prix_unit" type="text" >
                                </div>
                                <br/>
                                <input type="submit" name="buttonSubmit" value="Confirmer" class="btn btn-success" />
                                <div value="Nouveau produit" class="btn btn-info newProduct" >Nouveau produit</div>
                            </fieldset>
                        </form>
                    </div> <!-- /content -->
                </div><!-- /x-panel -->
            </div> <!-- /col -->
             <!-- /col -->
        </div> <!-- /row -->
        <div class="row" hidden data-id="5">
            <div class="col-md-6 col-sm-6 col-xs-6">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Produit</h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                            <li><a class="close-link"><i class="fa fa-close"></i></a></li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <label><?php echo $message; ?></label>
                        <form method="post">
                            <fieldset>
                                <div class="form-group">
                                    Produit : <input class="form-control" placeholder="Produit" name="name" id="username" type="text"  >
                                </div>
                                <div class="form-group">
                                    Quantité : <input class="form-control" placeholder="Quantité" name="quantity" type="text" >
                                </div>
                                <div class="form-group">
                                    Unité de mesure :
                                    <select class="form-control">
                                        <option>Gr</option>
                                        <option>Kg</option>
                                        <option>Pcs</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    Prix unitaire : <input class="form-control" placeholder="Prix unitaire" name="prix_unit" type="text" >
                                </div>
                                <br/>
                                <input type="submit" name="buttonSubmit" value="Confirmer" class="btn btn-success" />
                                <div value="Nouveau produit" class="btn btn-info newProduct" >Nouveau produit</div>
                            </fieldset>
                        </form>
                    </div> <!-- /content -->
                </div><!-- /x-panel -->
            </div><div class="col-md-6 col-sm-6 col-xs-6 right-product" hidden>
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Produit</h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                            <li><a class="close-link"><i class="fa fa-close"></i></a></li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <label><?php echo $message; ?></label>
                        <form method="post">
                            <fieldset>
                                <div class="form-group">
                                    Produit : <input class="form-control" placeholder="Produit" name="name" id="username" type="text"  >
                                </div>
                                <div class="form-group">
                                    Quantité : <input class="form-control" placeholder="Quantité" name="quantity" type="text" >
                                </div>
                                <div class="form-group">
                                    Unité de mesure :
                                    <select class="form-control">
                                        <option>Gr</option>
                                        <option>Kg</option>
                                        <option>Pcs</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    Prix unitaire : <input class="form-control" placeholder="Prix unitaire" name="prix_unit" type="text" >
                                </div>
                                <br/>
                                <input type="submit" name="buttonSubmit" value="Confirmer" class="btn btn-success" />
                                <div value="Nouveau produit" class="btn btn-info newProduct" >Nouveau produit</div>
                            </fieldset>
                        </form>
                    </div> <!-- /content -->
                </div><!-- /x-panel -->
            </div> <!-- /col -->
             <!-- /col -->
        </div> <!-- /row -->
        <div class="row" hidden data-id="6">
            <div class="col-md-6 col-sm-6 col-xs-6">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Produit</h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                            <li><a class="close-link"><i class="fa fa-close"></i></a></li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <label><?php echo $message; ?></label>
                        <form method="post">
                            <fieldset>
                                <div class="form-group">
                                    Produit : <input class="form-control" placeholder="Produit" name="name" id="username" type="text"  >
                                </div>
                                <div class="form-group">
                                    Quantité : <input class="form-control" placeholder="Quantité" name="quantity" type="text" >
                                </div>
                                <div class="form-group">
                                    Unité de mesure :
                                    <select class="form-control">
                                        <option>Gr</option>
                                        <option>Kg</option>
                                        <option>Pcs</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    Prix unitaire : <input class="form-control" placeholder="Prix unitaire" name="prix_unit" type="text" >
                                </div>
                                <br/>
                                <input type="submit" name="buttonSubmit" value="Confirmer" class="btn btn-success" />
                                <div value="Nouveau produit" class="btn btn-info newProduct" >Nouveau produit</div>
                            </fieldset>
                        </form>
                    </div> <!-- /content -->
                </div><!-- /x-panel -->
            </div><div class="col-md-6 col-sm-6 col-xs-6 right-product" hidden>
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Produit</h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                            <li><a class="close-link"><i class="fa fa-close"></i></a></li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <label><?php echo $message; ?></label>
                        <form method="post">
                            <fieldset>
                                <div class="form-group">
                                    Produit : <input class="form-control" placeholder="Produit" name="name" id="username" type="text"  >
                                </div>
                                <div class="form-group">
                                    Quantité : <input class="form-control" placeholder="Quantité" name="quantity" type="text" >
                                </div>
                                <div class="form-group">
                                    Unité de mesure :
                                    <select class="form-control">
                                        <option>Gr</option>
                                        <option>Kg</option>
                                        <option>Pcs</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    Prix unitaire : <input class="form-control" placeholder="Prix unitaire" name="prix_unit" type="text" >
                                </div>
                                <br/>
                                <input type="submit" name="buttonSubmit" value="Confirmer" class="btn btn-success" />
                                <div value="Nouveau produit" class="btn btn-info newProduct" >Nouveau produit</div>
                            </fieldset>
                        </form>
                    </div> <!-- /content -->
                </div><!-- /x-panel -->
            </div> <!-- /col -->
             <!-- /col -->
        </div> <!-- /row -->
        <div class="row" hidden data-id="7">
            <div class="col-md-6 col-sm-6 col-xs-6">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Produit</h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                            <li><a class="close-link"><i class="fa fa-close"></i></a></li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <label><?php echo $message; ?></label>
                        <form method="post">
                            <fieldset>
                                <div class="form-group">
                                    Produit : <input class="form-control" placeholder="Produit" name="name" id="username" type="text"  >
                                </div>
                                <div class="form-group">
                                    Quantité : <input class="form-control" placeholder="Quantité" name="quantity" type="text" >
                                </div>
                                <div class="form-group">
                                    Unité de mesure :
                                    <select class="form-control">
                                        <option>Gr</option>
                                        <option>Kg</option>
                                        <option>Pcs</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    Prix unitaire : <input class="form-control" placeholder="Prix unitaire" name="prix_unit" type="text" >
                                </div>
                                <br/>
                                <input type="submit" name="buttonSubmit" value="Confirmer" class="btn btn-success" />
                                <div value="Nouveau produit" class="btn btn-info newProduct" >Nouveau produit</div>
                            </fieldset>
                        </form>
                    </div> <!-- /content -->
                </div><!-- /x-panel -->
            </div><div class="col-md-6 col-sm-6 col-xs-6 right-product" hidden>
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Produit</h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                            <li><a class="close-link"><i class="fa fa-close"></i></a></li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <label><?php echo $message; ?></label>
                        <form method="post">
                            <fieldset>
                                <div class="form-group">
                                    Produit : <input class="form-control" placeholder="Produit" name="name" id="username" type="text"  >
                                </div>
                                <div class="form-group">
                                    Quantité : <input class="form-control" placeholder="Quantité" name="quantity" type="text" >
                                </div>
                                <div class="form-group">
                                    Unité de mesure :
                                    <select class="form-control">
                                        <option>Gr</option>
                                        <option>Kg</option>
                                        <option>Pcs</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    Prix unitaire : <input class="form-control" placeholder="Prix unitaire" name="prix_unit" type="text" >
                                </div>
                                <br/>
                                <input type="submit" name="buttonSubmit" value="Confirmer" class="btn btn-success" />
                                <div value="Nouveau produit" class="btn btn-info newProduct" >Nouveau produit</div>
                            </fieldset>
                        </form>
                    </div> <!-- /content -->
                </div><!-- /x-panel -->
            </div> <!-- /col -->
             <!-- /col -->
        </div> <!-- /row -->
        <div class="row" hidden data-id="8">
            <div class="col-md-6 col-sm-6 col-xs-6">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Produit</h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                            <li><a class="close-link"><i class="fa fa-close"></i></a></li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <label><?php echo $message; ?></label>
                        <form method="post">
                            <fieldset>
                                <div class="form-group">
                                    Produit : <input class="form-control" placeholder="Produit" name="name" id="username" type="text"  >
                                </div>
                                <div class="form-group">
                                    Quantité : <input class="form-control" placeholder="Quantité" name="quantity" type="text" >
                                </div>
                                <div class="form-group">
                                    Unité de mesure :
                                    <select class="form-control">
                                        <option>Gr</option>
                                        <option>Kg</option>
                                        <option>Pcs</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    Prix unitaire : <input class="form-control" placeholder="Prix unitaire" name="prix_unit" type="text" >
                                </div>
                                <br/>
                                <input type="submit" name="buttonSubmit" value="Confirmer" class="btn btn-success" />
                                <div value="Nouveau produit" class="btn btn-info newProduct" >Nouveau produit</div>
                            </fieldset>
                        </form>
                    </div> <!-- /content -->
                </div><!-- /x-panel -->
            </div><div class="col-md-6 col-sm-6 col-xs-6 right-product" hidden>
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Produit</h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                            <li><a class="close-link"><i class="fa fa-close"></i></a></li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <label><?php echo $message; ?></label>
                        <form method="post">
                            <fieldset>
                                <div class="form-group">
                                    Produit : <input class="form-control" placeholder="Produit" name="name" id="username" type="text"  >
                                </div>
                                <div class="form-group">
                                    Quantité : <input class="form-control" placeholder="Quantité" name="quantity" type="text" >
                                </div>
                                <div class="form-group">
                                    Unité de mesure :
                                    <select class="form-control">
                                        <option>Gr</option>
                                        <option>Kg</option>
                                        <option>Pcs</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    Prix unitaire : <input class="form-control" placeholder="Prix unitaire" name="prix_unit" type="text" >
                                </div>
                                <br/>
                                <input type="submit" name="buttonSubmit" value="Confirmer" class="btn btn-success" />
                                <div value="Nouveau produit" class="btn btn-info newProduct" >Nouveau produit</div>
                            </fieldset>
                        </form>
                    </div> <!-- /content -->
                </div><!-- /x-panel -->
            </div> <!-- /col -->
             <!-- /col -->
        </div> <!-- /row -->
        <div class="row" hidden data-id="9">
            <div class="col-md-6 col-sm-6 col-xs-6">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Produit</h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                            <li><a class="close-link"><i class="fa fa-close"></i></a></li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <label><?php echo $message; ?></label>
                        <form method="post">
                            <fieldset>
                                <div class="form-group">
                                    Produit : <input class="form-control" placeholder="Produit" name="name" id="username" type="text"  >
                                </div>
                                <div class="form-group">
                                    Quantité : <input class="form-control" placeholder="Quantité" name="quantity" type="text" >
                                </div>
                                <div class="form-group">
                                    Unité de mesure :
                                    <select class="form-control">
                                        <option>Gr</option>
                                        <option>Kg</option>
                                        <option>Pcs</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    Prix unitaire : <input class="form-control" placeholder="Prix unitaire" name="prix_unit" type="text" >
                                </div>
                                <br/>
                                <input type="submit" name="buttonSubmit" value="Confirmer" class="btn btn-success" />
                                <div value="Nouveau produit" class="btn btn-info newProduct" >Nouveau produit</div>
                            </fieldset>
                        </form>
                    </div> <!-- /content -->
                </div><!-- /x-panel -->
            </div><div class="col-md-6 col-sm-6 col-xs-6 right-product" hidden>
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Produit</h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                            <li><a class="close-link"><i class="fa fa-close"></i></a></li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <label><?php echo $message; ?></label>
                        <form method="post">
                            <fieldset>
                                <div class="form-group">
                                    Produit : <input class="form-control" placeholder="Produit" name="name" id="username" type="text"  >
                                </div>
                                <div class="form-group">
                                    Quantité : <input class="form-control" placeholder="Quantité" name="quantity" type="text" >
                                </div>
                                <div class="form-group">
                                    Unité de mesure :
                                    <select class="form-control">
                                        <option>Gr</option>
                                        <option>Kg</option>
                                        <option>Pcs</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    Prix unitaire : <input class="form-control" placeholder="Prix unitaire" name="prix_unit" type="text" >
                                </div>
                                <br/>
                                <input type="submit" name="buttonSubmit" value="Confirmer" class="btn btn-success" />
                                <div value="Nouveau produit" class="btn btn-info newProduct" >Nouveau produit</div>
                            </fieldset>
                        </form>
                    </div> <!-- /content -->
                </div><!-- /x-panel -->
            </div> <!-- /col -->
             <!-- /col -->
        </div> <!-- /row -->
        <div class="row" hidden data-id="10">
            <div class="col-md-6 col-sm-6 col-xs-6">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Produit</h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                            <li><a class="close-link"><i class="fa fa-close"></i></a></li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <label><?php echo $message; ?></label>
                        <form method="post">
                            <fieldset>
                                <div class="form-group">
                                    Produit : <input class="form-control" placeholder="Produit" name="name" id="username" type="text"  >
                                </div>
                                <div class="form-group">
                                    Quantité : <input class="form-control" placeholder="Quantité" name="quantity" type="text" >
                                </div>
                                <div class="form-group">
                                    Unité de mesure :
                                    <select class="form-control">
                                        <option>Gr</option>
                                        <option>Kg</option>
                                        <option>Pcs</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    Prix unitaire : <input class="form-control" placeholder="Prix unitaire" name="prix_unit" type="text" >
                                </div>
                                <br/>
                                <input type="submit" name="buttonSubmit" value="Confirmer" class="btn btn-success" />
                                <div value="Nouveau produit" class="btn btn-info newProduct" >Nouveau produit</div>
                            </fieldset>
                        </form>
                    </div> <!-- /content -->
                </div><!-- /x-panel -->
            </div><div class="col-md-6 col-sm-6 col-xs-6 right-product" hidden>
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Produit</h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                            <li><a class="close-link"><i class="fa fa-close"></i></a></li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <label><?php echo $message; ?></label>
                        <form method="post">
                            <fieldset>
                                <div class="form-group">
                                    Produit : <input class="form-control" placeholder="Produit" name="name" id="username" type="text"  >
                                </div>
                                <div class="form-group">
                                    Quantité : <input class="form-control" placeholder="Quantité" name="quantity" type="text" >
                                </div>
                                <div class="form-group">
                                    Unité de mesure :
                                    <select class="form-control">
                                        <option>Gr</option>
                                        <option>Kg</option>
                                        <option>Pcs</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    Prix unitaire : <input class="form-control" placeholder="Prix unitaire" name="prix_unit" type="text" >
                                </div>
                                <br/>
                                <input type="submit" name="buttonSubmit" value="Confirmer" class="btn btn-success" />
                                <div value="Nouveau produit" class="btn btn-info newProduct" >Nouveau produit</div>
                            </fieldset>
                        </form>
                    </div> <!-- /content -->
                </div><!-- /x-panel -->
            </div> <!-- /col -->
             <!-- /col -->
        </div> <!-- /row -->
        <div class="row" hidden data-id="12">
            <div class="col-md-6 col-sm-6 col-xs-6">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Produit</h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                            <li><a class="close-link"><i class="fa fa-close"></i></a></li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <label><?php echo $message; ?></label>
                        <form method="post">
                            <fieldset>
                                <div class="form-group">
                                    Produit : <input class="form-control" placeholder="Produit" name="name" id="username" type="text"  >
                                </div>
                                <div class="form-group">
                                    Quantité : <input class="form-control" placeholder="Quantité" name="quantity" type="text" >
                                </div>
                                <div class="form-group">
                                    Unité de mesure :
                                    <select class="form-control">
                                        <option>Gr</option>
                                        <option>Kg</option>
                                        <option>Pcs</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    Prix unitaire : <input class="form-control" placeholder="Prix unitaire" name="prix_unit" type="text" >
                                </div>
                                <br/>
                                <input type="submit" name="buttonSubmit" value="Confirmer" class="btn btn-success" />
                                <div value="Nouveau produit" class="btn btn-info newProduct" >Nouveau produit</div>
                            </fieldset>
                        </form>
                    </div> <!-- /content -->
                </div><!-- /x-panel -->
            </div><div class="col-md-6 col-sm-6 col-xs-6 right-product" hidden>
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Produit</h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                            <li><a class="close-link"><i class="fa fa-close"></i></a></li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <label><?php echo $message; ?></label>
                        <form method="post">
                            <fieldset>
                                <div class="form-group">
                                    Produit : <input class="form-control" placeholder="Produit" name="name" id="username" type="text"  >
                                </div>
                                <div class="form-group">
                                    Quantité : <input class="form-control" placeholder="Quantité" name="quantity" type="text" >
                                </div>
                                <div class="form-group">
                                    Unité de mesure :
                                    <select class="form-control">
                                        <option>Gr</option>
                                        <option>Kg</option>
                                        <option>Pcs</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    Prix unitaire : <input class="form-control" placeholder="Prix unitaire" name="prix_unit" type="text" >
                                </div>
                                <br/>
                                <input type="submit" name="buttonSubmit" value="Confirmer" class="btn btn-success" />
                                <div value="Nouveau produit" class="btn btn-info newProduct" >Nouveau produit</div>
                            </fieldset>
                        </form>
                    </div> <!-- /content -->
                </div><!-- /x-panel -->
            </div> <!-- /col -->
             <!-- /col -->
        </div> <!-- /row -->
        <div class="row" hidden data-id="13">
            <div class="col-md-6 col-sm-6 col-xs-6">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Produit</h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                            <li><a class="close-link"><i class="fa fa-close"></i></a></li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <label><?php echo $message; ?></label>
                        <form method="post">
                            <fieldset>
                                <div class="form-group">
                                    Produit : <input class="form-control" placeholder="Produit" name="name" id="username" type="text"  >
                                </div>
                                <div class="form-group">
                                    Quantité : <input class="form-control" placeholder="Quantité" name="quantity" type="text" >
                                </div>
                                <div class="form-group">
                                    Unité de mesure :
                                    <select class="form-control">
                                        <option>Gr</option>
                                        <option>Kg</option>
                                        <option>Pcs</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    Prix unitaire : <input class="form-control" placeholder="Prix unitaire" name="prix_unit" type="text" >
                                </div>
                                <br/>
                                <input type="submit" name="buttonSubmit" value="Confirmer" class="btn btn-success" />
                                <div value="Nouveau produit" class="btn btn-info newProduct" >Nouveau produit</div>
                            </fieldset>
                        </form>
                    </div> <!-- /content -->
                </div><!-- /x-panel -->
            </div><div class="col-md-6 col-sm-6 col-xs-6 right-product" hidden>
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Produit</h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                            <li><a class="close-link"><i class="fa fa-close"></i></a></li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <label><?php echo $message; ?></label>
                        <form method="post">
                            <fieldset>
                                <div class="form-group">
                                    Produit : <input class="form-control" placeholder="Produit" name="name" id="username" type="text"  >
                                </div>
                                <div class="form-group">
                                    Quantité : <input class="form-control" placeholder="Quantité" name="quantity" type="text" >
                                </div>
                                <div class="form-group">
                                    Unité de mesure :
                                    <select class="form-control">
                                        <option>Gr</option>
                                        <option>Kg</option>
                                        <option>Pcs</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    Prix unitaire : <input class="form-control" placeholder="Prix unitaire" name="prix_unit" type="text" >
                                </div>
                                <br/>
                                <input type="submit" name="buttonSubmit" value="Confirmer" class="btn btn-success" />
                                <div value="Nouveau produit" class="btn btn-info newProduct" >Nouveau produit</div>
                            </fieldset>
                        </form>
                    </div> <!-- /content -->
                </div><!-- /x-panel -->
            </div> <!-- /col -->
             <!-- /col -->
        </div> <!-- /row -->
        <div class="row" hidden data-id="14">
            <div class="col-md-6 col-sm-6 col-xs-6">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Produit</h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                            <li><a class="close-link"><i class="fa fa-close"></i></a></li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <label><?php echo $message; ?></label>
                        <form method="post">
                            <fieldset>
                                <div class="form-group">
                                    Produit : <input class="form-control" placeholder="Produit" name="name" id="username" type="text"  >
                                </div>
                                <div class="form-group">
                                    Quantité : <input class="form-control" placeholder="Quantité" name="quantity" type="text" >
                                </div>
                                <div class="form-group">
                                    Unité de mesure :
                                    <select class="form-control">
                                        <option>Gr</option>
                                        <option>Kg</option>
                                        <option>Pcs</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    Prix unitaire : <input class="form-control" placeholder="Prix unitaire" name="prix_unit" type="text" >
                                </div>
                                <br/>
                                <input type="submit" name="buttonSubmit" value="Confirmer" class="btn btn-success" />
                                <div value="Nouveau produit" class="btn btn-info newProduct" >Nouveau produit</div>
                            </fieldset>
                        </form>
                    </div> <!-- /content -->
                </div><!-- /x-panel -->
            </div><div class="col-md-6 col-sm-6 col-xs-6 right-product" hidden>
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Produit</h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                            <li><a class="close-link"><i class="fa fa-close"></i></a></li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <label><?php echo $message; ?></label>
                        <form method="post">
                            <fieldset>
                                <div class="form-group">
                                    Produit : <input class="form-control" placeholder="Produit" name="name" id="username" type="text"  >
                                </div>
                                <div class="form-group">
                                    Quantité : <input class="form-control" placeholder="Quantité" name="quantity" type="text" >
                                </div>
                                <div class="form-group">
                                    Unité de mesure :
                                    <select class="form-control">
                                        <option>Gr</option>
                                        <option>Kg</option>
                                        <option>Pcs</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    Prix unitaire : <input class="form-control" placeholder="Prix unitaire" name="prix_unit" type="text" >
                                </div>
                                <br/>
                                <input type="submit" name="buttonSubmit" value="Confirmer" class="btn btn-success" />
                                <div value="Nouveau produit" class="btn btn-info newProduct" >Nouveau produit</div>
                            </fieldset>
                        </form>
                    </div> <!-- /content -->
                </div><!-- /x-panel -->
            </div> <!-- /col -->
             <!-- /col -->
        </div> <!-- /row -->
        <div class="row" hidden data-id="15">
            <div class="col-md-6 col-sm-6 col-xs-6">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Produit</h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                            <li><a class="close-link"><i class="fa fa-close"></i></a></li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <label><?php echo $message; ?></label>
                        <form method="post">
                            <fieldset>
                                <div class="form-group">
                                    Produit : <input class="form-control" placeholder="Produit" name="name" id="username" type="text"  >
                                </div>
                                <div class="form-group">
                                    Quantité : <input class="form-control" placeholder="Quantité" name="quantity" type="text" >
                                </div>
                                <div class="form-group">
                                    Unité de mesure :
                                    <select class="form-control">
                                        <option>Gr</option>
                                        <option>Kg</option>
                                        <option>Pcs</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    Prix unitaire : <input class="form-control" placeholder="Prix unitaire" name="prix_unit" type="text" >
                                </div>
                                <br/>
                                <input type="submit" name="buttonSubmit" value="Confirmer" class="btn btn-success" />
                                <div value="Nouveau produit" class="btn btn-info newProduct" >Nouveau produit</div>
                            </fieldset>
                        </form>
                    </div> <!-- /content -->
                </div><!-- /x-panel -->
            </div><div class="col-md-6 col-sm-6 col-xs-6 right-product" hidden>
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Produit</h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                            <li><a class="close-link"><i class="fa fa-close"></i></a></li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <label><?php echo $message; ?></label>
                        <form method="post">
                            <fieldset>
                                <div class="form-group">
                                    Produit : <input class="form-control" placeholder="Produit" name="name" id="username" type="text"  >
                                </div>
                                <div class="form-group">
                                    Quantité : <input class="form-control" placeholder="Quantité" name="quantity" type="text" >
                                </div>
                                <div class="form-group">
                                    Unité de mesure :
                                    <select class="form-control">
                                        <option>Gr</option>
                                        <option>Kg</option>
                                        <option>Pcs</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    Prix unitaire : <input class="form-control" placeholder="Prix unitaire" name="prix_unit" type="text" >
                                </div>
                                <br/>
                                <input type="submit" name="buttonSubmit" value="Confirmer" class="btn btn-success" />
                                <div value="Nouveau produit" class="btn btn-info newProduct" >Nouveau produit</div>
                            </fieldset>
                        </form>
                    </div> <!-- /content -->
                </div><!-- /x-panel -->
            </div> <!-- /col -->
             <!-- /col -->
        </div> <!-- /row -->
        <div class="row" hidden data-id="16">
            <div class="col-md-6 col-sm-6 col-xs-6">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Produit</h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                            <li><a class="close-link"><i class="fa fa-close"></i></a></li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <label><?php echo $message; ?></label>
                        <form method="post">
                            <fieldset>
                                <div class="form-group">
                                    Produit : <input class="form-control" placeholder="Produit" name="name" id="username" type="text"  >
                                </div>
                                <div class="form-group">
                                    Quantité : <input class="form-control" placeholder="Quantité" name="quantity" type="text" >
                                </div>
                                <div class="form-group">
                                    Unité de mesure :
                                    <select class="form-control">
                                        <option>Gr</option>
                                        <option>Kg</option>
                                        <option>Pcs</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    Prix unitaire : <input class="form-control" placeholder="Prix unitaire" name="prix_unit" type="text" >
                                </div>
                                <br/>
                                <input type="submit" name="buttonSubmit" value="Confirmer" class="btn btn-success" />
                                <div value="Nouveau produit" class="btn btn-info newProduct" >Nouveau produit</div>
                            </fieldset>
                        </form>
                    </div> <!-- /content -->
                </div><!-- /x-panel -->
            </div><div class="col-md-6 col-sm-6 col-xs-6 right-product" hidden>
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Produit</h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                            <li><a class="close-link"><i class="fa fa-close"></i></a></li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <label><?php echo $message; ?></label>
                        <form method="post">
                            <fieldset>
                                <div class="form-group">
                                    Produit : <input class="form-control" placeholder="Produit" name="name" id="username" type="text"  >
                                </div>
                                <div class="form-group">
                                    Quantité : <input class="form-control" placeholder="Quantité" name="quantity" type="text" >
                                </div>
                                <div class="form-group">
                                    Unité de mesure :
                                    <select class="form-control">
                                        <option>Gr</option>
                                        <option>Kg</option>
                                        <option>Pcs</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    Prix unitaire : <input class="form-control" placeholder="Prix unitaire" name="prix_unit" type="text" >
                                </div>
                                <br/>
                                <input type="submit" name="buttonSubmit" value="Confirmer" class="btn btn-success" />
                                <div value="Nouveau produit" class="btn btn-info newProduct" >Nouveau produit</div>
                            </fieldset>
                        </form>
                    </div> <!-- /content -->
                </div><!-- /x-panel -->
            </div> <!-- /col -->
             <!-- /col -->
        </div> <!-- /row -->
        <div class="row" hidden data-id="17">
            <div class="col-md-6 col-sm-6 col-xs-6">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Produit</h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                            <li><a class="close-link"><i class="fa fa-close"></i></a></li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <label><?php echo $message; ?></label>
                        <form method="post">
                            <fieldset>
                                <div class="form-group">
                                    Produit : <input class="form-control" placeholder="Produit" name="name" id="username" type="text"  >
                                </div>
                                <div class="form-group">
                                    Quantité : <input class="form-control" placeholder="Quantité" name="quantity" type="text" >
                                </div>
                                <div class="form-group">
                                    Unité de mesure :
                                    <select class="form-control">
                                        <option>Gr</option>
                                        <option>Kg</option>
                                        <option>Pcs</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    Prix unitaire : <input class="form-control" placeholder="Prix unitaire" name="prix_unit" type="text" >
                                </div>
                                <br/>
                                <input type="submit" name="buttonSubmit" value="Confirmer" class="btn btn-success" />
                                <div value="Nouveau produit" class="btn btn-info newProduct" >Nouveau produit</div>
                            </fieldset>
                        </form>
                    </div> <!-- /content -->
                </div><!-- /x-panel -->
            </div><div class="col-md-6 col-sm-6 col-xs-6 right-product" hidden>
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Produit</h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                            <li><a class="close-link"><i class="fa fa-close"></i></a></li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <label><?php echo $message; ?></label>
                        <form method="post">
                            <fieldset>
                                <div class="form-group">
                                    Produit : <input class="form-control" placeholder="Produit" name="name" id="username" type="text"  >
                                </div>
                                <div class="form-group">
                                    Quantité : <input class="form-control" placeholder="Quantité" name="quantity" type="text" >
                                </div>
                                <div class="form-group">
                                    Unité de mesure :
                                    <select class="form-control">
                                        <option>Gr</option>
                                        <option>Kg</option>
                                        <option>Pcs</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    Prix unitaire : <input class="form-control" placeholder="Prix unitaire" name="prix_unit" type="text" >
                                </div>
                                <br/>
                                <input type="submit" name="buttonSubmit" value="Confirmer" class="btn btn-success" />
                                <div value="Nouveau produit" class="btn btn-info newProduct" >Nouveau produit</div>
                            </fieldset>
                        </form>
                    </div> <!-- /content -->
                </div><!-- /x-panel -->
            </div> <!-- /col -->
             <!-- /col -->
        </div> <!-- /row -->
        <div class="row" hidden data-id="18">
            <div class="col-md-6 col-sm-6 col-xs-6">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Produit</h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                            <li><a class="close-link"><i class="fa fa-close"></i></a></li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <label><?php echo $message; ?></label>
                        <form method="post">
                            <fieldset>
                                <div class="form-group">
                                    Produit : <input class="form-control" placeholder="Produit" name="name" id="username" type="text"  >
                                </div>
                                <div class="form-group">
                                    Quantité : <input class="form-control" placeholder="Quantité" name="quantity" type="text" >
                                </div>
                                <div class="form-group">
                                    Unité de mesure :
                                    <select class="form-control">
                                        <option>Gr</option>
                                        <option>Kg</option>
                                        <option>Pcs</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    Prix unitaire : <input class="form-control" placeholder="Prix unitaire" name="prix_unit" type="text" >
                                </div>
                                <br/>
                                <input type="submit" name="buttonSubmit" value="Confirmer" class="btn btn-success" />
                                <div value="Nouveau produit" class="btn btn-info newProduct" >Nouveau produit</div>
                            </fieldset>
                        </form>
                    </div> <!-- /content -->
                </div><!-- /x-panel -->
            </div><div class="col-md-6 col-sm-6 col-xs-6 right-product" hidden>
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Produit</h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                            <li><a class="close-link"><i class="fa fa-close"></i></a></li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <label><?php echo $message; ?></label>
                        <form method="post">
                            <fieldset>
                                <div class="form-group">
                                    Produit : <input class="form-control" placeholder="Produit" name="name" id="username" type="text"  >
                                </div>
                                <div class="form-group">
                                    Quantité : <input class="form-control" placeholder="Quantité" name="quantity" type="text" >
                                </div>
                                <div class="form-group">
                                    Unité de mesure :
                                    <select class="form-control">
                                        <option>Gr</option>
                                        <option>Kg</option>
                                        <option>Pcs</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    Prix unitaire : <input class="form-control" placeholder="Prix unitaire" name="prix_unit" type="text" >
                                </div>
                                <br/>
                                <input type="submit" name="buttonSubmit" value="Confirmer" class="btn btn-success" />
                                <div value="Nouveau produit" class="btn btn-info newProduct" >Nouveau produit</div>
                            </fieldset>
                        </form>
                    </div> <!-- /content -->
                </div><!-- /x-panel -->
            </div> <!-- /col -->
             <!-- /col -->
        </div> <!-- /row -->
        <div class="row" hidden data-id="19">
            <div class="col-md-6 col-sm-6 col-xs-6">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Produit</h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                            <li><a class="close-link"><i class="fa fa-close"></i></a></li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <label><?php echo $message; ?></label>
                        <form method="post">
                            <fieldset>
                                <div class="form-group">
                                    Produit : <input class="form-control" placeholder="Produit" name="name" id="username" type="text"  >
                                </div>
                                <div class="form-group">
                                    Quantité : <input class="form-control" placeholder="Quantité" name="quantity" type="text" >
                                </div>
                                <div class="form-group">
                                    Unité de mesure :
                                    <select class="form-control">
                                        <option>Gr</option>
                                        <option>Kg</option>
                                        <option>Pcs</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    Prix unitaire : <input class="form-control" placeholder="Prix unitaire" name="prix_unit" type="text" >
                                </div>
                                <br/>
                                <input type="submit" name="buttonSubmit" value="Confirmer" class="btn btn-success" />
                                <div value="Nouveau produit" class="btn btn-info newProduct" >Nouveau produit</div>
                            </fieldset>
                        </form>
                    </div> <!-- /content -->
                </div><!-- /x-panel -->
            </div><div class="col-md-6 col-sm-6 col-xs-6 right-product" hidden>
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Produit</h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                            <li><a class="close-link"><i class="fa fa-close"></i></a></li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <label><?php echo $message; ?></label>
                        <form method="post">
                            <fieldset>
                                <div class="form-group">
                                    Produit : <input class="form-control" placeholder="Produit" name="name" id="username" type="text"  >
                                </div>
                                <div class="form-group">
                                    Quantité : <input class="form-control" placeholder="Quantité" name="quantity" type="text" >
                                </div>
                                <div class="form-group">
                                    Unité de mesure :
                                    <select class="form-control">
                                        <option>Gr</option>
                                        <option>Kg</option>
                                        <option>Pcs</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    Prix unitaire : <input class="form-control" placeholder="Prix unitaire" name="prix_unit" type="text" >
                                </div>
                                <br/>
                                <input type="submit" name="buttonSubmit" value="Confirmer" class="btn btn-success" />
                                <div value="Nouveau produit" class="btn btn-info newProduct" >Nouveau produit</div>
                            </fieldset>
                        </form>
                    </div> <!-- /content -->
                </div><!-- /x-panel -->
            </div> <!-- /col -->
             <!-- /col -->
        </div> <!-- /row -->
        <div class="row" hidden data-id="20">
            <div class="col-md-6 col-sm-6 col-xs-6">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Produit</h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                            <li><a class="close-link"><i class="fa fa-close"></i></a></li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <label><?php echo $message; ?></label>
                        <form method="post">
                            <fieldset>
                                <div class="form-group">
                                    Produit : <input class="form-control" placeholder="Produit" name="name" id="username" type="text"  >
                                </div>
                                <div class="form-group">
                                    Quantité : <input class="form-control" placeholder="Quantité" name="quantity" type="text" >
                                </div>
                                <div class="form-group">
                                    Unité de mesure :
                                    <select class="form-control">
                                        <option>Gr</option>
                                        <option>Kg</option>
                                        <option>Pcs</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    Prix unitaire : <input class="form-control" placeholder="Prix unitaire" name="prix_unit" type="text" >
                                </div>
                                <br/>
                                <input type="submit" name="buttonSubmit" value="Confirmer" class="btn btn-success" />
                                <div value="Nouveau produit" class="btn btn-info newProduct" >Nouveau produit</div>
                            </fieldset>
                        </form>
                    </div> <!-- /content -->
                </div><!-- /x-panel -->
            </div><div class="col-md-6 col-sm-6 col-xs-6 right-product" hidden>
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Produit</h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                            <li><a class="close-link"><i class="fa fa-close"></i></a></li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <label><?php echo $message; ?></label>
                        <form method="post">
                            <fieldset>
                                <div class="form-group">
                                    Produit : <input class="form-control" placeholder="Produit" name="name" id="username" type="text"  >
                                </div>
                                <div class="form-group">
                                    Quantité : <input class="form-control" placeholder="Quantité" name="quantity" type="text" >
                                </div>
                                <div class="form-group">
                                    Unité de mesure :
                                    <select class="form-control">
                                        <option>Gr</option>
                                        <option>Kg</option>
                                        <option>Pcs</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    Prix unitaire : <input class="form-control" placeholder="Prix unitaire" name="prix_unit" type="text" >
                                </div>
                                <br/>
                                <input type="submit" name="buttonSubmit" value="Confirmer" class="btn btn-success" />
                                <div value="Nouveau produit" class="btn btn-info newProduct" >Nouveau produit</div>
                            </fieldset>
                        </form>
                    </div> <!-- /content -->
                </div><!-- /x-panel -->
            </div> <!-- /col -->
             <!-- /col -->
        </div> <!-- /row -->
        <input type="submit" name="buttonSubmit" value="Confirmer" class="btn btn-success"/>
    </div>
</div> <!-- /.col-right --> 
<!-- /page content -->

<?php $this->load->view('admin/partials/admin_footer'); ?>

<?php if($this->session->flashdata('message') != NULL) : ?>
<script>
    swal({
      title: "Success",
      text: "<?php echo $this->session->flashdata('message'); ?>",
      type: "success",
      timer: 1500,
      showConfirmButton: false
    });
</script>

<?php endif ?>

<script>

    $(document).ready(function () {
        var productSize=1;
        var productsList=[];
        $(".productSize").click(function () {
            productSize=$('input[name="productSize"]').val();
            if(productSize > 1){
                $('.right-product').fadeIn("slow");
            }
            if(productSize>2){
                $('.row[data-id=2]').fadeIn("slow");
            }

           // container.append(productContainer[0]);
        });
        $('input[name="buttonSubmit"]').on('click',function () {

            var size = Math.round(productSize/2);
            for (var i = 1; i <= size; i++) {

                var row = $('.row[data-id='+i+']');

                var name = row.find('.left-product input[name="name"]').val();
                var quantity = row.find('.left-product input[name="quantity"]').val();
                var unit = row.find('.left-product select[name="unit"]').val();
                var unit_price = row.find('.left-product input[name="unit_price"]').val();
                var product1 = {'name': name, 'quantity': quantity, 'unit': unit, 'unit_price': unit_price};
                name = row.find('.right-product input[name="name"]').val();
                quantity = row.find('.right-product input[name="quantity"]').val();
                unit = row.find('.right-product select[name="unit"]').val();
                unit_price = row.find('.right-product input[name="unit_price"]').val();
                var product2 = {'name': name, 'quantity': quantity, 'unit': unit, 'unit_price': unit_price};

                productsList.push(product1);
                productsList.push(product2);

            }
            $.ajax({
                url: "<?php echo base_url(); ?>admin/product/add",
                type: "POST",
                dataType: "json",
                data: {"productsList": productsList},
                success: function (data) {

                },
                error: function (data) {
                    // do something
                }
            });
            console.log(productsList);
            productsList = [];
        });
    });


</script>
