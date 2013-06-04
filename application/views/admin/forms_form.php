
 	<?php
	$forms_nombre = isset($row->forms_nombre) ? $row->forms_nombre : set_value('forms_nombre');
	$forms_texto_boton_enviar = isset($row->forms_texto_boton_enviar) ? $row->forms_texto_boton_enviar : set_value('forms_texto_boton_enviar');
	$forms_titulo = isset($row->forms_titulo) ? $row->forms_titulo : set_value('forms_titulo');
	$forms_descripcion = isset($row->forms_descripcion) ? $row->forms_descripcion : set_value('forms_descripcion');
	$forms_nombre_action = isset($row->forms_nombre_action) ? $row->forms_nombre_action : set_value('forms_nombre_action');
	$grupos_fields_id = isset($row->grupos_fields_id) ? $row->grupos_fields_id : set_value('grupos_fields_id');
	
	$def_form_nombre = array(
	        'name'              => 'forms_nombre',
	        'value'             => $forms_nombre,
	        'class'             => 'text span5',
	        'id'                => 'forms_nombre'
	);
	$def_forms_texto_boton_enviar = array(
	        'name'              => 'forms_texto_boton_enviar',
	        'value'             => $forms_texto_boton_enviar,
	        'class'             => 'text span5',
	        'id'                => 'forms_texto_boton_enviar'
	);
	$def_forms_titulo = array(
	        'name'              => 'forms_titulo',
	        'value'             => $forms_titulo,
	        'class'             => 'text span5',
	        'id'                => 'forms_titulo'
	);
	$forms_descripcion = array(
	        'name'              => 'forms_descripcion',
	        'value'             => $forms_descripcion,
	        'class'             => 'text span5',
	        'id'                => 'forms_descripcion'
	);
	$def_form_nombre = array(
	        'name'              => 'forms_nombre',
	        'value'             => $forms_nombre,
	        'class'             => 'text span5',
	        'id'                => 'forms_nombre'
	);
	$def_forms_nombre_action = array(
	        'name'              => 'forms_nombre_action',
	        'value'             => $forms_nombre_action,
	        'class'             => 'text span5',
	        'id'                => 'forms_nombre_action'
	);
	$def_grupos_fields_id = array(
	        'name'              => 'grupos_fields_id',
	        'value'             => $grupos_fields_id,
	        'class'             => 'text span5',
	        'id'                => 'grupos_fields_id'
	);
	
	?>

	<div class="row">
            <div class="span12 margin-bottom-10">
                	<div class="row">
	               		<div class="span12">
	                		<h2><?php if(isset($t)) { echo $t;} ?></h2>
	                	</div>
                	</div>
	        </div>			
	        

            <div class="span12">
            	
            	<div class="row margin-bottom-10">
                  <div class="alert span5 alert-error margin-top-10" id="resultado-operacion" style="display: none;"></div>
                </div>
                
                <?php echo form_open($this->uri->uri_string()); ?>
					<div class="row">
                		<div class="span6 control-group <?php if(form_error($def_form_nombre['name']) != "") echo "error"; ?>">
                            <?php echo form_label('Nombre del Form<i class="icon-asterisk"></i>', $def_form_nombre['name']); ?>
                            <?php echo form_input($def_form_nombre); ?>
                            
							<?php if(form_error($def_form_nombre['name']) != "" || isset($errors[$def_form_nombre['name']])) {?>
							<div class="row">
                                <div class="alert span4 alert-error">
							        <?php echo form_error($def_form_nombre['name']); ?><?php echo isset($errors[$def_form_nombre['name']])?$errors[$def_form_nombre['name']]:''; ?>
							    </div>
							</div>
				   			<?php } ?>
				    	</div>
					</div>
					
					<div class="row">
                		<div class="span6 control-group <?php if(form_error($def_forms_titulo['name']) != "") echo "error"; ?>">
                            <?php echo form_label('Titulo del form', $def_forms_titulo['name']); ?>
                            <?php echo form_input($def_forms_titulo); ?>
                            
							<?php if(form_error($def_forms_titulo['name']) != "" || isset($errors[$def_forms_titulo['name']])) {?>
							<div class="row">
                                <div class="alert span4 alert-error">
							        <?php echo form_error($def_forms_titulo['name']); ?><?php echo isset($errors[$def_forms_titulo['name']])?$errors[$def_forms_titulo['name']]:''; ?>
							    </div>
							</div>
				   			<?php } ?>
				    	</div>
					</div>
					
					<div class="row">
                		<div class="span6 control-group <?php if(form_error($def_forms_texto_boton_enviar['name']) != "") echo "error"; ?>">
                            <?php echo form_label('Texto para el boton de envío del formulario', $def_forms_texto_boton_enviar['name']); ?>
                            <?php echo form_input($def_forms_texto_boton_enviar); ?>
                            
							<?php if(form_error($def_forms_texto_boton_enviar['name']) != "" || isset($errors[$def_forms_texto_boton_enviar['name']])) {?>
							<div class="row">
                                <div class="alert span4 alert-error">
							        <?php echo form_error($def_forms_texto_boton_enviar['name']); ?><?php echo isset($errors[$def_forms_texto_boton_enviar['name']])?$errors[$def_forms_texto_boton_enviar['name']]:''; ?>
							    </div>
							</div>
				   			<?php } ?>
				    	</div>
					</div>
					
					<div class="row">
                		<div class="span6 control-group <?php if(form_error($forms_descripcion['name']) != "") echo "error"; ?>">
                            <?php echo form_label('Descripcion del Form', $forms_descripcion['name']); ?>
                            <?php echo form_textarea($forms_descripcion); ?>
                            
							<?php if(form_error($forms_descripcion['name']) != "" || isset($errors[$forms_descripcion['name']])) {?>
							<div class="row">
                                <div class="alert span4 alert-error">
							        <?php echo form_error($forms_descripcion['name']); ?><?php echo isset($errors[$forms_descripcion['name']])?$errors[$forms_descripcion['name']]:''; ?>
							    </div>
							</div>
				   			<?php } ?>
				    	</div>
					</div>
					
					<?php if(isset($grupos_fields)) { ?>
                    <div class="row">
                		<div class="span6 control-group">
                            <?php echo form_label('Grupo Field', 'grupo_id'); ?></td>
                                    <?php
										
										foreach($grupos_fields as $grupo_field)
                                        {
                                        	$options[$grupo_field['grupos_fields_id']] = $grupo_field['grupos_fields_nombre'];
                                        }
                                        if(isset($row)) {									
                                        	echo form_dropdown("grupos_fields_id", $options, $row->grupos_fields_id);
                                        } else {
                                        	echo form_dropdown("grupos_fields_id", $options);
                                        }
                                    ?>
                           
                    	</div>
					</div>
					<?php } ?>
					
					<div class="row">
                		<div class="span6 control-group <?php if(form_error($def_forms_nombre_action['name']) != "") echo "error"; ?>">
                            <?php echo form_label('Nombre del Action: <small>(Método dentro del controller)</small>', $def_forms_nombre_action['name']); ?>
                            <?php echo form_input($def_forms_nombre_action); ?>
                            
							<?php if(form_error($def_forms_nombre_action['name']) != "" || isset($errors[$def_forms_nombre_action['name']])) {?>
							<div class="row">
                                <div class="alert span4 alert-error">
							        <?php echo form_error($def_forms_nombre_action['name']); ?><?php echo isset($errors[$def_forms_nombre_action['name']])?$errors[$def_forms_nombre_action['name']]:''; ?>
							    </div>
							</div>
				   			<?php } ?>
				    	</div>
					</div>
 
                    <p><input type="submit" class="btn btn-primary btn-large" value="<?php if(isset($tb)) echo $tb; ?>" /></p>
                    <?php echo form_close(); ?>
                                                              
            </div><!--fin span12-->		
					
	</div><!--fin row formulario-->		