<div class="modal fade" id="addProductsModal" tabindex="-1" role="dialog"
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
                    Ajouter des produits
                </h4>
            </div>

            <!-- Modal Body -->
            <div class="modal-body" style="padding-bottom: 40px;">
                <div class="formList">
                    <form class="form-horizontal" role="form" id="addProductProviderForm" data-id="1">
                        <div class="form-group">
                            <label class="col-sm-2 control-label"
                                   for="inputEmail3">Produit</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" name="name"
                                       id="name" placeholder="Nom"/>
                            </div>
                            <label class="col-sm-2 control-label"
                                   for="inputPassword3">Prix</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" name="price"
                                       id="price" placeholder="Prix"/>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="col-md-12" style="text-align: right;">
                    <button type="button" class="btn btn-success btn-sm fa fa-plus"  onclick="addForm();"></button>
                </div>

            </div>

            <!-- Modal Footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-default"
                        data-dismiss="modal">
                    Annuler
                </button>
                <button type="button" id="saveProviderProducts" class="btn btn-primary">
                    Enregistrer
                </button>
            </div>
        </div>
    </div>
</div>
