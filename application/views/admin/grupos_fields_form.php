 	<?php
	$grupo_field = isset($roleRow->grupos_fields_nombre) ? $roleRow->grupos_fields_nombre : set_value('grupos_fields_nombre');
	
	$grupos_fields_nombre = array(
	        'name'              => 'grupos_fields_nombre',
	        'value'             => $grupo_field,
	        'class'             => 'text span5',
	        'id'                => 'grupos_fields_nombre'
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
                		<div class="span6 control-group <?php if(form_error($grupos_fields_nombre['name']) != "") echo "error"; ?>">
                            <?php echo form_label('Nombre Grupo Field <i class="icon-asterisk"></i>', $grupos_fields_nombre['name']); ?>
                            <?php echo form_input($grupos_fields_nombre); ?>
                            
							<?php if(form_error($grupos_fields_nombre['name']) != "" || isset($errors[$grupos_fields_nombre['name']])) {?>
							<div class="row">
                                <div class="alert span4 alert-error">
							        <?php echo form_error($grupos_fields_nombre['name']); ?><?php echo isset($errors[$grupos_fields_nombre['name']])?$errors[$grupos_fields_nombre['name']]:''; ?>
							    </div>
							</div>
				   			<?php } ?>
				    	</div>
					</div>
 
                    <p><input type="submit" class="btn btn-primary btn-large" value="<?php if(isset($tb)) echo $tb; ?>" /></p>
                    <?php echo form_close(); ?>
                                                              
            </div><!--fin span12-->		
					
	</div><!--fin row formulario-->		


