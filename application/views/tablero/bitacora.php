<style>
tbody tr td:nth-child(3) {
	max-width: 200px;
	word-wrap: break-word;
}
</style>

<div class="message success alert alert-success" style="display: none;"><p></p></div>

<input type="text" id="datepicker" size="30" />
<a class="DTTT_button ui-button ui-state-default DTTT_button_print" style="margin: 3px;margin-right: 20px!important;" id="pasaje_historico" title="Pasaje a Historico"><span>Pasaje a Historico</span></a>

<?php echo $crud; ?>

<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>

<script type="text/javascript">
	$(function() {

		if( localStorage.getItem('pasajeSuccess') ) {
			$('.message').show().find('p').text( localStorage.getItem('pasajeSuccess') ).delay(5000).hide('slow', function() {
					$('.message').hide();
			});
			localStorage.removeItem('pasajeSuccess')
		}

		$('#datepicker').datepicker();

		$('#datepicker').datepicker('option', 'dateFormat', 'yymmdd');

		
		$('#pasaje_historico').on('click', function() {
			if($("#datepicker").val()) {
				$.ajax({
					url: "<?php echo base_url(); ?>" + "index.php/adm/tablero/pasaje_historico",
					type : "POST",
					data: { fecha: $("#datepicker").val() },
					success: function(data) {
						localStorage.setItem('pasajeSuccess', $.parseJSON(data).msg)
						window.location = "<?php echo base_url(); ?>" + "index.php/adm/tablero/bitacora"
					}
				});
			}
		}); 
	})
</script>