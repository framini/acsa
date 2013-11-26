<style type="text/css">
tbody tr td:nth-child(2), tbody tr td:nth-child(3), tbody tr td:nth-child(4) {
	max-width: 200px;
	word-wrap: break-word;
}
</style>

<?php echo form_open($this->uri->uri_string()); ?>

<input type="text" name="anio" placeholder="Año" <?php if(isset($anio)) echo 'value="' . $anio . '"'; ?>>
<input type="text" name="mes" placeholder="Mes" <?php if(isset($mes)) echo 'value="' . $mes . '"'; ?>>
<button type="submit" style="margin: -9px 0 0 0;" class="btn">Enviar Consulta</button>

</form>

<?php echo $crud; ?>