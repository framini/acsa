<?php $this->load->file('includes/datatables_files.php'); ?>
<script>
	$(function() {
		$objInit = $.extend( {}, objInit, { 
			"aoColumnDefs": [ 
								{ "bSortable": false, "aTargets": [ 0 ] } 
							] 
			} );

	    var $tabla = $('#tabla').dataTable($objInit);
	    
	    $('#tabla').on('eliminarFila', function(event, param) {
			if( param.fila ) {
				$tabla.fnDeleteRow( param.fila[0] )
			}
		});
	});
</script>

<script type="text/javascript">
    $(function() {
        
        var datos = {};
        	var dire = "<?php echo site_url('adm/general'); ?>";
			
			////////////////////////////////////////////////////////////
			//BOTONES Firmar
			////////////////////////////////////////////////////////////
        	$('input.enviar').click(function(event) {
        		event.preventDefault();
        		
        		//Primero comprobamos que se haya seleccionado algun warrant
        		//Seleccionamos el unico elemento requerido del formulario y verificamos que haya uno seleccionado
        		if($('input[name=ewid]:checked').length > 0) {
	        		//Establecemos reglas default
	        		$.ajaxSetup({
		        		dataFilter: function(data, type) {
		        			//Filtramos la data de confirmacion.php
		        			//pàra insertarla dentro del pop-up
		        			data = $(data).find('#contenedor');
		        			data.removeClass('row').addClass('centrado');
		        			data.find('.span4').each(function() {
		        				$(this).addClass('cont-centrado-span4')
		        			});
		        			return data;
		        		}
		        	});
	        		
	        		
	        		datos.dire = $(this).closest('form').attr('action') + "/" + $('input[name=ewid]:checked').val();
	        		datos.elem = $(this);
	        		
	        		$.colorbox(
		        	{
		        		ajax: true,
		        		width:"390", 
		        		height:"200",
		        		overlayClose: false,
		        		escKey: false,
		        		href: dire,
		        		scrolling: false,
		        		close: "Cancelar",
		        		fastIframe: false,
		        		onComplete: function() {
		        			$('#contenedor h2').text(datos.elem.attr('data-original-title'));
		        		}
		        	});
		        } else {
		        	//Mostramos el mensaje de error porque no selecciono ningun eWarrant
		        	$('#resultado-operacion').find('#icono-mensaje').attr('class', 'icon-remove');
		        	$('#resultado-operacion').removeClass('alert-success').addClass('alert-error').find('#texto-mensaje').html("Debes seleccionar un eWarrant!");
	                $('#resultado-operacion').slideDown('slow');
		        }
        	});
        	
        	//Si el usuario hizo click en firmar sin antes haber seleccionado un eWarrant
        	//una ventana de error fue abierta informando la situacion.
        	//Aca ocultamos dicha ventana cuando el usuario seleccione alguno de los radios.
        	$('input[name=ewid]').change(function() {
        		//Si existe una ventana de error la ocultamos
        		if($('#resultado-operacion.alert-error').length > 0) {
        			$('#resultado-operacion').slideUp('slow', function() {
        				$(this).removeClass('alert-error');
        			});
        		}
        	});
        	
        	//Registramos el handler para el boton NO del pop-up
        	$(document).on('click', '#btn-no', function(event) {
        		event.preventDefault();
        		$.colorbox.close();
        	});
        	//Registramos el handler para el boton SI del pop-up
        	$(document).on('click', '#btn-si', function(event) {
        		event.preventDefault();
        		var urif = datos.dire + "/si";

        		$.ajax({ 
	                url: urif, 
	                cache: false,
	                type: 'POST',
	                dataType: 'json',
	                dataFilter: function(data, type) {
	                	return data;
	                },
	                success: function(data, textStatus, jqXHR) {
	                	$.colorbox.close();
	                	
	                	if(data.error) {
	                		//Mostramos el mensaje de error devuelto como respuesta
	                		$('#resultado-operacion').slideUp(function() {
	                			$(this).find('#icono-mensaje').attr('class', data.icono);
	                			$(this).find('#texto-mensaje').html(data.message);
	                		})
		        			$('#resultado-operacion').removeClass('alert-success').addClass('alert-error').slideDown('slow');
		        			
	                	} else {

							if( data.redireccion ) {
								window.location = data.redireccion;
							} else {
		                	
		                		//Se firmo el eWarrant correctamente. Mostramos el mensaje de confirmacion
		                		//Mostramos el mensaje de error devuelto como respuesta
		                		$('#resultado-operacion').slideUp(function() {
		                			$(this).find('#icono-mensaje').attr('class', data.icono);
		                			$(this).find('#texto-mensaje').html(data.message);
		                		})
		                		
		                		//Actualizamos la tabla para eliminar el eWarrant firmado
			        			var inp = "input[name=ewid][value=" + data.ewid + "]";
			        			$(inp).closest('tr').fadeOut('slow', function() {
			        				$.event.trigger('eliminarFila', { fila: $(this) } );
			                    	//$(this).detach();
			                    });
		          
		                		
			        			$('#resultado-operacion').removeClass('alert-error')
			        									 .addClass('alert-success')
			        									 .fadeIn('slow', function() {
							        							$('input#id_search').trigger('actualizarTabla');
							        					  })
			        									 .delay(5000)
			        									 .slideUp('slow');
							}
		        			
		        			
	                	}
	                }
	            }); 
        	});
        	////////////////////////////////////////////////////////////
			//FIN BOTONES firmar
			////////////////////////////////////////////////////////////
    });
