<?php
$login = array(
	'name'	=> 'login',
	'id'	=> 'login',
	'value' => set_value('login'),
	'maxlength'	=> 80,
	'size'	=> 30,
                  'class'       => 'text',
);
if ($login_by_username AND $login_by_email) {
	$login_label = 'login';
} else if ($login_by_username) {
	$login_label = 'Login';
} else {
	$login_label = 'Email';
}
$password = array(
	'name'	=> 'password',
	'id'	=> 'password',
	'size'	=> 30,
                  'class'       => 'text',
);
$remember = array(
	'name'	=> 'remember',
	'id'	=> 'remember',
	'value'	=> 1,
	'checked'	=> set_value('remember'),
	'class'       => 'checkbox',
);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>

	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	
	<title>eWarrants</title>
	
    <style type="text/css" media="all">
		@import url("<?php echo base_url(); ?>css/style.css");
		@import url("<?php echo base_url(); ?>css/jquery.wysiwyg.css");
		@import url("<?php echo base_url(); ?>css/facebox.css");
		@import url("<?php echo base_url(); ?>css/visualize.css");
		@import url("<?php echo base_url(); ?>css/date_input.css");
    </style>
	
    <!--[if lt IE 8]><style type="text/css" media="all">@import url("<?php echo base_url(); ?>css/ie.css");</style><![endif]-->
    
    <!--[if IE]><script type="text/javascript" src="<?php echo base_url(); ?>js/excanvas.js"></script><![endif]-->	
	<script type="text/javascript" src="<?php echo base_url(); ?>js/jquery.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>js/jquery.img.preload.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>js/jquery.filestyle.mini.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>js/jquery.wysiwyg.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>js/jquery.date_input.pack.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>js/facebox.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>js/jquery.visualize.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>js/jquery.visualize.tooltip.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>js/jquery.select_skin.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>js/jquery.tablesorter.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>js/ajaxupload.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>js/jquery.pngfix.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>js/custom.js"></script>

</head>

<body>
	
	<div id="hld">
	
		<div class="wrapper">

			<div class="block small center login">
			
				<div class="block_head">
					<div class="bheadl"></div>
					<div class="bheadr"></div>
					
					<h2>Login</h2>
				</div>		
                                                                        <!-- FIN .block_head -->

				<div class="block_content">
                                                                                        <?php
                                                                                             if(isset($message))
                                                                                             {
                                                                                                  echo "<div class='message success'>";
                                                                                                             echo "<p>" . $message. "</p>";
                                                                                                  echo "</div>";
                                                                                             }
                                                                                             ?>
                                                                                        <?php
                                                                                          $errorLogueo = isset($errors[$login['name']]) ? $errors[$login['name']]:'';
                                                                                          $errorPassword = isset($errors[$password['name']])?$errors[$password['name']]:'';
                                                                                          
                                                                                          if(form_error($login['name']) != '' || form_error($password['name']) != '' || $errorLogueo != '' || $errorPassword != '')
                                                                                          {
                                                                                               echo "<div class='message errormsg'>";
                                                                                                         echo form_error($login['name'],  '<p>', '</p>'); 
                                                                                                         echo isset($errors[$login['name']]) ? "<p>" . $errors[$login['name']] . "</p>" : '';
                                                                                                         echo form_error($password['name'],  '<p>', '</p>'); 
                                                                                                         echo isset($errors[$password['name']])?"<p>" . $errors[$password['name']] . "</p>"  : '';
                                                                                              echo "</div>";
                                                                                          }
                                                                                          ?>
                        
					<?php echo form_open($this->uri->uri_string()); ?>
						<p>
							<label>Username:</label> <br />
                                                                                                                              <?php echo form_input($login); ?>
						</p>
						
						<p>
							<label>Password:</label> <br />
							<?php echo form_password($password); ?>
						</p>
						
						<p>
							<input type="submit" class="submit" value="Login" name="submit" /> &nbsp; 
							<label for="remember">Recordarme</label><?php echo form_checkbox($remember); ?>
						</p>

                                                                                          <?php echo form_close(); ?>
					
				</div>		
                <!-- FIN .block_content -->
					
				<div class="bendl"></div>
				<div class="bendr"></div>
								
			</div>
            <!-- FIN .login -->
		
		</div>
        <!-- FIN wrapper -->
		
	</div>
    <!-- FIN #hld -->
	
	
</body>
</html>