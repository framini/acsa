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
	                		<?php if(isset($data_menu)) { ?>
		                		<?php foreach ($data_menu as $keyp => $row) { ?>
		               				<?php if($row['boton_superior']) { ?>
		               					<?php echo anchor($this->uri->segment(1) ."/". $keyp, '<i class="' . $row['icono'] . '"></i> ' . $row['texto_anchor'], 'class="' . $row['clase_boton'] . '"');  ?>
		                			<?php } ?>
		                		<?php } ?>
		                	<?php } ?>
	                		<h2>Entradas</h2>
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

                        <table id="tabla" class="table table-striped table-bordered display">

                                <thead>
                                        <tr>
                                                <th>ID</th>
                                                <th>Titulo</th>
                                                <th>Info entrada</th>
                                                <th>Acciones</th>
                                        </tr>
                                </thead>

                                <tbody>
                                        <?php 
                                                foreach($entries as $entry)
                                                {
                                                    echo "<tr id=entry-" . $entry['entry_id'] .  ">";
                                                    echo "<td class='id-entry'>" . $entry['entry_id'] .'</td>';
                                                    echo "<td class='titulo-entry'>";
													echo $entry['titulo'] .'</td>';
													//echo '<td>' . '<a rel="tooltip" href="#" title="Email: ' . $user['email'] . '<br/>Empresa: ' . $user['empresa'] .  '">Info usuario</a>' . '</td>';
													echo "<td class='datos-entry'>" . '<abbr title="Autor"><i class="icon-user"></i></abbr><small class="small" class="datos-email"> ';
													echo $entry['autor'] ;
													echo '</small><br/> <abbr title="Formulario" class="datos-empresa"><i class="icon-th-list"></i></abbr> ' . '<small class="small">' ;
													echo $entry['form'] ;
													echo '</small><br/><abbr title="Fecha de creacion" class="datos-role"><i class="icon-calendar"></i></abbr> ' . '<small class="small">' ;
													echo $entry['entry_date'] ;
													echo '</small>';
                                                    /*echo '<td>' . anchor("seguridad/editar_usuario/" . $user['user_id'], '<i class="icon-pencil icon-white"></i> Editar usuario', array("class" => "btn btn-info editar-usuario margin-bottom-5"));
                                                    echo ' ' . anchor("seguridad/cambiar_email/" .$user['user_id'] , '<i class="icon-pencil icon-white"></i> Cambiar mail', array("class" => "btn cambiar-email-usuario btn-primary margin-bottom-5"));
                                                    echo ' ' . anchor("seguridad/cambiar_password/" .$user['user_id'] , '<i class="icon-pencil icon-white"></i> Cambiar Password', array("class" => "btn btn-primary cambiar-password-usuario margin-bottom-5"));
                                                    echo ' ' . anchor("seguridad/eliminar_user/".$user['user_id'] , '<i class="icon-trash"></i> Eliminar', array("class" => "btn btn-danger eliminar-usuario margin-bottom-5", "data-original-title" => "Confirma que desea eliminar el usuario?")) .'</td>';
                                                    echo "</tr>";*/
                                                   echo '<td>';
                                                   	echo "<a class='btn cambiar-email-usuario btn-primary margin-bottom-5' href='" . site_url() . "/admin/form/" .  $entry['forms_id'] . "/" . $entry['entry_id'] . "'><i class='icon-pencil icon-white'></i> Modificar</a> ";
													echo "<a class='btn cambiar-email-usuario btn-danger margin-bottom-5' href='" . site_url() . "/admin/eliminar_entry/" .  $entry['entry_id'] . "'><i class='icon-trash icon-white'></i> Eliminar</a> ";

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