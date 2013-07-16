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
					$login = array(
						'name'	=> 'login',
						'id'	=> 'login',
						'value' => set_value('login'),
						'maxlength'	=> 80,
						'size'	=> 30,
					);
					if ($this->config->item('use_username', 'tank_auth')) {
						$login_label = 'Email or login';
					} else {
						$login_label = 'Email';
					}
					?>
					<?php echo form_open($this->uri->uri_string()); ?>
					<div class="form-inline">
					  <?php echo form_label($login_label, $login['id']); ?>
					  <?php echo form_input($login); ?>
					  <button type="submit" name="reset" class="btn">Solicitar Nuevo Password</button>
					</div>
					<?php echo form_close(); ?>
		</div>
					
	</div>	<!-- row -->	
	
	
</body>
</html>