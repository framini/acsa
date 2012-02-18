<?php
$username = array(
                  'name'	=> 'username',
                  'id'	=> 'username',
                  'value'        => set_value('username'),
                  'maxlength'	=> $this->config->item('username_max_length', 'auth_frr'),
                  'size'	=> 30,
                   'class'        => 'text',
);

$email = array(
	'name'	=> 'email',
	'id'	=> 'email',
	'value'	=> set_value('email'),
	'maxlength'	=> 80,
	'size'	=> 30,
                  'class'        => 'text',
);
$password = array(
	'name'	=> 'password',
	'id'	=> 'password',
	'value' => set_value('password'),
	'maxlength'	=> $this->config->item('password_max_length', 'auth_frr'),
	'size'	=> 30,
                  'class'        => 'text',
);
$confirm_password = array(
	'name'	=> 'confirm_password',
	'id'	=> 'confirm_password',
	'value' => set_value('confirm_password'),
	'maxlength'	=> $this->config->item('password_max_length', 'auth_frr'),
	'size'	=> 30,
                  'class'        => 'text',
);
?>

 <div class="block">
			
                            <div class="block_head">
                                    <div class="bheadl"></div>
                                    <div class="bheadr"></div>

                                    <h2>Agregar  Usuario</h2>
                            </div>		
                            <!-- .block_head ends -->
                            <div class="block_content">
                                
                                    <?php echo form_open($this->uri->uri_string()); ?>

                                    <table>
                                            <tr>
                                                    <td><?php echo form_label('Nombre de Usuario', $username['id']); ?></td>
                                                    <td><?php echo form_input($username); ?></td>
                                                    <td style="color: red;"><?php echo form_error($username['name']); ?><?php echo isset($errors[$username['name']])?$errors[$username['name']]:''; ?></td>
                                            </tr>
                                            <tr>
                                                    <td><?php echo form_label('Email', $email['id']); ?></td>
                                                    <td><?php echo form_input($email); ?></td>
                                                    <td style="color: red;"><?php echo form_error($email['name']); ?><?php echo isset($errors[$email['name']])?$errors[$email['name']]:''; ?></td>
                                            </tr>

                                    </table>
                                    <?php //echo form_submit('register', 'Crear Cuenta'); ?>
                                    <p><input type="submit" class="submit mid" value="Crear Cuenta" name="register" /></p>
                                    <?php echo form_close(); ?>
                            </div>		
                            <!-- .block_content ends -->
				
                        <div class="bendl"></div>
                        <div class="bendr"></div>
					
</div>		
<!-- .block ends -->
