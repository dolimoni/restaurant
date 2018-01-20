<?php $this->load->view('admin/partials/admin_header.php'); ?>
<style>

    /* Tabs container */
    .r-tabs {
        position: relative;

        background-color: #3c8dbc;

        border-top: 1px solid #3c8dbc;
        border-right: 1px solid #3c8dbc;
        border-left: 1px solid #3c8dbc;
        border-bottom: 4px solid #3c8dbc;
        border-radius: 4px;

    }

    /* Tab element */
    .r-tabs .r-tabs-nav .r-tabs-tab {
        position: relative;
        background-color: #3c8dbc;
    }

    /* Tab anchor */
    .r-tabs .r-tabs-nav .r-tabs-anchor {
        display: inline-block;
        padding: 10px 12px;

        text-decoration: none;
        text-shadow: 0 1px rgba(0, 0, 0, 0.4);
        font-size: 14px;
        font-weight: bold;
        color: #fff;
    }

    /* Disabled tab */
    .r-tabs .r-tabs-nav .r-tabs-state-disabled {
        opacity: 0.5;
    }

    /* Active state tab anchor */
    .r-tabs .r-tabs-nav .r-tabs-state-active .r-tabs-anchor {
        color: #3c8dbc;
        text-shadow: none;

        background-color: white;

        border-top-right-radius: 4px;
        border-top-left-radius: 4px;
    }

    /* Tab panel */
    .r-tabs .r-tabs-panel {
        background-color: white;

        border-bottom: 4px solid white;

        border-bottom-right-radius: 4px;
        border-bottom-left-radius: 4px;

    }

    /* Accordion anchor */
    .r-tabs .r-tabs-accordion-title .r-tabs-anchor {
        display: block;
        padding: 10px;

        background-color: #3c8dbc;
        color: #fff;
        font-weight: bold;
        text-decoration: none;
        text-shadow: 0 1px rgba(0, 0, 0, 0.4);
        font-size: 14px;

        border-top-right-radius: 4px;
        border-top-left-radius: 4px;
    }

    /* Active accordion anchor */
    .r-tabs .r-tabs-accordion-title.r-tabs-state-active .r-tabs-anchor {
        background-color: #fff;
        color: #3c8dbc;
        text-shadow: none;
    }

    /* Disabled accordion button */
    .r-tabs .r-tabs-accordion-title.r-tabs-state-disabled {
        opacity: 0.5;
    }

    .r-tabs .r-tabs-nav {
        margin: 0;
        padding: 0;
    }

    .r-tabs .r-tabs-tab {
        display: inline-block;
        margin: 0;
        list-style: none;
    }

    .r-tabs .r-tabs-panel {
        padding: 15px;
        display: none;
    }

    .r-tabs .r-tabs-accordion-title {
        display: none;
    }

    .r-tabs .r-tabs-panel.r-tabs-state-active {
        display: block;
    }

    /* Accordion responsive breakpoint */
    @media only screen and (max-width: 768px) {
        .r-tabs .r-tabs-nav {
            display: none;
        }

        .r-tabs .r-tabs-accordion-title {
            display: block;
        }
    }

</style>
<link href="<?php echo base_url("assets/build/css/main.css"); ?>" rel="stylesheet">
<!-- page content -->
<div class="right_col" role="main">
    <div class="productsList">
        <div class="page-title">
            <div class="title_left">
                <h3>Configuration générale</h3>
            </div>
        </div>
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">

                </div>
                <div class="x_content">
                    <div id="responsiveTabsDemo" class="r-tabs">
                        <ul class="r-tabs-nav">
                            <li class="r-tabs-tab r-tabs-state-active"><a href="#tab-1" class="r-tabs-anchor">
                                    Détails </a>
                            </li>
                            <!-- <li class="r-tabs-tab r-tabs-state-default"><a href="#tab-3" class="r-tabs-anchor">
                                     Factures</a>
                             </li>-->
                        </ul>

                        <div class="r-tabs-accordion-title r-tabs-state-active"><a href="#tab-1" class="r-tabs-anchor">
                                Détails </a></div>
                        <div id="tab-1" class="r-tabs-panel r-tabs-state-active" style="display: block;">
                            <div class="row">
                                <div class="col-md-6 col-sm-8 col-xs-12">
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <label>Nom</label>
                                            </div>
                                            <div class="col-md-8">
                                                <?php echo $user['last_name']; ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <label>Prénom</label>
                                            </div>
                                            <div class="col-md-8">
                                                <?php echo $user['first_name']; ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <label>Téléphone</label>
                                            </div>
                                            <div class="col-md-8">
                                                <?php echo $user['mobile']; ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <label>email</label>
                                            </div>
                                            <div class="col-md-8">
                                                <?php echo $user['email']; ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <label>adresse</label>
                                            </div>
                                            <div class="col-md-8">
                                                <?php echo $user['address']; ?>
                                            </div>
                                        </div>
                                    </div>
                                    <button class="btn btn-info btn-xs action"
                                            onclick="window.location.href='<?php echo base_url("admin/config/editUser"); ?>'">
                                        <span></span>Modifier
                                    </button>
                                </div>
                                <div class="col-md-6 col-sm-4 col-xs-12">
                                    <img src="<?= base_url('assets/images/' . $params['photo']); ?>" alt="icon">
                                </div>
                            </div>
                        </div>
                    </div>
                </div> <!-- /content -->
            </div><!-- /x-panel -->
        </div>
    </div>
</div>

