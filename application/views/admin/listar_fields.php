<div class="row">
        <div class="span12 margin-bottom-10">
                	<div class="row relativo">
	               			<div class="span12">
		                        	<?php if(isset($data_menu)) { ?>
				                		<?php foreach ($data_menu as $keyp => $row) { ?>
				               				<?php if($row['boton_superior']) { ?>
				                				<?php echo '<a class="'. $row['clase_boton'] . '" href="'. site_url() . "/" . $this->uri->segment(1) . "/" . $keyp . "/" . $this->uri->segment(3) . '" ><i class="'. $row['icono'] . '"></i> ' . $row['texto_anchor'] . '</a>';  ?>
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
             if(isset($message))
             {
                  echo "<div class='message success'>";
                             echo "<p>" . $message. "</p>";
                  echo "</div>";
             }
             ?>     
                <table class="table table-striped table-bordered">

                        <thead>
                                <tr>
                                        <th>ID</th>
                                        <th>Nombre Field</th>
                                        <th>Acciones</th>
                                </tr>
                        </thead>

                        <tbody>
                                <?php 
                                	if(!empty($fields)) {
                                		foreach($fields as $field)
                                        {
                                            echo "<tr>";
                                            	echo "<td>";
													echo $field['fields_id'];
												echo "</td>";
												
												echo "<td>";
													echo $field['fields_nombre'];
												echo "</td>";
												
												echo "<td>";
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
								               					
								               					if($keyp == "modificar_field") {
								               						//if($empresa['activated'] == 0) {
								               							echo anchor($this->uri->segment(1) ."/". $keyp . '/' .$field['fields_id'], '<i class="' . $row['icono'] . '"></i> ' . $row['texto_anchor'], $atributos);
								               						//}
								               					} else if($keyp == "eliminar_empresa") {
								               						if($empresa['activated'] == 1) {
								               							echo anchor($this->uri->segment(1) ."/". $keyp . '/' .$field['fields_id'], '<i class="' . $row['icono'] . '"></i> ' . $row['texto_anchor'], $atributos);
								               						}
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
                                            echo "</tr>";
                                        }
                                	}
                                ?>
                        </tbody>
                </table>                                
        </div>						
	</div>		