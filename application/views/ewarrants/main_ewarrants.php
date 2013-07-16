<div class="row">
					        <div class="span12 margin-bottom-10">
					                	<div class="row">
						               		<div class="span12">
						                		<h2>Gestión de eWarrants</h2>
						                	</div>
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
     							<?php if(count($permisos) > 0) { ?>
                                 <ul class="nav nav-tabs nav-stacked">
                                 	<?php 
                                 	
									foreach ($data_menu as $keyp => $row) {
										if( $this->auth_frr->has_role_aseguradora() && $keyp == "emitir" ) {
										 
										} elseif( $this->auth_frr->has_role_aseguradora() && $keyp == "registro_poliza" ) {
										} elseif( $this->auth_frr->has_role_aseguradora() && $keyp == "modificar_poliza") {
										} else {
											echo "<li>";
											$contenido_menu = isset($row['icono']) ? '<i class="' . $row['icono'] . '"></i> ' . $row['texto_anchor'] : $row['texto_anchor'];
											echo anchor($this->uri->segment(1) . "/" . $this->uri->segment(2) . "/" . $keyp, $contenido_menu);
											echo "</li>";
										}
									 }

									 if( $this->auth_frr->has_role_aseguradora() ) {
										echo "<li>"; 
										echo anchor("/adm/ewarrants/gestionar_polizas", "Gestionar Polizas");
										echo "</li>";
									}
									?>
                                </ul>
      							<?php } else { ?>
                                <div class="row">
                                	<div class="alert alert-info span12 mensajes margin-top-10" id="resultado-operacion"><?php echo '<i class="' . $error_sin_permiso['icono'] . '"></i>' . " " . $error_sin_permiso['texto'] ; ?></div>
                                </div>
                                <?php } ?>                                              
                            </div>		
					
	</div>		
