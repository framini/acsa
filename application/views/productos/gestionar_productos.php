<div class="row">

        <div class="span12 margin-bottom-10">
                	<div class="row">
	               		<div class="span12">
	               			<?php //echo anchor('/seguridad/registro', "<i class='icon-user icon-white'></i> Agregar Usuario", "class='btn btn-large btn-success pull-right'");  ?>
	                		<?php foreach ($data_menu as $keyp => $row) { ?>
	               				<?php if($row['boton_superior']) { ?>
	               					<?php echo anchor($this->uri->segment(1) ."/". $keyp, '<i class="' . $row['icono'] . '"></i> ' . $row['texto_anchor'], 'class="' . $row['clase_boton'] . '"');  ?>
	                			<?php } ?>
	                		<?php } ?>
	                		<h2>Productos</h2>
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
                                if(isset($errormsg))
                                {
                                    echo "<div class='message errormsg'>";
                                                 echo "<p>" . $errormsg. "</p>";
                                      echo "</div>";
                                }
                				?>
            
            					<?php
                                 if(isset($message))
                                 {
                                      echo "<div class='message success'>";
                                                 echo "<p>" . $message. "</p>";
                                      echo "</div>";
                                 }
                                 ?>

                


                        <table class="table table-bordered">

                                <thead>
                                        <tr>
                                                <th>ID</th>
                                                <th>Nombre Producto</th>
                                                <th>Datos Producto</th>
                                                <th>Acciones</th>
                                        </tr>
                                </thead>

                                <tbody>
                                        <?php 
                                                foreach($productos as $producto)
                                                {
                                                    echo "<tr id=producto-" . $producto['producto_id'];
													echo ">";
                                                    echo "<td class='id-producto'>" . $producto['producto_id'] .'</td>';
                                                    echo "<td class='nombre-producto'>";
													echo $producto['nombre'] .'</td>';
													echo "<td class='datos-producto'>";
													if($producto['precio'] != "") {
														echo '<abbr title="Precio"><i class="icon-info-sign"></i> ' . '<small class="small" class="datos-precio_producto">' . $producto['precio'] . '</small></abbr><br/>';
													}
													if($producto['calidad'] != "") {
														echo '<abbr title="Calidad"><i class="icon-ok-sign"></i> ' . '<small class="small" class="datos-calidad_producto">' . $producto['calidad'] . '</small></abbr><br/>';
													}
													if($producto['aforo'] != "") {
														echo '<abbr title="Aforo"><i class="icon-plus-sign"></i> ' . '<small class="small" class="datos-aforo_producto">' . $producto['aforo'] . '</small></abbr><br/>';
													}
													echo '</td>';
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
								               					
								               					echo anchor($this->uri->segment(1) ."/". $keyp . '/' .$producto['producto_id'], '<i class="' . $row['icono'] . '"></i> ' . $row['texto_anchor'], $atributos);
								               					
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
                                        ?>
                                </tbody>

                        </table>


        </div>		<!-- .block_content ends -->
</div>		
<!-- .block ends -->