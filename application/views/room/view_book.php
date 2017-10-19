
<?php $this->load->view('partials/admin_header.php'); ?>
<style>
    .plugHeader .address{
        font-weight: bold;
    }
    .plugHeader .title{
        text-align: center;
        font-weight: bold;
        font-size: 23px;
        margin: 5px 0px;
    }
    .arabTitle{
        float:right !important;
    }
</style>
<!-- page content -->

<div class="right_col" role="main">

    <div class="row">
        <div class="col-md-12">
                <div class="page-title">
                    <div class="title_left">
                        <h3>Nouvelle résevation</h3>
                    </div>
                    <div id="reportrange" class="pull-right"
                         style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc">
                        <i class="glyphicon glyphicon-calendar fa fa-calendar"></i>
                        <span>December 30, 2014 - January 28, 2015</span> <b class="caret"></b>
                    </div>
                </div>
                <!-- /row -->
        </div>

        <div class="row">
            <div class="col-md-6 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <div class="row">
                            <ul class="nav navbar-right panel_toolbox">
                                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                                <li><a class="close-link"><i class="fa fa-close"></i></a></li>
                            </ul>
                        </div>
                        <div class="plugHeader">
                            <div class="col-md-6"><h2>Hôtel Anjou</h2></div>
                            <div class="col-md-6"><h2 class="arabTitle">فندق أنجو</h2></div>
                            <div class="address text-center">
                               <div> 3, Rue Ibn Albanna (Ex.Dickens)</div>
                               <div> Tél. & Fax : 05 39 94 27 84</div>
                               <div> Tanger</div>
                            </div>
                            <div class="title">BULLETIN INDIVIDUEL D'HOTEL</div>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <form>
                            <div class="form-group">
                                <label for="prenom">Prénom</label>
                                <input type="text" class="form-control" id="firstName"
                                       aria-describedby="prenomHelp" placeholder="Enter le prénom">
                                <small id="prenomHelp" class="form-text text-muted">
                                    First Name - Nombre
                                </small>
                            </div>
                            <div class="form-group">
                                <label for="prenom">Nom</label>
                                <input type="text" class="form-control" id="lastName"
                                       aria-describedby="omHelp" placeholder="Enter le nom">
                                <small id="nomHelp" class="form-text text-muted">
                                    Name
                                </small>
                            </div><div class="form-group">
                                <label for="prenom">Date de naissance</label>
                                <input type="text" class="form-control" id="dateOfBirth"
                                       aria-describedby="dateOfBirthHelp" placeholder="Enter la date de naissance">
                                <small id="dateOfBirthHelp" class="form-text text-muted">
                                    date of birth
                                </small>
                            </div><div class="form-group">
                                <label for="prenom">Lieu de naissance</label>
                                <input type="text" class="form-control" id="placeOfBirth"
                                       aria-describedby="placeOfBirthHelp" placeholder="Enter le lieu de naissance">
                                <small id="placeOfBirthHelp" class="form-text text-muted">
                                    Place of birth
                                </small>
                            </div><div class="form-group">
                                <label for="prenom">Nationnalité</label>
                                <input type="text" class="form-control" id="nationality"
                                       aria-describedby="nationalityHelp" placeholder="Enter la nationalité">
                                <small id="nationalityHelp" class="form-text text-muted">
                                    Nationality
                                </small>
                            </div><div class="form-group">
                                <label for="prenom">Profession</label>
                                <input type="text" class="form-control" id="profession"
                                       aria-describedby="professionHelp" placeholder="Enter la profession">
                                <small id="professionHelp" class="form-text text-muted">
                                    Profession
                                </small>
                            </div>
                        </form>
                    </div> <!-- /content -->
                </div>
            </div>
            <div class="col-md-6 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <div class="row">
                            <ul class="nav navbar-right panel_toolbox">
                                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                                <li><a class="close-link"><i class="fa fa-close"></i></a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="x_content">
                        <form>
                            <div class="form-group">
                                <label for="prenom">N° de passeport</label>
                                <input type="text" class="form-control" id="passeportNumber"
                                       aria-describedby="passeportNumber" placeholder="Enter le numéro du passeport">
                            </div>
                            <div class="form-group">
                                <label for="prenom">N° d'entrée au Maroc</label>
                                <input type="text" class="form-control" id="inMoroccoNumber"
                                       aria-describedby="inMoroccoNumber" placeholder="Enter le N° d'entrée au Maroc">
                            </div>
                            <div class="form-group">
                                <label for="prenom">Date d'entrée</label>
                                <input type="text" class="form-control" id="inMoroccoDate"
                                       aria-describedby="inMoroccoDate" placeholder="Enter la date d'entrée">
                            </div>
                            <div class="form-group">
                                <label for="prenom">Lieu de province</label>
                                <input type="text" class="form-control" id="province"
                                       aria-describedby="province" placeholder="Enter le lieu de province">
                            </div>
                            <div class="form-group">
                                <label for="prenom">Destination</label>
                                <input type="text" class="form-control" id="destination"
                                       aria-describedby="destination" placeholder="Enter la destination">

                            </div>
                            <hr>
                            <hr>
                            <div class="form-group">
                                <label for="prenom">Domicil Habituel</label>
                                <input type="text" class="form-control" id="domicil"
                                       aria-describedby="domicil" placeholder="Enter le domicil Habituel">

                            </div>
                            <div class="form-group">
                                <label for="prenom">Nombre d'enfant mineurs accompaghant le client</label>
                                <input type="text" class="form-control" id="kidsNumber"
                                       aria-describedby="kidsNumber" placeholder="Enter la nombre d'enfant">
                            </div>
                        </form>
                    </div> <!-- /content -->
                </div>
            </div>
        </div>
        <button class="btn btn-success action" name="book">
            Réserver
        </button>
    </div>

</div>




<?php $this->load->view('partials/admin_footer'); ?>

<script>
    $('button[name="book"]').on('click', book);
    function book() {
        var client={
            'firstName':$('#firstName').val(),
            'lastName': $('#lastName').val(),
            'dateofbirth': $('#dateOfBirth').val(),
            'placeofbirth': $('#placeOfBirth').val(),
            'nationality': $('#nationality').val(),
            'profession': $('#profession').val(),
        };
        var myData={'book':{'room':<?php echo $roomNumber;?>,'client':client}};

        console.log(myData);
       $.ajax({
            type: 'POST',
            url: "<?php echo base_url('index.php/room/apiBook'); ?>",
            dataType: "json",
            data: myData,
            success: function (data) {
                if(data.status="success"){
                    swal({
                        title: "Success",
                        text: "La réservation a été bien effectuée",
                        type: "success",
                        timer: 1500,
                        showConfirmButton: false
                    });

                    window.location.href=data.redirect;
                }
            },
            error: function (data) {
                console.log("error");
                console.log(data);
            }
        });
    }
</script>


