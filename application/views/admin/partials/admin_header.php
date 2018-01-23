<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
      <link rel="icon" type="image/png" href="<?php echo base_url('assets/images/favicon.png'); ?>"/>

    <title><?php echo $params['name']; ?></title>


  <!-- Global site tag (gtag.js) - Google Analytics -->
  <script async src="https://www.googletagmanager.com/gtag/js?id=UA-110319921-1"></script>
  <script>
      window.dataLayer = window.dataLayer || [];
      function gtag() {
          dataLayer.push(arguments);
      }
      gtag('js', new Date());

      gtag('config', 'UA-110319921-1');
  </script>


      <!-- Bootstrap -->
    <link href="<?php echo base_url("assets/vendors/bootstrap/dist/css/bootstrap.min.css"); ?>" rel="stylesheet">
	<!--date picker -->
	<link href="<?php echo base_url("assets/datepicker3.css"); ?>" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="<?php echo base_url("assets/vendors/font-awesome/css/font-awesome.min.css"); ?>" rel="stylesheet">
    <!-- NProgress -->
    <link href="<?php echo base_url("assets/vendors/nprogress/nprogress.css"); ?>" rel="stylesheet">
    <!-- sweet-alert -->
    <link href="<?php echo base_url("assets/vendors/sweetalert/sweetalert.css"); ?>" rel="stylesheet">


    <link href="<?php echo base_url("assets/vendors/bootstrap-daterangepicker/daterangepicker.css"); ?>" rel="stylesheet">
    <link href="<?php echo base_url("assets/vendors/fullcalendar/dist/fullcalendar.css"); ?>" rel="stylesheet">

    <!-- Custom Theme Style -->
    <link href="<?php echo base_url("assets/build/css/custom.min.css"); ?>" rel="stylesheet">
    <link href="<?php echo base_url("assets/build2/css/custom.min.css"); ?>" rel="stylesheet">

    <link href="<?php echo base_url("assets/css/main.css"); ?>" rel="stylesheet">
      <style>
          #loading {
              width: 100%;
              height: 100%;
              top: 0px;
              left: 0px;
              position: fixed;
              opacity: 0.7;
              background-color: #fff;
              z-index: 999999;
              text-align: center;
              display: none;
          }

          #loading-image {
              position: absolute;
              top: 20%;
              z-index: 10000;
          }
      </style>
  </head>

  <body class="nav-md">
  <div id="loading">
      <img id="loading-image" src="<?php echo base_url("assets/images/loader.gif"); ?>" alt="Loading..."/>
  </div>
    <div class="container body">
      <div class="main_container">
        <div class="col-md-3 left_col">
          <div class="left_col scroll-view">
            <div class="navbar nav_title" style="border: 0;">
                <?php
                    $link="";
                    if($this->session->userdata('type') == "admin"){
                        $link= base_url('admin/dashboard');
                    }else if($this->session->userdata('type') == "thrifty"){
                        $link = base_url('admin/department/showProducts');
                    }
                ?>
             <a href="<?= $link ?>" class="site_title"><i class="fa fa-coffee"></i> <span><?php echo $params['name']; ?></span></a>
            </div>

            <div class="clearfix"></div>

            <!-- menu profile quick info -->
            <div class="profile clearfix">
                <div class="profile_pic">
                    <img src="<?= base_url('assets/images/'.$params['photo']); ?>" alt="icon" class="img-circle profile_img">
                </div>
                <div class="profile_info">
                    <span>Bienvenu,</span>
                    <h2><?= $this->session->userdata('first_name'); ?></h2>
                </div>
                <div class="clearfix"></div>
            </div>
            <!-- /menu profile quick info -->

            <br />

            <!-- sidebar menu -->
            <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
              <div class="menu_section">
                <ul class="nav side-menu">
                  <?php if($this->session->userdata('type') == "admin" ) : ?>
                      <li><a href="<?= base_url('admin/report/statistic'); ?>"><i class="fa fa-home"></i> Dashboard </a>
                      </li>
                  <li><a><i class="fa fa-shopping-cart"></i> Fournisseurs <span
                                  class="fa fa-chevron-down"></span></a>
                      <ul class="nav child_menu">
                          <li><a href="<?= base_url('admin/provider'); ?>">Liste des fournisseurs</a></li>
                          <li><a href="<?= base_url('admin/provider/compare'); ?>">Comparaison</a></li>
                      </ul>
                  </li>
                  <li><a><i class="fa fa-coffee"></i> Gestion des produits <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="<?= base_url('admin/product/add'); ?>">Ajouter des produits</a></li>
                      <li><a href="<?= base_url('admin/product/addComposition'); ?>">Ajouter un produit composé</a></li>
                      <li><a href="<?= base_url('admin/product/index'); ?>">Stock des produits</a></li>
                       <li><a href="<?= base_url('admin/product/toOrder'); ?>">Produits à commander</a></li>
                       <li><a href="<?= base_url('admin/product/inventory'); ?>">Inventaire</a></li>
                    </ul>
                  </li>
                  <li><a><i class="fa fa-cutlery"></i> Gestion des articles <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="<?= base_url('admin/meal/group'); ?>">Mes familles</a></li>
                      <li><a href="<?= base_url('admin/meal/add'); ?>">Ajouter un article</a></li>
                      <li><a href="<?= base_url('admin/meal/index'); ?>">Liste des articles</a></li>
                    </ul>
                  </li>
                    <?php if ($params['department'] === "true") { ?>
                  <li><a>
                  <i class="fa fa-users"></i> Départements <span
                                  class="fa fa-chevron-down"></span></a>
                      <ul class="nav child_menu">
                          <li><a href="<?= base_url('admin/department'); ?>">Mes départements</a></li>
                          <li><a href="<?= base_url('admin/department/addProducts'); ?>">Stock produits</a></li>
                      </ul>
                  </li>
                      <?php } ?>
                  <li>
                  <a>
                      <i class="fa fa-male"></i>Gestion du personnel <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="<?= base_url('admin/employee/add'); ?>">Liste des employés</a></li>
                    </ul>
                  </li>
                  <li>
                      <a><i class="fa fa-bar-chart-o"></i> Rapports <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="<?= base_url('admin/report/statistic'); ?>">Statistiques</a></li>
                      <li><a href="<?= base_url('admin/report'); ?>">Rapport des articles</a></li>
                      <li><a href="<?= base_url('admin/reports'); ?>">Rapport du jour</a></li>
                    </ul>
                  </li>
                  <li>
                      <a><i class="fa fa-dollar"></i>Gestion des charges<span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="<?= base_url('admin/budget/regular'); ?>">Alertes</a></li>
                      <li><a href="<?= base_url('admin/budget/reparation'); ?>">Mes réparations</a></li>
                      <li><a href="<?= base_url('admin/budget/productPurchase'); ?>">Achats produits</a></li>
                      <li><a href="<?= base_url('admin/budget/variousPurchase'); ?>">Achats divers</a></li>
                    </ul>
                  </li>
                  <li>
                      <a><i class="fa fa-refresh"></i>Synchorinisation<span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                        <li><a href="<?= base_url('admin/Main/index'); ?>">Synchorinisation par fichier </a></li>
                        <li><a href="<?= base_url('admin/Main/index2'); ?>">Synchorinisation manuelle</a></li>
                    </ul>
                  </li>
                    <?php if ($params['multi_site'] === "true") { ?>
                      <li>
                          <a><i class="fa fa-exchange"></i>Mes agences<span class="fa fa-chevron-down"></span></a>
                          <ul class="nav child_menu">
                              <li><a href="<?= base_url('admin/agency/statistic'); ?>">Statistiques</a></li>
                              <li><a href="<?= base_url('admin/agency'); ?>">Rapport des articles</a></li>
                          </ul>
                      </li>
                    <?php } ?>
                      <li><a href="<?= base_url('admin/config'); ?>"><i class="fa fa-cogs"></i>Paramètres</a>
                      </li>


                  <!--<li><a href="<?/*= base_url('admin/Cron/index'); */?>"><i class="fa fa-refresh"></i> Synchronisation des produits </a></li>-->

                    <?php endif; ?>

                    <?php if ($this->session->userdata('type') == "thrifty") : ?>

                        <li>
                            <a href="<?= base_url('admin/department/showProducts'); ?>"><i class="fa fa-home"></i>Mon stock</a>
                        </li>
                        <li>
                            <a href="<?= base_url('admin/department/addProducts'); ?>"><i class="fa fa-arrow-circle-o-right"></i>Sortir des produits</a>
                        </li><li>
                            <a href="<?= base_url('admin/department/historyProducts'); ?>"><i class="fa fa-history"></i>Historique</a>
                        </li>

                    <?php endif; ?>


                    <?php if ($this->session->userdata('type') == "department") : ?>

                        <li>
                            <a href="<?= base_url('admin/department/show'); ?>"><i class="fa fa-user"></i>Mon département</a>
                        </li>

                        <li>
                            <a href="<?= base_url('admin/department/showDepartmentStock'); ?>"><i class="fa fa-coffee"></i>Stock des produits</a>
                        </li>

                        <li>
                            <a href="<?= base_url('admin/department/meals'); ?>"><i
                                        class="fa fa-file-text-o"></i>Mes fiches techniques</a>
                        </li>

                    <?php endif; ?>


                  <li>
                 </li>
                </ul>
              </div>
            </div>
            <!-- /sidebar menu -->

            <!-- /menu footer buttons -->
            <div class="sidebar-footer hidden-small">
              <a data-toggle="tooltip" data-placement="top" title="Settings">
                <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
              </a>
              <a data-toggle="tooltip" data-placement="top" title="FullScreen" id="fullScreen">
                <span class="glyphicon glyphicon-fullscreen" aria-hidden="true"></span>
              </a>
              <a data-toggle="tooltip" data-placement="top" title="Lock">
                <span class="glyphicon glyphicon-eye-close" aria-hidden="true"></span>
              </a>
              <a data-toggle="tooltip" data-placement="top" title="Logout"
                 href="<?php echo base_url() . 'admin/dashboard/logout'; ?>">
                <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
              </a>
            </div>
            <!-- /menu footer buttons -->
          </div>
        </div>

        <!-- top navigation -->
        <div class="top_nav">
          <div class="nav_menu">
            <nav>
              <div class="nav toggle">
                <a id="menu_toggle"><i class="fa fa-bars"></i></a>
              </div>

              <ul class="nav navbar-nav navbar-right">
                <li class="">
                  <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                    <?= $this->session->userdata('first_name'); ?>
                    <span class=" fa fa-angle-down"></span>
                  </a>
                  <ul class="dropdown-menu dropdown-usermenu pull-right">
                    
                    <li><a href="<?php echo base_url() . 'admin/dashboard/logout'; ?>"><i class="fa fa-sign-out pull-right"></i> Log Out</a></li>
                  </ul>
                </li>
                  <?php
                  if ($this->session->userdata('type') == "admin") {
                      $activeAlert="passive-alert";
                      $alertes_count=0;
                      if (isset($params["alertes"]) and count($params["alertes"])>0) {
                          $alertes_count= count($params["alertes"]) ;
                          $activeAlert="active-alert";
                      }
                  ?>
                  <li class="<?php echo $activeAlert ?>">
                  <a id="alerte" href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                      <i class="fa fa-bell"></i>(<?php echo $alertes_count; ?>)
                    <span class=" fa fa-angle-down"></span>
                  </a>
                  <ul class="dropdown-menu dropdown-usermenu pull-right">

                    <li><a href="<?php echo base_url() . 'admin/budget/regular'; ?>"><i class="fa fa-eye pull-right"></i>Afficher les alertes</a></li>
                  </ul>
                </li>
                  <?php } ?>
              </ul>
            </nav>
          </div>
        </div>
        <!-- /top navigation -->
