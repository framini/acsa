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

<!DOCTYPE html>
<html lang="en">

<head>

	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	
	<title>eWarrants</title>
	
    <link href="<?php echo base_url(); ?>bootstrap/css/bootstrap.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url(); ?>bootstrap/css/custom.css" rel="stylesheet" type="text/css" />
	<style>
		body {
        padding-top: 40px;
        padding-bottom: 40px;
        background-color: #f5f5f5;
      }

      .form-signin {
        max-width: 300px;
        padding: 19px 29px 29px;
        margin: 0 auto 20px;
        background-color: #fff;
        border: 1px solid #e5e5e5;
        -webkit-border-radius: 5px;
           -moz-border-radius: 5px;
                border-radius: 5px;
        -webkit-box-shadow: 0 1px 2px rgba(0,0,0,.05);
           -moz-box-shadow: 0 1px 2px rgba(0,0,0,.05);
                box-shadow: 0 1px 2px rgba(0,0,0,.05);
      }
      .form-signin .form-signin-heading,
      .form-signin .checkbox {
        margin-bottom: 10px;
      }
      .form-signin input[type="text"],
      .form-signin input[type="password"] {
        font-size: 16px;
        height: auto;
        margin-bottom: 15px;
        padding: 7px 9px;
      }
      .input-append .add-on, .input-prepend .add-on {
      	padding: 7px 5px !important;
      }
      .input-block-level {
      	width:270px;
      }
	</style>

</head>

<body>
	
	<div class="row">
		<div class="offset5 span6">
	                <?php
	                     if(isset($message))
	                     {
	                          echo "<div class='message success alert alert-success'>";
	                                     echo "<p>" . $message. "</p>";
	                          echo "</div>";
	                     }
	                     ?>
	                <?php
	                  $errorLogueo = isset($errors[$login['name']]) ? $errors[$login['name']]:'';
	                  $errorPassword = isset($errors[$password['name']])?$errors[$password['name']]:'';
	                  
	                  if(form_error($login['name']) != '' || form_error($password['name']) != '' || $errorLogueo != '' || $errorPassword != '')
	                  {
	                       echo "<div class='alert alert-error' style='max-width: 300px; padding: 10px 29px 10px; margin: 0 auto 20px;'>";
	                                 echo form_error($login['name'],  '<p>', '</p>'); 
	                                 echo isset($errors[$login['name']]) ? "<p>" . $errors[$login['name']] . "</p>" : '';
	                                 echo form_error($password['name'],  '<p>', '</p>'); 
	                                 echo isset($errors[$password['name']])?"<p>" . $errors[$password['name']] . "</p>"  : '';
	                      echo "</div>";
	                  }
	                  ?>                
					<!--<form class="form-signin" action="<?php echo $this->uri->uri_string() ?>">-->
					<?php echo form_open($this->uri->uri_string(), array('class' => 'form-signin') ); ?>
				        <h2 class="form-signin-heading">Login</h2>
				        <div class="input-prepend">
				        	<span class="add-on"><i class="icon-user"></i></span>
				        	<input type="text" class="input-block-level" name="login" id="login" placeholder="Nombre de usuario">
				        </div>
				        <div class="input-prepend">
				        	<span class="add-on"><i class="icon-lock"></i></span>
				        	<input type="password" class="input-block-level" name="password" id="password" placeholder="Password">
				        </div>

				        <button class="btn btn-large btn-primary" type="submit">Ingresar</button>

				        <a href="http://localhost/argc/index.php/adm/ew/olvide_contrasena">Olvide mi contraseña</a>
				   </form>
		</div>
					
	</div>	<!-- row -->	
	
	
</body>
</html>