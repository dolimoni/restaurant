<!-- Theme style -->
<link rel="stylesheet" href="<?php echo base_url("assets/dist/css/AdminLTE.min.css"); ?>">

<?php $this->load->view('partials/admin_header.php'); ?>
<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
<!-- Ionicons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">


<link href="<?php echo base_url("assets/build/css/main.css"); ?>" rel="stylesheet">
<!-- page content -->

<div class="right_col" role="main">

    <div class="row">
        <div class="col-md-12">
            <div class="productsList">
                <div class="page-title">
                    <div class="title_left">
                        <h3>Détails de la chambre</h3>
                    </div>
                    <div id="reportrange" class="pull-right"
                         style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc">
                        <i class="glyphicon glyphicon-calendar fa fa-calendar"></i>
                        <span>December 30, 2014 - January 28, 2015</span> <b class="caret"></b>
                    </div>
                </div>
                <!-- /row -->
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-3 col-md-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-aqua">
                <div class="inner">
                    <h3>250DH</h3>

                    <p>Prix de location</p>
                </div>
                <div class="icon">
                    <i class="ion ion-bag"></i>
                </div>
                <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-md-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-green">
                <div class="inner">
                    <h3>2</h3>

                    <p>Nombre de lits</p>
                </div>
                <div class="icon">
                    <i class="ion ion-stats-bars"></i>
                </div>
                <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-md-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-yellow">
                <div class="inner">
                    <h3>Oui</h3>

                    <p>Anomalie</p>
                </div>
                <div class="icon">
                    <i class="ion ion-person-add"></i>
                </div>
                <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-md-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-red">
                <div class="inner">
                    <h3>Non</h3>

                    <p>Disponibilitée</p>
                </div>
                <div class="icon">
                    <i class="ion ion-pie-graph"></i>
                </div>
                <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <!-- ./col -->
    </div>

   <div>
       <button class="btn btn-success action"
               onclick="window.location.href='<?php echo base_url('index.php/room/book/' . $roomNumber );?>'"><span
                   class="fa fa-plus"></span> Nouvelle Réservation
       </button>
   </div>

    <div class="row">
        <div class="col-md-4 col-sm-4 col-xs-12 profile_details">
            <div class="well profile_view">
                <div class="col-sm-12">
                    <h4 class="brief"><i> Test1 </i></h4>
                    <div class="left col-xs-7">
                        <h2>Khalid ESSALHI</h2>
                        <p>CIN:BH95211</p>
                    </div>
                  <!--  <div class="right col-xs-5 text-center">
                        <img src="assets/images/itsMe.jpg" alt=""
                             class="img-circle img-responsive">
                    </div>-->
                    <div class="left col-xs-12">
                        <ul class="list-unstyled">
                            <li><i class="fa fa-building"></i> Adresse: Hay sadri Gr2
                            </li>
                            <li><i class="fa fa-phone"></i> Téléphone #: 06 56 01 18 27</li>
                        </ul>
                    </div>
                </div>
                <div class="col-xs-12 bottom text-center">
                    <div class="col-xs-12 col-sm-6 emphasis">
                        <p class="ratings">
                            <a>4.0</a>
                            <a href="#"><span class="fa fa-star"></span></a>
                            <a href="#"><span class="fa fa-star"></span></a>
                            <a href="#"><span class="fa fa-star"></span></a>
                            <a href="#"><span class="fa fa-star"></span></a>
                            <a href="#"><span class="fa fa-star-o"></span></a>
                        </p>
                    </div>
                    <div class="col-xs-12 col-sm-6 emphasis">
                        <button type="button" class="btn btn-primary btn-xs">
                            <i class="fa fa-print"> </i> Imprimer
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4 col-sm-4 col-xs-12 profile_details">
            <div class="well profile_view">
                <div class="col-sm-12">
                    <h4 class="brief"><i> Test1 </i></h4>
                    <div class="left col-xs-7">
                        <h2>Omar ABIDA</h2>
                        <p>CIN:BH95211</p>
                    </div>
                   <!-- <div class="right col-xs-5 text-center">
                        <img src="assets/images/itsMe.jpg" alt=""
                             class="img-circle img-responsive">
                    </div>-->
                    <div class="left col-xs-12">
                        <ul class="list-unstyled">
                            <li><i class="fa fa-building"></i> Adresse: Hay sadri Gr2
                            </li>
                            <li><i class="fa fa-phone"></i> Téléphone #: 06 56 01 18 27</li>
                        </ul>
                    </div>
                </div>
                <div class="col-xs-12 bottom text-center">
                    <div class="col-xs-12 col-sm-6 emphasis">
                        <p class="ratings">
                            <a>4.0</a>
                            <a href="#"><span class="fa fa-star"></span></a>
                            <a href="#"><span class="fa fa-star"></span></a>
                            <a href="#"><span class="fa fa-star"></span></a>
                            <a href="#"><span class="fa fa-star"></span></a>
                            <a href="#"><span class="fa fa-star-o"></span></a>
                        </p>
                    </div>
                    <div class="col-xs-12 col-sm-6 emphasis">
                        <button type="button" class="btn btn-primary btn-xs">
                            <i class="fa fa-print"> </i> Imprimer
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>




<?php $this->load->view('partials/admin_footer'); ?>

<script>
    $('button[name="view"]').on('click',view);
    function  view() {
        var myData={'room':$(this).attr('data-id')};
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url('admin/provider/add'); ?>",
            dataType: "json",
            data: myData,
            success: function (data) {
                console.log("success");
                console.log(data);
            },
            error: function (data) {
                console.log("error");
                console.log(data);
            }
        });
    }
</script>


