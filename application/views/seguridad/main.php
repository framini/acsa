<div class="row">

					        <div class="span12 margin-bottom-10">
					                	<div class="row">
						               		<div class="span12">
						                		<h2>Menu de Seguridad</h2>
						                	</div>
					                	</div>
					        </div>	

				
                            <div class="span12">
                                <?php if(isset($message)) { ?>
	                            	<div class="row">
	                            		<div class="alert alert-success span12 mensajes margin-top-10" id="resultado-operacion" style="margin-bottom: 10px !important;">
	                                <?php
	                                         echo $message;
	                                 ?>
	                                 </div> 
	                                </div>
                                <?php } ?>
                            <div class="row">
                            	<?php if(isset($data_menu)) { ?>
	                            	<?php foreach ($data_menu as $keyp => $row) { ?>
	                            		<?php if($row['texto_anchor']) { ?>
	                            		<div class="span6">
		                                    <h3><?php echo $row['titulo_gestion']; ?></h3>
		
		                                    <ul class="nav nav-tabs nav-stacked">
		                                        <li>
		                                                <?php 
															 $contenido_menu = isset($row['icono']) ? '<i class="' . $row['icono'] . '"></i> ' . $row['texto_anchor'] : $row['texto_anchor'];
															 echo anchor($this->uri->segment(1) . "/" . $keyp, $contenido_menu);
														?>
		                                        </li>
		                                    </ul>
		                                </div>
		                                <?php } ?>
										
									<?php } ?>
                                <?php } else { ?>
                                	<div class="alert alert-info span12 mensajes margin-top-10" id="resultado-operacion"><?php echo '<i class="' . $error_sin_permiso['icono'] . '"></i>' . " " . $error_sin_permiso['texto'] ; ?></div>
                                <?php } ?>  
	                            </div>	<!--fin row-->	

							</div>
					
	</div>		