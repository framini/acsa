 <div class="row" id="contenido">
 	<?php
	$nombre_empresa = isset($roleRow->nombre) ? $roleRow->nombre : set_value('nombre');
	$cuit_empresa = isset($roleRow->cuit) ? $roleRow->cuit : set_value('cuit');
	$tipo_empresaid_empresa = isset($roleRow->tipo_empresa_id) ? $roleRow->tipo_empresa_id : set_value('tipo_empresa_id');
	
	$nombre = array(
	        'name'              => 'nombre',
	        'value'             => $nombre_empresa,
	        'class'             => 'text span5',
	        'id'                => 'nombre'
	);
	
	$cuit = array(
	        'name'              => 'cuit',
	        'value'             => $cuit_empresa,
	        'class'             => 'textarea-mid span5',
	        'id'                => 'cuit'
	);
	
	$tipoempresaid = array(
	        'name'              => 'tipo_empresa_id',
	        'value'             => $tipo_empresaid_empresa,
	        'class'             => 'text span5',
	        'id'                => 'tipo_empresa_id'
	);
	
	?>
 	
 	<div class="row" id="contenido">

	<script type="text/javascript">
		$(function() {
			$('.btn-large.btn-primary').on('click', function(event) {
				alert("ASDASDASD");
				event.preventDefault();
				
				//url para la peticion AJAX
				var uri = "<?php $uri = site_url() . "/" .$this->uri->uri_string(); echo $uri; ?>";
				
				//Seleccionamos los inputs
				var campos = {
					nombre: $('#nombre').val(),
					cuit: $('#cuit').val(),
					tipo_empresa_id: $('#tipo_empresa_id').val()
				};
				
				var param = $.extend({}, campos);
				
				$.ajax({
					url: uri,
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
						                		<h2><?php if(isset($t)) { echo $t;} else {echo "Modificar Role";} ?></h2>
						                	</div>
					                	</div>
					        </div>		
					        <!-- .block_head ends -->
				
				
				
                            <div class="span12">
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

                                echo form_open($this->uri->uri_string()); ?>
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

                                                    	<?php echo form_label('Empresa ID', $empresa_id['name']); ?>

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