<?php
$nombre_producto = isset($row_producto[0]['nombre']) ? $row_producto[0]['nombre'] : set_value('nombre');
$precio_producto = isset($row_producto[0]['precio']) ? $row_producto[0]['precio'] : set_value('precio');
$calidad_producto = isset($row_producto[0]['calidad']) ? $row_producto[0]['calidad'] : set_value('calidad');
$aforo_producto = isset($row_producto[0]['aforo']) ? $row_producto[0]['aforo'] : set_value('aforo');

$nombre = array(
                  'name'	=> 'nombre',
                  'id'		=> 'nombre',
                  'value'   => $nombre_producto,
                  'class'   => 'span5',
);

$precio = array(
	'name'	=> 'precio',
	'id'	=> 'precio',
	'value'	=> $precio_producto,
    'class' => 'span5',
);

$calidad = array(
	'name'	=> 'calidad',
	'id'	=> 'calidad',
	'value'	=> $calidad_producto,
    'class' => 'span5',
);

$aforo = array(
	'name'	=> 'aforo',
	'id'	=> 'aforo',
	'value'	=> $aforo_producto,
    'class' => 'span5',
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
					precio: $('#precio').val(),
					calidad: $('#calidad').val(),
					aforo:   $('#aforo').val()
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
									window.location = "<?php $uri = site_url() . "/" . "productos/gestionar_productos"; echo $uri; ?>";
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
                                		<div class="span6 control-group <?php if(form_error($nombre['name']) != "") echo "error"; ?>">
		                                    <?php echo form_label('Nombre Producto: <i class="icon-asterisk"></i>', $nombre['id']); ?>
		                                    <?php echo form_input($nombre); ?>
		                                    	<?php if(form_error($nombre['name']) != "" || isset($errors[$nombre['name']])) {?>
		                                    	<div class="alert alert-error error-gral span5"><?php echo form_error($nombre['name']); ?><?php echo isset($errors[$nombre['name']])?$errors[$nombre['name']]:''; ?></div>
		                                    	<?php } ?>
										</div>
									</div>
									
									<div class="row">
                                		<div class="span6 control-group <?php if(form_error($precio['name']) != "") echo "error"; ?>">
		                                    <?php echo form_label('Precio: <i class="icon-asterisk"></i>', $precio['id']); ?>
		                                    <?php echo form_input($precio); ?>
		                                    	<?php if(form_error($precio['name']) != "" || isset($errors[$precio['name']])) {?>
		                                    	<div class="alert alert-error error-gral span5"><?php echo form_error($precio['name']); ?><?php echo isset($errors[$precio['name']])?$errors[$precio['name']]:''; ?></div>
		                                    	<?php } ?>
										</div>
									</div>
									
									<div class="row">
                                		<div class="span6 control-group <?php if(form_error($calidad['name']) != "") echo "error"; ?>">
		                                    <?php echo form_label('Calidad: <i class="icon-asterisk"></i>', $calidad['id']); ?>
		                                    <?php echo form_input($calidad); ?>
		                                    	<?php if(form_error($calidad['name']) != "" || isset($errors[$calidad['name']])) {?>
		                                    	<div class="alert alert-error error-gral span5"><?php echo form_error($calidad['name']); ?><?php echo isset($errors[$calidad['name']])?$errors[$calidad['name']]:''; ?></div>
		                                    	<?php } ?>
										</div>
									</div>
									
									<div class="row">
                                		<div class="span6 control-group <?php if(form_error($aforo['name']) != "") echo "error"; ?>">
		                                    <?php echo form_label('Aforo: <i class="icon-asterisk"></i>', $aforo['id']); ?>
		                                    <?php echo form_input($aforo); ?>
		                                    	<?php if(form_error($aforo['name']) != "" || isset($errors[$aforo['name']])) {?>
		                                    	<div class="alert alert-error error-gral span5"><?php echo form_error($aforo['name']); ?><?php echo isset($errors[$aforo['name']])?$errors[$aforo['name']]:''; ?></div>
		                                    	<?php } ?>
										</div>
									</div>

                                    <?php //echo form_submit('register', 'Crear Cuenta'); ?>
                                    <p><input type="submit" class="btn btn-large btn-primary" value="<?php if(isset($tb)) echo $tb; else echo "Crear Producto"; ?>" name="register" /></p>
                                    <?php echo form_close(); ?>
                            </div>		
                            <!-- .block_content ends -->
					
</div>		