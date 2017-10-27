<?php $this->load->view('admin/partials/admin_header.php'); ?>
<!-- page content -->
<div class="right_col" role="main">

    <div class="">

        <?php echo validation_errors(); ?>
        <?php echo form_open('admin/vehicles/location'); ?>
        <div class="page-title">
            <div class="text-center">
                <h3>Contrat de location</h3>

                <div class="row">
                    <div class="col-md-6 col-sm-6 col-xs-6">
                       <div class="row">
                           <div class="col-md-3 col-sm-3 col-xs-3 text-right"><label>Marque</label></div>
                           <div class="col-md-6 col-sm-6 col-xs-6">
                               <input name="marque" type="text" value="<?php echo $vehicule['manufacturer_name']; ?>"
                                      class="form-control" placeholder="Marque">
                           </div>
                       </div>
                        <br/>

                        <div class="row">
                            <div class="col-md-3 col-sm-3 col-xs-3 text-right"><label>Immat</label></div>
                            <div class="col-md-6 col-sm-6 col-xs-6">
                                <input name="immat" type="text" value="<?php  ?>"
                                       class="form-control" placeholder="Immat">
                            </div>
                        </div>
                        <br/>

                        <div class="row">
                            <div class="col-md-3 col-sm-3 col-xs-3 text-right"><label>Kilométrage dép</label></div>
                            <div class="col-md-6 col-sm-6 col-xs-6">
                                <input name="mileage" type="text" value="<?php echo $vehicule['mileage']; ?>"
                                       class="form-control" placeholder="Kilométrage dép">
                            </div>
                        </div>
                        <br/>

                        <div class="row">
                            <div class="col-md-3 col-sm-3 col-xs-3 text-right"><label>Durée de location</label></div>
                            <div class="col-md-6 col-sm-6 col-xs-6">
                                <input name="duree" type="text" value="<?php echo set_value('cf_name'); ?>"
                                       class="form-control" placeholder="Durée de location">
                            </div>
                        </div>
                        <br/>
                    </div>
                    <div class="col-md-6 col-sm-6 col-xs-6">
                        <div class="row">
                            <div class="col-md-5 col-sm-5 col-xs-5 text-right"><label>Date et lieu de livraison</label></div>
                            <div class="col-md-6 col-sm-6 col-xs-6">
                                <input class="form-control" name="dl_livraison"
                                       value="<?php echo date("Y-m-d"); ?>">
                            </div>
                        </div>
                        <br/>

                        <div class="row">
                            <div class="col-md-5 col-sm-5 col-xs-5 text-right"><label>Date et lieu de reprise</label></div>
                            <div class="col-md-6 col-sm-6 col-xs-6">
                                <input class="form-control" name="dl_reprise"
                                       value="<?php echo date("Y-m-d"); ?>">
                            </div>
                        </div>
                        <br/>

                        <div class="row">
                            <div class="col-md-5 col-sm-5 col-xs-5 text-right"><label>Prolonger jusqu'au</label></div>
                            <div class="col-md-6 col-sm-6 col-xs-6">
                                <input type="date" class="form-control" name="prolonger"
                                       value="<?php echo date("Y-m-d"); ?>">
                            </div>
                        </div>
                        <br/>


                        <br/>
                    </div>
                </div>
            </div>
        </div>
        <div class="clearfix"></div>
        <hr>
        <div class="row">
            <div class="col-md-6 col-sm-6 col-xs-6">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Conducteur (1)</h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                            <li><a class="close-link"><i class="fa fa-close"></i></a></li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                            <fieldset>
                                <div class="row">
                                    <div class="col-xs-12">
                                        <input name="nom" value="essalhi" type="text"  class="form-control" placeholder="Nom" >
                                    </div>
                                </div>

                                <br>

                                <div class="row">
                                    <div class="col-xs-12">
                                        <input value="marocain" name="nationalitee" type="text"
                                               class="form-control" placeholder="Nationalitée">
                                    </div>
                                </div>
                                <br>
                                
                                <div class="row">
                                
                                    <div class="col-xs-12">
                                        <input value="11/10/1992" name="naissance" class="form-control"   placeholder="Né (e) le" >
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xs-12">
                                        <br>
                                        <input  class="form-control" name="adresse" placeholder="Adresse au Maroc" >
                                    </div><br>
                                </div><br>



                                <div class="row">
                                    <div class="col-xs-12">
                                        <input type="text" value="0656011827" class="form-control" name="mobile"   placeholder="Téléphone" >
                                    </div>
                                </div>
                                <br>

                                <div class="row">
                                    <div class="col-xs-12">
                                        <input type="text" class="form-control" value="*" name="adresseEtranger"   placeholder="Adresse a l'Etranger" >
                                    </div>
                                </div>
                                
                                <br>

                                <div class="row">
                                    <div class="col-xs-12">
                                        <input type="text" class="form-control" value="22222" name="permisNumber"   placeholder="Permis de conduire N°" >
                                    </div>
                                </div>

                                <br>

                                <div class="row">
                                    <div class="col-xs-2"><label>Délivré le:</label></div>
                                    <div class="col-xs-4">
                                        <input type="date" class="form-control" name="permisDelivrance">
                                    </div>
                                    <div class="col-xs-1"><label>A</label></div>
                                    <div class="col-xs-5">
                                        <input type="text" value="khalid" class="form-control" name="permisOwner"   placeholder="Nom" >
                                    </div>
                                </div>
                                <br/>

                                <div class="row">
                                    <div class="col-xs-12">
                                        <input value="1111" type="text" class="form-control" name="cin"
                                               
                                               placeholder="Passeport N° ou CIN">
                                    </div>
                                </div>
                                <br/>

                                <div class="row">
                                    <div class="col-xs-2"><label>Délivré le:</label></div>
                                    <div class="col-xs-4">
                                        <input type="date" class="form-control" name="cinDelivrance">
                                    </div>
                                    <div class="col-xs-1"><label>A</label></div>
                                    <div class="col-xs-5">
                                        <input value="essalhi" type="text" class="form-control" name="cinOwner"
                                                placeholder="Nom">
                                    </div>
                                </div>

                                <br>

                            </fieldset>
                        <br/>
                        <label><?php //echo $message; ?></label>
                                
                    </div> <!-- /content --> 
                </div>
            </div>
            <div class="col-md-6 col-sm-6 col-xs-6">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Conducteur (1)</h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                            <li><a class="close-link"><i class="fa fa-close"></i></a></li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <?php echo validation_errors(); ?>
                            <fieldset>
                                <div class="row">
                                    <div class="col-xs-12">
                                        <input name="nom2" type="text" class="form-control" placeholder="Nom">
                                    </div>
                                </div>

                                <br>

                                <div class="row">
                                    <div class="col-xs-12">
                                        <input name="nationalitee2" type="text"
                                               class="form-control" placeholder="Nationalitée">
                                    </div>
                                </div>
                                <br>

                                <div class="row">

                                    <div class="col-xs-12">
                                        <input name="naissance2" class="form-control" placeholder="Né (e) le">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xs-12">
                                        <br>
                                        <input class="form-control" name="adresse2" placeholder="Adresse au Maroc">
                                    </div>
                                    <br>
                                </div>
                                <br>


                                <div class="row">
                                    <div class="col-xs-12">
                                        <input type="text" class="form-control" name="mobile2" placeholder="Téléphone">
                                    </div>
                                </div>
                                <br>

                                <div class="row">
                                    <div class="col-xs-12">
                                        <input type="text" class="form-control" name="adresseEtranger2"
                                               placeholder="Adresse a l'Etranger">
                                    </div>
                                </div>

                                <br>

                                <div class="row">
                                    <div class="col-xs-12">
                                        <input type="text" class="form-control" name="permisNumber2"
                                               placeholder="Permis de conduire N°">
                                    </div>
                                </div>

                                <br>

                                <div class="row">
                                    <div class="col-xs-2"><label>Délivré le:</label></div>
                                    <div class="col-xs-4">
                                        <input type="date" class="form-control" name="permisDelivrance2">
                                    </div>
                                    <div class="col-xs-1"><label>A</label></div>
                                    <div class="col-xs-5">
                                        <input type="text" class="form-control" name="permisOwner2" placeholder="Nom">
                                    </div>
                                </div>
                                <br/>

                                <div class="row">
                                    <div class="col-xs-12">
                                        <input type="text" class="form-control" name="cin2"

                                               placeholder="Passeport N° ou CIN">
                                    </div>
                                </div>
                                <br/>

                                <div class="row">
                                    <div class="col-xs-2"><label>Délivré le:</label></div>
                                    <div class="col-xs-4">
                                        <input type="date" class="form-control" name="cinDelivrance2">
                                    </div>
                                    <div class="col-xs-1"><label>A</label></div>
                                    <div class="col-xs-5">
                                        <input type="text" class="form-control" name="cinOwner2"
                                               placeholder="Nom">
                                    </div>
                                </div>

                                <br>

                            </fieldset>
                        <br/>
                        <label><?php //echo $message; ?></label>

                    </div> <!-- /content -->
                </div>
            </div>
        </div> <!-- /row -->


        <div class="row">
            <div class="col-md-6 col-sm-6 col-xs-6">
                <div class="row">
                    <div class="col-md-2 col-sm-2 col-xs-2 text-left"><label>Avance</label></div>
                    <div class="col-md-6 col-sm-6 col-xs-6">
                        <input name="avance" type="number"
                               class="form-control" placeholder="Avance">
                    </div>
                </div>
                <br/>

                <div class="row">
                    <div class="col-md-2 col-sm-2 col-xs-2 text-left"><label>Reste</label></div>
                    <div class="col-md-6 col-sm-6 col-xs-6">
                        <input value="0" name="reste" type="number"
                               class="form-control" placeholder="Reste">
                    </div>
                </div>
                <br/>

                <div class="row">
                    <div class="col-md-2 col-sm-2 col-xs-2 text-left tva"><label>TVA 20%</label></div>
                    <div class="col-md-6 col-sm-6 col-xs-6">
                        <input name="tva" type="number"
                               class="form-control" placeholder="TVA 20%">
                    </div>
                </div>
                <br/>

                <div class="row">
                    <div class="col-md-2 col-sm-2 col-xs-2 text-left ttc"><label>Total T.T.C</label></div>
                    <div class="col-md-6 col-sm-6 col-xs-6">
                        <input name="ttc" type="number"
                               class="form-control" placeholder="Total T.T.C">
                    </div>
                </div>
                <br/>
            </div>
            <div class="col-md-6 col-sm-6 col-xs-6 text-right">
                <input type="hidden" name="vehicle_id" value="<?php if (isset($cid)) {
                    echo $cid;
                } ?> <?php echo $vehicule['vehicle_id']; ?>">
                <input type="submit" name="buttonSubmits" value="Confirmer" class="btn btn-success"/>
                </form>

            </div>
        </div>
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
