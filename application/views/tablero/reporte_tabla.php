<div class="message success alert alert-success" style="display: none;"><p></p></div>

<?php echo $crud; ?>

<script type="text/javascript">
	$(window).load(function() {

		$('tr td:nth-child(8)').wrapInner('<span class="inlinesparkline">');
	})
</script>