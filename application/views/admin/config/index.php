<?php $this->load->view('admin/partials/admin_header.php'); ?>
<!-- page content -->
<div class="right_col" role="main">
    <div class="productsList">
        <div class="page-title">
            <div class="title_left">
                <h3>Liste des achats</h3>
            </div>
        </div>
        <div class="clearfix"></div>
        <hr>


        <button class="btn btn-danger btn-xs action"
                onclick="window.location.href='<?php echo base_url("admin/config/delete"); ?>'"><span></span>Suppression</button>

         <!-- /row -->

    </div>
</div>


<?php $this->load->view('admin/partials/admin_footer'); ?>




