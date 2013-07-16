<?php

$nombre_producto = isset($row_producto[0]['poliza_nombre']) ? $row_producto[0]['poliza_nombre'] : set_value('nombre');
$precio_producto = isset($row_producto[0]['poliza_comision']) ? $row_producto[0]['poliza_comision'] : set_value('comision');
$aforo_producto = isset($row_producto[0]['poliza_descripcion']) ? $row_producto[0]['poliza_descripcion'] : set_value('descripcion');


$nombre = array(
      'name'	=> 'nombre',
      'id'		=> 'nombre',
      'value'   => $nombre_producto,
      'class'   => 'span5',
);

$precio = array(
	'name'	=> 'comision',
	'id'	=> 'comision',
	'value'	=> $precio_producto,
    'class' => 'span5',
);

$aforo = array(
	'name'	=> 'descripcion',
	'id'	=> 'descripcion',
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
					comision: $('#comision').val(),
					descripcion:   $('#descripcion').val()
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
									window.location = "<?php $uri = site_url() . "/" . "adm/ewarrants/gestionar_polizas"; echo $uri; ?>";
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
            		<h2><?php if(isset($tf)) echo $tf; else echo "Agregar Poliza"; ?></h2>
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
                        <?php echo form_label('Nombre Poliza: <i class="icon-asterisk"></i>', $nombre['id']); ?>
                        <?php echo form_input($nombre); ?>
                        	<?php if(form_error($nombre['name']) != "" || isset($errors[$nombre['name']])) {?>
                        	<div class="alert alert-error error-gral span5"><?php echo form_error($nombre['name']); ?><?php echo isset($errors[$nombre['name']])?$errors[$nombre['name']]:''; ?></div>
                        	<?php } ?>
					</div>
				</div>
				
				<div class="row">
            		<div class="span6 control-group <?php if(form_error($precio['name']) != "") echo "error"; ?>">
                        <?php echo form_label('Comision: <i class="icon-asterisk"></i>', $precio['id']); ?>
                        <?php echo form_input($precio); ?>
                        	<?php if(form_error($precio['name']) != "" || isset($errors[$precio['name']])) {?>
                        	<div class="alert alert-error error-gral span5"><?php echo form_error($precio['name']); ?><?php echo isset($errors[$precio['name']])?$errors[$precio['name']]:''; ?></div>
                        	<?php } ?>
					</div>
				</div>
				
				<div class="row">
            		<div class="span6 control-group <?php if(form_error($aforo['name']) != "") echo "error"; ?>">
                        <?php echo form_label('Descripcion: <i class="icon-asterisk"></i>', $aforo['id']); ?>
                        <?php echo form_textarea($aforo); ?>
                        	<?php if(form_error($aforo['name']) != "" || isset($errors[$aforo['name']])) {?>
                        	<div class="alert alert-error error-gral span5"><?php echo form_error($aforo['name']); ?><?php echo isset($errors[$aforo['name']])?$errors[$aforo['name']]:''; ?></div>
                        	<?php } ?>
					</div>
				</div>

                <?php //echo form_submit('register', 'Crear Cuenta'); ?>
                <p><input type="submit" class="btn btn-large btn-primary" value="<?php if(isset($tb)) echo $tb; else echo "Crear Poliza"; ?>" name="register" /></p>
                <?php echo form_close(); ?>
        </div>		
        <!-- .block_content ends -->
					
</div>		