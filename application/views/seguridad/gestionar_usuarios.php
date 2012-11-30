<?php $this->load->file('includes/datatables_files.php'); ?>
<script>
	$(function() {
		$objInit = $.extend( {}, objInit );

	    var $tabla = $('#tabla').dataTable($objInit);
	    
	    $('#tabla').on('eliminarFila', function(event, param) {
			if( param.fila ) {
				$tabla.fnDeleteRow( param.fila[0] )
			}
		});
	});
</script>

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
	                		<h2>Usuarios</h2>
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

                


                        <table id="tabla" class="table table-striped table-bordered display">

                                <thead>
                                        <tr>
                                                <th>ID</th>
                                                <th>Nombre de usuario</th>
                                                <th>Info usuario</th>
                                                <th>Acciones</th>
                                        </tr>
                                </thead>

                                <tbody>
                                        <?php 
                                                foreach($usuarios as $user)
                                                {
                                                    echo "<tr id=usuario-" . $user['user_id'] .  ">";
                                                    echo "<td class='id-usuario'>" . $user['user_id'] .'</td>';
                                                    echo "<td class='nombre-usuario'>";
													if($user['es_admin'] == 1) echo '<a rel="tooltip" title="ADMIN" href="#"><i class="icon-star"></i></a>';
													echo $user['username'] .'</td>';
													//echo '<td>' . '<a rel="tooltip" href="#" title="Email: ' . $user['email'] . '<br/>Empresa: ' . $user['empresa'] .  '">Info usuario</a>' . '</td>';
													echo "<td class='datos-usuario'>" . '<abbr title="Email"><i class="icon-envelope"></i></abbr> ' . '<small class="small" class="datos-email">' . $user['email'] . '</small><br/> <abbr title="Empresa" class="datos-empresa"><i class="icon-home"></i></abbr> ' . '<small class="small">' . $user['empresa'] . '</small><br/><abbr title="Role" class="datos-role"><i class="icon-tags"></i></abbr> ' . '<small class="small">' . $nombre_role[$user['user_id']] . '</small>';
                                                    /*echo '<td>' . anchor("seguridad/editar_usuario/" . $user['user_id'], '<i class="icon-pencil icon-white"></i> Editar usuario', array("class" => "btn btn-info editar-usuario margin-bottom-5"));
                                                    echo ' ' . anchor("seguridad/cambiar_email/" .$user['user_id'] , '<i class="icon-pencil icon-white"></i> Cambiar mail', array("class" => "btn cambiar-email-usuario btn-primary margin-bottom-5"));
                                                    echo ' ' . anchor("seguridad/cambiar_password/" .$user['user_id'] , '<i class="icon-pencil icon-white"></i> Cambiar Password', array("class" => "btn btn-primary cambiar-password-usuario margin-bottom-5"));
                                                    echo ' ' . anchor("seguridad/eliminar_user/".$user['user_id'] , '<i class="icon-trash"></i> Eliminar', array("class" => "btn btn-danger eliminar-usuario margin-bottom-5", "data-original-title" => "Confirma que desea eliminar el usuario?")) .'</td>';
                                                    echo "</tr>";*/
                                                   echo '<td>';
                                                   if(count($data_menu) > 0) {
														$band = 0;
	                                                    foreach ($data_menu as $keyp => $row) {
								               				if(!$row['boton_superior']) {
								               					if( $keyp == "eliminar_user" && ( isset( $id_usuario_logueado ) && $user['user_id'] == $id_usuario_logueado ) ) {
								               						continue;
								               					}
								               					$band +=1;
								               					if(isset($row['titulo'])) {
								               						$atributos = array('data-original-title' => $row['titulo'], 'class' => $row['clase_boton']);
								               					} else {
								               						$atributos = array('class' => $row['clase_boton']);
								               					}
								               					echo anchor($this->uri->segment(1) ."/". $keyp . '/' .$user['user_id'], '<i class="' . $row['icono'] . '"></i> ' . $row['texto_anchor'], $atributos);
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

        <div class="bendl"></div>
        <div class="bendr"></div>
</div>		
<!-- .block ends -->