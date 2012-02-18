<div class="row">
					        <div class="span12 margin-bottom-10">
					                	<div class="row">
						               		<div class="span12">
						                		<h2>Gestión de eWarrants</h2>
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
     							<?php if(count($permisos) > 0) { ?>
                                 <ul class="nav nav-tabs nav-stacked">
                                 	<?php 
                                 	
									foreach ($data_menu as $keyp => $row) {
										 echo "<li>";
										 $contenido_menu = isset($row['icono']) ? '<i class="' . $row['icono'] . '"></i> ' . $row['texto_anchor'] : $row['texto_anchor'];
										 echo anchor($this->uri->segment(1) . "/" . $keyp, $contenido_menu);
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
