 
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
	
	//Inputs comunes a todos los forms
	if(isset($valores_campos)) {
		$titulo = ($valores_campos['titulo']['atributos']);
		$url_titulo = ($valores_campos['url_titulo']['atributos']);
	} else {
		$titulo = array(
		'name'              => 'titulo',
        'value'             => '',
        'class'             => 'text span5',
        'id'                => 'titulo'
		);
		$url_titulo = array(
	        'value'             => '',
	        'class'             => 'text span5',
	        'id'                => 'url_titulo'
		);
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
	        

            <div class="span6">
            	
            	<div class="row margin-bottom-10">
                  <div class="alert span5 alert-error margin-top-10" id="resultado-operacion" style="display: none;"></div>
                </div>
                
                <?php echo form_open($this->uri->uri_string()); ?>
                	<?php //Inputs comunes a todos los forms ?>
                	<div class="row">
                		<div class="span6 control-group ">
                			<?php echo form_label("Titulo", $titulo['id']); ?>
                			<?php echo form_input("titulo", $titulo); ?>
                		</div>
                	</div>
                	<div class="row">
                		<div class="span6 control-group ">
                			<?php echo form_label("URL (deberia ser igual al Titulo pero sin espacios)", $url_titulo['id']); ?>
                			<?php echo form_input("url_titulo", $url_titulo); ?>
                		</div>
                	</div>
					
					<?php if(isset($fields)) { ?>
						<?php $indice = 0; foreach($datos_parseados as $dato_parseado) { ?>
						<div class="row">
                		<div class="span6 control-group ">
                            <?php echo form_label($datos_fields[$indice]['fields_label'], $datos_fields[$indice]['fields_label']); ?>
                            <?php
                            	//Comprobamos si estamos en modo edicion con solo chequear la existencia de un array
                            	if(isset($valores_campos)) {
                            		//Si está buscamos los datos almacenados en el para mostrar en los campos los datos almacenados en ellos en la BDD
									$dato_parseado['atributos'] = $valores_campos["field_id_" . $datos_fields[$indice]['fields_id']]['atributos'];
								} 
                            ?>
							<?php echo call_user_func($datos_fields[$indice]['fields_constructor'], 'field_id_' . $datos_fields[$indice]['fields_id'], $dato_parseado['atributos']);?>
				    	</div>
					</div>
						<?php $indice++; }?>
					<?php }?>
 
                    <p><input type="submit" class="btn btn-primary btn-large" value="<?php if(isset($tb)) echo $tb; ?>" /></p>
                    <?php echo form_close(); ?>
                                                              
            </div><!--fin span12-->
            <?php if(isset($datos_extras)) { ?>
            <div class="span6">
            	    <div class="well alert-info">
					    <ul class="margin-bot-none sin-estilo">
					    	<?php foreach ($datos_extras as $key => $value) { 
								echo "<li><h6>". format_texto($key) . "</h6>" . $value . "</li>";
							 } ?>
					    </ul>
				    </div>
            </div>
            <?php } ?>
					
	</div><!--fin row formulario-->		