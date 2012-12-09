<style>
	.modal {
	    display:    none;
	    position:   fixed;
	    z-index:    1000;
	    top:        0;
	    left:       0;
	    height:     100%;
	    width:      100%;
	    background: rgba( 255, 255, 255, .8 ) 
	                url('<?php echo base_url() . "images/FhHRx.gif" ?>') 
	                50% 50% 
	                no-repeat;
	}

	body.loading {
	    overflow: hidden;   
	}
	

	body.loading .modal {
	    display: block;
	}
</style>
<script>
	$("body").on({
	    ajaxStart: function() { 
	        $(this).addClass("loading"); 
	    },
	    ajaxStop: function() { 
	        $(this).removeClass("loading"); 
	    }    
	});
</script>
<div class="row" id="contenido">
	
	<script type="text/javascript">
		$(function() {
			
			
			
			$('#cambiarEmail').click(function(event) {
				event.preventDefault();
				
				//url del usuario a actualizar
				//Si esta pagina se abrio por medio de un pop-up
				//buscamos la URL en la pagina que la invoco
				var uri;
				if(window.top.$('body').data('uriUpdate')) {
					uri = window.top.$('body').data('uriUpdate');
				} else {
					uri = window.location;
				}

				var param = {
					email: $('#email').val()
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
							$('#info-nombre').text("Se ha cambiado el mail de")
							$('#nuevo_email').text(data.email_nuevo);
							$('#info-operacion .info-mail').fadeIn('slow');
						}
						
					}
				});
			});
		});
	</script>
	
                            <div class="span12 margin-bottom-10">
				                	<div class="row">
					               		<div class="span12">
					                		<h2>Cambiar Email</h2>
					                	</div>
				                	</div>
					        </div>		
					        <!-- .block_head ends -->
                            <div class="span12">
                            	
                            		<?php
									$email = array(
										'name'	=> 'email',
										'id'	=> 'email',
										'value'	=> set_value('email'),
									    'class'        => 'text span5',
									);
									?>
									
									<div class="row margin-bottom-10">
	                                  <div class="alert span5 alert-error margin-top-10" id="resultado-operacion" style="display: none;"></div>
	                                </div>
	                                <div class="row margin-bottom-10">
	                                <?php echo '<div class="alert span5 alert-info margin-top-10" id="info-operacion" ><span class="info-usuario"> <span id="info-nombre">Se cambiara el email al usuario</span>: <strong>' . $username . '</strong></span><br/><span class="info-mail" style="display:none;">En caso de confirmarlo su nuevo email sera: <i class="icon-envelope"></i> <strong id="nuevo_email"></strong></span></div>' ?>
	                                </div>
                                
                                    <?php echo form_open($this->uri->uri_string()); ?>
                                    
                                    <?php echo form_label('Nuevo email', $email['id']); ?>
                                    <?php echo form_input($email); ?>
									<?php if(form_error($email['name']) != "" || isset($errors['email_en_uso'] )) {?>
	                                    <div class="alert alert-error">
									        <?php if(isset($errors['email_en_uso'] ))echo $errors['email_en_uso']; else echo form_error($email['name']); ?>
									    </div>
								    <?php } ?>
                                    <p><input type="submit" class="btn btn-primary btn-large" id="cambiarEmail" value="Guardar" name="register" /></p>
                                    <?php echo form_close(); ?>
                            </div>		

					
</div>		
<div class="modal"></div>
<!-- .block ends -->