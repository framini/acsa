<?php

$nombre_producto = isset($row_producto[0]['nombre']) ? $row_producto[0]['nombre'] : set_value('nombre');
$precio_producto = isset($row_producto[0]['saldo']) ? $row_producto[0]['saldo'] : set_value('saldo');
$precio_producto2 = isset($row_producto[0]['saldo_a_pagar']) ? $row_producto[0]['saldo_a_pagar'] : set_value('saldo_a_pagar');


$calidad_producto = isset($row_producto[0]['owner']) ? $row_producto[0]['owner'] : set_value('owner');
$aforo_producto = isset($row_producto[0]['empresa']) ? $row_producto[0]['empresa'] : set_value('empresa');


$nombre = array(
      'name'	=> 'nombre',
      'id'		=> 'nombre',
      'value'   => $nombre_producto,
      'class'   => 'span5',
);

$precio = array(
	'name'	=> 'saldo',
	'id'	=> 'saldo',
	'value'	=> $precio_producto,
    'class' => 'span5',
);

$precio2 = array(
	'name'	=> 'saldo_a_pagar',
	'id'	=> 'saldo_a_pagar',
	'value'	=> $precio_producto2,
    'class' => 'span5',
);

$calidad = array(
	'name'	=> 'owner',
	'id'	=> 'owner',
	'value'	=> $calidad_producto,
    'class' => 'span5',
);

$aforo = array(
	'name'	=> 'empresa',
	'id'	=> 'empresa',
	'value'	=> $aforo_producto,
    'class' => 'span5',
);

?>

<div class="row">
	
	<script type="text/javascript">
		$(function() {

			$('#empresa').change(function(e) {
				window.location = <?php echo '"' . site_url() . '"' ?> + "/adm/personas/registro_cuenta_corriente/" + $(this).val();
			});

			$('.btn-large.btn-primary').on('click', function(event) {

				event.preventDefault();
				
				//url para la peticion AJAX
				var uri = "<?php $uri = site_url() . "/" .$this->uri->uri_string(); echo $uri; ?>";
				
				//Seleccionamos los inputs
				var campos = {
					saldo: $('#saldo').val(),
					saldo_a_pagar: $('#saldo_a_pagar').val()
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
								.delay(2500)
								.slideDown('slow', function() {
									window.location = "<?php $uri = site_url() . "/" . "adm/personas/gestionar_cuentas_corrientes"; echo $uri; ?>";
								});
						}
						
					}
				});
			});
		});
	</script>

        <div class="span12 margin-bottom-10">
                	<div class="row">
	               		<div class="span12">
	                		<h2><?php if(isset($tf)) echo $tf; else echo "Agregar Cuenta Corriente"; ?></h2>
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
                    	<?php echo form_label('Nombre', 'nombre'); ?></td>
                        <div class="controls controls-row">
                        	<span class="input-xlarge uneditable-input"><?php echo $row_producto[0]['nombre']; ?></span>
                        </div>
                  </div>
            </div>
			
			<div class="row">
        		<div class="span6 control-group <?php if(form_error($precio['name']) != "") echo "error"; ?>">
                    <?php echo form_label('Saldo: <i class="icon-asterisk"></i>', $precio['id']); ?>
                    <?php echo form_input($precio); ?>
                    	<?php if(form_error($precio['name']) != "" || isset($errors[$precio['name']])) {?>
                    	<div class="alert alert-error error-gral span5"><?php echo form_error($precio['name']); ?><?php echo isset($errors[$precio['name']])?$errors[$precio['name']]:''; ?></div>
                    	<?php } ?>
				</div>
			</div>

			<div class="row">
        		<div class="span6 control-group <?php if(form_error($precio2['name']) != "") echo "error"; ?>">
                    <?php echo form_label('Saldo a pagar: <i class="icon-asterisk"></i>', $precio2['id']); ?>
                    <?php echo form_input($precio2); ?>
                    	<?php if(form_error($precio2['name']) != "" || isset($errors[$precio2['name']])) {?>
                    	<div class="alert alert-error error-gral span5"><?php echo form_error($precio2['name']); ?><?php echo isset($errors[$precio2['name']])?$errors[$precio2['name']]:''; ?></div>
                    	<?php } ?>
				</div>
			</div>
			
			<div class="row">
        		<div class="span6 control-group">
                    	<?php echo form_label('Owner', 'owner'); ?></td>
                        <div class="controls controls-row">
                        	<span class="input-xlarge uneditable-input"><?php echo $row_producto[0]['owner']; ?></span>
                        </div>
                  </div>
            </div>

            <?php //echo form_submit('register', 'Crear Cuenta'); ?>
            <p><input type="submit" class="btn btn-large btn-primary" value="<?php if(isset($tb)) echo $tb; else echo "Crear Producto"; ?>" name="register" /></p>
            <?php echo form_close(); ?>
    </div>		
    <!-- .block_content ends -->
					
</div>		