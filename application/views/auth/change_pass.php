<div class="row" id="contenido">
	
	<script type="text/javascript">
		$(function() {
			$('#cambiarPassword').click(function(event) {
				event.preventDefault();
				
				//url del usuario a actualizar
				var uri = $('form').attr('action');

				var param = {
					password: $('#password').val()
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
							//Mostramos en pantalla el nuevo mail que le sera asignado al usuario
							//en caso de que confirme el email que se le fue enviado
							$('#info-nombre').text("Se ha cambiado el password de")
						}
						
					}
				});
			});
		});
	</script>
			
                            <div class="span12 margin-bottom-10">
				                	<div class="row">
					               		<div class="span12">
					                		<h2>Cambiar Password</h2>
					                	</div>
				                	</div>
					        </div>		
					        <!-- .block_head ends -->
                            <div class="span12">
                            	
                            	<?php
								$password = array(
									'name'	=> 'password',
									'id'	=> 'password',
									'value' => set_value('password'),
									'maxlength'	=> $this->config->item('password_max_length', 'auth_frr'),
								    'class'        => 'text',
								);
								?>
								
								<div class="row margin-bottom-10">
                                  <div class="alert span5 alert-error margin-top-10" id="resultado-operacion" style="display: none;"></div>
                                </div>
                                <div class="row margin-bottom-10">
                                <?php echo '<div class="alert span5 alert-info margin-top-10" id="info-operacion" ><span class="info-usuario"> <span id="info-nombre">Se cambiara el password al usuario</span>: <strong>' . $username . '</strong></span></span></div>' ?>
                                </div>
                                
                                    <?php echo form_open($this->uri->uri_string()); ?>

                                    <?php echo form_label('Password', $password['id']); ?></td>
                                    <?php echo form_password($password); ?>
                                    <input type="submit" class="btn btn-primary btn-large" id="cambiarPassword" value="Guardar" name="register" />
                                    <?php echo form_close(); ?>
                            </div>	
					
</div>		
<!-- .block ends -->