<?php $this->load->file('includes/datatables_files.php'); ?>
<script>
	$(function() {
		$objInit = $.extend( {}, objInit, { 
			"aoColumnDefs": [ 
								{ "bSortable": false, "aTargets": [ 0 ] } 
							],
            "fnPreDrawCallback": function( oSettings ) {
                    if($('.inlinesparkline').find('canvas').length == 0) {
                       $('.inlinesparkline').sparkline('html', {
                            type: 'tristate',
                            tooltipValueLookups: { map: { '-1': 'No cumplida', '0': 'Cumplida', '1': 'Superada' } }
                        } ); 
                    }  
                }
			} );

	    var $tabla = $('#tabla').dataTable($objInit);
	    
	    $('#tabla').on('eliminarFila', function(event, param) {
			if( param.fila ) {
				$tabla.fnDeleteRow( param.fila[0] )
			}
		});

		var qs = $('input#id_search').quicksearch('table tbody tr', {
			'selector': 'td.id'
		});
		var qsa = $('input#anio_search').quicksearch('table tbody tr', {
			'selector': 'td.anio'
		});
		var qsm = $('input#mes_search').quicksearch('table tbody tr', {
			'selector': 'td.mes'
		});
		$('input#id_search').on('actualizarTabla', function(event) {
			qs.cache();
		});
	});
</script>

<div class="row">
        <div class="span12 margin-bottom-10">
                	<div class="row relativo">
	               			<div class="span12">
                            <?php echo form_open($this->uri->uri_string()); ?>
                            	<?php if(isset($data_menu)) { ?>
			                		<?php foreach ($data_menu as $keyp => $row) { ?>
			               				<?php if($row['boton_superior'] && ($keyp == $this->uri->segment(3))) { ?>
			                				<?php echo '<input type="submit" class="'. $row['clase_boton'] . '" value="' . $row['texto_anchor'] . '" />';  ?>
			                			<?php } ?>
			                		<?php } ?>
			                	<?php } ?>
                                    <h2>Tablero de Control</h2>
                                    <!--<input type="submit" class="btn btn-primary btn-large firmar" value="Firmar!" />-->
                            </div>
	                		<div class="span12 filtros">
	                			<input type="text" name="search" value="" id="id_search" class="input-medium search-query span3 " placeholder="Filtrar por ID" data-index="1"/>

	                			<input type="text" name="search" value="" id="mes_search" class="input-medium search-query span2 " placeholder="Filtrar por Mes" data-index="1"/>

	                			<input type="text" name="search" value="" id="anio_search" class="input-medium search-query span2 " placeholder="Filtrar por Año" data-index="1"/>
	                		</div>
                	</div>
                	<div class="row">
                		<div class="alert alert-success span12 mensajes margin-top-10" id="resultado-operacion" style="display: none;"><span><i id="icono-mensaje" class=""></i> </span> <span id="texto-mensaje"></span></div>
                	</div>
        </div>
				
				
				
                            <div class="span12">
                                <?php
					            	if(isset($errormsg)) {
					            		$data['estado'] = "error";
					            	} else if(isset($message)) {
					            		$data['estado'] = "success";
					            	}
									if(isset($data)) {
										$this->load->view('general/mensaje_operacion', $data); 
									}
					            ?>

                

                                                        <table class="table display table-striped table-bordered" id="tabla">

                                                                <thead>
                                                                        <tr>
                                                                                <?php if(isset($data_menu)) { ?><th width="10"><!--<input type="radio" class="check_all" />--></th> <?php } ?>
                                                                                <th>ID</th>
                                                                                <th>Descripcion</th>
                                                                                <th>Tipo</th>
                                                                                <th>Mes</th>
                                                                                <th>Año</th>
                                                                                <th>Valor</th>
                                                                                <th>Objetivo</th>
                                                                                <th>Historico</th>
                                                                        </tr>
                                                                </thead>

                                                                <tbody>
                                                                        <?php 
                                                                                foreach($ewarrants as $ew)
                                                                                {
                                                                                    echo "<tr>";
                                                                                    if(isset($data_menu)) { echo '<td><input type="radio" name="ewid" value= "'.$ew['id'].'" /></td>'; };
                                                                                    //echo '<td class="id">' . $ew['id'] .'</td>';
                                                                                    echo '<td class="id">';
                                                                                    echo '<a href="' . site_url() . "/" .$this->uri->uri_string() . "/" . $ew['mes'] . "/" . $ew['anio'] . "?id=" . $ew['id'] . '">';
                                                                                    echo  $ew['id'];
                                                                                    echo '</a></td>';
                                                                                    echo '<td>' . $ew['descripcion'] .'</td>';
                                                                                    echo '<td>' . $ew['tipo'] .'</td>';
                                                                                    echo '<td class="mes">' . $ew['mes'] .'</td>';
                                                                                    echo '<td class="anio">' . $ew['anio'] .'</td>';
                                                                                    echo '<td>' . $ew['valor'] .'</td>';
                                                                                    echo '<td>' . $ew['objetivo'] .'</td>';
                                                                                    echo '<td><span class="inlinesparkline">' . $ew['historico'] .'</span></td>';
                                                                                    echo "</tr>";
                                                                                }
                                                                        ?>
                                                                </tbody>

                                                                <script>
                                                                
                                                                </script>

                                                        </table>

                                </form>
                                                                              
                            </div>		
                            <!-- .block_content ends -->
					
	</div>		
<!-- .block ends -->