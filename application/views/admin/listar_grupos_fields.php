<div class="row">
        <div class="span12 margin-bottom-10">
                	<div class="row relativo">
	               			<div class="span12">
		                        	<?php if(isset($data_menu)) { ?>
				                		<?php foreach ($data_menu as $keyp => $row) { ?>
				               				<?php if($row['boton_superior']) { ?>
				                				<?php echo '<a class="'. $row['clase_boton'] . '" href="'. site_url() . "/" . $this->uri->segment(1) . "/" . $keyp . '"><i class="'. $row['icono'] . '"></i> ' . $row['texto_anchor'] . '</a>';  ?>
				                			<?php } ?>
				                		<?php } ?>
				                	<?php } ?>
                                    <h2>Grupos Fields</h2>
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
	            	if(isset($errormsg)) {
	            		$data['estado'] = "error";
	            	} else if(isset($message)) {
	            		$data['estado'] = "success";
	            	}
					if(isset($data)) {
						$this->load->view('general/mensaje_operacion', $data); 
					}
	            ?>     
                <table class="table table-striped table-bordered">

                        <thead>
                                <tr>
                                        <th>ID</th>
                                        <th>Nombre</th>
                                        <th>Acciones</th>
                                </tr>
                        </thead>

                        <tbody>
                                <?php 
                                	if(!empty($grupos_fields)) {
                                		foreach($grupos_fields as $grupo_field)
                                        {
                                            echo "<tr>";
                                            	echo "<td>";
													echo $grupo_field['grupos_fields_id'];
												echo "</td>";
												
												echo "<td>";
													echo $grupo_field['grupos_fields_nombre'];
												echo "</td>";
												
												echo "<td>";
														echo "<a class='btn cambiar-email-usuario btn-primary margin-bottom-5' href='" . site_url() . "/admin/modificar_grupo_field/" .  $grupo_field['grupos_fields_id'] . "'><i class='icon-pencil icon-white'></i> Modificar</a> ";
														echo "<a class='btn cambiar-email-usuario btn-danger margin-bottom-5' href='" . site_url() . "/admin/baja_grupo_fields/" .  $grupo_field['grupos_fields_id'] . "'><i class='icon-trash icon-white'></i> Eliminar</a> ";
														echo "<a class='btn cambiar-email-usuario btn-info margin-bottom-5' href='" . site_url() . "/admin/fields/" .  $grupo_field['grupos_fields_id'] . "'><i class='icon-align-justify icon-white'></i> Ver Fields</a> ";
												echo "</td>";
                                            echo "</tr>";
                                        }
                                	}
                                ?>
                        </tbody>
                </table>                                
        </div>						
	</div>		