</script>
<div class="row">
        <div class="span12 margin-bottom-10">
                	<div class="row relativo">
	               			<div class="span12">
                            <?php echo form_open($this->uri->uri_string()); ?>
                            	<?php if(isset($data_menu)) { ?>
			                		<?php foreach ($data_menu as $keyp => $row) { ?>
			               				<?php if($row['boton_superior'] && ($keyp == $this->uri->segment(3))) { ?>
			                				<?php echo '<input type="submit" class="'. $row['clase_boton'] . '" value="' . $row['texto_anchor'] . '" />';  ?>
			                			<?php } ?>
			                		<?php } ?>
			                	<?php } ?>
                                    <h2>Menu de eWarrants</h2>
                                    <!--<input type="submit" class="btn btn-primary btn-large firmar" value="Firmar!" />-->
                            </div>
	                		<div class="span12">
	                			<?php $this->load->file('includes/buscador.php');?>
	                		</div>
                	</div>
                	<div class="row">
                		<div class="alert alert-success span12 mensajes margin-top-10" id="resultado-operacion" style="display: none;"><span><i id="icono-mensaje" class=""></i> </span> <span id="texto-mensaje"></span></div>
                	</div>
        </div>
				
				
				
                            <div class="span12">
                                <?php
					            	if(isset($errormsg)) {
					            		$data['estado'] = "error";
					            	} else if(isset($message)) {
					            		$data['estado'] = "success";
					            	}
									if(isset($data)) {
										$this->load->view('general/mensaje_operacion', $data); 
									}
					            ?>

                

                                                        <table class="table display table-striped table-bordered" id="tabla">

                                                                <thead>
                                                                        <tr>
                                                                                <?php if(isset($data_menu)) { ?><th width="10"><!--<input type="radio" class="check_all" />--></th> <?php } ?>
                                                                                <th>ID</th>
                                                                                <th>Codigo</th>
                                                                                <th>Fecha</th>
                                                                                <th>Registro Depositante</th>
                                                                                <th>Cuenta Registro</th>
                                                                                <th>Producto</th>
                                                                                <th>Kilos</th>
                                                                                <th>Estado</th>
                                                                                <th>Firmado</th>
                                                                                <th>Creado por</th>
                                                                        </tr>
                                                                </thead>

                                                                <tbody>
                                                                        <?php 
                                                                                foreach($ewarrants as $ew)
                                                                                {
                                                                                    echo "<tr>";
                                                                                    if(isset($data_menu)) { echo '<td><input type="radio" name="ewid" value= "'.$ew['id'].'" /></td>'; };
                                                                                    echo '<td>' . $ew['id'] .'</td>';
                                                                                    echo '<td>' . $ew['codigo'] .'</td>';
                                                                                    echo '<td>' . $ew['created'] .'</td>';
                                                                                    echo '<td>' . $ew['nombre_cuenta_registro_depositante'] .'</td>';
                                                                                    echo '<td>' . $ew['nombre_cuenta_registro'] .'</td>';
                                                                                    echo '<td>' . $ew['producto'] .'</td>';
                                                                                    echo '<td>' . $ew['kilos'] .'</td>';
                                                                                    if($ew['estado'] == 1) echo '<td>Activo</td>'; else echo '<td>Anulado</td>';
                                                                                    if($ew['firmado'] == 1) echo '<td>Firmado</td>'; else echo '<td>Sin firmar</td>';
                                                                                    echo '<td>' . $ew['emitido_por'] .'</td>';
                                                                                    echo "</tr>";
                                                                                }
                                                                        ?>
                                                                </tbody>

                                                        </table>

                                </form>
                                                                              
                            </div>		
                            <!-- .block_content ends -->
					
	</div>		
<!-- .block ends -->