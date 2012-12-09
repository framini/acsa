<?php 
	//var_dump(($cotizacion)); die();
	//var_dump($cuentas); die();
?>
<div class="row">
				
				<div class="widget widget-table action-table span6 last">
						
					<div class="widget-header">
						<i class="icon-globe"></i>
						<h3>Introducción</h3>
					</div> <!-- /widget-header -->
					
					<div class="widget-content" style="padding: 10px;">
							<p>El uso del warrant viene creciendo de manera sostenida, pero para que este ágil y 
							sencillo instrumento de crédito libere su potencial y afiance su credibilidad es necesario 
							modernizar la ley que le dió origen, -que data de 1914- y sigue vigente, tomando en 
							cuenta las exigencias de mercados que hoy demandan diferenciación, especialización y 
							valor agregado. </p>
							<p>Si bien en el transcurso del tiempo han aparecido opiniones que plantean la 
							necesidad de su reforma, hay que ser prudente al tratar de hacer modificaciones porque 
							pueden tender a desnaturalizarla. </p>
							<p>Sin perjuicio de ello, resulta conducente la necesidad de modernizar el esquema 
							legal, sin alterar su esencia, que tiene como destinatario al pequeño y mediano 
							productor, actuando como soporte de economías regionales y debe resultar sencillo en 
							su aplicación y comprensión. </p>
							<p>No debe soslayarse la importancia que tiene el warrant como herramienta, 
							constituyendo un verdadero impulsor del crédito, permitiendo retener el producto y 
							venderlo a futuro en mejores condiciones. </p>
							<p>Según información del sector, el índice de falta de pago, desde 1991, es del 0,4%, 
							porcentaje más que bajo si se tiene en cuenta que la mitad de esos incumplimientos se 
							produjeron tras el efecto tequila, cuando los bancos no renovaban créditos y pedían la 
							venta de las mercaderías.  </p>
							<p>Actualmente la mayoría de los bancos de primera línea poseen un sector de 
							agribusiness y buscan acercarse al productor. Es por lo antes mencionado que debe 
							“refrescarse” este instrumento sencillo, ágil y seguro, virtudes éstas, que no siempre son 
							fáciles de apreciar en las figuras jurídicas de garantía existentes en la República 
		
					</div>
				
				</div> <!-- widget cotizacion -->
				
				
				<div class="widget widget-table action-table span6 last">
						
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
						
					</div>
				
				</div> <!-- widget cotizacion -->
				<?php if( $this-> auth_frr -> es_admin() ) { ?>
				<div class="widget widget-table action-table span6 last">
						
					<div class="widget-header">
						<i class="icon-info-sign"></i>
						<h3>Estadisticas</h3>
					</div> <!-- /widget-header -->
					
					<div class="widget-content">
						
						<table class="table table-striped table-bordered">
							<thead>
								<tr>
									<th>Entidades dadas de alta</th>
									<th>Cantidad</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td>Usuarios</td>
									<td><?php echo $estadisticas_usuarios; ?></td>
								</tr>
								<tr>
									<td>Empresas</td>
									<td><?php echo $estadisticas_empresas; ?></td>
								</tr>
								<tr>
									<td>eWarrants habilitados</td>
									<td><?php echo $estadisticas_ewarrants; ?></td>
								</tr>
							</tbody>
						</table>
						
					</div>
				
				</div> <!-- widget cotizacion -->
				<?php } ?>
</div>