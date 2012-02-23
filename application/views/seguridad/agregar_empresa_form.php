<?php
$nombre_empresa = isset($row_empresa[0]['nombre']) ? $row_empresa[0]['nombre'] : set_value('nombre');
$cuit_empresa = isset($row_empresa[0]['cuit']) ? $row_empresa[0]['cuit'] : set_value('cuit');
$tipo_empresaid_empresa = isset($row_empresa[0]['tipo_empresa_id']) ? $row_empresa[0]['tipo_empresa_id'] : set_value('tipo_empresa_id');

$empresa = array(
                  'name'	=> 'nombre',
                  'id'	=> 'nombre',
                  'value'        => $nombre_empresa,
                  'class'   => 'span5',
);

$cuit = array(
	'name'	=> 'cuit',
	'id'	=> 'cuit',
	'value'	=> $cuit_empresa,
    'class'        => 'span5',
);
?>

<div class="row">

        <div class="span12 margin-bottom-10">
                	<div class="row">
	               		<div class="span12">
	                		<h2><?php if(isset($tf)) echo $tf; else echo "Agregar Empresa"; ?></h2>
	                	</div>
                	</div>
        </div>		
        <!-- .block_head ends -->
                            <div class="span12">
                                <?php echo form_open($this->uri->uri_string()); ?>
                                	<div class="row">
                                		<div class="span6 control-group <?php if(form_error($empresa['name']) != "") echo "error"; ?>">
		                                    <?php echo form_label('Nombre Empresa: <i class="icon-asterisk"></i>', $empresa['id']); ?>
		                                    <?php echo form_input($empresa); ?>
		                                    	<?php if(form_error($empresa['name']) != "" || isset($errors[$empresa['name']])) {?>
		                                    	<div class="alert alert-error error-gral span5"><?php echo form_error($empresa['name']); ?><?php echo isset($errors[$empresa['name']])?$errors[$empresa['name']]:''; ?></div>
		                                    	<?php } ?>
										</div>
									</div>
									
									<div class="row">
                                		<div class="span6 control-group <?php if(form_error($cuit['name']) != "") echo "error"; ?>">
		                                    <?php echo form_label('Cuit: <i class="icon-asterisk"></i>', $cuit['id']); ?>
		                                    <?php echo form_input($cuit); ?>
		                                    	<?php if(form_error($cuit['name']) != "" || isset($errors[$cuit['name']])) {?>
		                                    	<div class="alert alert-error error-gral span5"><?php echo form_error($cuit['name']); ?><?php echo isset($errors[$cuit['name']])?$errors[$cuit['name']]:''; ?></div>
		                                    	<?php } ?>
										</div>
									</div>
									
									<div class="row">
										<div class="span6">
                                                <?php echo form_label('Tipos Empresas', 'tipo_empresa_id'); ?>

                                                <?php
                                                    echo '<select name="tipo_empresa_id" class="span5" id="tipo_empresa_id">';
                                                    foreach($tipos_empresas as $tipo_empresa)
                                                    {
                                                       if($tipo_empresaid_empresa == $tipo_empresa['tipo_empresa_id']) {
                                                       		echo '<option value="' . $tipo_empresa['tipo_empresa_id'] . '" selected="selected" >' . $tipo_empresa['tipo_empresa'] . "</option>";
                                                       } else {
                                                       		echo '<option value="' . $tipo_empresa['tipo_empresa_id'] . '">' . $tipo_empresa['tipo_empresa'] . "</option>";
                                                       }
                                                    }
                                                    echo '</select>';
                                                ?>
                                        </div>
									</div>

                                    <?php //echo form_submit('register', 'Crear Cuenta'); ?>
                                    <p><input type="submit" class="btn btn-large btn-primary" value="<?php if(isset($tb)) echo $tb; else echo "Crear Empresa"; ?>" name="register" /></p>
                                    <?php echo form_close(); ?>
                            </div>		
                            <!-- .block_content ends -->
					
</div>		