<div class="modal fade" id="invoice3" tabindex="-1" role="dialog" aria-labelledby="editlabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content ff">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">×</span></button>
                <h4 class="modal-title" id="editlabel">Facture </h4>
            </div>
            <div class="modal-body">
                <div class="box-body">

                    <section class="content invoice">
                        <table width="100%" border="0" id="print_inv3" class="bd">
                            <tbody>
                            <tr>
                                <td>
                                    <table width="100%" style="border-bottom:1px solid #CCCCCC; padding-bottom:20px;">
                                        <tbody>
                                        <tr>
                                            <td align="left">
                                                <b>Hôtel Anjou</b><br>
                                                3, Rue Ibn Albanna (Ex.Dickens) Tanger<br>
                                                Tél. & Fax : 05 39 94 27 84<br>
                                                C.N.S.S. : 83296<br>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <table width="100%" border="0"
                                           style="border-bottom:1px solid #CCCCCC; padding-bottom:30px;">
                                        <tbody>
                                        <tr>
                                            <td align="left" width="45%">
                                                Facturé A :
                                                <address class="invoiceBill_to">
                                                </address>
                                            </td>
                                            <td width="10%"></td>
                                            <td align="right" width="45%" colspan="1">
                                                <address>
                                                    Chambre N°
                                                    <br>
                                                    <span class="invoiceRoomNumber"></span>
                                                </address>

                                            </td>

                                        </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <table width="100%" style="border:1px solid #CCCCCC;">
                                        <tbody>
                                        <tr>

                                            <td style="border-bottom:1px solid #CCCCCC; border-right:1px solid #CCCCCC"
                                                width="75%" align="left">Détails
                                            </td>
                                            <td style="border-bottom:1px solid #CCCCCC;" width="25%">Montant</td>
                                        </tr>
                                        <tr>
                                            <td width="75%" style="border-right:1px solid #CCCCCC">Chambre</td>
                                            <td width="25%" class="invoiceRoomPrice"></td>

                                        </tr>
                                        <tr>
                                            <td width="75%" style="border-right:1px solid #CCCCCC">Réduction</td>
                                            <td width="25%" class="invoiceDiscount">50.00</td>
                                        </tr>
                                        <tr>
                                            <td width="75%" style="border-right:1px solid #CCCCCC">Date : du <span
                                                        class="invoiceFromDate"></span> au <span
                                                        class="invoiceToDate"></span></td>
                                            <td width="25%">-</td>
                                        </tr>
                                        <tr>
                                            <td width="75%" style="border-right:1px solid #CCCCCC">Prix total</td>
                                            <td width="25%"><b class="invoiceTotalPrice"></b></td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                        <div class="row no-print" style="padding-top:10px;">
                            <div class="col-xs-12">
                                <button class="btn btn-default no-print" onclick="printData3()"><i
                                            class="fa fa-print"></i> Print
                                </button>

                                <a href="#"
                                   class="btn btn-primary pull-right hide" style="margin-right: 5px;"><i
                                            class="fa fa-download"></i> </a>
                                <a href="#"
                                   class="btn btn-primary pull-right hide" style="margin-right: 5px;"><i
                                            class="fa fa-mail-forward"></i> </a>
                            </div>
                        </div>


                    </section>


                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<?php $this->load->view('admin/partials/admin_footer'); ?>
<script src="<?php echo base_url('assets\vendors\datatables.net\js\jquery.dataTables.js'); ?>"></script>
<script>
    $(document).ready(function () {
        var handleDataTableButtons = function () {
            if ($("#datatable-responsive").length) {
                $("#datatable-responsive").DataTable({
                    aaSorting: [[0, 'desc']],
                    responsive: true,
                });
            }
        };

        TableManageButtons = function () {
            "use strict";
            return {

                init: function () {
                    handleDataTableButtons();
                }
            };
        }();

        //TableManageButtons.init();
    });
</script>

<script>
    var li = $('.r-tabs-nav .r-tabs-tab');
    li.on('click', function () {
        console.log(li);
        var link = $(this).find("a").attr('href');
        console.log(link);

        li.removeClass('r-tabs-state-active');
        li.addClass('r-tabs-state-default');
        $(this).addClass('r-tabs-state-active');

        var panel = $('div.r-tabs-panel');

        panel.removeClass('r-tabs-state-active');
        panel.addClass('r-tabs-state-default');
        panel.css({'display': 'none'});


        $(link).addClass('r-tabs-state-active');
        $(link).css({
            'display': 'block'
        })


    });
</script>

<script>
    $(document).ready(function () {
        $(".invoiceLink").on('click', invoicePopulate);
        function invoicePopulate() {
            <?php
            $js_array = json_encode($bookings);
            echo "var bookings = " . $js_array . ";\n";
            ?>
            var key = $(this).attr('data-id');
            var booking = bookings[key];
            console.log(booking);
            $('.invoiceBill_to').html(booking['bill_to']);
            $('.invoiceRoomNumber').html(booking['bi_room']);
            $('.invoiceRoomPrice').html(booking['bi_price'] + 'DH');
            $('.invoiceDiscount').html(booking['b_discount'] + 'DH');
            $('.invoiceFromDate').html(booking['check_in']);
            $('.invoiceToDate').html(booking['check_out']);
            $('.invoiceTotalPrice').html(booking['bi_price'] - booking['b_discount'] + 'DH');
        }
    });
</script>


<?php $this->load->view('admin/partials/admin_footer'); ?>




