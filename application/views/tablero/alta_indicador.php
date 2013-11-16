<?php
$id = isset($row_indicador[0]['idIndicador']) ? $row_indicador[0]['idIndicador'] : set_value('idIndicador');
$descripcion = isset($row_indicador[0]['Descripcion']) ? $row_indicador[0]['Descripcion'] : set_value('Descripcion');
$tipo = isset($row_indicador[0]['Tipo']) ? $row_indicador[0]['Tipo'] : set_value('Tipo');
$calculo_nominador = isset($row_indicador[0]['CalculoNumerador']) ? $row_indicador[0]['CalculoNumerador'] : set_value('CalculoNumerador');
$relative = isset($row_indicador[0]['Relative']) ? $row_indicador[0]['Relative'] : set_value('Relative');
$calculo_denominador = isset($row_indicador[0]['CalculoDenominador']) ? $row_indicador[0]['CalculoDenominador'] : set_value('CalculoDenominador');
$relacion_objetivo = isset($row_indicador[0]['RelacionObjetivo']) ? $row_indicador[0]['RelacionObjetivo'] : set_value('RelacionObjetivo');
$drilldown = isset($row_indicador[0]['Drilldown']) ? $row_indicador[0]['Drilldown'] : set_value('Drilldown');
?>

<style>
	input.error {
		border: 1px solid red;
	}
</style>

<div class="row">
	<script type="text/javascript" src="<?php echo base_url(); ?>js/jquery.validate.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>js/additional-methods.min.js"></script>
	<script type="text/javascript">
		$(function() {

			$("form").validate({
				rules: {
				    id: {
				      required: true,
				      remote: {
				        url: "<?php $uri = site_url() . "/" . 'adm/tablero/check_idindicador'; echo $uri; ?>",
				        type: "post",
				        data: {
				          id: function() {
				            return $( "#id" ).val();
				          },
				          current : "<?php echo $id ?>"
				        }
				      }
				    }
				},
				messages: {
					id: {
						required: "El campo es requerido",
						remote: "El ID seleccionado ya se encuentra en uso. Por favor elija otro."
					}
				},
    			submitHandler: function (form) {
    				//url para la peticion AJAX
					var uri = "<?php $uri = site_url() . "/" .$this->uri->uri_string(); echo $uri; ?>";
					
    				//Seleccionamos los inputs
					var campos = {
						id: $('#id').val(),
						descripcion: $('#descripcion').val(),
						tipo: $('#tipo').val(),
						calculo_nominador:   $('#calculo_nominador').val(),
						relative:   $('input[name="relative"]:checked').val(),
						calculo_denominador:   $('#calculo_denominador').val(),
						relacion_objetivo:   $('input[name="relacion_objetivo"]:checked').val(),
						drilldown:   $('#drilldown').val(),
						currid:   $('#currid').val()
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
										window.location = "<?php $uri = site_url() . "/" . "adm/tablero/gestionar_indicadores"; echo $uri; ?>";
									});
							}
							
						}
					});
    			}
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
                                	<input type="hidden" name="currid" id="currid" value="<?php echo $currid; ?>" />
                                	<div class="row">
                                		<div class="span6 control-group">
		                                    <?php echo form_label('ID del Indicador: <i class="icon-asterisk"></i>'); ?>
		                                    <input class="span4" type="text" name="id" id="id" value="<?php echo $id ?>"/>
										</div>
									</div>

									<div class="row">
                                		<div class="span6 control-group">
		                                    <?php echo form_label('Descripcion:'); ?>
		                                    <textarea class="span4" name="descripcion" id="descripcion"><?php echo $descripcion ?></textarea>
										</div>
									</div>

									<div class="row">
                                		<div class="span6 control-group">
		                                    <?php echo form_label('Tipo:'); ?>
		                                    <select name="tipo" id="tipo">
		                                    	<option value="Negocio" <?php echo ($tipo == "Negocio") ? 'selected="selected"' : ""; ?>>Negocio</option>
		                                    	<option value="Tecnico" <?php echo ($tipo == "Tecnico") ? 'selected="selected"' : ""; ?>>Tecnico</option>
		                                    </select>
										</div>
									</div>

									<div class="row">
                                		<div class="span6 control-group">
                                			<?php echo form_label('Relative:'); ?> 
		                                    <label class="radio" for="relative"><input type="radio" <?php echo ($relative == "0") ? 'checked="checked"' : ""; ?> name="relative" value="0" /> No </label>
		                                    <label class="radio" for="relative"><input type="radio" <?php echo ($relative == "1") ? 'checked="checked"' : ""; ?> name="relative" value="1" /> Si </label>
										</div>
									</div>

									<div class="row">
                                		<div class="span6 control-group">
		                                    <?php echo form_label('Calculo Numerador:'); ?>
		                                    <textarea class="span4" name="calculo_nominador" id="calculo_nominador"><?php echo $calculo_nominador ?></textarea>
										</div>
									</div>

									<div class="row">
                                		<div class="span6 control-group">
		                                    <?php echo form_label('Calculo Denomidador:'); ?>
		                                    <textarea class="span4" name="calculo_denominador" id="calculo_denominador"><?php echo $calculo_denominador ?></textarea>
										</div>
									</div>

									<div class="row">
                                		<div class="span6 control-group">
                                			<?php echo form_label('Relacion Objetivo:'); ?>
		                                    <label class="radio" for="relacion_objetivo"><input type="radio" <?php echo ($relacion_objetivo == "0") ? 'checked="checked"' : ""; ?> name="relacion_objetivo" value="0" /> No </label>
		                                    <label class="radio" for="relacion_objetivo"><input type="radio" <?php echo ($relacion_objetivo == "1") ? 'checked="checked"' : ""; ?> name="relacion_objetivo" value="1" /> Si </label>
										</div>
									</div>

									<div class="row">
                                		<div class="span6 control-group">
		                                    <?php echo form_label('Drilldown:'); ?>
		                                    <textarea class="span4" name="drilldown" id="drilldown"><?php echo $drilldown ?></textarea>
										</div>
									</div>
									
									
                                    <?php //echo form_submit('register', 'Crear Cuenta'); ?>
                                    <p><input type="submit" class="btn btn-large btn-primary" value="<?php if(isset($tb)) echo $tb; else echo "Crear Indicador"; ?>" name="register" /></p>
                                    <?php echo form_close(); ?>
                            </div>		
                            <!-- .block_content ends -->
					
</div>		