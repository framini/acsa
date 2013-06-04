    $(document).ready(function() {

    		var datos = {};
        	var dire = "http://localhost/argc/index.php" + "/adm/general";
        	//var dire = "http://localhost/acsa/index.php" + "/adm/general";
        	
        	////////////////////////////////////////////////////////////
			//BOTONES NO del POP-UP
			////////////////////////////////////////////////////////////
        	//Registramos el handler para el boton NO del pop-up
        	$(document).on('click', '#btn-no', function(event) {
        		event.preventDefault();
        		$.colorbox.close();
        	});
			
			////////////////////////////////////////////////////////////
			//BOTONES Eliminar
			////////////////////////////////////////////////////////////
        	$(document).on('click', 'a.eliminar-empresa', function(event) {
        		//Limpiamos los handlers anteriormente asignados
        		$(document).off('click', '#btn-si');
        		
	        	//Registramos el handler para el boton SI del pop-up
	        	$(document).on('click', '#btn-si', function(event) {
	        		event.preventDefault();
	        		
	        		$('body').data('empresaEliminada', true);
	        		
	        		var urlf = datos.dire + "/si";
	        		$.ajax({ 
		                url: urlf, 
		                cache: false,
		                success: function() {
		                    $.colorbox.close();
		                    //Ponemos el tr en rojo para indicar que fue eliminada
		                    datos.elem.closest('tr').addClass('alert-error');
		                    
		                    $('#resultado-operacion p').text('Se ha eliminado la empresa correctamente!');
		                    $('#resultado-operacion').slideDown('slow').delay(5000).slideUp('slow');
		                }
		            });
	        	});
        		
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
	        		width:"370", 
	        		height:"250",
	        		overlayClose: false,
	        		escKey: false,
	        		href: datos.dire,
	        		scrolling: false,
	        		close: "Cancelar",
	        		onComplete: function() {
	        			$('#contenedor h2').text(datos.elem.attr('data-original-title'));
	        		},
	        		onCleanup: function() {
	        			$('#btn-si').off('click');
	        			//Si se actualizo el usuario, volvemos a cargar la fila para refrescar datos
	        			var urf = "" + window.location;
	        			if($('body').data('empresaEliminada')) {
	        				$.ajax({
	        					url: urf,
	        					dataFilter: function(data, type) {
	        						//Filtramos los datos devueltos en nuestra peticion
	        						//para solo quedarnos con los referentes a la fila cambiada
	        						var id = "#" + datos.elem.closest('tr').attr('id');
									//Nos quedamos solamente con la fila que tuvo cambios
	        						var row = $(data).find(id);
	        						data = row.children();
	        						
	        						return data;
	        					},
	        					dataType: 'html',
	        					cache: false,
	        					type: 'GET',
	        					success: function(data, textStatus, jqXHR){
	        						var $contenedor = datos.elem.closest('tr');
	        						//$(datos.elem).html(data);
	        						$($contenedor).fadeOut('slow', function() {
	        							$contenedor.html(data);
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
			//FIN BOTONES Eliminar
			////////////////////////////////////////////////////////////
			
			
			////////////////////////////////////////////////////////////
			//BOTONES Activar
			////////////////////////////////////////////////////////////
        	$(document).on('click', 'a.activar-empresa', function(event) {
        		//Limpiamos los handlers anteriormente asignados
        		$(document).off('click', '#btn-si');
        		
	        	//Registramos el handler para el boton SI del pop-up
	        	$(document).on('click', '#btn-si', function(event) {
	        		event.preventDefault();
	        		
	        		$('body').data('empresaActivada', true);
	        		
	        		var urlf = datos.dire + "/si";
	        		$.ajax({ 
		                url: urlf, 
		                cache: false,
		                success: function() {
		                    $.colorbox.close();
		                    //Ponemos el tr en rojo para indicar que fue eliminada
		                    datos.elem.closest('tr').removeClass('alert-error');
		                    
		                    $('#resultado-operacion p').text('Se ha activada la empresa correctamente!');
		                    $('#resultado-operacion').slideDown('slow').delay(5000).slideUp('slow');
		                }
		            });
	        	});
        		
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
        		
        		//alert(datos.elem.closest('tr').attr('id'));
        		
        		$.colorbox(
	        	{
	        		ajax: true,
	        		width:"370", 
	        		height:"200",
	        		overlayClose: false,
	        		escKey: false,
	        		href: datos.dire,
	        		scrolling: false,
	        		close: "Cancelar",
	        		onComplete: function() {
	        			$('#contenedor h2').text(datos.elem.attr('data-original-title'));
	        		},
	        		onCleanup: function() {
	        			//Si se actualizo el usuario, volvemos a cargar la fila para refrescar datos
	        			$('#btn-si').off('click');
	        			var urf = "" + window.location;
	        			if($('body').data('empresaActivada')) {
	        				$.ajax({
	        					url: urf,
	        					dataFilter: function(data, type) {
	        						//Filtramos los datos devueltos en nuestra peticion
	        						//para solo quedarnos con los referentes a la fila cambiada
	        						var id = "#" + datos.elem.closest('tr').attr('id');
									//Nos quedamos solamente con la fila que tuvo cambios
	        						var row = $(data).find(id);
	        						data = row.children();
	        						
	        						return data;
	        					},
	        					dataType: 'html',
	        					cache: false,
	        					type: 'GET',
	        					success: function(data, textStatus, jqXHR){
	        						var $contenedor = datos.elem.closest('tr');
	        						//$(datos.elem).html(data);
	        						$($contenedor).fadeOut('slow', function() {
	        							$contenedor.html(data);
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
			//FIN BOTONES Activar
			////////////////////////////////////////////////////////////
			
			
			////////////////////////////////////////////////////////////
			//BOTONES Editar
			////////////////////////////////////////////////////////////

			$(document).on('click', 'a.modificar-empresa', function(event) {
				event.preventDefault();
				
				//Limpiamos los handlers previamente registrados
				$(document).off('iframeCargado');
				
				//Filtramos el contenido del iFrame
				$(document).on('iframeCargado', function() {
					$('iframe.cboxIframe').contents().find('.navbar-fixed-top').hide();
					
					//Registramos un listener al boton guardar. Si se hace click suponemos que se cambiaron datos
					$('iframe.cboxIframe').contents().find('.btn-primary.btn-large').click(function(event){
						event.preventDefault();
						//Registramos si el boton update se clickeo o no
						$('body').data('empresaActualizado', true);
					});
				});
				
				//Guardamos los datos del boton clickeado
				datos.dire = $(this).attr('href');
        		datos.elem = $(this);
        		
        		//Registramos la URL del elemento clickeado
        		$('body').data('uriUpdate', datos.dire);

	        	$.colorbox(
	        	{
	        		iframe: true,
	        		ajax:true,
	        		width:"390", 
	        		height:"500",
	        		overlayClose: false,
	        		escKey: false,
	        		href: datos.dire,
	        		scrolling: false,
	        		close: "Cancelar",
	        		onCleanup: function() {
	        			var rfsh = window.location + " #" + $(datos.elem).attr('id');
	        			//Si se actualizo el usuario, volvemos a cargar la fila para refrescar datos
	        			if($('body').data('empresaActualizado')) {
	        				$.ajax({
	        					url: window.location,
	        					dataFilter: function(data, type) {
	        						//Filtramos los datos devueltos en nuestra peticion
	        						//para solo quedarnos con los referentes a la fila cambiada
	        						var id = "#" + datos.elem.closest('tr').attr('id');
									//Nos quedamos solamente con la fila que tuvo cambios
	        						var row = $(data).find(id);
	        						data = row.children();
	        						
	        						return data;
	        					},
	        					dataType: 'html',
	        					cache: false,
	        					type: 'GET',
	        					success: function(data, textStatus, jqXHR){
	        						var $contenedor = datos.elem.closest('tr');
	        						//$(datos.elem).html(data);
	        						$($contenedor).fadeOut('slow', function() {
	        							$contenedor.html(data);
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

    }); 