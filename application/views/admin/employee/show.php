<?php $this->load->view('admin/partials/admin_header.php'); ?>
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.2.5/fullcalendar.min.css">
<!-- page content -->
<div class="right_col" role="main">
    <div class="productsList">
        <div class="page-title">
            <div class="title_left">
                <h3>Employée</h3>
            </div>
        </div>
        <div class="clearfix"></div>
        <hr>
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>User Report
                            <small>Activity report</small>
                        </h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                            </li>
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
                                   aria-expanded="false"><i class="fa fa-wrench"></i></a>
                                <ul class="dropdown-menu" role="menu">
                                    <li><a href="#">Settings 1</a>
                                    </li>
                                    <li><a href="#">Settings 2</a>
                                    </li>
                                </ul>
                            </li>
                            <li><a class="close-link"><i class="fa fa-close"></i></a>
                            </li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                       <div class="row">
                           <div class="col-md-3 col-sm-3 col-xs-12 profile_left">
                               <div class="profile_img">
                                   <div id="crop-avatar">
                                       <!-- Current avatar -->
                                       <img class="img-responsive avatar-view"
                                            src="<?php echo base_url(); ?>assets/images/itsMe.jpg" alt="Avatar"
                                            title="Change the avatar">
                                   </div>
                               </div>
                               <h3><span class="provider-firstName">Khalid</span> <span class="provider-lastName">ESSALHI</span>
                               </h3>
                               <input type="hidden" value="1" id="provider_id"
                                      data-id="<?php echo $provider['id']; ?>"/>
                               <ul class="list-unstyled user_data">
                                   <li><i class="fa fa-map-marker user-profile-icon"></i><span class="provider-address">Hay sadri, gr 2, rue 38, n 24, Casa</span>
                                   </li>

                                   <li>
                                       <i class="fa fa-briefcase user-profile-icon"> Fournisseur produits</i>
                                   </li>

                                   <li>
                                       <i class="fa fa-phone provider-phone"> 06 56 01 18 27</i>
                                   </li>

                                   <li class="m-top-xs">
                                       <i class="fa fa-external-link user-profile-icon"></i>
                                       <a href="http://www.google.com" target="_blank">www.dolimoni.com</a>
                                   </li>
                               </ul>

                               <a class="btn btn-success"><i class="fa fa-edit m-right-xs"></i>Edit Profile</a>
                               <br/>

                           </div>
                           <div class="col-md-9 col-sm-9 col-xs-12">

                               <div class="profile_title">
                                   <div class="col-md-12">
                                       <div class="x_panel">
                                           <div class="x_title">
                                               <h2>User Activity Report</h2>
                                               <ul class="nav navbar-right panel_toolbox">
                                                   <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                                   </li>
                                                   <li class="dropdown">
                                                       <a href="#" class="dropdown-toggle" data-toggle="dropdown"
                                                          role="button"
                                                          aria-expanded="false"><i class="fa fa-wrench"></i></a>
                                                       <ul class="dropdown-menu" role="menu">
                                                           <li><a href="#">Settings 1</a>
                                                           </li>
                                                           <li><a href="#">Settings 2</a>
                                                           </li>
                                                       </ul>
                                                   </li>
                                                   <li><a class="close-link"><i class="fa fa-close"></i></a>
                                                   </li>
                                               </ul>
                                               <div class="clearfix"></div>
                                           </div>
                                           <div class="x_content">

                                               <div class="row">
                                                   <div class="col-md-12">
                                                       <header>
                                                           <h5>Calendar</h5>
                                                       </header>
                                                       <div id="calendar_content" class="body">
                                                           <div id='calendar'></div>
                                                       </div>
                                                   </div>
                                               </div>

                                           </div>
                                       </div>
                                   </div>
                                   <!--<div id="reportrange" class="pull-right"
                                        style="margin-top: 5px; background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #E6E9ED">
                                       <i class="glyphicon glyphicon-calendar fa fa-calendar"></i>
                                       <span>December 30, 2014 - January 28, 2015</span> <b class="caret"></b>
                                   </div>-->

                               </div>
                           </div>
                       </div>
                        <div class="row">
                            <table id="datatable-responsive"
                                   class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0"
                                   width="100%">
                                <thead>
                                <tr>
                                    <th>Salaire</th>
                                    <th>Avance</th>
                                    <th>Reste<br></th>
                                    <th>Date de paiement<br></th>
                                    <th>Absences</th>
                                </tr>
                                </thead>
                                <tfoot>
                                <tr>
                                    <th>Salaire</th>
                                    <th>Avance</th>
                                    <th>Reste<br></th>
                                    <th>Date de paiement<br></th>
                                    <th>Absences</th>
                                </tr>
                                </tfoot>
                                <tbody>
                                <tr>
                                    <td>3000 DH</td>
                                    <td>0 DH</td>
                                    <td>3000 DH</td>
                                    <td>0</td>
                                    <td>01/10/2017</td>
                                </tr>
                                <tr>
                                    <td>2800 DH</td>
                                    <td>500 DH</td>
                                    <td>2300 DH</td>
                                    <td>1</td>
                                    <td>01/09/2017</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>


    </div>
</div>


<?php $this->load->view('admin/partials/admin_footer'); ?>

