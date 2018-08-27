<?php $this->load->view('admin/partials/admin_header.php'); ?>
<!-- page content -->
<div class="right_col" role="main">
    <div class="productsList">
        <div class="page-title">
            <div class="title_left">
                <h3>Supprimer</h3>
            </div>
        </div>
        <div class="clearfix"></div>
        <hr>
        <div class="article-title">


            <?php echo form_open('admin/config/apiDelete'); ?>
            <div class="form-group">
                <label for="deletes">Select list:</label>
                <select multiple class="form-control" name="deletes[]" id="deletes" size="8">
                    <option value="employee" selected>Employés</option>
                    <option value="provider" selected>Fournisseur</option>
                    <option value="consumption" selected>Ventes</option>
                    <option value="order" selected>Commandes</option>
                    <option value="charges" selected>Achats</option>
                    <option value="history" selected>Historique d'achats</option>
                    <option value="product">Produits</option>
                    <option value="meal">Articles</option>
                </select>
            </div>
            <input type="submit" value="supprimer"/>
            <?php echo form_close(); ?>
        </div>


         <!-- /row -->

    </div>
</div>


<?php $this->load->view('admin/partials/admin_footer'); ?>




