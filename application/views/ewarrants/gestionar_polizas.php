<?php $this->load->file('includes/datatables_files.php'); ?>
<script>
	$(function() {
		$objInit = $.extend( {}, objInit );

	    $('#tabla').dataTable($objInit);
	});
</script>

<div class="row">

        <div class="span12 margin-bottom-10">
                	<div class="row">
	               		<div class="span12">
	               			<?php //echo anchor('/seguridad/registro', "<i class='icon-user icon-white'></i> Agregar Usuario", "class='btn btn-large btn-success pull-right'");  ?>
	                		<?php if(isset($data_menu)) foreach ($data_menu as $keyp => $row) { ?>
	               				<?php if($row['boton_superior']) { ?>
	               					<?php echo anchor($this->uri->segment(1) ."/". $this->uri->segment(2) ."/". $keyp, '<i class="' . $row['icono'] . '"></i> ' . $row['texto_anchor'], 'class="' . $row['clase_boton'] . '"');  ?>
	                			<?php } ?>
	                		<?php } ?>
	                		<h2>Polizas</h2>
	                	</div>
	                	<div class="span12 margin-top-10">
	                		<?php $this->load->file('includes/buscador.php'); ?>
	                	</div>
	                	<div class="alert alert-success span12 mensajes margin-top-10" id="resultado-operacion" style="display: none;"><p></p></div>
                	</div>
        </div>		
        <!-- .block_head ends -->

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

                


                        <table id="tabla" class="table table-bordered display">

                                <thead>
                                        <tr>
                                                <th>ID</th>
                                                <th>Nombre Poliza</th>
                                                <th>Comision</th>
                                                <th>Descripcion</th>
                                                <th>Acciones</th>
                                        </tr>
                                </thead>

                                <tbody>
                                        <?php 
                                        	if( !is_null($productos) ) { 
                                                foreach($productos as $producto)
                                                {
                                                    echo "<tr id=producto-" . $producto['poliza_id'];
													echo ">";
                                                    echo "<td class='id-producto'>" . $producto['poliza_id'] .'</td>';
                                                    echo "<td class='nombre-producto'>";
													echo $producto['nombre'] .'</td>';
													echo "<td class='comision-producto'>";
													echo $producto['comision'] .'</td>';
													echo "<td class='descripcion-producto'>";
													echo $producto['descripcion'] .'</td>';
												   echo '<td>';
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
								               					
								               					echo anchor($this->uri->segment(1) . "/" . $this->uri->segment(2) ."/". $keyp . '/' .$producto['poliza_id'], '<i class="' . $row['icono'] . '"></i> ' . $row['texto_anchor'], $atributos);
								               					
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
													echo '</td>';
                                                    echo "</tr>";
                                                }
                                              }
                                        ?>
                                </tbody>

                        </table>


        </div>		<!-- .block_content ends -->
</div>		
<!-- .block ends -->