<?php $this->load->view('admin/partials/admin_header.php'); ?>

<div class="right_col" role="main">
    <div class="">
        <div class="page-title">
            <div class="title_left">
                <h3>Ajouter une voiture</h3>
            </div>
        </div>
        <div class="clearfix"></div>

        <hr>

        <div class="row">
            <div class="col-md-8 col-md-offset-2">
            <div id="collapseExample">
            <?php echo validation_errors(); ?> 
			<?php echo form_open_multipart('admin/vehicles/add'); ?>
                <fieldset>
                    <div class="row">
                        <div class="col-xs-6">
                            <label>Marque</label>
                                <select class="form-control" name="manufacturer_id" id="parent_cat">
                                    {manufacturers}
                                        <option value="{id}">{manufacturer_name}</option>
                                    {/manufacturers}
                                </select>
                        </div>
                        <div class="col-xs-6">
                            <label>Modèle</label>
                            <select class="form-control" name="model_id" >
                                {models}
                                    <option value="{id}">{model_name}</option>
                                {/models}
                            </select>
                        </div>
                    </div>
                            
                    <br>
                        
                    <div class="row">
                        <!--<div class="col-xs-6">
                        <label>Vehicle Category</label>
                            <select class="form-control" name="category" >
                                <option value="Subcompact">Subcompact</option>
                                <option value="Compact">Compact</option>
                                <option value="Mid-size">Mid-size</option>
                                <option value="Full-size">Full-size</option>
                                <option value="Mini-Van">Mini-Van</option>
                            </select>
                        </div>-->
                        <div class="col-xs-6">
                            <br>
                            <input value="80000" type="number" step="any" class="form-control" name="b_price" placeholder="Prix d'achat" required>
                        </div>
                    </div>
                            
                    <br>
                    <div class="row">
                        <div class="col-xs-6">
                            <br>
                            <label for="gear">Vitesse:</label>
                            <select name="gear" id="gear" class="form-control">
                                <option value="auto">Auto</option>
                                <option value="manual">Manual</option>
                            </select>
                        </div>

                        <div class="col-xs-6">
                            <br>
                            <label for="gear">Immatriculation</label>
                            <input value="4215877" class="form-control" name="e_no" placeholder="Immatriculation" required>
                        </div>

                    </div>
                            
                    <br>
                    <div class="row">

                        <div class="col-xs-6">
                        <br>
                            <label for="mileage">Kilométrage:</label>
                            <input value="30000" type="text" step="any" class="form-control" name="mileage" placeholder="Kilométrage(km)" required>
                        </div>

                        <div class="col-xs-6">
                        <br>
                            <label for="mileage">Vidange:</label>
                            <input  value="40000" type="text" step="any" class="form-control" name="vidange" placeholder="Kilométrage(km)" required>
                        </div>
                       <!-- <div class="col-xs-6">
                            <br>
                            <input class="form-control" name="c_no" placeholder="Chassis Number" required>
                        </div>-->
                    </div>
                            
                    <br>
                        
                    <div class="row">
                        <div class="col-xs-6">
                            <label>Date d'ajout</label>
                            <input type="Date"class="form-control" name="add_date"  value="<?php echo date("Y-m-d"); ?>" >
                        </div>
                       <!-- <div class="col-xs-6">
                            <br>
                            <input type="number" class="form-control" name="doors" placeholder="No of Doors" required>
                        </div>-->
                    </div>
                            
                    <br>

                    <div class="row">
                        <div class="col-xs-6">
                            <br>
                            <input value="2015" type="number"class="form-control" name="registration_year" placeholder="Année-Modèle" required>
                        </div>
                        <div class="col-xs-6">
                            <br>
                            <input   value="5124" type="number" class="form-control" name="insurance_id" placeholder="Numéro d'assurance" required>
                        </div>
                    </div>
                            
                    <br>

                    <div class="row">
                        <div class="col-xs-6">
                            <input value="5" type="number"class="form-control" name="seats" placeholder="Nombre de places" required>
                        </div>
                        <div class="col-xs-6">
                            <input value="10" type="number" step="any" class="form-control" name="tank" placeholder="Capacité du réservoir(litres)" required>
                        </div>
                    </div>
                    <br>
                            
                    <div class="row">
                        <div class="col-xs-6">
                         <input value="noir" type="text"class="form-control" name="v_color" placeholder="Couleur" required>
                        </div>
                        <div class="col-xs-6">
                            <input type="file" class="form-control" name="image" >
                        </div>
                    </div>
<br>
                   <!-- <div class="row">
                        <div class="col-xs-6">
                        <label for="gear">Featured ?</label>
                            <select name="featured" id="featured" class="form-control">
                                <option value="0">No</option>
                                <option value="1">Yes</option>
                            </select>
                        </div>
                    </div>-->
                    <br>
                    <input class="btn btn-primary" type="submit" name="buttonSubmit" value="Ajouter la voiture" />
                                                            
                </fieldset>         
            </form>
            <br>
            </div>
        </div> <!-- /row --> 




    </div>
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