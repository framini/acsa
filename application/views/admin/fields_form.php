
 	<?php
	$fields_nombre = isset($roleRow->fields_nombre) ? $roleRow->fields_nombre : set_value('fields_nombre');
	$fields_label = isset($roleRow->fields_label) ? $roleRow->fields_label : set_value('fields_label');
	$fields_instrucciones = isset($roleRow->fields_instrucciones) ? $roleRow->fields_instrucciones : set_value('fields_instrucciones');
	$fields_option_items = isset($roleRow->fields_option_items) ? $roleRow->fields_option_items : set_value('fields_option_items');
	$fields_posicion = isset($roleRow->fields_posicion) ? $roleRow->fields_posicion : set_value('fields_posicion');
	
	//Si usamos el form para dar de alta un field, tuvimos que haber definido la posicion recomendado para el form
	if(isset($ordenSiguiente)) $fields_posicion = $ordenSiguiente;
	//No requeridos
	$fields_value_defecto = isset($roleRow->fields_value_defecto) ? $roleRow->fields_value_defecto : set_value('fields_value_defecto');
	$fields_requerido = isset($roleRow->fields_requerido) ? $roleRow->fields_requerido : set_value('fields_requerido');
	$fields_hidden = isset($roleRow->fields_hidden) ? $roleRow->fields_hidden : set_value('fields_hidden');
	
	$def_fields_nombre = array(
	        'name'              => 'fields_nombre',
	        'value'             => $fields_nombre,
	        'class'             => 'text span5',
	        'id'                => 'fields_nombre'
	);
	$def_fields_label = array(
	        'name'              => 'fields_label',
	        'value'             => $fields_label,
	        'class'             => 'text span5',
	        'id'                => 'fields_label'
	);
	$def_fields_instrucciones = array(
	        'name'              => 'fields_instrucciones',
	        'value'             => $fields_instrucciones,
	        'class'             => 'text span5',
	        'id'                => 'fields_instrucciones'
	);
	$def_fields_option_items = array(
	        'name'              => 'fields_option_items',
	        'value'             => $fields_option_items,
	        'class'             => 'text span5',
	        'id'                => 'fields_option_items'
	);
	$def_fields_posicion = array(
	        'name'              => 'fields_posicion',
	        'value'             => $fields_posicion,
	        'class'             => 'text span5',
	        'id'                => 'fields_posicion'
	);
	$fields_value_defecto = array(
	        'name'              => 'fields_value_defecto',
	        'value'             => $fields_value_defecto,
	        'class'             => 'text span5',
	        'id'                => 'fields_value_defecto'
	);
	$fields_requerido_si = array(
	        'name'              => 'fields_requerido',
	        'value'             => '1',
	        'class'             => 'text span5',
	        'id'                => 'fields_requerido'
	);
	$fields_requerido_no = array(
	        'name'              => 'fields_requerido',
	        'value'             => '0',
	        'class'             => 'text span5',
	        'id'                => 'fields_requerido'
	);
	$fields_hidden_si = array(
	        'name'              => 'fields_hidden',
	        'value'             => '1',
	        'class'             => 'text span5',
	        'id'                => 'fields_hidden'
	);
	$fields_hidden_no = array(
	        'name'              => 'fields_hidden',
	        'value'             => '0',
	        'class'             => 'text span5',
	        'id'                => 'fields_hidden'
	);
	
	?>
	<script type="text/javascript">
		
	</script>
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
                	<?php if(isset($grupos_fields)) { ?>
                    <div class="row">
                		<div class="span6 control-group">
                            <?php echo form_label('Grupo Field', 'grupo_id'); ?></td>
                                    <?php
                                        echo '<select name="grupos_fields_id" class="listas-padding span5" id="empresas_dd">';
                                        foreach($grupos_fields as $grupo_field)
                                        {
                                           echo '<option value="' . $grupo_field['grupos_fields_id'] . '">' . $grupo_field['grupos_fields_nombre'] . "</option>";
                                        }
                                        echo '</select>';
                                    ?>
                           
                    	</div>
					</div>
					<?php } else { ?>
						<input type="hidden" name="grupos_fields_id" value="<?php echo $this->uri->segment(3); ?>" id="grupos_fields_id" />
					<?php } ?>
					
					<div class="row">
                		<div class="span6 control-group <?php if(form_error($def_fields_nombre['name']) != "") echo "error"; ?>">
                            <?php echo form_label('Nombre del Field <i class="icon-asterisk"></i>', $def_fields_nombre['name']); ?>
                            <?php echo form_input($def_fields_nombre); ?>
                            
							<?php if(form_error($def_fields_nombre['name']) != "" || isset($errors[$def_fields_nombre['name']])) {?>
							<div class="row">
                                <div class="alert span4 alert-error">
							        <?php echo form_error($def_fields_nombre['name']); ?><?php echo isset($errors[$def_fields_nombre['name']])?$errors[$def_fields_nombre['name']]:''; ?>
							    </div>
							</div>
				   			<?php } ?>
				    	</div>
					</div>
					
					<?php if(isset($fields_types)) { ?>
                    <div class="row">
                		<div class="span6 control-group">
                            <?php echo form_label('Field Type', 'grupo_id'); ?></td>
                                    <?php
                                        echo '<select name="fields_type_id" class="listas-padding span5" id="fields_type_id">';
                                        foreach($fields_types as $field_type)
                                        {
                                           echo '<option value="' . $field_type['fields_type_id'] . '">' . $field_type['fields_type_nombre'] . "</option>";
                                        }
                                        echo '</select>';
                                    ?>
                           
                    	</div>
					</div>
					<?php } ?>
					
					<div class="row">
                		<div class="span6 control-group <?php if(form_error($def_fields_option_items['name']) != "") echo "error"; ?>" id="<?php echo $def_fields_option_items['name']; ?>">
                            <?php echo form_label('Listar las Options para el Dropdown<br/><small>Forma: "value":"Texto" separadas por coma</small>', $def_fields_option_items['name']); ?>
                            <?php echo form_textarea($def_fields_option_items); ?>
                            
							<?php if(form_error($def_fields_option_items['name']) != "" || isset($errors[$def_fields_option_items['name']])) {?>
							<div class="row">
                                <div class="alert span4 alert-error">
							        <?php echo form_error($def_fields_option_items['name']); ?><?php echo isset($errors[$def_fields_option_items['name']])?$errors[$def_fields_option_items['name']]:''; ?>
							    </div>
							</div>
				   			<?php } ?>
				    	</div>
					</div>
					
					<div class="row">
                		<div class="span6 control-group <?php if(form_error($def_fields_label['name']) != "") echo "error"; ?>">
                            <?php echo form_label('Label para el Field <i class="icon-asterisk"></i>', $def_fields_label['name']); ?>
                            <?php echo form_input($def_fields_label); ?>
                            
							<?php if(form_error($def_fields_label['name']) != "" || isset($errors[$def_fields_label['name']])) {?>
							<div class="row">
                                <div class="alert span4 alert-error">
							        <?php echo form_error($def_fields_label['name']); ?><?php echo isset($errors[$def_fields_label['name']])?$errors[$def_fields_label['name']]:''; ?>
							    </div>
							</div>
				   			<?php } ?>
				    	</div>
					</div>
					
					<div class="row">
                		<div class="span6 control-group <?php if(form_error($def_fields_instrucciones['name']) != "") echo "error"; ?>">
                            <?php echo form_label('Instrucciones para el Field <i class="icon-asterisk"></i>', $def_fields_instrucciones['name']); ?>
                            <?php echo form_textarea($def_fields_instrucciones); ?>
                            
							<?php if(form_error($def_fields_instrucciones['name']) != "" || isset($errors[$def_fields_instrucciones['name']])) {?>
							<div class="row">
                                <div class="alert span4 alert-error">
							        <?php echo form_error($def_fields_instrucciones['name']); ?><?php echo isset($errors[$def_fields_instrucciones['name']])?$errors[$def_fields_instrucciones['name']]:''; ?>
							    </div>
							</div>
				   			<?php } ?>
				    	</div>
					</div>
					<div class="row">
                		<div class="span6 control-group <?php if(form_error($def_fields_posicion['name']) != "") echo "error"; ?>">
                            <?php echo form_label('Posicion (ubicación) del Field dentro del formulario <i class="icon-asterisk"></i>', $def_fields_posicion['name']); ?>
                            <?php echo form_input($def_fields_posicion); ?>
                            
							<?php if(form_error($def_fields_posicion['name']) != "" || isset($errors[$def_fields_posicion['name']])) {?>
							<div class="row">
                                <div class="alert span4 alert-error">
							        <?php echo form_error($def_fields_posicion['name']); ?><?php echo isset($errors[$def_fields_posicion['name']])?$errors[$def_fields_posicion['name']]:''; ?>
							    </div>
							</div>
				   			<?php } ?>
				    	</div>
					</div>
					
					<div class="row" id="valor_defecto">
                		<div class="span6 control-group">
                            <?php echo form_label('Valor por defecto para el Field', $fields_value_defecto['name']); ?>
                            <?php echo form_input($fields_value_defecto); ?>
				    	</div>
					</div>
					
					<div class="row">
                		<div class="span6 control-group">
                            <?php echo form_label('El field será requerído?', $fields_requerido_si['name']); ?>
                            	<label class="radio">
				                	<input type="radio" value="<?php echo $fields_requerido_si['value']; ?>" id="<?php echo $fields_requerido_si['id']; ?>" name="<?php echo $fields_requerido_si['name']; ?>">
				                	Si
				            	</label>
				              	<label class="radio">
				                	<input type="radio" checked="checked" value="<?php echo $fields_requerido_no['value']; ?>" id="<?php echo $fields_requerido_no['id']; ?>" name="<?php echo $fields_requerido_no['name']; ?>">
				                	No
				            	</label>
				    	</div>
					</div>
					
					<div class="row">
                		<div class="span6 control-group" id="tipo_hidden">
                            <?php echo form_label('El field será de tipo hidden?', $fields_hidden_si['name']); ?>
                            <div class="controls">
				            	<label class="radio">
				                	<input type="radio" value="<?php echo $fields_hidden_si['value']; ?>" id="<?php echo $fields_hidden_no['id']; ?>" name="<?php echo $fields_hidden_no['name']; ?>">
				                	Si
				             	</label>
				              		<label class="radio">
				                	<input type="radio" checked="checked" value="<?php echo $fields_hidden_no['value']; ?>" id="<?php echo $fields_hidden_no['id']; ?>" name="<?php echo $fields_hidden_no['name']; ?>">
				                	No
				               </label>
				            </div>
				    	</div>
					</div>
 
                    <p><input type="submit" class="btn btn-primary btn-large" value="<?php if(isset($tb)) echo $tb; ?>" /></p>
                    <?php echo form_close(); ?>
                                                              
            </div><!--fin span12-->		
					
	</div><!--fin row formulario-->		


