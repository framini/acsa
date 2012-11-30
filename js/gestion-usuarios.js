    $(document).ready(function() {
    		var datos = {};
        	var dire = "http://localhost/argc/index.php" + "/general";
			
			////////////////////////////////////////////////////////////
			//BOTONES Eliminar
			////////////////////////////////////////////////////////////
        	$('#tabla').on('click', 'a.eliminar-usuario', function(event) {
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
	                    	//$(this).detach();
	                    	$.event.trigger('eliminarFila', { fila: $(this) } );
	                    });
	                    $('#resultado-operacion p').text('Se ha eliminado al usuario correctamente!');
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
					event.preventDefault();
					//Registramos si el boton update se clickeo o no
					var actualizado = $('body').data('userActualizado', true);
				});
				
			});
			$('#tabla').on('click', 'a.editar-usuario', function(event) {
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
	        		height:"480",
	        		overlayClose: false,
	        		escKey: false,
	        		href: datos.dire,
	        		scrolling: false,
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
	        						var username = $(data).find('#nombre-usuario-top').html();
	        						var row = $(data).find(id);
	        						data = row.children();
	        						//Almacenamos los datos de los td a modificar
	        						data.unombre = row.find('.nombre-usuario').html();
	        						data.udatos = row.find('.datos-usuario').html();
	        						data.username = username;
	        						
	        						return data;
	        					},
	        					dataType: 'html',
	        					cache: false,
	        					type: 'GET',
	        					success: function(data, textStatus, jqXHR){
	        						//$(datos.elem).html(data);
	        						$(datos.elem).fadeOut('slow', function() {
	        							datos.elem.find('.nombre-usuario').html(data.unombre);
	        							datos.elem.find('.datos-usuario').html(data.udatos);
	        							$('#nombre-usuario-top').html(data.username);
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
			
			////////////////////////////////////////////////////////////
			//FIN EDITAR
			////////////////////////////////////////////////////////////
			
			////////////////////////////////////////////////////////////
			//BOTONES Cambiar mail
			////////////////////////////////////////////////////////////
			//Filtramos el contenido del iFrame
			$(document).on('iframeCargado', function() {	
				//Registramos un listener al boton guardar. Si se hace click suponemos que se cambiaron datos
				$('iframe.cboxIframe').contents().find('#cambiarEmail').click(function(event){
					event.preventDefault();
					//Registramos si el boton update se clickeo o no
					var actualizado = $('body').data('userActualizado', true);
				});
				
			});
			
			$('#tabla').on('click', 'a.cambiar-email-usuario', function(event) {
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
	        		height:"400",
	        		overlayClose: false,
	        		escKey: false,
	        		href: datos.dire,
	        		scrolling: false,
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
	        						data.unombre = row.find('.nombre-usuario').html();
	        						data.udatos = row.find('.datos-usuario').html();
	        						return data;
	        					},
	        					dataType: 'html',
	        					cache: false,
	        					type: 'GET',
	        					success: function(data, textStatus, jqXHR){
	        						//$(datos.elem).html(data);
	        						$(datos.elem).fadeOut('slow', function() {
	        							datos.elem.find('.nombre-usuario').html(data.unombre);
	        							datos.elem.find('.datos-usuario').html(data.udatos);
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
			////////////////////////////////////////////////////////////
			//Fin BOTONES Cambiar mail
			////////////////////////////////////////////////////////////
			
			////////////////////////////////////////////////////////////
			//BOTONES Cambiar Password
			////////////////////////////////////////////////////////////
			
			$('#tabla').on('click', 'a.cambiar-password-usuario', function(event) {
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
	        		height:"400",
	        		overlayClose: false,
	        		escKey: false,
	        		href: datos.dire,
	        		scrolling: false,
	        		close: "Cancelar"
	        	});
	        	
	        	
			});
			////////////////////////////////////////////////////////////
			//Fin BOTONES Cambiar Password
			////////////////////////////////////////////////////////////
    }); 