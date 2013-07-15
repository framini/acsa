<?php

$com = array(
	'name' => 'comision', 
	'id' => 'comision',
	'value' => isset($comision) ? $comision->comision : ""
);

?>

<div class="row">

        <div class="span12 margin-bottom-10">
        	<div class="row">
           		<div class="span12">
            		<h2><?php if(isset($tf)) echo $tf; else echo "Agregar Producto"; ?></h2>
            	</div>
        	</div>
        </div>		
        <!-- .block_head ends -->
        <div class="span12">
        	<div class="row margin-bottom-10">
              	<div class="alert span5 alert-error margin-top-10" id="resultado-operacion" style="display: none;"></div>
            </div>
            <?php echo form_open($this->uri->uri_string()); ?>

				<div class="row">
            		<div class="span6 control-group">
                        	<?php echo form_label('Productos', 'productos'); ?></td>
                            <?php
                                echo '<select name="productos" class="listas-padding span5" id="productos">';
                                foreach($productos as $prd)
                                {
                                   echo '<option value="' . $prd['producto_id'] . '"';
                                   if( isset($comision) && $comision->producto_id == $prd['producto_id'] ) echo 'selected="selected"';
								   echo '>' . $prd['nombre'] . "</option>";
                                }
                                echo '</select>';
                            ?>
                      </div>
                </div>

                <div class="row">
            		<div class="span6 control-group">
                        <?php echo form_label('Comision: <i class="icon-asterisk"></i>', 'comision'); ?>
                        <?php echo form_input($com); ?>
					</div>
				</div>

                <?php //echo form_submit('register', 'Crear Cuenta'); ?>
                <p><input type="submit" class="btn btn-large btn-primary" value="Registrar comision"  /></p>
                <?php echo form_close(); ?>
        </div>		
        <!-- .block_content ends -->
					
</div>		