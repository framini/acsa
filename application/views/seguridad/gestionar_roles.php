<div class="row">

        <div class="span12 margin-bottom-10">
                	<div class="row">
	               		<div class="span12">
	               			<?php foreach ($data_menu as $keyp => $row) { ?>
	               				<?php if($row['boton_superior']) { ?>
	               					<?php echo anchor($this->uri->segment(1) ."/". $keyp, '<i class="' . $row['icono'] . '"></i> Agregar Role', 'class="' . $row['clase_boton'] . '"');  ?>
	                			<?php } ?>
	                		<?php } ?>
	                		<h2>Gestión Roles</h2>
	                	</div>
	                	<div class="span12 margin-top-10">
	                		<?php $this->load->file('includes/buscador.php'); ?>
	                	</div>
	                	<div class="alert alert-success span12 mensajes margin-top-10" id="resultado-operacion" style="display: none;"><p></p></div>
                	</div>
        </div>

        <div class="span12">
                 				<?php
                                /*if(isset($errormsg))
                                {
                                    echo "<div class='message errormsg'>";
                                                 echo "<p>" . $errormsg. "</p>";
                                      echo "</div>";
                                }*/
                				?>
            
            					<?php
                                 /*if(isset($message))
                                 {
                                 	echo '<div class="row">';
                                      echo "<div class='alert alert-success span12 mensajes margin-top-10'>";
                                                 echo "<p>" . $message. "</p>";
                                      echo "</div>";
									echo '</div>';
                                 }*/
                                 ?>

                

						<?php if(!isset($sin_roles)) { ?>
                        <table class="table table-striped table-bordered">

                                <thead>
                                        <tr>
                                                <th>ID</th>
                                                <th>Nombre del Role</th>
                                                <th>Info</th>
                                                <th>Acciones</th>
                                        </tr>
                                </thead>

                                <tbody>
                                        <?php 
                                                foreach($roles as $role)
                                                {
                                                    echo "<tr id=role-" . $role['role_id'] .  ">";
                                                    echo "<td class='id-role'>" . $role['role_id'] .'</td>';
                                                    echo "<td class='nombre-role'>" . $role['nombre'] .'</td>';
													
													echo "<td class='datos-role'>" . '<abbr title="Descripcion"><i class="icon-list"></i></abbr> ' . '<small class="small" class="datos-descripcion">' . $role['descripcion'] . '</small><br/> <abbr title="Empresa"><i class="icon-home"></i></abbr> ' . '<small class="small" class="datos-empresa">' . $role['empresa'] . '</small>';
                                                    //echo '<td>' . anchor("seguridad/modificar_role/" . $role['role_id'], '<i class="icon-pencil icon-white"></i> Mofificar', array("class" => "btn btn-info editar-role margin-bottom-5"));
                                                    //echo ' ' . anchor("seguridad/eliminar_role/".$role['role_id'] , '<i class="icon-trash"></i> Eliminar', array("class" => "btn btn-danger eliminar-role margin-bottom-5", "data-original-title" => "Confirma que desea eliminar el role?")) .'</td>';
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
								               					echo anchor($this->uri->segment(1) ."/". $keyp . '/' .$role['role_id'], '<i class="' . $row['icono'] . '"></i> ' . $row['texto_anchor'], $atributos);
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
						<?php } else { ?>
							<div class="row">
								<div class="alert alert-info span10 margin-top-10">
									<strong><?php echo $sin_roles; ?></strong>
								</div>
							</div>
						<?php } ?>

        </div>		<!-- .block_content ends -->

        <div class="bendl"></div>
        <div class="bendr"></div>
</div>		
<!-- .block ends -->