<?php if ($this->session->flashdata('message') != NULL) : ?>
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
        $('#addProviderForm').on('submit', function (e) {
            e.preventDefault();
            var formData = new FormData(this);
            $.ajax({
                type: 'POST',
                url: "<?php echo base_url(); ?>admin/provider/add",
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


<!-- NProgress -->
<script src="<?php echo base_url('assets/vendors/bootstrap-progressbar/bootstrap-progressbar.min.js'); ?>"></script>

<!-- bootstrap-wysiwyg -->
<script src="<?php echo base_url('assets/vendors/bootstrap-wysiwyg/js/bootstrap-wysiwyg.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/vendors//jquery.hotkeys/jquery.hotkeys.js'); ?>"></script>
<script src="<?php echo base_url('assets/vendors/google-code-prettify/src/prettify.js'); ?>"></script>

<!-- ECharts -->

<script src="<?php echo base_url('assets/vendors/echarts/dist/echarts.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/build2/js/custom.js'); ?>"></script>

<script src="<?php echo base_url('assets/vendors/moment/min/moment.min.js'); ?>"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.2/jquery-ui.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.2.5/fullcalendar.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery-sparklines/2.1.2/jquery.sparkline.min.js"></script>


<script src="<?php echo base_url('assets/vendors/metis/assets/lib/metismenu/metisMenu.js'); ?>"></script>
<script src="<?php echo base_url('assets/vendors/metis/assets/js/core.js'); ?>"></script>
<script src="<?php echo base_url('assets/vendors/metis/assets/js/app.js'); ?>"></script>

<script>
    $(function () {
        Metis.dashboard();
    });
</script>

<script>

    var productsCount=1;
    var productsQuotationCount=1;

    function addForm(){
        productsCount++;
        var form = $('#addProductProviderForm').clone().attr('data-id', productsCount);
        $('#addProductsModal .formList').append(form);
    }
    function addFormQuotation(){
        productsQuotationCount++;
        var form = $('#addProductProviderForm').clone().attr('data-id', productsCount);
        $('#quotationModal .formList').append(form);
    }

    //adding new products for provider
    $('#saveProviderProducts').on('click', {'p_productsCount': productsCount,'p_quotation':false}, saveProviderPoducts);
    $('#saveProviderQuotation').on('click', {'p_productsCount': productsQuotationCount,'p_quotation':true}, saveProviderPoducts);

    function saveProviderPoducts(event){
        var productsList = [];
        var provider = $('#provider_id').attr('data-id');
        var quotation_id = $('#quotation_id').val();
        var p_productsCount= productsCount;

        for (i = 1; i <= productsQuotationCount; i++) {
            var product = '';
            var form = $('form[data-id=' + i + ']');
            if(event.data.p_quotation){
                form=$('.addProviderQuotationForm[data-id=' + i + ']');
            }
            var name = form.find('#name').val();
            var price = form.find('#price').val();

            product = {"provider": provider, "name": name, "price": price, 'quotation': quotation_id};
            productsList.push(product);
        }
        console.log(productsList);
        $.ajax({
            url: "<?php echo base_url(); ?>admin/provider/apiAddProducts",
            type: "POST",
            dataType: "json",
            data: {'productsList': productsList},
            success: function (data) {
                if (data.status === true) {
                    console.log('Les produits ont été bien ajouté');
                }
                else {
                    console.log('Error');
                }
            },
            error: function (data) {
            }
        })
    }

    //adding new order

    $('button[name=print]').on('click', {url: "admin/provider/apiPrintOrder"}, newOrder);

    $("input[type='text']").keyup(calulProductPrice);

    function calulProductPrice() {
        var row = $(this).closest('.row');
        var quantity   = parseFloat(row.find('input[name="quantity"]').val().replace(',', '.'));
        var unit_price = parseFloat(row.find('input[name="product"]').attr('data-price').replace(',', '.'));
        if(quantity>0){
            row.find('.productCost').html(quantity * unit_price + 'DH');
        }else{
            row.find('.productCost').html(' 0DH');
        }

    };

    $('button[name="save"]').on('click', {url: "admin/provider/order"}, newOrder);

    function newOrder(event) {
            var productsList = [];
            var underTotal = 0;
            var productsCount = $('#productsOrder > .row').length;
            for (var i = 0; i < productsCount; i++) {
                var row = $('.product[data-index=' + i + ']');
                var quantity = parseFloat(row.find('input[name="quantity"]').val().replace(',', '.'));
                var id = row.find('input[name="product"]').attr('data-id');
                var name = row.find('input[name="product"]').attr('data-name');
                var unit_price = parseFloat(row.find('input[name="product"]').attr('data-price').replace(',', '.'));

                if (quantity > 0 && unit_price > 0) {
                    underTotal += quantity * unit_price;
                    var product = {'id': id, 'name': name, 'quantity': quantity, 'unit_price': unit_price, 'unit': '-'};
                    productsList.push(product);
                }

            }

            var order = {
                'productsList': productsList,
                'provider': {
                    'firstName': $('.provider-firstName').text(),
                    'lastName': $('.provider-lastName').text(),
                    'address': $('.provider-address').text(),
                    'phone': $('.provider-phone').text(),
                },
                'underTotal': underTotal,
                'tva': 0.2,
                'shipping': '-',
                'other': '-'
            };

            $.ajax({
                url: "<?php echo base_url(); ?>"+ event.data.url,
                type: "POST",
                dataType: "json",
                data: {'order': order},
                success: function (data) {
                    if (data.status === true) {

                        console.log('ok');
                        window.open("<?=site_url()?>" + data.filepath);
                    }
                    else {
                        console.log('ko');
                    }

                },
                error: function (data) {
                    // do something
                }
            });



    }
</script>



