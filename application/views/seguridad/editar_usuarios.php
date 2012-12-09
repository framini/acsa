
<div class="row" id="contenido">
	<script type="text/javascript">
		$(function() {
			$('.btn-primary.btn-large').click(function(event) {
				event.preventDefault();
				
				//url del usuario a actualizar
				var uri;
				if(window.top.$('body').data('uriUpdate')) {
					uri = window.top.$('body').data('uriUpdate');
				} else {
					uri = window.location;
				}
				
				
				var param = {
					username: $('#username').val(),
					empresa_id: $('#empresas_id').val(),
					role_id: $('#role_id').val()
				};
				
				$.ajax({
					url: uri,
					type: 'json',
					dataType: 'json',
					data: param,
					type: 'POST',
					success: function(data, textStatus, jqXHR) {
						if(data.error) {
							$('#resultado-operacion').text("");
							$('#resultado-operacion').slideUp('fast', function() {
								$(this).text(data.message)} )
								.removeClass('alert-success')
								.addClass('alert-error')
								.delay(200)
								.slideDown('slow');
						} else {
							$('#resultado-operacion').text("");
							$('#resultado-operacion').slideUp('fast', function() {
								$(this).text(data.message)} )
								.removeClass('alert-error')
								.addClass('alert-success')
								.delay(200)
								.slideDown('slow');
						}
						
					}
				});
			});
		});
	</script>
	
			
                            <div class="span12 margin-bottom-10">
				                	<div class="row">
					               		<div class="span12">
					                		<h2>Editar Usuario</h2>
					                	</div>
				                	</div>
					        </div>		
					        <!-- .block_head ends -->
                            <div class="span12">
                            	
                            		<?php
										$username = array(
										        'name'	=> 'username',
										        'id'	                  => 'username',
										        'value'                  => $usuario->username,
										        'maxlength'	=> $this->config->item('username_max_length', 'tank_auth'),
										        'class'                   => 'text span5',
										);
									?>
                                
                                    <?php echo form_open($this->uri->uri_string()); ?>
                                
                                    <?php
                                  
                                  if(isset($usuario_existente))
                                  {
                                       echo "<div class='alert alert-error'>";
                                                 
                                                 echo "<strong>" . $usuario_existente . "</strong>";
                                                // echo isset($errors[$login['name']]) ? "<p>" . $errors[$login['name']] . "</p>" : '';
                                                 
                                                // echo isset($errors[$password['name']])?"<p>" . $errors[$password['name']] . "</p>"  : '';
                                      echo "</div>";
                                  }
                                  ?>
                                  <div class="row margin-bottom-10">
                                  <div class="alert span5 alert-error margin-top-10" id="resultado-operacion" style="display: none;"></div>
                                  </div>

                                    <?php echo form_label('Nombre de Usuario', $username['id']); ?></td>
                                    <?php echo form_input($username); ?></td>
                                    <?php if(form_error($username['name']) != "" || isset($usuario_existente)) {?>
	                                    <div class="alert alert-error">
									        <?php if(isset($usuario_existente))echo $usuario_existente; else echo form_error($username['name']); ?>
									    </div>
								    <?php } ?>
                                    <?php if(isset($empresas)) { ?>
	                                    <?php echo form_label('Empresa', 'empresa_id'); ?></td>
	                                    <?php
	                                        echo '<select name="empresa_id" class="styled span5" id="empresas_id">';
	                                        foreach($empresas as $emp)
	                                        {
	                                            //echo "<option>" . $emp['empresa_id'] . " " . $usuario->empresa_id . "</option>";
	                                           if($emp['empresa_id'] != $usuario->empresa_id)
	                                               echo '<option value="' . $emp['empresa_id'] . '">' . $emp['nombre'] . "</option>";
	                                           else
	                                               echo '<option value="' . $emp['empresa_id'] . '" selected="selected">' . $emp['nombre'] . "</option>";
	                                        }
	                                        echo '</select>';
	                                    ?>
                                    <?php } ?>
                                    <?php if(count($roles) > 0) { ?>
	                                    	<?php echo form_label('Role', 'role_id'); ?></td>
	                                        <?php
	                                            echo '<select name="role_id" class="styled span5" id="role_id">';
												echo '<option value="0">--Sin role--</option>';
	                                            foreach($roles as $role)
	                                            {
	                                               if($role['role_id'] != $usuario->role_id) {
	                                               		//Chequeamos para no mostrar el rol admin a usuarios que no sean superadmins
	                                               		if($role['role_id'] == 1) {
	                                               			if(isset($es_admin)) {
	                                               				echo '<option value="' . $role['role_id'] . '">' . $role['nombre'] . "</option>";
	                                               			}
	                                               		} else {
	                                               			echo '<option value="' . $role['role_id'] . '">' . $role['nombre'] . "</option>";
	                                               		}
	                                               }
	                                               else {
	                                               		echo '<option value="' . $role['role_id'] . '" selected="selected">' . $role['nombre'] . "</option>";
	                                               }
	                                            }
	                                            echo '</select>';
	                                        ?>
	                                <?php } else { ?>
	                                	<select name="role_id" class="styled span5" id="role_id">
	                                			<option value="0">--Sin role--</option>
	                                	</select>
	                                <?php } ?>
                                    <?php //echo form_submit('register', 'Crear Cuenta'); ?>
                                    <p><input type="submit" class="btn btn-primary btn-large" value="Guardar" name="register" /></p>
                                    <?php echo form_close(); ?>
                            </div>	<!--span12-->	
</div>		