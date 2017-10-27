<?php $this->load->view('admin/partials/admin_header.php'); ?>
<!-- page content -->
<div class="right_col" role="main">
    <div class="">
        <div class="page-title">
            <div class="title_left">
                <h3>Article</h3>
            </div>
        </div>
        <div class="clearfix"></div>
        <hr>
        <div class="row">
            <h1 class="text-center"><?php echo $meal['name']; ?></h1>
            <h2>Contenu</h2>
            <div class="col-md-12 col-sm-12 col-xs-12">
                <table class="table">
                    <thead class="thead-default">
                    <tr>
                        <th>Id</th>
                        <th>Produit</th>
                        <th>Quantité</th>
                        <th>Coût</th>
                    </tr>
                    </thead>
                    <tbody>
                    {products}
                    <tr>
                        <th scope="row">{id}</th>
                        <td>{name}</td>
                        <td>{name}</td>
                        <td>{unit_price}</td>
                    </tr>
                    {/products}
                    </tbody>
                </table>
                <div class="text-right">
                    <?php echo form_open('admin/meal/mypdf'); ?>
                    <input type="hidden" name="id" value="<?php echo $meal['id'];?>"/>
                    <button type="submit" class="btn btn-warning" >
                        <span class="fa fa-print"></span> Imprimer
                    </button>
                    <?php echo form_close(); ?>
                </div>
            </div> <!-- /col -->



        </div> <!-- /row --> 
    </div>
</div> <!-- /.col-right --> 
<!-- /page content -->

<?php $this->load->view('admin/partials/admin_footer'); ?>

<?php if($this->session->flashdata('message') != NULL) : ?>
<script>
    swal({
      title: "Success",
      text: "<?php echo $this->session->flashdata('message'); ?>",
      type: "success",
      timer: 1500,
      showConfirmButton: false
    });
</script>
<?php endif ?>