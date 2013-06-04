$(function() {    
    var datos = {};
	var dire = "http://localhost/argc/index.php" + "/adm/general";
	
	////////////////////////////////////////////////////////////
	//BOTONES Eliminar
	////////////////////////////////////////////////////////////
	$('#tabla').on('click', 'a.eliminar-role', function(event) {
		//Establecemos reglas default
		$.ajaxSetup({
    		dataFilter: function(data, type) {
    			//Filtramos la data de confirmacion.php
    			//pàra insertarla dentro del pop-up
    			data = $(data).find('#contenedor');
    			data.removeClass('row').addClass('centrado');
    			data.find('.span4').each(function() {
    				$(this).addClass('cont-centrado-span4')
    			});
    			return data;
    		}
    	});
		
		event.preventDefault();
		datos.dire = $(this).attr('href');
		datos.elem = $(this);
		
		$.colorbox(
    	{
    		ajax: true,
    		width:"390", 
    		height:"250",
    		overlayClose: false,
    		escKey: false,
    		href: dire,
    		scrolling: false,
    		close: "Cancelar",
    		fastIframe: false,
    		onComplete: function() {
    			$('#contenedor h2').text(datos.elem.attr('data-original-title'));
    		}
    	});
	});
	
	//Registramos el handler para el boton NO del pop-up
	$(document).on('click', '#btn-no', function(event) {
		event.preventDefault();
		$.colorbox.close();
	});
	//Registramos el handler para el boton SI del pop-up
	$(document).on('click', '#btn-si', function(event) {
		event.preventDefault();
		
		$.ajax({ 
            url: datos.dire, 
            cache: false, 
            success: function() {
                $.colorbox.close();
                datos.elem.closest('tr').fadeOut('slow', function() {
                	$.event.trigger('eliminarFila', { fila: $(this) } );
                	//$(this).detach();
                });
                $('#resultado-operacion p').text('Se ha eliminado el role correctamente!');
                $('#resultado-operacion').slideDown('slow').delay(5000).slideUp('slow');
            }
        }); 
	});
	////////////////////////////////////////////////////////////
	//FIN BOTONES Eliminar
	////////////////////////////////////////////////////////////
	
	////////////////////////////////////////////////////////////
	//BOTONES Editar
	////////////////////////////////////////////////////////////
	
	//Filtramos el contenido del iFrame
	$(document).on('iframeCargado', function() {
		$('iframe.cboxIframe').contents().find('.navbar-fixed-top').hide();
		
		//Registramos un listener al boton guardar. Si se hace click suponemos que se cambiaron datos
		$('iframe.cboxIframe').contents().find('.btn-primary.btn-large').click(function(event){
			//event.preventDefault();
			//Registramos si el boton update se clickeo o no
			var actualizado = $('body').data('userActualizado', true);
		});
		
	});
	
	$('#tabla').on('click', 'a.editar-role', function(event) {
		console.log("ntro");
		event.preventDefault();
		
		//Guardamos los datos del boton clickeado
		datos.dire = $(this).attr('href');
		datos.elem = $(this).closest('tr');
		
		//Registramos la URL del elemento clickeado
		$('body').data('uriUpdate', datos.dire);

    	$.colorbox(
    	{
    		iframe: true,
    		ajax:true,
    		width:"390", 
    		height:"520",
    		overlayClose: false,
    		escKey: false,
    		href: datos.dire,
    		scrolling: true,
    		close: "Cancelar",
    		onCleanup: function() {
    			var rfsh = window.location + " #" + $(datos.elem).attr('id');
    			//Si se actualizo el usuario, volvemos a cargar la fila para refrescar datos
    			if($('body').data('userActualizado')) {
    				$.ajax({
    					url: window.location,
    					dataFilter: function(data, type) {
    						//Filtramos los datos devueltos en nuestra peticion
    						//para solo quedarnos con los referentes a la fila cambiada
    						var id = "#" + $(datos.elem).attr('id');
    						var row = $(data).find(id);
    						data = row.children();
    						//Almacenamos los datos de los td a modificar
    						data.rnombre = row.find('.nombre-role').html();
							data.rdatos = row.find('.datos-role').html();
    						return data;
    					},
    					dataType: 'html',
    					cache: false,
    					type: 'GET',
    					success: function(data, textStatus, jqXHR){
    						//$(datos.elem).html(data);
    						$(datos.elem).fadeOut('slow', function() {
    							//Almacenamos los datos de los td a modificar
    							datos.elem.find('.nombre-role').html(data.rnombre);
    							datos.elem.find('.datos-role').html(data.rdatos);
    						})
    						.delay(400)
    						.fadeIn('slow', function() {
    							$('input#id_search').trigger('actualizarTabla');
    						});
    					},
    					global:false
    				});
    				//$(datos.elem).load(rfsh);
    			} 
    		}
    	});
    	
    	
	});
});
