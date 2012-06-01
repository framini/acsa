<?php 
	//var_dump(($cotizacion)); die();
	//var_dump($cuentas); die();
?>
<div class="row">
				
				<div class="widget widget-table action-table span6">
						
					<div class="widget-header">
						<i class="icon-globe"></i>
						<h3>Cotizaciones</h3>
					</div> <!-- /widget-header -->
					
					<div class="widget-content">
						
						<table class="table table-striped table-bordered">
							<thead>
								<tr>
									<th>Moneda</th>
									<th>Cotizacion</th>
								</tr>
							</thead>
							<tbody>
								<?php foreach ($cotizacion as $key => $moneda) { $m = json_decode($moneda); ?>
								<tr>
									<td><?php echo $key; ?></td>
									<td><?php echo $m->rhs; ?></td>
								</tr>
								<?php } ?>
								
							</tbody>
						</table>
						
					</div> <!-- /widget-content -->
				
				</div>
					<script type="text/javascript">
						    $(function () {
							    $('body').on('click.tab.data-api', '[data-toggle="tab"], [data-toggle="pill"]', function (e) {
							      e.preventDefault();
							      if(!$(this).is('.accion')) {
							      	$(this).tab('show');
							      } else {
							      	$('#myModal').modal('show');
							      }
							    })
							  })
					</script>
				
					<div class="widget widget-table action-table span6 last">
						<div class="widget-header" id="twitter_barra">
							<i class="icon-nav-home-logged-out"></i>
							<h3></h3>
							<script type="text/javascript">
								$(function(){
								    $('#myModal').modal({
								    	keyboard: false,
								    	show: false
								    });
								    
								    var $bot_elim;
									$('.contenedor-tabs').on('click', '.elim-cuenta', function() {
								    	$('#confirmacion').modal('show');
								    	$bot_elim = $(this).attr('id');
								    });
								    
								    $('#cancelar-op').on('click', function(event) {
								    	event.preventDefault();
								    	$('#confirmacion').modal('hide');
								    })
								    
								    $('#confirmar-op').on('click', function(event) {
									    	event.preventDefault();
									    	
									    	var param = {
									    		"nombre": $bot_elim
									    	};
									    	
									    	$.ajax({
												url: 'http://localhost/argc/index.php/services/twitter/borrar_twitteraccount',
												type: 'json',
												dataType: 'json',
												data: param,
												type: 'POST',
												beforeSend: function() {
													//$('p.error-nombre-usuario code').html('Buscando usuario...');
												},
												success: function(data, textStatus, jqXHR) {
													if(data.error) {
														console.log("ERROR");
													} else {
														$('#mensaje-conf-elim').text('Se ha eliminado la suscripcion a la cuenta!');
														$('#' + $bot_elim + '-cnt').remove();
														$('.tab-' + $bot_elim).remove();
														
														$('.contenedor-tabs').find('li:first').addClass('active');
														$('.contenedor-contenido-tabs').find('div:first').addClass('active in');
														
														//$('#confirmacion').modal('hide');
													}
												}
											});
									    });

								    $('#btn-addtwitter').on('click', function(event) {
								    	event.preventDefault();
								    	var param = {
								    		"nombre": $('input[name="usuario"]').val()
								    	};
								    	
								    	$.ajax({
											url: 'http://localhost/argc/index.php/services/twitter/get',
											type: 'json',
											dataType: 'json',
											data: param,
											type: 'POST',
											beforeSend: function() {
												$('p.error-nombre-usuario code').html('Buscando usuario...');
											},
											success: function(data, textStatus, jqXHR) {
												if(data.error) {
													$('p.error-nombre-usuario code').html(data.error);
												} else {
													if(data.length > 0) {
														$('p.error-nombre-usuario code').html('Usuario agregado!');
														var $li = $('<li>');
												      	var $a = $('<a>');
												      	$a.text(data[0].user.screen_name);
												      	$a.attr('href', '#' + data[0].user.screen_name + '-cnt');
												      	$a.attr('data-toggle', 'tab');
														var $ie = $('<i class="icon-remove elim-cuenta"></i>');
														$ie.attr('id', data[0].user.screen_name);
														$a.append($ie);
												      	
												      	$li.append($a);
												      	
												      	$('.contenedor-tabs').find('.menu-tabs').before($li);
												      	
												      	var $div = $('<div class="tab-pane fade"></div>');
												      	var $ul = $('<ul class="news-items"></ul>');
												      	$div.append($ul);
												      	for (var i=0; i < data.length; i++) {
												      		var $sli = $('<li>');
												      		var $sdiv = $('<div class="news-item-detail sin-tabla"></div>')
												      		$sli.append($sdiv);
												      		var $p = $('<p class="news-item-preview"></p>');
												      		
												      		var $d2 = $('<div class="news-item-month"></div>');
												      		var $spn = $('<span class="news-item-day"></span>');
												      		$spn.text(data[i].user.created_at); 
												      		$d2.append($spn);
												      		$sli.find($sdiv).append($p);
												      		$sli.find($p).text(data[i].text);
												      		$sli.append($d2);
															$ul.append($sli);
														};
												      	
												      	$div.attr('id', data[0].user.screen_name + '-cnt');
												      	
												      	$('.contenedor-contenido-tabs').append($div);
													}
												}
												
											}
										});
								   })
								})
							</script>
							<div class="modal" id="myModal" style="display: none;">
							    <div class="modal-header">
							    	<button class="close" data-dismiss="modal">×</button>
							    </div>
							    <div class="modal-body">
							    	<h3>Nueva Cuenta</h3>
								    <form id="add-cuenta-twitter" class="form-search" action="#" method="post">
								    	<input type="text" name="usuario" class="input-medium search-query span3" />
								    	<p class="error-nombre-usuario"><code></code></p>
								    	<input type="submit" class="btn btn-small btn-primary" id="btn-addtwitter"/>
								    </form>
							    </div>
						    </div>
					        <div class="modal" id="confirmacion" style="display: none;">
					        	<h3>Confirma que desea eliminar?</h3>
					        	<p class="center" id="mensaje-conf-elim">
					        		
					        	</p>
					        	<p class="center">
								    <a href="#" id="confirmar-op" class="btn btn-primary">Eliminar</a>
								    <a href="#" id="cancelar-op" class="btn">Cancelar</a>
							    </p>
						    </div>
						</div>
						    
						
						<ul class="nav nav-tabs contenedor-tabs" id="myTab">
							<?php
								foreach ($cuentas as $key => $cuenta) {
									echo '<li ';
									echo 'class="tab-' . $cuenta['usuario'] ;
									if($key == 0) {
										echo ' active';
									}
									echo '"';
									echo '>';
									echo '<a data-toggle="tab" href="#';
									echo $cuenta['usuario'] . '-cnt';
									echo '">';
									$sn = $cuenta['tweets'][0];
									echo $sn->user->screen_name;
									echo ' <i class="icon-remove elim-cuenta" id="'. $cuenta['usuario'] . '"></i></a>';
									echo '</li>';
								}
							?>
				            <!--<li class="active">
				            	<a data-toggle="tab" href="#home">Home <i class="icon-remove elim-cuenta"></i></a>
				            </li>-->
				            <!--<li class=""><a data-toggle="tab" href="#profile">Profile</a></li>-->
				            <li class="dropdown menu-tabs">
				              <a data-toggle="dropdown" class="dropdown-toggle" href="#">Acciones <b class="caret"></b></a>
				              <ul class="dropdown-menu">
				                <li class=""><a class="accion" data-toggle="tab" href="#dropdown2">Agregar cuenta</a></li>
				              </ul>
				            </li>
				        </ul>
				        
				        <div class="tab-content contenedor-contenido-tabs" id="myTabContent">
				        	<?php
				        		$cont = 0;
								foreach ($cuentas as $key => $cuenta) {
									echo '<div id="';
									echo $cuenta['usuario'] . '-cnt';
									echo '" class="tab-pane fade ';
									echo 'cont-' . $cuenta['usuario'];
									if($cont == 0) {
										echo ' active in';
									}
									echo '"><p>';
									$cont++;
									echo '<ul class="news-items">';
										foreach ($cuenta['tweets'] as $key => $tweet) {
											if(isset($tweet->created_at)) {
												echo '<li>';
													echo '<div class="news-item-detail sin-tabla">';
														echo '<p class="news-item-preview">';
															echo $tweet->text;
														echo '</p>';
													echo '</div>';
													echo '<div class="news-item-month">';
													echo	'<span class="news-item-day">';
														//$afecha = date_parse_from_format("D M d H:i:s O Y",$tweet->created_at);
														//echo $afecha['day'] . "/" . $afecha['month'] . "/" . $afecha['year']. " a las" . $afecha['hour'] . ':' . $afecha['minute'];
														echo $tweet->created_at;
													echo 	'</span>';
													echo '</div>';
												echo '</li>';
											}
										}
									echo '</ul>';	
									echo '</p></div>';
								}
							?>
				            <div id="home" class="tab-pane fade in">
				              <p>Raw denim you probably haven't heard of them jean shorts Austin. Nesciunt tofu stumptown aliqua, retro synth master cleanse. Mustache cliche tempor, williamsburg carles vegan helvetica. Reprehenderit butcher retro keffiyeh dreamcatcher synth. Cosby sweater eu banh mi, qui irure terry richardson ex squid. Aliquip placeat salvia cillum iphone. Seitan aliquip quis cardigan american apparel, butcher voluptate nisi qui.</p>
				            </div>
				            <div id="profile" class="tab-pane fade">
				              <p>Food truck fixie locavore, accusamus mcsweeney's marfa nulla single-origin coffee squid. Exercitation +1 labore velit, blog sartorial PBR leggings next level wes anderson artisan four loko farm-to-table craft beer twee. Qui photo booth letterpress, commodo enim craft beer mlkshk aliquip jean shorts ullamco ad vinyl cillum PBR. Homo nostrud organic, assumenda labore aesthetic magna delectus mollit. Keytar helvetica VHS salvia yr, vero magna velit sapiente labore stumptown. Vegan fanny pack odio cillum wes anderson 8-bit, sustainable jean shorts beard ut DIY ethical culpa terry richardson biodiesel. Art party scenester stumptown, tumblr butcher vero sint qui sapiente accusamus tattooed echo park.</p>
				            </div>
				            <div id="dropdown1" class="tab-pane fade">
				              <p>Etsy mixtape wayfarers, ethical wes anderson tofu before they sold out mcsweeney's organic lomo retro fanny pack lo-fi farm-to-table readymade. Messenger bag gentrify pitchfork tattooed craft beer, iphone skateboard locavore carles etsy salvia banksy hoodie helvetica. DIY synth PBR banksy irony. Leggings gentrify squid 8-bit cred pitchfork. Williamsburg banh mi whatever gluten-free, carles pitchfork biodiesel fixie etsy retro mlkshk vice blog. Scenester cred you probably haven't heard of them, vinyl craft beer blog stumptown. Pitchfork sustainable tofu synth chambray yr.</p>
				            </div>
				            <div id="dropdown2" class="tab-pane fade">
				              <p>Trust fund seitan letterpress, keytar raw denim keffiyeh etsy art party before they sold out master cleanse gluten-free squid scenester freegan cosby sweater. Fanny pack portland seitan DIY, art party locavore wolf cliche high life echo park Austin. Cred vinyl keffiyeh DIY salvia PBR, banh mi before they sold out farm-to-table VHS viral locavore cosby sweater. Lomo wolf viral, mustache readymade thundercats keffiyeh craft beer marfa ethical. Wolf salvia freegan, sartorial keffiyeh echo park vegan.</p>
				            </div>
				        </div>
			        </div>
			     
				
</div>