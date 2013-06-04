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
    <link href="<?php echo base_url(); ?>css/style.css" rel="stylesheet" type="text/css" />
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
    <script src="<?php echo base_url(); ?>js/modernizr.js"></script>
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
          <a class="brand" href="<?php echo site_url('adm/home'); ?>">eWarrants</a>
          <div class="nav-collapse">
            <ul class="nav">
              <?php if( (isset($gestiones_disponibles_seguridad) && is_array($gestiones_disponibles_seguridad) && ( count($gestiones_disponibles_seguridad) > 0 ) ) || isset($admin) ) { ?>
              <li <?php if($this->uri->segment(2) == "seguridad") echo "class='active'" ?> ><a href="<?php echo site_url(); ?>/adm/seguridad">Seguridad</a></li>
			  <?php } ?>
			  
              <?php 
                if(isset($warrantera) || isset($argclearing)) {
                  echo '<li ';
                  if($this->uri->segment(2) == "ewarrants") echo "class='active'";
                  echo '><a href="' . site_url() . '/adm/ewarrants">eWarrants</a></li>';
                }
              ?>
              
              <?php if( (isset($gestiones_disponibles_personas) && is_array($gestiones_disponibles_personas) && ( count($gestiones_disponibles_personas) > 0 ) ) || isset($admin) ) { ?>
              <li <?php if($this->uri->segment(2) == "personas") echo "class='active'" ?> ><a href="<?php echo site_url(); ?>/adm/personas">Personas</a></li>
			  <?php } ?>
			  
			  <?php if( (isset($gestiones_disponibles_productos) && is_array($gestiones_disponibles_productos) && ( count($gestiones_disponibles_productos) > 0 ) ) || isset($admin) ) { ?>
              <li <?php if($this->uri->segment(2) == "productos") echo "class='active'" ?> ><a href="<?php echo site_url(); ?>/adm/productos/gestionar_productos">Productos</a></li>
			  <?php } ?>
              
              <?php
              
              $m_contenido = array(
              	"controladora" => "admin",
              	"submenu" => array(
              		"forms",
              		"grupos_fields"
				)
			  );
              
              ?>
              
              <?php if( (isset($permisos) && is_array($permisos) && (in_array("forms", $permisos) || in_array("grupos_fields", $permisos)) ) || isset($admin) ) { ?>
              <li class="dropdown <?php if($this->uri->segment(2) == $m_contenido['controladora'] && in_array($this->uri->segment(3), $m_contenido['submenu'], TRUE) ) echo "active" ?>">
				<a href="#" class="dropdown-toggle" data-toggle="dropdown">
				Admin
				<b class="caret"></b>
				</a>
				<ul class="dropdown-menu">
					  <li><?php if( ( isset($permisos) && is_array($permisos) && (in_array("forms", $permisos)) ) || isset($admin) ) echo anchor('adm/admin/forms', '<i class="icon-th-list"></i> Formularios'); ?></li>
				      <li><?php if( ( isset($permisos) && is_array($permisos) && (in_array("grupos_fields", $permisos)) ) || isset($admin) ) echo anchor('adm/admin/grupos_fields', '<i class="icon-folder-open"></i> Grupos Fields'); ?></li>
				</ul>
              </li>
              <?php } ?>
              
              <?php if( (isset($permisos) && is_array($permisos) && in_array("template_manager", $permisos)) || isset($admin) ) { ?>
              <li <?php if($this->uri->segment(3) == "template_manager") echo "class='active'" ?>>
				<?php echo anchor('adm/admin/template_manager', '<i class=""></i>Template Manager'); ?>
              </li>
              <?php } ?>
              
              <?php
              
              $m_contenido = array(
              	"controladora" => "admin",
              	"submenu" => array(
              		"editar_contenido",
              		"form"
				)
			  );
              
              ?>
              
              <?php if( (isset($permisos) && is_array($permisos) && in_array("form", $permisos)) || isset($admin) ) { ?>
              <li class="dropdown <?php if($this->uri->segment(2) == $m_contenido['controladora'] && in_array($this->uri->segment(3), $m_contenido['submenu'], TRUE) ) echo "active" ?>">
				<a href="#" class="dropdown-toggle" data-toggle="dropdown">
				Contenido
				<b class="caret"></b>
				</a>
				<ul class="dropdown-menu">
					<li class="nav-header"><span class="small menu">Generar contenido:</span></li>
					<?php foreach($forms as $form) { ?>
						 <li><?php echo anchor('adm/admin/form/' . $form['forms_id'], '<i class="icon-chevron-right"></i>' . $form['forms_titulo'] ); ?></li>
					<?php } ?>
					<?php if( (isset($permisos) && is_array($permisos) && in_array("editar_contenido", $permisos)) || isset($admin) ) { ?>
					<li class="divider"></li>
					<li class="nav-header"><span class="small menu">Editar:</span></li>
					<li><?php echo anchor('adm/admin/editar_contenido', '<i class="icon-pencil"></i> Editar Contenido') ?></li>
					<?php } ?>

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
					  <!--<li><a href="#"><i class="icon-user"></i> Perfil</a></li>-->
				      <li><?php echo anchor('adm/ew/logout', '<i class="icon-off"></i> Cerrar Sesión') ?></li>
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
    <script src="<?php echo base_url(); ?>js/underscore-min.js"></script>
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
    <?php if($this->uri->segment(3) == "gestionar_usuarios") { echo '<script type="text/javascript" src="' . base_url() . 'js/gestion-usuarios.js"></script>'; } ?>
    <?php if($this->uri->segment(3) == "gestionar_roles") { echo '<script type="text/javascript" src="' . base_url() . 'js/gestion-roles.js"></script>'; } ?>
    <?php if($this->uri->segment(3) == "gestionar_empresas" || $this->uri->segment(3) == "gestionar_cuentas_registro") { echo '<script type="text/javascript" src="' . base_url() . 'js/gestion-empresas.js"></script>'; } ?>
    <?php if($this->uri->segment(3) == "alta_fields") { echo '<script type="text/javascript" src="' . base_url() . 'js/fields_form.js"></script>'; } ?>
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
