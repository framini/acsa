 	<?php
 	//print_r($template_data); die();
	$grupo_template = isset($template_data) ? $template_data['nombre'] : set_value('grupos_fields_nombre');
	$grupo_template_default = isset($template_data) ? $template_data['grupo_default'] : set_value('grupos_fields_grupo_default');
	
	$grupo_template_nombre = array(
	        'name'              => 'nombre',
	        'value'             => $grupo_template,
	        'class'             => 'text span5',
	        'id'                => 'nombre'
	);
	
	$grupo_template_grupo_default = array(
	        'name'              => 'grupo_default',
	        'value'             => $grupo_template_default,
	        'class'             => 'text span5',
	        'id'                => 'grupo_default'
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
					
					<div class="row">
						<div class="span5 control-group">
				    		

				    			<div class="well">
				    				<?php echo form_label('Grupo default?', $grupo_template_grupo_default['name']); ?>
				    				<small class="text-success"><em>Cuando se ingrese a la direccion base del sitio: <strong><?php echo site_url(); ?></strong> se usará este grupo para mostrar contenido</em></small><br/>
				    				<input type="checkbox" value="y" name="<?php echo $grupo_template_grupo_default['name']; ?>" <?php if( $grupo_template_grupo_default['value'] == "y" ) echo "checked='checked'"; ?> />
				    			</div>
				    		
                            
				    	</div>
					</div>
 
                    <p><input type="submit" class="btn btn-primary btn-large" value="<?php if(isset($tb)) echo $tb; ?>" /></p>
                    <?php echo form_close(); ?>
                                                              
            </div><!--fin span12-->		
					
	</div><!--fin row formulario-->		


