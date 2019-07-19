<style>
    .modal-footer {
        border-top: 0px solid #e5e5e5;
    }
    #tab_config_order .row{
        margin-bottom:10px;
    }
</style>
<div class="modal fade" id="addInventoryModal" tabindex="-1" role="dialog"
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
                    Quantité final <span class="finalQuantityConvert"></span>
                </h4>
            </div>

            <!-- Modal Body -->
            <div class="modal-body">
                <div class="" role="tabpanel" data-example-id="togglable-tabs-newOrder">
                    <div id="tab-newOrder" class="tab-content col-md-12 col-sm-12 col-xs-12" style="margin-bottom:20px">
                        <form id="addInventoryForm">
                            <input type="hidden" name="inventory_m_unit">
                            <fieldset>
                                <div class="row">
                                    <div class="col-xs-4 col-sm-4 col-md-4">
                                        <label>Sans marque</label>
                                    </div>
                                    <div class="col-xs-4 col-sm-4 col-md-4">
                                        <input type="text" class="form-control" name="inventory_quantity"
                                               data-unit="<?php echo $product['unit'] ?>";
                                               data-m_unit_convert="1";
                                               placeholder="Quantity">
                                    </div>
                                    <div class="col-xs-2 col-sm-2 col-md-2">
                                        <label class="markQuantityLabled">0</label> <span><?php echo $product['unit'] ?></span>
                                    </div>
                                    <div class="col-xs-2 col-sm-2 col-md-2">
                                        <label class="markQuantityConvert">0</label> <span><?php echo $product['unit'] ?></span>
                                    </div>
                                </div>
                                <?php foreach ($marks as $mark) { ?>
                                    <div class="row">
                                        <div class="col-xs-4 col-sm-4 col-md-4">
                                           <label><?php echo $mark['name']; ?></label>
                                        </div>
                                        <div class="col-xs-4 col-sm-4 col-md-4">
                                            <input type="text" class="form-control" name="inventory_quantity"
                                                   data-unit="<?php echo $mark['m_unit'] ?>";
                                                   data-m_unit_convert="<?php echo $mark['m_unit_convert'] ?>";
                                                   placeholder="Quantity">
                                        </div>
                                        <div class="col-xs-2 col-sm-2 col-md-2">
                                            <label class="markQuantityLabled">0</label> <span><?php echo $mark['m_unit'] ?></span>
                                        </div>
                                        <div class="col-xs-2 col-sm-2 col-md-2">
                                            <label class="markQuantityConvert">0</label> <span><?php echo $product['unit'] ?></span>
                                        </div>
                                    </div>
                                <?php } ?>
                            </fieldset>
                            <div class="row text-right">
                                <input class="btn btn-success" type="submit" name="addInventory" value="Confirmer"/>
                            </div>
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

