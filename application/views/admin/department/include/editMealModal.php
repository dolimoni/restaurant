<style>
    .modal-footer {
        border-top: 0px solid #e5e5e5;
    }
    #tab_config_order .row{
        margin-bottom:10px;
    }
    h4.plus{
        color: green;
    }
    h4.minus{
        color: red;
    }
</style>
<div class="modal fade" id="editMealHistoryModal" tabindex="-1" role="dialog"
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
                <h4 class="modal-title class="plus"" id="myModalLabel">
                    <?= lang('new_order') ?>
                    Modifier
                </h4>
            </div>

            <!-- Modal Body -->
            <div class="modal-body">

                <input type="hidden" name="id" value="1"/>
                <input type="hidden" name="quantity_id" value="1"/>
                <input type="hidden" name="quantityInMagazinNow" value="1"/>
                <input type="hidden" name="quantityToSaleNow" value="1"/>
                <input type="hidden" name="brokenQuantityNow" value="1"/>
                <input type="hidden" name="notSoldQuantityNow" value="1"/>
                <div class="" role="tabpanel" data-example-id="togglable-tabs-newOrder">
                    <div class="row" style="margin-bottom:20px">
                       <div class="col-xs-12 col-sm-4">
                           <label for="quantityToSale">Vente</label>
                           <input class="form-control" type="text" name="quantityToSale"/>
                       </div>
                        <div class="col-xs-12 col-sm-4">
                           <label for="brokenQuantity">Casse</label>
                           <input class="form-control" type="text" name="brokenQuantity"/>
                       </div>
                        <div class="col-xs-12 col-sm-4">
                            <label for="brokenQuantity">Non vendu</label>
                            <input class="form-control" type="text" name="notSoldQuantity"/>
                       </div>
                    </div>
                </div>
                <table class="table table-striped table-bordered">
                   <tr>
                       <th></th>
                       <th>Quantité acutelle</th>
                       <th>Max à ajouter</th>
                       <th>Max à retirer</th>
                   </tr>
                    <tr>
                        <td>Quantité en vente</td>
                        <td>0</td>
                        <td>0</td>
                        <td>0</td>
                   </tr>
                    <tr hidden>
                        <td>Quantité en stock</td>
                        <td>0</td>
                        <td>0</td>
                        <td>0</td>
                   </tr>
                    <tr>
                        <td>Quantité casse</td>
                        <td>0</td>
                        <td>0</td>
                        <td>0</td>
                   </tr>
                    <tr>
                        <td>Quantité non vendu</td>
                        <td>0</td>
                        <td>0</td>
                        <td>0</td>
                   </tr>
                </table>
            </div>

            <!-- Modal Footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-default small-button"
                        data-dismiss="modal">
                    <?= lang('cancele') ?>
                </button>
                <button type="button" class="btn btn-primary small-button" name="edit">
                    <?= lang('edit') ?>
                </button>
            </div>
        </div>
    </div>
</div>

