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
	                		<h2>Cuentas Registro</h2>
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
                                                <th>Nombre Cuenta Registro</th>
                                                <th>Datos Cuenta Registro</th>
                                                <th>Acciones</th>
                                        </tr>
                                </thead>

                                <tbody>
                                        <?php 
                                                foreach($empresas as $empresa)
                                                {
                                                    echo "<tr id=empresa-" . $empresa['cuentaregistro_id'];
													if($empresa['activated'] == 0) echo " class='alert-error'";
													echo ">";
                                                    echo "<td class='id-empresa'>" . $empresa['cuentaregistro_id'] .'</td>';
                                                    echo "<td class='nombre-empresa'>";
													echo $empresa['nombre'] .'</td>';
													//echo '<td>' . '<a rel="tooltip" href="#" title="Email: ' . $user['email'] . '<br/>Empresa: ' . $user['empresa'] .  '">Info usuario</a>' . '</td>';
													echo "<td class='datos-empresa'>";
													if($empresa['tipo_cuentaregistro_id'] != "") {
													echo '<abbr title="Tipo Cuenta Registro"><i class="icon-bookmark"></i> ' . '<small class="small" class="datos-tipo_empresa">' . $empresa['tipo_cuentaregistro'] . '</small></abbr><br/>';
													}
													echo '<abbr title="Codigo"><i class="icon-list-alt"></i> ' . '<small class="small" class="datos-tipo_empresa">' . $empresa['codigo'] . '</small></abbr><br/>';
													echo '<abbr title="Empresa"><i class="icon-home"></i> ' . '<small class="small" class="datos-tipo_empresa">' . $empresa['empresa'] . '</small></abbr><br/>';
													if($empresa['activated'] == 0) {
													echo '<abbr title="Activada"><i class="icon-minus"></i> ' . '<small class="small" class="datos-tipo_empresa">Desactivada</small></abbr><br/>';
													} else {
													echo '<abbr title="Activada"><i class="icon-plus"></i> ' . '<small class="small" class="datos-tipo_empresa">Activada</small></abbr><br/>';	
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
								               					
								               					if($keyp == "activar_cuenta_registro") {
								               						if($empresa['activated'] == 0) {
								               							echo anchor($this->uri->segment(1) ."/". $keyp . '/' .$empresa['cuentaregistro_id'], '<i class="' . $row['icono'] . '"></i> ' . $row['texto_anchor'], $atributos);
								               						}
								               					} else if($keyp == "eliminar_cuenta_registro") {
								               						if($empresa['activated'] == 1) {
								               							echo anchor($this->uri->segment(1) ."/". $keyp . '/' .$empresa['cuentaregistro_id'], '<i class="' . $row['icono'] . '"></i> ' . $row['texto_anchor'], $atributos);
								               						}
								               					} else {
								               						echo anchor($this->uri->segment(1) ."/". $keyp . '/' .$empresa['cuentaregistro_id'], '<i class="' . $row['icono'] . '"></i> ' . $row['texto_anchor'], $atributos);
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
													echo '</td>';
                                                    echo "</tr>";
                                                }
                                        ?>
                                </tbody>

                        </table>


        </div>		<!-- .block_content ends -->
</div>		
<!-- .block ends -->