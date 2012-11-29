<script type="text/javascript">
	$(function() {
		//Buscador
		var qs = $('input#id_search').quicksearch('table tbody tr');
		$('input#id_search').on('actualizarTabla', function(event) {
			qs.cache();
		}); 
	});
</script>
<input type="text" name="search" value="" id="id_search" class="input-medium search-query span4 " placeholder="Filtrar Resultados" />