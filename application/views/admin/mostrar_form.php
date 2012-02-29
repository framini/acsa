 
 	<?php
	if(isset($datos_fields)) {
		foreach($datos_fields as $dato_field) {
			$fields[] = array(
				'name'              => $dato_field['fields_nombre'],
		        'value'             => $dato_field['fields_value_defecto'],
		        'class'             => 'text span5',
		        'id'                => $dato_field['fields_nombre']
			);
		}
	}

	?>
<!--<input type="<?php echo $dato_field['fields_type']; ?>" name="<?php echo $dato_field['fields_nombre']; ?>" id="<?php echo $dato_field['fields_nombre']; ?>" value="<?php echo $dato_field['fields_value_defecto']; ?>" />-->
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
					<?php if(isset($datos_fieldsss)) { ?>
                    <div class="row">
                		<div class="span6 control-group">
                            <?php echo form_label($dato_field['fields_label'], 'fields_type_id'); ?>
                                    <?php
                                        echo '<select name="fields_type_id" class="listas-padding span5" id="fields_type_id">';
                                        foreach($datos_fields as $dato_field)
                                        {
                                           echo '<option value="' . $dato_field['fields_type_id'] . '">' . $grupo_field['fields_type_nombre'] . "</option>";
                                        }
                                        echo '</select>';
                                    ?>
                           
                    	</div>
					</div>
					<?php }?>
					
					<?php if(isset($fields)) { ?>
						<?php $indice = 0; foreach($datos_parseados as $dato_parseado) { ?>
						<div class="row">
                		<div class="span6 control-group ">
                            <?php echo form_label($datos_fields[$indice]['fields_label'], $datos_fields[$indice]['fields_label']); ?>
							<?php echo call_user_func($datos_fields[$indice]['fields_constructor'], $dato_parseado['name'], $dato_parseado['atributos']);?>
				    	</div>
					</div>
						<?php $indice++; }?>
					<?php }?>
 
                    <p><input type="submit" class="btn btn-primary btn-large" value="<?php if(isset($tb)) echo $tb; ?>" /></p>
                    <?php echo form_close(); ?>
                                                              
            </div><!--fin span12-->		
					
	</div><!--fin row formulario-->		