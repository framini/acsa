 	<?php
	$grupo_template = isset($template_data) ? $template_data : set_value('grupos_fields_nombre');
	
	$grupo_template_nombre = array(
	        'name'              => 'nombre',
	        'value'             => $grupo_template,
	        'class'             => 'text span5',
	        'id'                => 'nombre'
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
                
                <?php if(isset($fa)) echo form_open($fa); else echo form_open($this->uri->uri_string()); ?>
					<div class="row">
                		<div class="span6 control-group <?php if(form_error($grupo_template_nombre['name']) != "") echo "error"; ?>">
                            <?php echo form_label('Nombre Grupo Template <i class="icon-asterisk"></i>', $grupo_template_nombre['name']); ?>
                            <?php echo form_input($grupo_template_nombre); ?>
                            
							<?php if(form_error($grupo_template_nombre['name']) != "" || isset($errors[$grupo_template_nombre['name']])) {?>
							<div class="row">
                                <div class="alert span4 alert-error">
							        <?php echo form_error($grupo_template_nombre['name']); ?><?php echo isset($errors[$grupo_template_nombre['name']])?$errors[$grupo_template_nombre['name']]:''; ?>
							    </div>
							</div>
				   			<?php } ?>
				    	</div>
					</div>
 
                    <p><input type="submit" class="btn btn-primary btn-large" value="<?php if(isset($tb)) echo $tb; ?>" /></p>
                    <?php echo form_close(); ?>
                                                              
            </div><!--fin span12-->		
					
	</div><!--fin row formulario-->		


