 	<?php
	$template_n = isset($form_data) ? $form_data : set_value('nombre');
	$template_c = isset($form_data) ? $form_data : set_value('codigo');
	
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
					
					<?php if(isset($extensiones)) { ?>
					<script type="text/javascript">
					var editor;
						//$(function() {
						$(window).load(function() {
							editor = ace.edit("editor");
							$('#extension').change(function() {
								
								
								//editor.setTheme("ace/theme/monokai");
								/*var tmode = "ace/mode/" + $(this).val();
								var mode = require(tmode).Mode;
   	 							editor.getSession().setMode(new mode());*/
   	 							var tmode = "ace/mode/" + $(this).val();
   	 							
   	 							editor.getSession().setMode(tmode);
   	 							editor.getSession().modeName = $(this).val();
   	 							
   	 							
   	 							//console.log($(this).val());
							})
						});
					</script>
					<div class="row">
						<div class="span6 control-group">
                        <label for="extension">Extension del template</label>
						<select name="extension" id="extension">
						<?php 
							foreach ($extensiones as $key => $extension) {
								echo '<option value="';
								if($extension['extension'] == "js") {
									echo "javascript";
								} else {
									echo $extension['extension'];
								}
								echo '">' . $extension['extension'] . '</option>';
							} 
						?>
						</select>
						</div>
					</div>
					<?php } ?>
                
					<div class="row height400">
                		<div class="span6 control-group <?php if(form_error($template_codigo['name']) != "") echo "error"; ?>">
                            <?php echo form_label('Código Template <i class="icon-asterisk"></i>', $template_codigo['name']); ?>
                            <?php echo form_textarea($template_codigo); ?>
                            
                            <div id="editor">some text</div>
                            
						    <script src="<?php echo base_url(); ?>js/ace/ace.js" type="text/javascript" charset="utf-8"></script>
						    <script src="<?php echo base_url(); ?>js/ace/theme-monokai.js" type="text/javascript" charset="utf-8"></script>
						    <script src="<?php echo base_url(); ?>js/ace/mode-html.js" type="text/javascript" charset="utf-8"></script>
						    <script src="<?php echo base_url(); ?>js/ace/mode-css.js" type="text/javascript" charset="utf-8"></script>
						    <script src="<?php echo base_url(); ?>js/ace/mode-javascript.js" type="text/javascript" charset="utf-8"></script>
						    
						    <script>
						    $(window).load(function() {
						        //var editor = ace.edit("editor");
						        editor.setTheme("ace/theme/monokai");
						        editor.renderer.setShowPrintMargin(false);
						        editor.setShowInvisibles(true);
						        //editor.getSession().setMode("ace/mode/javascript");
						        var HtmlMode = require("ace/mode/html").Mode;
   	 							editor.getSession().setMode(new HtmlMode());
						        
								var textarea = $('textarea[name="codigo"]').hide();
								editor.getSession().setValue(textarea.val());
								editor.getSession().on('change', function(){
								  textarea.val(editor.getSession().getValue());
								});
						    });
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


