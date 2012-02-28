 <div class="row" id="contenido">
 	<?php
	$forms_nombre = isset($roleRow->form_nombre) ? $roleRow->form_nombre : set_value('form_nombre');
	$forms_nombre_action = isset($roleRow->forms_nombre_action) ? $roleRow->forms_nombre_action : set_value('forms_nombre_action');
	$grupos_fields_id = isset($roleRow->grupos_fields_id) ? $roleRow->grupos_fields_id : set_value('grupos_fields_id');
	
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
					<?php } ?>
					
					<div class="row">
                		<div class="span6 control-group <?php if(form_error($def_forms_nombre_action['name']) != "") echo "error"; ?>">
                            <?php echo form_label('Nombre del Action: <small>(Método dentro del controller)</small><i class="icon-asterisk"></i>', $def_forms_nombre_action['name']); ?>
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