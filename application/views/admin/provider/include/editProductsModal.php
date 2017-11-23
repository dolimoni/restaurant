<div class="modal fade" id="editProductsModal" tabindex="-1" role="dialog"
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
                    Modifier le produit
                </h4>
            </div>

            <!-- Modal Body -->
            <div class="modal-body" style="padding-bottom: 40px;">
                <div class="formList">
                    <form class="form-horizontal" role="form" id="editProductProviderForm" data-id="1">

                        <input type="hidden"  name="id" />

                        <div class="form-group">
                            <label class="col-sm-2 control-label"
                                   for="name">Produit</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" name="name"
                                       id="name" placeholder="Nom"/>
                            </div>
                            <label class="col-sm-2 control-label"
                                   for="price">Prix</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" name="price"
                                       id="price" placeholder="Prix"/>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Modal Footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-default"
                        data-dismiss="modal">
                    Annuler
                </button>
                <button type="button" id="editProviderProducts" class="btn btn-primary">
                    Modifier
                </button>
            </div>
        </div>
    </div>
</div>
