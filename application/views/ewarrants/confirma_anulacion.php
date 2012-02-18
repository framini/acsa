<div class="block">
			
                            <div class="block_head">
                            <div class="bheadl"></div>
                            <div class="bheadr"></div>

                            <h2>Firma de eWarrant</h2>
                            </div>		
                            <!-- .block_head ends -->
				
				
				
                            <div class="block_content">
                                
                                <?php echo form_open('ewarrants/confirma_anulacion/'); ?>

                                    <input type="hidden" name="anular_confirm" value="1" />
                                    <?php //echo form_submit('register', 'Crear Cuenta'); ?>
                                    <input type="hidden" name="ewid" value="<?php echo $id ?>" />
                                    <p><input type="submit" class="submit long" value="Firmar eWarrant" name="register" /></p>
                                <?php echo form_close(); ?>
                                                                              
                            </div>		
                            <!-- .block_content ends -->
				
                        <div class="bendl"></div>
                        <div class="bendr"></div>
					
	</div>		
<!-- .block ends -->