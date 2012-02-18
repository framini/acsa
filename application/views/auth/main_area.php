<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>

	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	
	<title>Adminus &#9679; Page</title>
	
    <style type="text/css" media="all">
		@import url("css/style.css");
		@import url("css/jquery.wysiwyg.css");
		@import url("css/facebox.css");
		@import url("css/visualize.css");
		@import url("css/date_input.css");
    </style>
	
	<!--[if lt IE 8]><style type="text/css" media="all">@import url("css/ie.css");</style><![endif]-->
    
    <!--[if IE]><script type="text/javascript" src="js/excanvas.js"></script><![endif]-->	
	<script type="text/javascript" src="js/jquery.js"></script>
	<script type="text/javascript" src="js/jquery.img.preload.js"></script>
	<script type="text/javascript" src="js/jquery.filestyle.mini.js"></script>
	<script type="text/javascript" src="js/jquery.wysiwyg.js"></script>
	<script type="text/javascript" src="js/jquery.date_input.pack.js"></script>
	<script type="text/javascript" src="js/facebox.js"></script>
	<script type="text/javascript" src="js/jquery.visualize.js"></script>
	<script type="text/javascript" src="js/jquery.visualize.tooltip.js"></script>
	<script type="text/javascript" src="js/jquery.select_skin.js"></script>
	<script type="text/javascript" src="js/jquery.tablesorter.min.js"></script>
	<script type="text/javascript" src="js/ajaxupload.js"></script>
	<script type="text/javascript" src="js/jquery.pngfix.js"></script>
	<script type="text/javascript" src="js/custom.js"></script>
</head>

<body>
	
	<div id="hld">
	
		<div class="wrapper">		
			
			<div id="header">
				<div class="hdrl"></div>
				<div class="hdrr"></div>
				
				<h1><a href="<?php echo base_url(); ?>">eWarrants</a></h1>
				
				<ul id="nav">
					<li><a href=""<?php echo base_url(); ?>">Home</a></li>
					<!--<li class="active"><a href="#">Pages</a>
						<ul>
							<li><a href="#">List pages</a></li>
							<li><a href="#">Add page</a></li>
							<li><a href="#">More actions</a>
								<ul>
									<li><a href="#">Some action</a></li>
									<li><a href="#">Some action</a></li>
									<li><a href="#">Some action</a>
										<ul>
											<li><a href="#">Some action</a></li>
											<li><a href="#">Some action</a></li>
											<li><a href="#">Some action</a></li>
										</ul>
									</li>
								</ul>
							</li>
						</ul>
					</li>-->
					<li><a href="#">Seguridad</a></li>
					
				</ul>
				
				<p class="user">Hola, <a href="#"><?php echo $username ?></a> | <a href="index.html">Cerrar Sesión</a></p>
			</div>		
            <!-- #header ends -->
	
</body>
</html>