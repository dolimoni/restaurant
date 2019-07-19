<style>
    .modal-footer {
        border-top: 0px solid #e5e5e5;
    }
    #tab_config_order .row{
        margin-bottom:10px;
    }
</style>
<div class="modal fade" id="editMarkModal" tabindex="-1" role="dialog"
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
                    <?= lang('new_order') ?>
                    Modifier la marque
                </h4>
            </div>

            <!-- Modal Body -->
            <div class="modal-body">
                <div class="" role="tabpanel" data-example-id="togglable-tabs-newOrder">
                    <div id="tab-newOrder" class="tab-content col-md-12 col-sm-12 col-xs-12" style="margin-bottom:20px">
                        <form id="editMarkForm">
                            <fieldset>
                                <div class="row">
                                    <input type="hidden" name="id"/>
                                    <div class="col-xs-12 col-sm-6 col-md-3">
                                        Nom de la marque :
                                        <input type="text" class="form-control" name="name"
                                               placeholder=""
                                               required>
                                    </div>
                                    <div class="col-xs-12 col-sm-6 col-md-3">
                                        <div class="form-group">
                                            <?= lang("unit_of_measure"); ?> :
                                            <select class="form-control" name="m_unit">
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
                                    </div>
                                    <div class="col-xs-12 col-sm-6 col-md-3">
                                        <?= lang("unit_price"); ?> :
                                        <input type="text" class="form-control" name="m_unit_price"
                                               placeholder="" value="<?php echo $product['unit_price']; ?>"
                                               required>
                                    </div>
                                    <div class="col-xs-12 col-sm-6 col-md-3">
                                        <?= lang("weightByUnit"); ?> en gr:
                                        <input type="text" class="form-control" name="m_weightByUnit"
                                               placeholder="" value="<?php echo $product['weightByUnit']; ?>"
                                               required>
                                    </div>
                                </div>
                                <div class="row text-right">
                                    <input class="btn btn-success" type="submit" name="editMark" value="Confirmer"/>
                                </div>
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Modal Footer -->
            <div class="modal-footer">
            </div>
        </div>
    </div>
</div>

