
	<div class="row">
            <div class="span12 margin-bottom-10">
                	<div class="row">
	               		<div class="span12">
	                		<h2><?php if(isset($t)) { echo $t;} ?></h2>
	                	</div>
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
            	
            	<script type="text/javascript">
            		$(function() {
            			//Ocultamos todos los templates a excepcion del primero y le damos la clase de activo
            			$('.lista_templates').filter(':first').addClass('activo').end().not(':first').hide();
            			//Asignamos la clase de activo al primer item
            			$('.lista_grupos li:first').addClass('active');

            			//Asignamos la clase de activo al primer boton de crear template
            			$('.bot-crear-template').first().addClass('bot-t-activo').end().not(':first').hide();
            			//Asigamos la clase de activo al primer boton de eliminar grupo template
            			$('.bot-elim-grupo-template').first().addClass('bot-gt-activo').end().not(':first').hide();
            			$('.bot-mod-grupo-template').first().addClass('bot-mt-activo').end().not(':first').hide();
            			
            			$('.lista_grupos').on('click', '.link_grupos', function(event) {
            				event.preventDefault();
            				//Le quitamos el focus al item del grupo activo
            				$('.active').removeClass('active');
            				//Se lo asignamos al item en el que se hizo click
            				$(this).closest('li').addClass('active');
							
							//Primero buscamos la lista de templates con clase de activo
							//Le quitamos la clase y luego la ocultamos
							$('.activo').removeClass('activo').hide();
							$('.bot-t-activo').removeClass('bot-t-activo').hide();
							$('.bot-gt-activo').removeClass('bot-gt-activo').hide();
							$('.bot-mt-activo').removeClass('bot-mt-activo').hide();
							
							//Buscamos la lista de templates a mostrar
							//Le asigamos la clase de activo y la mostramos
							$("[id='" + $(this).attr('id') + "-content']").addClass('activo').animate({opacity:'show'}, 800);
							$("[id='" + $(this).attr('id') + "-boton-crear']").addClass('bot-t-activo').animate({opacity:'show'}, 800);
							$("[id='" + $(this).attr('id') + "-boton-eliminar']").addClass('bot-gt-activo').animate({opacity:'show'}, 800);
							$("[id='" + $(this).attr('id') + "-boton-mod']").addClass('bot-mt-activo').animate({opacity:'show'}, 800);
            			});
            		});
            	</script>
            	
            	<div class="row">
            		
            		<div class="span4 widget">
            			<div class="widget-header">
            				<h3>Grupos de Templates</h3>
            				<a class="btn btn-small btn-success posicion-6-top-right pull-right" href="<?php echo site_url() . "/admin/alta_grupos/"; ?>">Crear Grupo Template</a>
            			</div>
            			<div class="widget-content">
	            			<ul class="nav nav-pills nav-stacked lista_grupos margin-bottom-none">
	            				<?php 
				            	if(isset($grupos_templates)) {
				            		//print_r($grupos_templates[0]['template_group_id']);
				            		$band = 0;
				            		foreach ($grupos_templates as $key => $grupo) {
										echo '<li><a href="#" class="link_grupos" id="' . $grupo['nombre'] . '">' . $grupo['nombre'] . '</a> ';
										//echo '<button class="btn btn-mini btn-danger elim-grupo">Eliminar</button>';
										echo '</li>';
									}
				            	}
				            	?>
						    </ul>

						</div>
            		</div>
            		
            		<div class="span8">
            			<div class="widget widget-table">
	            			<div class="widget-header header-templates">
	            				<h3>Templates</h3>
	            				<?php 
				            	if(isset($grupos_templates)) {
				            		//print_r($grupos_templates[0]['template_group_id']);
				            		$band = 0;
				            		foreach ($grupos_templates as $key => $grupo) {
										//echo '<li><a href="#" class="link_grupos" id="' . $grupo['nombre'] . '">' . $grupo['nombre'] . '</a></li>';
										
										echo ' <a class="btn btn-small btn-success posicion-6-top-right pull-right bot-crear-template"';
										echo ' id="' . $grupo['nombre'] . '-boton-crear"';
										echo ' href="'. site_url() . '/admin/alta_templates/' . $grupo['template_group_id'] . '">Crear Template</a> ';
										
										echo ' <a class="btn btn-small posicion-6-top-right pull-right bot-elim-grupo-template"';
										echo ' id="' . $grupo['nombre'] . '-boton-eliminar"';
										echo ' href="'. site_url() . '/admin/baja_grupo_template/' . $grupo['template_group_id'] . '">Eliminar grupo</a>';
										
										echo ' <a class="btn btn-small posicion-6-top-right pull-right bot-mod-grupo-template"';
										echo ' id="' . $grupo['nombre'] . '-boton-mod"';
										echo ' href="'. site_url() . '/admin/editar_grupo_templates/' . $grupo['template_group_id'] . '">Modificar grupo</a>';
									}
				            	}
				            	?>
	            				
	            			</div>
	            			<div class="widget-content lista-templates">
		 				 				<?php 
				            				//$grupo = -1;
											foreach ($grupos_templates as $keyg => $grupo) {
												echo '<table class="lista_templates table table-bordered table-striped" id="' . $grupo['nombre'] . '-content">';
				 				 				echo '<thead>';
			 				 					echo '<tr>';								
												echo '<th>Nombre</th>';
												echo '<th>Acciones</th>';							
												echo '</tr>';
												echo '</thead>';
												echo '<tbody>';
												
												$band = true;
					            				foreach ($templates as $keyt => $template) {
													if($template['template_group_id'] == $grupo['template_group_id']) {
														$band = false;
														echo "<tr>";
														echo '<td width="70%"><a href="' . site_url() . '/admin/editar_templates/' . $template['template_id'] . '">' . $template['nombre'] . '</a></td>';
														echo '<td width="30%">';
															echo '<a class="btn btn-mini" href="' . site_url() . "/" . $template['template_group_nombre'] . "/" . $template['nombre'] . '" target="_blank"><i class="icon-eye-open"></i></a> ';
															echo '<a class="btn btn-mini" href="' . site_url() . '/admin/editar_templates/' . $template['template_id'] . '">Modificar</a> ';
															echo '<a class="btn btn-mini" href="' . site_url() . '/admin/baja_template/' . $template['template_id'] . '">Eliminar</a> ';
															
														echo '</td>';
														echo '</tr>';
														$grupo = $template['template_group_id'];
													}
												}
												//Significa que no hay templates en el grupo
												if($band) {
													echo "<tr>";
													echo '<td colspan="2">';
														echo '<em>No hay templates cargados en el grupo seleccionado</em>';
													echo '</td>';
													echo '</tr>';
												}
												
												echo '</tbody>';
												echo '</table>';
											}
				            			?>
		            		</div>
	            		</div>
            		</div>
            	</div>
                                                              
            </div><!--fin span12-->		
					
	</div><!--fin row formulario-->		


