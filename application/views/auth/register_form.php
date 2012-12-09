<?php
$username = array(
                  'name'	=> 'username',
                  'id'	=> 'username',
                  'value'        => set_value('username'),
                  'maxlength'	=> $this->config->item('username_max_length', 'auth_frr'),
                  'class'   => 'span5',
);

$email = array(
	'name'	=> 'email',
	'id'	=> 'email',
	'value'	=> set_value('email'),
    'class'        => 'span5',
);
$password = array(
	'name'	=> 'password',
	'id'	=> 'password',
	'value' => set_value('password'),
	'maxlength'	=> $this->config->item('password_max_length', 'auth_frr'),
    'class'        => 'span5',
);
$confirm_password = array(
	'name'	=> 'confirm_password',
	'id'	=> 'confirm_password',
	'value' => set_value('confirm_password'),
	'maxlength'	=> $this->config->item('password_max_length', 'auth_frr'),
    'class'        => 'span5',
);
?>
<script>
	$(function() {
		$('#empresas_dd').on('change', function(){
				$emp_id = $(this).val();
				
				uri = "<?php echo site_url('adm/seguridad/get_roles_empresa'); ?>" + "/" + $emp_id;
				
				$.ajax({
					url: uri,
					type: 'json',
					dataType: 'json',
					type: 'POST',
					success: function(data, textStatus, jqXHR) {
						$('#role_id').children().remove();
						$('#role_id').append('<option value="0">--Sin role--</option>');
						
						if(data) {
							$.each(data, function(index, val) {
								$opt = $('<option>');
								$opt.attr('val', val.role_id );
								$opt.text( val.nombre );
								$('#role_id').append($opt);
							});
						}	
					}
				});
				
			} );
	});
</script>

<div class="row">

        <div class="span12 margin-bottom-10">
                	<div class="row">
	               		<div class="span12">
	                		<h2>Agregar Usuario</h2>
	                	</div>
                	</div>
        </div>		
        <!-- .block_head ends -->
                            <div class="span12">
                                <?php echo form_open($this->uri->uri_string()); ?>
                                	<div class="row">
                                		<div class="span6 control-group <?php if(form_error($username['name']) != "") echo "error"; ?>">
		                                    <?php if ($use_username) { ?>
		                                    <?php echo form_label('Nombre de Usuario: <i class="icon-asterisk"></i>', $username['id']); ?>
		                                    <?php echo form_input($username); ?>
		                                    	<?php if(form_error($username['name']) != "" || isset($errors[$username['name']])) {?>
		                                    	<div class="alert alert-error error-gral span5"><?php echo form_error($username['name']); ?><?php echo isset($errors[$username['name']])?$errors[$username['name']]:''; ?></div>
		                                    	<?php } ?>
											<?php } ?>
										</div>
									</div>
									
									<div class="row">
                                		<div class="span6 control-group <?php if(form_error($email['name']) != "") echo "error"; ?>">
		                                    <?php echo form_label('Email: <i class="icon-asterisk"></i>', $email['id']); ?>
		                                    <?php echo form_input($email); ?>
		                                    	<?php if(form_error($email['name']) != "" || isset($errors['email'])) {?>
		                                    	<div class="alert alert-error error-gral span5"><?php echo form_error($email['name']); ?><?php echo isset($errors['email'])?$errors['email']:'asdsad'; ?></div>
		                                    	<?php } ?>
										</div>
									</div>
									
									<div class="row">
                                		<div class="span6 control-group <?php if(form_error($password['name']) != "") echo "error"; ?>">
		                                    <?php echo form_label('Pasword: <i class="icon-asterisk"></i>', $password['id']); ?>
		                                    <?php echo form_password($password); ?>
		                                    	<?php if(form_error($password['name']) != "") {?>
		                                    	<div class="alert alert-error error-gral span5"><?php echo form_error($password['name']); ?></div>
		                                    	<?php } ?>
										</div>
									</div>
									
									<div class="row">
                                		<div class="span6 control-group <?php if(form_error($confirm_password['name']) != "") echo "error"; ?>">
		                                    <?php echo form_label('Confirmar password: <i class="icon-asterisk"></i>', $confirm_password['id']); ?>
		                                    <?php echo form_password($confirm_password); ?>
		                                    	<?php if(form_error($confirm_password['name']) != "") {?>
		                                    	<div class="alert alert-error error-gral span5"><?php echo form_error($confirm_password['name']); ?></div>
		                                    	<?php } ?>
										</div>
									</div>
									<div class="row">
									<?php if(isset($empresas)) { ?>
											<div class="span6">
                                                    <?php echo form_label('Empresa', 'empresas_dd'); ?>

                                                            <?php
                                                                echo '<select name="empresa_id" class="span5" id="empresas_dd">';
                                                                foreach($empresas as $empresa)
                                                                {
                                                                   echo '<option value="' . $empresa['empresa_id'] . '">' . $empresa['nombre'] . "</option>";
                                                                }
                                                                echo '</select>';
                                                            ?>
                                            </div>
                                    <?php } ?>
									</div>
									
									<div class="row">
									<?php if(isset($roles)) { ?>
											<div class="span6">
                                                    <?php echo form_label('Role', 'role_id'); ?>

                                                            <?php
                                                                echo '<select name="role_id" class="span5" id="role_id">';
																echo '<option value="0">--Sin role--</option>';
                                                                foreach($roles as $roles)
                                                                {
                                                                   echo '<option value="' . $roles['role_id'] . '">' . $roles['nombre'] . "</option>";
                                                                }
                                                                echo '</select>';
                                                            ?>
                                            </div>
                                    <?php } ?>
									</div>

                                    <?php //echo form_submit('register', 'Crear Cuenta'); ?>
                                    <p><input type="submit" class="btn btn-large btn-primary" value="Crear Cuenta" name="register" /></p>
                                    <?php echo form_close(); ?>
                            </div>		
                            <!-- .block_content ends -->
					
</div>		
<!-- .block ends -->