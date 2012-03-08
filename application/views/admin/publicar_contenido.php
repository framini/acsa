<div class="row">
        <div class="span12 margin-bottom-10">
                	<div class="row relativo">
	               			<div class="span12">
                                    <h2>Elige un Form para publicar contenido:</h2>
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
	            <?php if(isset($forms)) { ?>
					<ul class="nav nav-tabs nav-stacked">
						<li class="nav-header"><span class="small menu">Forms disponibles:</span></li>
						<?php foreach($forms as $form) { ?>
							 <li><?php echo anchor('admin/form/' . $form['forms_id'], '<i class=""></i>' . format_texto($form['forms_nombre'])); ?></li>
						<?php } ?>
					</ul>
	           <?php } ?>                      
        </div>						
	</div>		