<style>
    .modal-footer {
        border-top: 0px solid #e5e5e5;
    }
    #tab_config_order .row{
        margin-bottom:10px;
    }
</style>
<div class="modal fade" id="addMagazinModal" tabindex="-1" role="dialog"
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
                    Nouveau
                </h4>
            </div>

            <!-- Modal Body -->
            <div class="modal-body">
                <div class="" role="tabpanel" data-example-id="togglable-tabs-newOrder">
                    <div id="tab-newOrder" class="tab-content col-md-12 col-sm-12 col-xs-12" style="margin-bottom:20px">
                        <form id="addMagazinForm">
                            <fieldset>
                                <div class="row">
                                    <div class="col-xs-8 col-sm-6 col-md-9">
                                        <input type="hidden" name="department" value="<?php  echo $department['id']; ?>"/>
                                        <input type="text" class="form-control" name="name"
                                               placeholder="Nom du magzin"
                                               required>
                                    </div>
                                    <div class="col-sm-6 col-md-3 col-xs-4">
                                        <input class="btn btn-success" type="submit" name="addEmployee" value="Confirmer"/>
                                    </div>
                                </div>
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Modal Footer -->
            <div class="modal-footer">
               <!-- <button type="button" class="btn btn-default small-button"
                        data-dismiss="modal">
                    <?/*= lang('cancele') */?>
                </button>
                <button type="button" class="btn btn-primary small-button" name="edit">
                    <?/*= lang('edit') */?>
                </button>-->
            </div>
        </div>
    </div>
</div>

