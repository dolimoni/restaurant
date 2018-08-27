<?php $this->load->view('admin/partials/admin_header.php'); ?>
<!-- page content -->
<div class="right_col" role="main">
    <div class="">
        <div class="page-title">

            <div class="title_left">
                <h3><?= lang("article") ?></h3>
            </div>
        </div>
        <div class="clearfix"></div>
        <hr>
        <div class="row">
            <h1 class="text-center"><?= lang("technical_sheet") ?> : <?php echo $meal['name']; ?></h1>
            <h2><?= lang("content") ?></h2>
            <div class="col-md-12 col-sm-12 col-xs-12">
                <table class="table">
                    <thead class="thead-default">
                    <tr>
                       <!-- <th>Id</th>-->
                        <th><?= lang("product") ?></th>
                        <th><?= lang("quantity") ?></th>
                       <!-- <th>Coût</th>-->
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($products as $product){ ?>
                    <tr>
                        <!--<th scope="row">{id}</th>-->
                        <td><?php echo $product['name']?></td>
                        <td><?php echo $product['mp_quantity']*$meal['quantity']." ". $product['mp_unit']; ?></td>
                       <!-- <td>{unit_price}</td>-->
                    </tr>
                   <?php }?>
                    </tbody>
                </table>
                <div class="text-right">
                    <?php echo form_open('admin/meal/mypdf'); ?>
                    <input type="hidden" name="id" value="<?php echo $meal['id'];?>"/>
                    <button type="submit" class="btn btn-warning" >
                        <span class="fa fa-print"></span> <?= lang("print") ?>
                    </button>
                    <a href="<?php echo base_url('admin/meal/groupMeals/' . $meal['group']); ?>" class="btn btn-info" >
                        <?= lang("groupsArticle") ?>
                    </a>
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