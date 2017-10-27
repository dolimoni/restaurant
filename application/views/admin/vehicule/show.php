<?php $this->load->view('admin/partials/admin_header.php'); ?>

<div class="right_col" id="show" role="main">
<!--<pre>
<?php /*print_r($vehicle); */?>
</pre>-->
    <div class="row">
        <div class="page-title">
            <div>
               <div class="row">
                    <div class="col-md-6">
                        <img  class="img-responsive" src="<?= base_url('uploads'); ?>/<?php echo $vehicle['image']; ?>">

                    </div>
                     <div class="col-md-6">
                         <h1><?php echo $vehicle['manufacturer_name']; ?>-<?php echo $vehicle['model_name']; ?></h1>
                         <div class="price"><?php echo $vehicle['buying_price']; ?> DH</div>
                         <div class="description"><h5><i>Description</i></h5></div>
                         <div class="description"><p><?php echo $vehicle['model_description']; ?></p></div>

                         <div class="description">Couleur : <?php echo $vehicle['color']; ?></div>

                         <div class="description">Vitesse :
                            <span <?php if( strtoupper($vehicle['gear'])==='AUTO')  {echo 'class="selected"'; }else{echo 'class="not-selected"';}?>>Manuel</span>
                            <span <?php if( strtoupper($vehicle['gear'])==='MANUEL'){echo 'class="selected"'; }else{echo 'class="not-selected"';}?>>Auto</span>
                         </div>
                         <div>Autres caractéristiques</div>
                         <table class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0">
                            <tr>
                                <th>Modèle</th>
                                <th>Numéro d'assurance</th>
                                <th>Nombre de places</th>
                                <th>Capacité du réservoir</th>
                            </tr>
                            <tr>
                                <td><?php echo $vehicle['registration_year']; ?></td>
                                <td><?php echo $vehicle['insurance_id']; ?></td>
                                <td><?php echo $vehicle['seats']; ?></td>
                                <td><?php echo $vehicle['tank']; ?></td>
                            </tr>
                        </table>
                        <div class="btn-group">
                        <?php if($vehicle['status']!=='loué'){ ?>
                          <form action="http://localhost/vsmsatp3/admin/vehicles/location" method="post" accept-charset="utf-8">
                                <input type="hidden" name="vehicle_id" value="<?php echo $vehicle['vehicle_id'];?>">
                                <button class="btn btn-info btn-success" type="submit" name="btn-sell">Location</button>
                          </form>
                          <?php } ?>
                          <button type="button" class="btn btn-info btn-primary">Modification</button>
                          <button type="button" class="btn btn-info btn-primary">Historique</button>
                          <button type="button" class="btn btn-info btn-primary">Maintenance</button>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="clearfix"></div>

        <hr>


</div> <!-- /.col-right -->
<!-- /page content -->

<?php $this->load->view('admin/partials/admin_footer.php'); ?>



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

    <script src="<?php echo base_url("assets/vendors/datatables.net/js/jquery.dataTables.min.js"); ?>"></script>
    <script src="<?php echo base_url("assets/vendors/datatables.net-bs/js/dataTables.bootstrap.min.js"); ?>"></script>
    <script src="<?php echo base_url("assets/vendors/datatables.net-buttons/js/dataTables.buttons.min.js"); ?>"></script>
    <script src="<?php echo base_url("assets/vendors/datatables.net-buttons-bs/js/buttons.bootstrap.min.js"); ?>"></script>
    <script src="<?php echo base_url("assets/vendors/datatables.net-buttons/js/buttons.flash.min.js"); ?>"></script>
    <script src="<?php echo base_url("assets/vendors/datatables.net-buttons/js/buttons.html5.min.js"); ?>"></script>
    <script src="<?php echo base_url("assets/vendors/datatables.net-buttons/js/buttons.print.min.js"); ?>"></script>
    <script src="<?php echo base_url("assets/vendors/datatables.net-fixedheader/js/dataTables.fixedHeader.min.js"); ?>"></script>
    <script src="<?php echo base_url("assets/vendors/datatables.net-keytable/js/dataTables.keyTable.min.js"); ?>"></script>
    <script src="<?php echo base_url("assets/vendors/datatables.net-responsive/js/dataTables.responsive.min.js"); ?>"></script>
    <script src="<?php echo base_url("assets/vendors/datatables.net-responsive-bs/js/responsive.bootstrap.js"); ?>"></script>
    <script src="<?php echo base_url("assets/vendors/datatables.net-scroller/js/datatables.scroller.min.js"); ?>"></script>
    <script src="<?php echo base_url("assets/vendors/jszip/dist/jszip.min.js"); ?>"></script>
    <script src="<?php echo base_url("assets/vendors/pdfmake/build/pdfmake.min.js"); ?>"></script>
    <script src="<?php echo base_url("assets/vendors/pdfmake/build/vfs_fonts.js"); ?>"></script>

    <script>
      $(document).ready(function() {
        var handleDataTableButtons = function() {
          if ($("#datatable-responsive").length) {
            $("#datatable-responsive").DataTable({
            aaSorting: [[0, 'desc']],

              dom: "Blfrtip",
              buttons: [
                {
                  extend: "copy",
                  className: "btn-sm",
				  exportOptions: {
                    columns: [ 0, 1, 2, 3, 4, 5, 6 ]
                }
                },
                {
                  extend: "csv",
                  className: "btn-sm",
				  exportOptions: {
                    columns: [ 0, 1, 2, 3, 4, 5, 6 ]
                }
                },
                {
                  extend: "excel",
                  className: "btn-sm",
				  exportOptions: {
                    columns: [ 0, 1, 2, 3, 4, 5, 6 ]
                }
                },
                {
                  extend: "pdf",
                  className: "btn-sm",
				  exportOptions: {
                    columns: [ 0, 1, 2, 3, 4, 5, 6 ]
                }
                },
                {
                  extend: "print",
                  className: "btn-sm",
				  exportOptions: {
                    columns: [ 0, 1, 2, 3, 4, 5, 6 ]
                }
                },
              ],
              responsive: true,
            });
          }
        };

        TableManageButtons = function() {
          "use strict";
          return {

            init: function() {
              handleDataTableButtons();
            }
          };
        }();

        TableManageButtons.init();
      });
    </script>
    <script type="text/javascript">
        $(document).ready(function() {

    $("#parent_cat").change(function() {
        $(this).after();
        $.get('<?php echo base_url(); ?>controller_vehicle/getsub/' + $(this).val(), function(data) {
            $("#sub_cat").html(data);
            $('#loader').slideUp(200, function() {
                $(this).remove();
            });
        });
    });

});
</script>

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