<?php
$codigo= array(
        'name'             => 'codigo',
        'value'             => set_value('codigo'),
        'class'             => 'text span5'
);

$depositante = array(
        'name'             => 'cuentaregistro_id',
        'value'             => set_value('cuentaregistro_id'),
        'class'             => 'textarea-mid span5',
);

$producto = array(
        'name'             => 'producto',
        'value'             => set_value('producto'),
        'class'             => 'text span5'
);
$kilos = array(
        'name'             => 'kilos',
        'value'             => set_value('kilos'),
        'class'             => 'text span5'
);
$observaciones = array(
        'name'             => 'observaciones',
        'value'             => set_value('observaciones'),
        'class'             => 'text span5'
);
$observaciones = array(
        'name'             => 'observaciones',
        'value'             => set_value('observaciones'),
        'class'             => 'text span5'
);
?>
<script type="text/javascript">
    $(function() {
        $("#empresas_dd").change(function() {
            var site_root = <?php echo '"' . site_url('adm/ewarrants/get_cuentas_registro') . '"'; ?>;
            var dire = site_root + "/" + $(this).val();
            $.ajax({ 
            cache: false,
            type: "GET",
            url: dire,
            contentType: "application/x-www-form-urlencoded;charset=ISO-8859-1",
            dataType:'html',
            success: function(data){
                  $("#cuentas_registro").html(data);

           }
         });
        });
    });
</script>
<div class="row">

                            <div class="span12 margin-bottom-10">
				                	<div class="row">
					               		<div class="span12">
					                		<h2>Emisión de eWarrant</h2>
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
                                		<div class="span6 control-group <?php if(form_error($codigo['name']) != "") echo "error"; ?>">
		                                    <?php echo form_label('Codigo', $codigo['name']); ?>
		                                    <?php echo form_input($codigo); ?>
		                                    
											<?php if(form_error($codigo['name']) != "" || isset($errors[$codigo['name']])) {?>
										
										<div class="row">
		                                    <div class="alert span4 alert-error">
										        <?php echo form_error($codigo['name']); ?><?php echo isset($errors[$codigo['name']])?$errors[$codigo['name']]:''; ?>
										    </div>
										</div>
								    <?php } ?>
								    	</div>
									</div>
									
                                    <?php if(isset($empresas)) { ?>
                                    <div class="row">
                                		<div class="span6 control-group">
		                                    <?php echo form_label('Empresa', 'empresa_id'); ?></td>
		                                            <?php
		                                                echo '<select name="empresa_id" class="listas-padding span5" id="empresas_dd">';
		                                                foreach($empresas as $empresa)
		                                                {
		                                                   echo '<option value="' . $empresa['empresa_id'] . '">' . $empresa['nombre'] . "</option>";
		                                                }
		                                                echo '</select>';
		                                            ?>
		                                   
		                            	</div>
									</div>
									 <?php } ?>
                                    <div class="row">
                                		<div class="span6 control-group">
                                                <?php echo form_label('Cuenta Registro Depositante', 'cuentaregistro_id'); ?></td>
                                                <?php
                                                	if(count($cuentasregistro) > 0) {
                                                		echo '<select name="cuentaregistro_id" class="listas-padding span5" id="cuentas_registro">';
	                                                    foreach($cuentasregistro as $crd)
	                                                    {
	                                                       echo '<option value="' . $crd['cuentaregistro_id'] . '">' . $crd['nombre'] . "</option>";
	                                                    }
	                                                    echo '</select>';
                                                	} else {
                                                		echo '<select name="cuentaregistro_id" class="listas-padding span5" id="cuentas_registro">';
															echo '<option value="">La empresa no tiene Cuentas Registro Depositante cargadas</option>'; 
														echo '</select>';
                                                	}
                                                ?>
                             
                                        </div>
                                    </div>
                                    <div class="row">
                                		<div class="span6 control-group">
                                            	<?php echo form_label('Producto', 'producto'); ?></td>
                                                <?php
                                                    echo '<select name="producto" class="listas-padding span5" id="productos">';
                                                    foreach($productos as $prd)
                                                    {
                                                       echo '<option value="' . $prd['producto_id'] . '">' . $prd['nombre'] . "</option>";
                                                    }
                                                    echo '</select>';
                                                ?>
                                          </div>
                                    </div>
                                    <div class="row">
                                		<div class="span6 control-group <?php if(form_error($kilos['name']) != "") echo "error"; ?>">            
                                                    <?php echo form_label('Cantidad', $kilos['name']); ?>
                                                    <?php echo form_input($kilos); ?>
                                                    <?php if(form_error($kilos['name']) != "" || isset($errors[$kilos['name']]) ) {?>
                                                    <div class="row">
					                                    <div class="alert span4 alert-error">
													        <?php echo form_error($kilos['name']); ?><?php echo isset($errors[$kilos['name']])?$errors[$kilos['name']]:''; ?>
													    </div>
													</div>
												    <?php } ?>
										</div>
                                    </div>			 
									<div class="row">
                                		<div class="span6 control-group <?php if(form_error($observaciones['name']) != "") echo "error"; ?>">   
                                                    <?php echo form_label('Observaciones', $observaciones['name']); ?>
                                                    <?php echo form_textarea($observaciones); ?>
                                                    <?php if(form_error($observaciones['name']) != "" || isset($errors[$observaciones['name']]) ) {?>
                                                   	<div class="row">
					                                    <div class="alert span4 alert-error">
													        <?php echo form_error($observaciones['name']); ?><?php echo isset($errors[$observaciones['name']])?$errors[$observaciones['name']]:''; ?>
													    </div>
													</div>
												    <?php } ?>
								    	</div>
                                    </div>
                                    <?php //echo form_submit('register', 'Crear Cuenta'); ?>
                                    <p><input type="submit" class="btn btn-primary btn-large" value="Emitir eWarrant" name="register" /></p>
                                    <?php echo form_close(); ?>
                                                                              
                            </div>		
                            <!-- .block_content ends -->
					
	</div>		
<!-- .block ends -->