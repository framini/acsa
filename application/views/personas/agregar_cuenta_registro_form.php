<?php
$nombre_empresa = isset($row_empresa[0]['nombre']) ? $row_empresa[0]['nombre'] : set_value('nombre');
$codigo_empresa = isset($row_empresa[0]['codigo']) ? $row_empresa[0]['codigo'] : set_value('codigo');
$empresa_id = isset($row_empresa[0]['empresa_id']) ? $row_empresa[0]['empresa_id'] : set_value('empresa_id');
$tipo_cuentaregistroid_empresa = isset($row_empresa[0]['tipo_cuentaregistro_id']) ? $row_empresa[0]['tipo_cuentaregistro_id'] : set_value('tipo_cuentaregistro_id');

$empresa = array(
                  'name'	=> 'nombre',
                  'id'	=> 'nombre',
                  'value'        => $nombre_empresa,
                  'class'   => 'span5',
);

$codigo = array(
                  'name'	=> 'codigo',
                  'id'	=> 'codigo',
                  'value'        => $codigo_empresa,
                  'class'   => 'span5',
);

$emp_id = array(
	'name'	=> 'empresa_id',
	'id'	=> 'empresa_id',
	'value'	=> $empresa_id,
    'class'        => 'span5',
);

?>

<div class="row">
	
	<script type="text/javascript">
		$(function() {
			$('.btn-large.btn-primary').on('click', function(event) {
				event.preventDefault();
				
				//url para la peticion AJAX
				var uri = "<?php $uri = site_url() . "/" .$this->uri->uri_string(); echo $uri; ?>";
				
				//Seleccionamos los inputs
				var campos = {
					nombre: $('#nombre').val(),
					codigo: $('#codigo').val(),
					tipo_cuentaregistro_id: $('#tipo_cuentaregistro_id').val(),
					empresa_id : $('#empresa_id').val()
				};
				
				var param = $.extend({}, campos);
				
				$.ajax({
					url: uri,
					dataType: 'json',
					data: param,
					type: 'POST',
					success: function(data, textStatus, jqXHR) {
						if(data.error) {
							//Chequeamos si los mensajes vienen en forma de objetos
							//o simples string
							var msg = "";
							if($.isPlainObject(data.message)) {
								$.each(data.message, function(i, val){
									msg += "<p>" + val + "</p>";
								});
							} else {
								msg = data.message;
							}
							
							$('#resultado-operacion').html("");
							$('#resultado-operacion').slideUp('fast', function() {
								$(this).html(msg)} )
								.removeClass('alert-success')
								.addClass('alert-error')
								.delay(200)
								.slideDown('slow');
						} else {
							
							$('#resultado-operacion').text("");
							$('#resultado-operacion').slideUp('fast', function() {
								$(this).text(data.message)} )
								.removeClass('alert-error')
								.addClass('alert-success')
								.delay(200)
								.slideDown('slow')
								.delay(2000)
								.slideUp('slow');
						}
						
					}
				});
			});
		});
	</script>

        <div class="span12 margin-bottom-10">
                	<div class="row">
	               		<div class="span12">
	                		<h2><?php if(isset($tf)) echo $tf; else echo "Agregar Cuenta Registro"; ?></h2>
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
                                		<div class="span6 control-group <?php if(form_error($empresa['name']) != "") echo "error"; ?>">
		                                    <?php echo form_label('Nombre Cuenta Registro: <i class="icon-asterisk"></i>', $empresa['id']); ?>
		                                    <?php echo form_input($empresa); ?>
		                                    	<?php if(form_error($empresa['name']) != "" || isset($errors[$empresa['name']])) {?>
		                                    	<div class="alert alert-error error-gral span5"><?php echo form_error($empresa['name']); ?><?php echo isset($errors[$empresa['name']])?$errors[$empresa['name']]:''; ?></div>
		                                    	<?php } ?>
										</div>
									</div>
									
									<div class="row">
                                		<div class="span6 control-group <?php if(form_error($empresa['name']) != "") echo "error"; ?>">
		                                    <?php echo form_label('Codigo Empresa: <i class="icon-asterisk"></i>', $codigo['id']); ?>
		                                    <?php echo form_input($codigo); ?>
		                                    	<?php if(form_error($codigo['name']) != "" || isset($errors[$codigo['name']])) {?>
		                                    	<div class="alert alert-error error-gral span5"><?php echo form_error($codigo['name']); ?><?php echo isset($errors[$codigo['name']])?$errors[$codigo['name']]:''; ?></div>
		                                    	<?php } ?>
										</div>
									</div>
									
									
									<?php if( $this -> auth_frr -> es_admin() ) { ?>
									<div class="row">
										<div class="span6">
                                                <?php echo form_label('Empresa', 'empresa'); ?>

                                                <?php
                                                    echo '<select name="empresa_id" class="span5" id="empresa_id">';
                                                    foreach($empresas as $e)
                                                    {
                                                       if($empresa_id == $e['empresa_id']) {
                                                       		echo '<option value="' . $e['empresa_id'] . '" selected="selected" >' . $e['nombre'] . "</option>";
                                                       } else {
                                                       		echo '<option value="' . $e['empresa_id'] . '">' . $e['nombre'] . "</option>";
                                                       }
                                                    }
                                                    echo '</select>';
                                                ?>
                                        </div>
									</div>
									<?php } elseif( isset($eid) ) { ?>
										<input type="hidden" name="empresa_id" value="<?php echo $eid; ?>" />
									<?php } ?>
									
									<div class="row">
										<div class="span6">
                                                <?php echo form_label('Tipos Cuenta Registro', 'tipo_cuentaregistro_id'); ?>

                                                <?php
                                                    echo '<select name="tipo_cuentaregistro_id" class="span5" id="tipo_cuentaregistro_id">';
                                                    foreach($tipos_cuenta_registro as $tcr)
                                                    {
                                                       if($tipo_cuentaregistroid_empresa == $tcr['tipo_cuentaregistro_id']) {
                                                       		echo '<option value="' . $tcr['tipo_cuentaregistro_id'] . '" selected="selected" >' . $tcr['descripcion'] . "</option>";
                                                       } else {
                                                       		echo '<option value="' . $tcr['tipo_cuentaregistro_id'] . '">' . $tcr['descripcion'] . "</option>";
                                                       }
                                                    }
                                                    echo '</select>';
                                                ?>
                                        </div>
									</div>

                                    <?php //echo form_submit('register', 'Crear Cuenta'); ?>
                                    <p><input type="submit" class="btn btn-large btn-primary" value="<?php if(isset($tb)) echo $tb; else echo "Crear Cuenta Registro"; ?>" name="register" /></p>
                                    <?php echo form_close(); ?>
                            </div>		
                            <!-- .block_content ends -->
					
</div>		