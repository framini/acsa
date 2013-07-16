<?php
$nombre_producto = isset($row_producto[0]['nombre']) ? $row_producto[0]['nombre'] : set_value('nombre');
$precio_producto = isset($row_producto[0]['saldo']) ? $row_producto[0]['saldo'] : set_value('saldo');

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
					nombre: $('#nombre').val(),
					saldo: $('#saldo').val(),
					owner: $('#owner').val()
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
        		<div class="span6 control-group <?php if(form_error($nombre['name']) != "") echo "error"; ?>">
                    <?php echo form_label('Nombre para la cuenta corriente: <i class="icon-asterisk"></i>', $nombre['id']); ?>
                    <?php echo form_input($nombre); ?>
                    	<?php if(form_error($nombre['name']) != "" || isset($errors[$nombre['name']])) {?>
                    	<div class="alert alert-error error-gral span5"><?php echo form_error($nombre['name']); ?><?php echo isset($errors[$nombre['name']])?$errors[$nombre['name']]:''; ?></div>
                    	<?php } ?>
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
        		<div class="span6 control-group">
                    	<?php echo form_label('Empresa', 'empresa'); ?></td>
                        <?php
                            echo '<select name="empresa" class="listas-padding span5" id="empresa">';
                            foreach($empresas as $prd)
                            {
                               echo '<option value="' . $prd['empresa_id'] . '"';
							   if( $this->uri->segment(4) == $prd['empresa_id'] ) {
							   	echo " selected='selected '";
							   }
							   echo '>' . $prd['nombre'] . "</option>";
                            }
                            echo '</select>';
                        ?>
                  </div>
            </div>
			
			<div class="row">
        		<div class="span6 control-group">
                    	<?php echo form_label('Owner', 'owner'); ?></td>
                        <?php
                        if( isset($users_empresa) ) {
                        	if(count($users_empresa) > 0) {
	                            echo '<select name="owner" class="listas-padding span5" id="owner">';
	                            foreach($users_empresa as $prd)
	                            {
	                               echo '<option value="' . $prd['user_id'] . '"';
								   echo '>' . $prd['username'] . "</option>";
	                            }
	                            echo '</select>';
	                        } else {
	                        	echo '<select name="owner" class="listas-padding span5" id="owner">';
	                               echo '<option value="">--La empresa no tiene usuarios dados de alta</option>';
	                            echo '</select>';
	                        }
                        } else {
                        	echo '<select name="owner" class="listas-padding span5" id="owner">';
                               echo '<option value="">--Seleccione una empresa</option>';
                            echo '</select>';
                        }
                        
                        ?>
                  </div>
            </div>

            <?php //echo form_submit('register', 'Crear Cuenta'); ?>
            <p><input type="submit" class="btn btn-large btn-primary" value="<?php if(isset($tb)) echo $tb; else echo "Crear Producto"; ?>" name="register" /></p>
            <?php echo form_close(); ?>
    </div>		
    <!-- .block_content ends -->
					
</div>		