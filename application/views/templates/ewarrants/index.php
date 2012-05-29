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

    <link href="<?php echo base_url(); ?>bootstrap/css/bootstrap.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url(); ?>bootstrap/css/custom.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url(); ?>colorbox/colorbox.css" rel="stylesheet" type="text/css"  />
    <link href="<?php echo base_url(); ?>css/botones.css" rel="stylesheet" type="text/css"  />
    <link href="<?php echo base_url(); ?>css/custom-theme/jquery-ui-1.8.16.custom.css" rel="stylesheet" type="text/css"  />
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
              <?php if(isset($admin)) { ?>
              <li class="dropdown">
				<a href="#" class="dropdown-toggle" data-toggle="dropdown">
				Admin
				<b class="caret"></b>
				</a>
				<ul class="dropdown-menu">
					  <li><?php echo anchor('admin/forms', '<i class=""></i>Formularios'); ?></li>
				      <li class="divider"></li>
				      <li><?php echo anchor('/admin/grupos_fields', '<i class=""></i> Grupos Fields'); ?></li>
				</ul>
              </li>
              <?php } ?>
              <?php //if(isset($admin)) { ?>
              <li class="dropdown">
				<?php echo anchor('admin/template_manager', '<i class=""></i>Template Manager'); ?>
              </li>
              <?php //} ?>
              
              <?php if(isset($admin) && isset($forms)) { ?>
              <li class="dropdown">
				<a href="#" class="dropdown-toggle" data-toggle="dropdown">
				Contenido
				<b class="caret"></b>
				</a>
				<ul class="dropdown-menu">
					<li class="nav-header"><span class="small menu">Generar contenido en:</span></li>
					<?php foreach($forms as $form) { ?>
						 <li><?php echo anchor('admin/form/' . $form['forms_id'], '<i class=""></i>' . format_texto($form['forms_nombre'])); ?></li>
					<?php } ?>
					<li class="divider"></li>
					<li class="nav-header"><span class="small menu">Editar:</span></li>
					<li><?php echo anchor('admin/editar_contenido', 'Editar Contenido') ?></li>

				</ul>
              </li>
              <?php } ?>
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
    	
    	<div class="row">
    		<div class="span12">
    			<?php
					echo $this->breadcrumb->output();
				?>
		    </div>
		</div>
		
      <?php echo $messages; ?>
      <?php echo $content; ?>

    </div> <!-- /container -->

    <!-- Javascript
    ================================================== -->

    <!-- Puesto en este punto por temas de performance -->
    <script src="<?php echo base_url(); ?>bootstrap/js/bootstrap-transition.js"></script>
    <script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.9/jquery-ui.min.js"></script>
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
    <?php if($this->uri->segment(2) == "alta_fields") { echo '<script type="text/javascript" src="' . base_url() . 'js/fields_form.js"></script>'; } ?>
    <script type="text/javascript" src="<?php echo base_url(); ?>js/jquery.colorbox.js"></script>
    <br/>
    <script src="<?php echo base_url(); ?>bootstrap/js/custom.js"></script>
    <!--daterangepicker-->
    <script type="text/javascript" src="<?php echo base_url(); ?>bootstrap/third-party/jQuery-UI-Date-Range-Picker/js/date.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>bootstrap/third-party/jQuery-UI-Date-Range-Picker/js/daterangepicker.jQuery.js"></script>

    <!--wijmo-->
    <script src="<?php echo base_url(); ?>bootstrap/third-party/wijmo/jquery.mousewheel.min.js" type="text/javascript"></script>
    <script src="<?php echo base_url(); ?>bootstrap/third-party/wijmo/jquery.bgiframe-2.1.3-pre.js" type="text/javascript"></script>
    <script src="<?php echo base_url(); ?>bootstrap/third-party/wijmo/jquery.wijmo-open.1.5.0.min.js" type="text/javascript"></script>


    <!-- FileInput -->
    <script src="<?php echo base_url(); ?>bootstrap/third-party/jQuery-UI-FileInput/js/enhance.min.js" type="text/javascript"></script>
    <script src="<?php echo base_url(); ?>bootstrap/third-party/jQuery-UI-FileInput/js/fileinput.jquery.js" type="text/javascript"></script>

  </body>
</html>
