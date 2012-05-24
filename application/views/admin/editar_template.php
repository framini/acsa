 	<?php
	$template_n = isset($template_data) ? $template_data[0]['nombre'] : set_value('nombre');
	$template_c = isset($template_data) ? $template_data[0]['data'] : set_value('codigo');
	
	$template_codigo = array(
	        'name'              => 'codigo',
	        'value'             => $template_c,
	        'class'             => 'text span5',
	        'id'                => 'codigo'
	);
	
	$template_nombre = array(
	        'name'              => 'nombre',
	        'value'             => $template_n,
	        'class'             => 'text span5',
	        'id'                => 'template_nombre'
	);
	?>

	<div class="row">
            <div class="span12 margin-bottom-10">
                	<div class="row">
	               		<div class="span12">
	                		<h2><?php if(isset($t)) { echo $t;} ?></h2>
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
            	
            	<div class="row margin-bottom-10">
                  <div class="alert span5 alert-error margin-top-10" id="resultado-operacion" style="display: none;"></div>
                </div>
                
                <?php if(isset($fa)) echo form_open($fa); else echo form_open($this->uri->uri_string()); ?>
                
                	<div class="row">
                		<div class="span6 control-group <?php if(form_error($template_nombre['name']) != "") echo "error"; ?>">
                            <?php echo form_label('Nombre Template <i class="icon-asterisk"></i>', $template_nombre['name']); ?>
                            <?php echo form_input($template_nombre); ?>
                            
							<?php if(form_error($template_nombre['name']) != "" || isset($errors[$template_nombre['name']])) {?>
							<div class="row">
                                <div class="alert span4 alert-error">
							        <?php echo form_error($template_nombre['name']); ?><?php echo isset($errors[$template_nombre['name']])?$errors[$template_nombre['name']]:''; ?>
							    </div>
							</div>
				   			<?php } ?>
				    	</div>
					</div>
                
					<div class="row height400">
                		<div class="span6 control-group <?php if(form_error($template_codigo['name']) != "") echo "error"; ?>">
                            <?php echo form_label('Código Template <i class="icon-asterisk"></i>', $template_codigo['name']); ?>
                            <?php echo form_textarea($template_codigo); ?>
                            
                            <div id="editor">some text</div>
                            
						    <script src="<?php echo base_url(); ?>js/ace/ace.js" type="text/javascript" charset="utf-8"></script>
						    <script src="<?php echo base_url(); ?>js/ace/theme-monokai.js" type="text/javascript" charset="utf-8"></script>
						    <script src="<?php echo base_url(); ?>js/ace/mode-html.js" type="text/javascript" charset="utf-8"></script>
						    
						    <script>
						    window.onload = function() {
						        var editor = ace.edit("editor");
						        editor.setTheme("ace/theme/monokai");
						        //editor.getSession().setMode("ace/mode/javascript");
						        var HtmlMode = require("ace/mode/html").Mode;
   	 							editor.getSession().setMode(new HtmlMode());
						        
								var textarea = $('textarea[name="codigo"]').hide();
								editor.getSession().setValue(textarea.val());
								editor.getSession().on('change', function(){
								  textarea.val(editor.getSession().getValue());
								});
						    };
						    </script>
                            
							<?php if(form_error($template_codigo['name']) != "" || isset($errors[$template_codigo['name']])) {?>
							<div class="row">
                                <div class="alert span4 alert-error">
							        <?php echo form_error($template_codigo['name']); ?><?php echo isset($errors[$template_codigo['name']])?$errors[$template_codigo['name']]:''; ?>
							    </div>
							</div>
				   			<?php } ?>
				    	</div>
					</div>

                    <p><input type="submit" class="btn btn-primary btn-large" value="<?php if(isset($tb)) echo $tb; ?>" /></p>

                    <?php echo form_close(); ?>
                                                              
            </div><!--fin span12-->		
					
	</div><!--fin row formulario-->		


