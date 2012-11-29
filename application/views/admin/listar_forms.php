<?php $this->load->file('includes/datatables_files.php'); ?>
<script>
	$(function() {
		$objInit = $.extend( {}, objInit );

	    $('#tabla').dataTable($objInit);
	});
</script>

<div class="row">
        <div class="span12 margin-bottom-10">
                	<div class="row relativo">
	               			<div class="span12">
		                        	<?php if(isset($data_menu)) { ?>
				                		<?php foreach ($data_menu as $keyp => $row) { ?>
				               				<?php if($row['boton_superior']) { ?>
				                				<?php echo '<a class="'. $row['clase_boton'] . '" href="'. site_url() . "/" . $this->uri->segment(1) . "/" . $keyp . '"><i class="'. $row['icono'] . '"></i> ' . $row['texto_anchor'] . '</a>';  ?>
				                			<?php } ?>
				                		<?php } ?>
				                	<?php } ?>
                                    <h2>Forms</h2>
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
                <table id="tabla" class="table table-striped table-bordered display">

                        <thead>
                                <tr>
                                        <th>ID</th>
                                        <th>Nombre</th>
                                        <th>Acciones</th>
                                </tr>
                        </thead>

                        <tbody>
                                <?php 
                                	if(isset($forms)) {
                                		foreach($forms as $form)
                                        {
                                            echo "<tr>";
                                            	echo "<td>";
													echo $form['forms_id'];
												echo "</td>";
												
												echo "<td>";
													echo $form['forms_nombre'];
												echo "</td>";
												
												echo "<td>";
													//echo "<a class='btn cambiar-email-usuario btn-primary margin-bottom-5' href='" . site_url() . "/admin/modificar_form/" .  $form['forms_id'] . "'><i class='icon-pencil icon-white'></i> Modificar</a> ";
													//echo "<a class='btn cambiar-email-usuario btn-danger margin-bottom-5' href='" . site_url() . "/admin/baja_formulario/" .  $form['forms_id'] . "'><i class='icon-trash icon-white'></i> Eliminar form</a> ";
													//echo "<a class='btn cambiar-email-usuario btn-info margin-bottom-5' href='" . site_url() . "/admin/grupos_fields/" .  $form['grupos_fields_id'] . "'><i class='icon-folder-open icon-white'></i> Ver Grupo Fields</a> ";
													
													if(count($data_menu) > 0) {
														$band = 0;
	                                                    foreach ($data_menu as $keyp => $row) {
								               				if(!$row['boton_superior']) {
								               					$band +=1;
								               					if(isset($row['titulo'])) {
								               						$atributos = array('data-original-title' => $row['titulo'], 'class' => $row['clase_boton']);
								               					} else {
								               						$atributos = array('class' => $row['clase_boton']);
								               					}
																if( $keyp == "grupos_fields" ) {
																	echo anchor($this->uri->segment(1) ."/". $keyp . '/' . $form['grupos_fields_id'], '<i class="' . $row['icono'] . '"></i> ' . $row['texto_anchor'], $atributos);
																} else {
																	echo anchor($this->uri->segment(1) ."/". $keyp . '/' . $form['forms_id'], '<i class="' . $row['icono'] . '"></i> ' . $row['texto_anchor'], $atributos);
																}
								               					
								                				//Fix espacio entre botones
								                				echo ' ';
															}
								                		}
														if($band == 0) {
															echo '<i class="icon-remove"></i> No tienes acciones disponibles';
														}
								                	} else {
								                		echo '<i class="icon-remove"></i> No tienes acciones disponibles';
								                	}
													
													echo "</td>";
												echo "</td>";
                                            echo "</tr>";
                                        }
                                	}
                                        
                                ?>
                        </tbody>
                </table>                                
        </div>						
	</div>		