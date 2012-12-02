<div class="row">
	        <div class="span12 margin-bottom-10">
	                	<div class="row">
		               		<div class="span12">
		                		<h2>Administración</h2>
		                	</div>
	                	</div>
	        </div>

            <div class="span12">
            	<?php if(isset($message)) { ?>
                	<div class="row">
                		<div class="alert alert-success span12 mensajes margin-top-10" id="resultado-operacion" style="margin-bottom: 10px !important;">
                    <?php
                             echo $message;
                     ?>
                     </div> 
                    </div>
                <?php } ?>
				 <div class="row">
				 	<div class="span5">
	                    <div style="padding: 8px 0;" class="well">
					        <ul class="nav nav-list">
					          <li class="nav-header">Administración Formularios</li>
					          <li><?php echo anchor('adm/admin/forms', '<i class="icon-th-list"></i>Formularios'); ?></li>
						      <li><?php echo anchor('adm/admin/grupos_fields', '<i class="icon-folder-open"></i> Grupos Fields'); ?></li>
					        </ul>
					    </div>
					 </div>
				 </div>       
            </div>		
					
	</div>		
