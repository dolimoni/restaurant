<?php $this->load->view('admin/partials/admin_header.php'); ?>
<!-- page content -->
<div class="right_col" role="main">
    <div class="productsList">
        <div class="page-title">
            <div class="title_left">
                <h3>Liste des familles</h3>
            </div>
        </div>
        <div class="clearfix"></div>
        <hr>
        <div class="article-title">
            <a class="btn btn-primary" data-toggle="collapse" href="#collapseExample" aria-expanded="false" aria-controls="collapseExample">Nouvelle famille</a>

            <button type="submit" class="btn btn-warning" name="Fichier"
                    onclick="window.location.href='<?php echo base_url('admin/meal/loadFileGroup/'); ?>'">
                <span class="fa fa-print"></span> Importer
            </button>
        </div>

        <div class="collapse" id="collapseExample">
            <?php echo validation_errors(); ?>
            <form id="addGroupForm" enctype="multipart/form-data">
                <fieldset>
                    <div class="row">
                        <div class="col-xs-6">
                            <br>
                            <label for="name">Nom :</label>
                            <input type="text" step="any" class="form-control" name="groupName" placeholder="Nom de la famille"
                                   required>
                        </div>

                        <div class="col-xs-6">
                            <br>
                            <label for="image">Image :</label>
                            <input type="file" class="form-control" name="image" size="10485760">
                        </div>
                    </div><br/>

                    <div class="text-right">
                        <input class="btn btn-success" type="submit" name="addGroup" value="Confirmer"/>
                    </div>

                </fieldset>
            </form>
            <br>
        </div>
        <div class="row">

            <?php foreach ($groups as $group) { ?>
            <a href="<?php echo base_url('admin/meal/groupMeals/'.$group['g_id']);?>">
                <div class="col-md-4 col-sm-4 col-xs-12">
                    <div class="well profile_view">
                        <div class="col-sm-12">
                            <h4 class="brief"><i><?php echo $group['g_name'] ?></i></h4>
                            <div class="left col-xs-7">
                                <p><strong>Nombre d'article: </strong><?php echo $group['groupCount'] ?> </p>
                                <ul class="list-unstyled">
                                    <li><i class="fa"></i>Prix moyen: <?php echo round($group['avg_price']) ?>DH</li>
                                </ul>
                            </div>
                            <div class="right col-xs-5 text-center">
                                <img src="<?php echo base_url(); ?>assets/images/<?php echo $group['image'] ?>" alt=""
                                     class="img-circle img-responsive">
                            </div>
                        </div>

                    </div>
                </div>
            </a>
            <?php } ?>
        </div> <!-- /row -->
    </div>
</div>


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

<script>

    $(document).ready(function () {
        $('#addGroupForm').on('submit', function (e) {
            e.preventDefault();
            var formData = new FormData(this);
            $.ajax({
                type: 'POST',
                url: "<?php echo base_url(); ?>admin/meal/group",
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: function (data) {
                    console.log("success");
                    console.log(data);
                },
                error: function (data) {
                    console.log("error");
                    console.log(data);
                }
            });

        });
    });

</script>
