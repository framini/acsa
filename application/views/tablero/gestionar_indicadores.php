<?php $this->load->file('includes/datatables_files.php');?>
<script>
	$(function() {
		$objInit = $.extend( {}, objInit );

	    $('#tabla').dataTable($objInit);
	});
</script>

<div class="row">

        <div class="span12 margin-bottom-10">
                	<div class="row">
	               		<div class="span12">
	               			<?php //echo anchor('/seguridad/registro', "<i class='icon-user icon-white'></i> Agregar Usuario", "class='btn btn-large btn-success pull-right'");  ?>
	                		<?php foreach ($data_menu as $keyp => $row) { ?>
	               				<?php if($row['boton_superior']) { ?>
	               					<?php echo anchor($this->uri->segment(1) ."/". $this->uri->segment(2) ."/". $keyp, '<i class="' . $row['icono'] . '"></i> ' . $row['texto_anchor'], 'class="' . $row['clase_boton'] . '"');  ?>
	                			<?php } ?>
	                		<?php } ?>
	                		<h2>Indicadores</h2>
	                	</div>
	                	<div class="span12 margin-top-10">
	                		<?php $this->load->file('includes/buscador.php'); ?>
	                	</div>
	                	<div class="alert alert-success span12 mensajes margin-top-10" id="resultado-operacion" style="display: none;"><p></p></div>
                	</div>
        </div>		
        <!-- .block_head ends -->

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

                


                        <table id="tabla" class="table table-bordered display">

                                <thead>
                                        <tr>
                                                <th>ID</th>
                                                <th>Descripcion</th>
                                                <th>Tipo</th>
                                                <th>Calculo Numerador</th>
                                                <th>Relative</th>
                                                <th>Calculo Denominador</th>
                                                <th>Relacion Objetivo</th>
                                                <th>Drilldown</th>
                                                <th>Activo</th>
                                                <th>User</th>
                                        </tr>
                                </thead>

                                <tbody>
                                        <?php 
                                        	if( !is_null($indicadores) ) { 
                                                foreach($indicadores as $producto)
                                                {
                                                    echo "<tr id=producto-" . $producto['id'];
													echo ">";
                                                    echo "<td class='id-producto'>" . $producto['id'] .'</td>';
                                                    echo "<td class='nombre-producto'>";
													echo $producto['descripcion'] .'</td>';
													echo "<td>" . $producto['tipo'] . "</td>";
													echo "<td>" . $producto['numerador'] . "</td>";
													echo "<td>" . $producto['relative'] . "</td>";
													echo "<td>" . $producto['denominador'] . "</td>";
													echo "<td>" . $producto['relacionobjetivo'] . "</td>";
													echo "<td>" . $producto['drilldown'] . "</td>";
													echo "<td>" . $producto['activo'] . "</td>";
													echo "<td>" . $producto['user'] . "</td>";
                                                    echo "</tr>";
                                                }
                                              }
                                        ?>
                                </tbody>

                        </table>


        </div>		<!-- .block_content ends -->
</div>		
<!-- .block ends -->