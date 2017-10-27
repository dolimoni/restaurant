<div class="modal fade" id="quotationModal" tabindex="-1" role="dialog"
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
                    Ajouter un devis
                </h4>
            </div>

            <!-- Modal Body -->
            <div class="modal-body" style="padding-bottom: 40px;">
                <div class="infosQuotation">
                    <form class="form-horizontal">
                        <div class="form-group">
                            <input type="hidden" name="quotation_id" id="quotation_id"/>
                            <label class="col-sm-2 control-label"
                                   for="inputEmail3">N° Devis</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control"
                                       id="quotationNumber" placeholder="N° Devis"/>
                            </div>
                            <label class="col-sm-2 control-label"
                                   for="inputPassword3">Date de réception</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control"
                                       id="quotationDateReception" placeholder="Date de réception"/>
                            </div>
                        </div>
                    </form>
                </div>
                <hr/>
                <div class="formList">
                    <form class="form-horizontal addProviderQuotationForm" role="form"  data-id="1">
                        <div class="form-group">
                            <label class="col-sm-2 control-label"
                                   for="name">Produit</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control"
                                       id="name" name="name" placeholder="Nom"/>
                            </div>
                            <label class="col-sm-2 control-label"
                                   for="price">Prix</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control"
                                       id="price" name="price" placeholder="Prix"/>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="col-md-12" style="text-align: right;">
                    <button type="button" class="btn btn-success btn-sm fa fa-plus" onclick="addFormQuotation();"></button>
                </div>

            </div>

            <!-- Modal Footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-default"
                        data-dismiss="modal">
                    Annuler
                </button>
                <button type="button" id="applyProviderQuotation" class="btn btn-primary btn-warning">
                    Appliquer
                </button>
                <button type="button" id="saveProviderQuotation" class="btn btn-primary">
                    Enregistrer
                </button>
            </div>
        </div>
    </div>
</div>
