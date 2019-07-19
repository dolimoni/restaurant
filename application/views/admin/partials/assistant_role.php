

<?php if ($this->session->userdata('type') === "assistant") : ?>
    <li><a><i class="fa fa-shopping-cart"></i> Fournisseurs <span
                class="fa fa-chevron-down"></span></a>
        <ul class="nav child_menu">
            <li><a href="<?= base_url('admin/provider'); ?>">Liste des fournisseurs</a></li>
            <li><a href="<?= base_url('admin/provider/allOrders'); ?>">Mes commandes</a></li>
        </ul>
    </li>

    <li><a><i class="fa fa-coffee"></i> Gestion des produits <span class="fa fa-chevron-down"></span></a>
        <ul class="nav child_menu">
            <li><a href="<?= base_url('admin/product/add'); ?>">Ajouter des produits</a></li>
            <li><a href="<?= base_url('admin/product/addComposition'); ?>">Ajouter un produit composé</a></li>
            <li><a href="<?= base_url('admin/product/index'); ?>">Stock des produits</a></li>
            <li><a href="<?= base_url('admin/product/toOrder'); ?>">Produits à commander</a></li>
            <li><a href="<?= base_url('admin/product/inventory'); ?>">Inventaire</a></li>
        </ul>
    </li>

    <li><a><i class="fa fa-cutlery"></i> Gestion des articles <span class="fa fa-chevron-down"></span></a>
        <ul class="nav child_menu">
            <li><a href="<?= base_url('admin/meal/group'); ?>">Mes familles</a></li>
            <li><a href="<?= base_url('admin/Meal/add'); ?>">Ajouter un article</a></li>
            <li><a href="<?= base_url('admin/Meal/index'); ?>">Mes fiches techniques</a></li>
        </ul>
    </li>

    <li>
        <a><i class="fa fa-dollar"></i>Gestion des charges<span class="fa fa-chevron-down"></span></a>
        <ul class="nav child_menu">

            <li><a href="<?= base_url('admin/budget/regular'); ?>">Alertes</a></li>
            <li><a href="<?= base_url('admin/budget/reparation'); ?>">Mes réparations</a></li>
            <li><a href="<?= base_url('admin/budget/productPurchase'); ?>">Achats produits</a></li>
            <li><a href="<?= base_url('admin/budget/variousPurchase'); ?>">Achats divers</a>
            <li><a href="<?= base_url('admin/budget/fixedCharge'); ?>">Charge fixe</a>
        </ul>
    </li>

    <li>
        <a><i class="fa fa-refresh"></i>Synchorinisation<span class="fa fa-chevron-down"></span></a>
        <ul class="nav child_menu">
            <li><a href="<?= base_url('admin/Main/index'); ?>">Synchorinisation par fichier </a></li>
            <li><a href="<?= base_url('admin/Main/index2'); ?>">Synchorinisation manuelle</a></li>
        </ul>
    </li>

    <li>
        <a><i class="fa fa-exchange"></i>Gestion de transfert<span class="fa fa-chevron-down"></span></a>
        <ul class="nav child_menu">
            <li><a href="<?= base_url('admin/localAgency/index'); ?>">Mes agences</a></li>
            <li><a href="<?= base_url('admin/localAgency/addProducts'); ?>">Envoyer un stock</a></li>
            <li><a href="<?= base_url('admin/localAgency/historyProducts'); ?>">Historique</a></li>
        </ul>
    </li>


<?php endif; ?>


