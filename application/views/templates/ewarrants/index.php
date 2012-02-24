<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title><?php echo $site_title?> - <?php echo $site_name?></title>
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Soporte para IE6-8 support de elementos HTML -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

    <link href="<?php echo base_url(); ?>bootstrap/css/bootstrap.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>bootstrap/css/custom.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>colorbox/colorbox.css" rel="stylesheet"  />
    <style>
      body {
        padding-top: 60px; /* Espacio para el toolbar superior*/
      }
    </style>
    <link href="<?php echo base_url(); ?>bootstrap/css/bootstrap-responsive.css" rel="stylesheet">

    <!-- Le fav and touch icons -->
    <!--<link rel="shortcut icon" href="images/favicon.ico">
    <link rel="apple-touch-icon" href="images/apple-touch-icon.png">

    <link rel="apple-touch-icon" sizes="72x72" href="images/apple-touch-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="114x114" href="images/apple-touch-icon-114x114.png">-->
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
    <!--<script src="<?php echo base_url(); ?>bootstrap/js/jquery.js"></script>-->
  </head>

  <body>

    <div class="navbar navbar-fixed-top">
      <div class="navbar-inner">
        <div class="container">
          <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">

            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </a>
          <a class="brand" href="#">eWarrants</a>
          <div class="nav-collapse">
            <ul class="nav">
              <li <?php if($this->uri->segment(1) == "seguridad") echo "class='active'" ?> ><a href="<?php echo site_url(); ?>/seguridad">Seguridad</a></li>

              <?php 
                if(isset($warrantera) || isset($argclearing)) {
                  echo '<li ';
                  if($this->uri->segment(1) == "ewarrants") echo "class='active'";
                  echo '><a href="' . site_url() . '/ewarrants">eWarrants</a></li>';
                }
              ?>
            </ul>
            <ul class="nav pull-right">
            	<li class="dropdown">
				<a href="#"
				class="dropdown-toggle"
				data-toggle="dropdown">
				Hola, <span id="nombre-usuario-top"><?php echo $user ?></span>
				<b class="caret"></b>
				</a>
				<ul class="dropdown-menu">
					  <li><a href="#">Perfil</a></li>
				      <li class="divider"></li>
				      <li><?php echo anchor('ew/logout', 'Cerrar Sesión') ?></li>
				</ul>
              </li>
            </ul>
          </div><!--/.nav-collapse -->
        </div>
      </div>
    </div>

    <div class="container">

      <?php echo $messages; ?>
      <?php echo $content; ?>

    </div> <!-- /container -->

    <!-- Javascript
    ================================================== -->

    <!-- Puesto en este punto por temas de performance -->
    <script src="<?php echo base_url(); ?>bootstrap/js/bootstrap-transition.js"></script>
    <script src="<?php echo base_url(); ?>bootstrap/js/bootstrap-alert.js"></script>
    <script src="<?php echo base_url(); ?>bootstrap/js/bootstrap-modal.js"></script>
    <script src="<?php echo base_url(); ?>bootstrap/js/bootstrap-dropdown.js"></script>

    <script src="<?php echo base_url(); ?>bootstrap/js/bootstrap-scrollspy.js"></script>
    <script src="<?php echo base_url(); ?>bootstrap/js/bootstrap-tab.js"></script>
    <script src="<?php echo base_url(); ?>bootstrap/js/bootstrap-tooltip.js"></script>
    <script src="<?php echo base_url(); ?>bootstrap/js/bootstrap-popover.js"></script>
    <script src="<?php echo base_url(); ?>bootstrap/js/bootstrap-button.js"></script>
    <script src="<?php echo base_url(); ?>bootstrap/js/bootstrap-collapse.js"></script>

    <script src="<?php echo base_url(); ?>bootstrap/js/bootstrap-carousel.js"></script>
    <script src="<?php echo base_url(); ?>bootstrap/js/bootstrap-typeahead.js"></script>
    
    <script type="text/javascript" src="<?php echo base_url(); ?>js/jquery.blockUI.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>js/jquery.quicksearch.js"></script>
    <?php if($this->uri->segment(2) == "gestionar_usuarios") { echo '<script type="text/javascript" src="' . base_url() . 'js/gestion-usuarios.js"></script>'; } ?>
    <?php if($this->uri->segment(2) == "gestionar_roles") { echo '<script type="text/javascript" src="' . base_url() . 'js/gestion-roles.js"></script>'; } ?>
    <?php if($this->uri->segment(2) == "gestionar_empresas") { echo '<script type="text/javascript" src="' . base_url() . 'js/gestion-empresas.js"></script>'; } ?>
    <script type="text/javascript" src="<?php echo base_url(); ?>js/jquery.colorbox.js"></script>
    <br/>
    <script src="<?php echo base_url(); ?>bootstrap/js/custom.js"></script>

  </body>
</html>
