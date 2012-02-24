<div class="row">
	<div class="span12">
		<div class="row" id="contenedor">
			<div class="span4 omega alpha">
				<h2 class="padding-right-20">Desea continuar?</h2>
			</div>
			<div class="clear clear-left"></div>
			<div class="span4 omega alpha ">
				 <?php echo form_open($this->uri->uri_string() . "/si"); ?>
					<div class="span2 width-170 margin-left-none">
						<input type="submit" class="btn btn-large btn-danger margin-bottom-5" id="btn-si" value="SI" />
					</div>
					<div class="span2 width-170 margin-left-none">
						<a href="asd" class="btn btn-large margin-bottom-5" id="btn-no">NO</a>
					</div>
				<?php echo form_close(); ?>
			</div>
		</div>
	</div>
</div><!--fin row principal-->