



 <div class="row" id="contenido">
 	<?php
	$nombre = isset($roleRow->nombre) ? $roleRow->nombre : set_value('nombre');
	$desc = isset($roleRow->descripcion) ? $roleRow->descripcion : set_value('descripcion');
	$empresaid = isset($roleRow->empresa_id) ? $roleRow->empresa_id : set_value('empresa_id');
	//$tipoempresaid = isset($roleRow->tipo_empresa_id) ? $roleRow->tipo_empresa_id : set_value('tipo_empresa_id');
	
	$role = array(
	        'name'              => 'nombre',
	        'value'             => $nombre,
	        'maxlength'         => 80,
	        'size'              => 30,
	        'class'             => 'text span5',
	        'id'                => 'nombre_role'
	);
	
	$descripcion = array(
	        'name'              => 'descripcion',
	        'value'             => $desc,
	        'class'             => 'textarea-mid span5',
	        'id'                => 'descripcion'
	);
	
	$empresa_id = array(
	        'name'              => 'empresa_id',
	        'value'             => $empresaid,
	        'size'              => 30,
	        'class'             => 'text span5'
	);
	
	?>
 	
 	<div class="row" id="contenido">
 	<?php if(!isset($fa)) { ?>
	<script type="text/javascript">
		$(function() {
			$('.btn-primary.btn-large').click(function(event) {
				event.preventDefault();
				
				//url del role a actualizar
				var uri = "<?php $uri = site_url() . "/" .$this->uri->uri_string(); echo $uri; ?>";
			
				//Seleccionamos los checkbox que hayan sido seleccionados
				var checkboxes = {};
				$('input[type=checkbox]:checked').each(function() {		
					checkboxes[$(this).attr('name')] = $(this).val();
				});
				
				//Seleccionamos los inputs
				var campos = {
					nombre: $('#nombre_role').val(),
					empresa_id: $('#empresa_id').val(),
					descripcion: $('#descripcion').val()
				};
				
				//Hacemos un merge entre los dos objetos anteriores
				var param = $.extend({}, checkboxes, campos);
				
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
	<?php } ?>
			
                            <div class="span12 margin-bottom-10">
					                	<div class="row">
						               		<div class="span12">
						                		<h2><?php if(isset($t)) { echo $t;} else {echo "Modificar Role";} ?></h2>
						                	</div>
					                	</div>
					        </div>		
					        <!-- .block_head ends -->
				
				
				
                            <div class="span12">
                            	<?php
					            	if(isset($errors)) {
					            		$data['estado'] = "error";
										$data['message'] = $errors['nombre_role'];
					            	} else if(isset($message)) {
					            		$data['estado'] = "success";
					            	}
									if(isset($data)) {
										$this->load->view('general/mensaje_operacion', $data); 
									}
					            ?>
                                <?php
                               
                                  $errorLogueo = '';//isset($errors[$login['name']]) ? $errors[$login['name']]:'';
                                  $errorPassword = ''; //isset($errors[$password['name']])?$errors[$password['name']]:'';
                                  $errorNombreRole = isset($nombre_role) ? $nombre_role : '';
                                  
                                  if(form_error($role['name']) != '' || form_error($descripcion['name']) != '' || form_error($empresa_id['name']) != '' || $errorNombreRole != '' || $errorPassword != '')
                                  {
                                  	echo '<div class="row">';
                                       echo "<div class='alert alert-error span5'>";
                                                 echo form_error($role['name'],  '<p>', '</p>'); 
                                                 echo form_error($descripcion['name'],  '<p>', '</p>'); 
                                                 echo form_error($empresa_id['name'],  '<p>', '</p>');
                                                 
                                                 echo isset($nombre_role) ? "<p>" . $nombre_role . "</p>" : '';
                                                // echo isset($errors[$login['name']]) ? "<p>" . $errors[$login['name']] . "</p>" : '';
                                                 
                                                // echo isset($errors[$password['name']])?"<p>" . $errors[$password['name']] . "</p>"  : '';
                                      echo "</div>";
									echo '</div>';
                                  }
                                  ?>
                                  
                                  <div class="row margin-bottom-10">
                                  	<div class="alert span5 alert-error margin-top-10" id="resultado-operacion" style="display: none;"></div>
                                  </div>
                                
                                <?php 
                                $formaction = isset($fa) ? $fa : $this->uri->uri_string() . $roleRow->role_id;
                                echo form_open($formaction); ?>
													<div class="row">
                                                        <div class="span6 control-group <?php if(form_error($role['name']) != "") echo "error"; ?>">
		                                                    <?php echo form_label('Role <i class="icon-asterisk"></i>', $role['name']); ?>
		                                                    <?php echo form_input($role); ?>
		                                                    
		                                                </div>
		                                            </div>
		                                            <div class="row">
                                						<div class="span6 control-group <?php if(form_error($descripcion['name']) != "") echo "error"; ?>">
															<?php echo form_label('Descripcion <i class="icon-asterisk"></i>', $descripcion['name']); ?>
		                                                    <?php echo form_textarea($descripcion); ?>
		                                                </div>
		                                            </div>
												<div class="row">
                                						<div class="span6 control-group">
                                                	<?php if(isset($empresas)) { ?>

                                                    	<?php echo form_label('Empresa', $empresa_id['name']); ?>

	                                                    <?php
	      
	                                                        echo '<select name="empresa_id" class="styled span5" id="empresa_id">';
	                                                        
	                                                        foreach($empresas as $emp)
	                                                        {
	                                                            //echo "<option>" . $empresaid . "</option>";
	                                                            //echo $emp['empresa_id'];
	                                                           if($emp['empresa_id'] != $empresaid)
	                                                               echo '<option value="' . $emp['empresa_id'] . '">' . $emp['nombre'] . "</option>";
	                                                           else
	                                                               echo '<option value="' . $emp['empresa_id'] . '" selected="selected">' . $emp['nombre'] . "</option>";
	                                                        }
	                                                        echo '</select>';
	                                                    ?>
                                                	<?php } ?>
                                                	</div>
                                      			</div><!--fn row-->
                                      			<div class="row">
                                						<div class="span6 control-group">
	                                                <?php 
	                                                echo form_label('Permisos');
	                                                ?>
	                                                <p>
	                                                    <?php 
	                                                    
	                                                    foreach($permisos as $permiso)
	                                                    {
	                                                       $id = $permiso['id'];
	                                                       $permiso = $permiso['permiso'];
	                                                       
	                                                       if(isset($permisosRole)) {
	                                                           foreach($permisosRole as $pp)
	                                                           {
	                                                                if($pp->permiso_id == $id)
	                                                                {
	                                                                        $estado = true;
	                                                                        break;
	                                                                }
	                                                                else
	                                                                        $estado = false;
	                                                           }
	                                                       
	                                                       
	                                                           echo '<label class="checkbox">';
	                                                           echo form_checkbox($permiso, $id, $estado);
	                                                           echo $permiso;
	                                                           echo "</label>";
												              
	                                                       } else {
	                                                           echo '<label class="checkbox">';
	                                                           echo form_checkbox($permiso, $id);
	                                                           echo $permiso;
	                                                           echo "</label>";
	                                                       }
	                                                    }
	                                                    ?>
	                                                </p>
    
                                                </div>
                                            </div>
                                                    <input type="submit" class="btn btn-large btn-primary" value="<?php if(isset($tb)) echo $tb; else echo 'Modificar' ?>" name="submit" />
                                <?php echo form_close(); ?>
                                                                              
                            </div>		
                            <!-- .block_content ends -->
				
                        <div class="bendl"></div>
                        <div class="bendr"></div>
					
	</div>		
<!-- .block ends -->