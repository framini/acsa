<script type="text/javascript">
    $(function() {
        $('input#id_search').quicksearch('table tbody tr');
    });
</script>

<div class="block">
                            <div class="block_head">
                                    <div class="bheadl"></div>
                                    <div class="bheadr"></div>

                                    <h2>Todos los eWarrants emitidos</h2>
                            </div>		
                            <!-- .block_head ends -->
				
				
				
                            <div class="block_content">
                                <form action="#">
                                    <h3>Ingrese patron de busqueda</h3>
		<input type="text" name="search" value="" id="id_search" class="text" placeholder="Buscar" autofocus />
                                </form>
                                <?php
                                 if(isset($message))
                                 {
                                      echo "<div class='message success'>";
                                                 echo "<p>" . $message. "</p>";
                                      echo "</div>";
                                 }
                                 ?>     
                                

                                                        <?php
                                                        if(isset($errormsg))
                                                        {
                                                            echo "<div class='message errormsg'>";
                                                                         echo "<p>" . $errormsg. "</p>";
                                                              echo "</div>";
                                                        }
                                                        ?>

                                                        <?php
                                                         if(isset($message))
                                                         {
                                                              echo "<div class='message success'>";
                                                                         echo "<p>" . $message. "</p>";
                                                              echo "</div>";
                                                         }
                                                         ?>

                

                                                        <table cellpadding="0" cellspacing="0" width="100%" class="sortable">

                                                                <thead>
                                                                        <tr>
                                                                                <th width="10"><!--<input type="radio" class="check_all" />--></th>
                                                                                <th>ID</th>
                                                                                <th>Codigo</th>
                                                                                <th>Fecha</th>
                                                                                <th>Registro Depositante</th>
                                                                                <th>Cuenta Registro</th>
                                                                                <th>Producto</th>
                                                                                <th>Kilos</th>
                                                                                <th>Estado</th>
                                                                                <th>Firmado</th>
                                                                                <th>Creado por</th>
                                                                                <th>Empresa</th>
                                                                                <th>Cuit Empresa</th>
                                                                                <th>Val Ponderado</th>
                                                                        </tr>
                                                                </thead>

                                                                <tbody>
                                                                        <?php 
                                                                                foreach($ewarrants as $ew)
                                                                                {
                                                                                    echo "<tr>";
                                                                                    echo '<td><input type="radio" name="ewid" value= "'.$ew['id'].'" /></td>';
                                                                                    echo '<td>' . $ew['id'] .'</td>';
                                                                                    echo '<td>' . $ew['codigo'] .'</td>';
                                                                                    echo '<td>' . $ew['created'] .'</td>';
                                                                                    echo '<td>' . $ew['nombre_cuenta_registro_depositante'] .'</td>';
                                                                                    echo '<td>' . $ew['nombre_cuenta_registro'] .'</td>';
                                                                                    echo '<td>' . $ew['producto'] .'</td>';
                                                                                    echo '<td>' . $ew['kilos'] .'</td>';
                                                                                    if($ew['estado'] == 1) echo '<td>Activo</td>'; else echo '<td>Anulado</td>';
                                                                                    if($ew['firmado'] == 1) echo '<td>Firmado</td>'; else echo '<td>Sin firmar</td>';
                                                                                    echo '<td>' . $ew['emitido_por'] .'</td>';
                                                                                    echo '<td>' . $ew['empresa_nombre'] .'</td>';
                                                                                    echo '<td>' . $ew['empresa_cuit'] .'</td>';
                                                                                    echo '<td>' . $ew['valor_ponderado'] .'</td>';
                                                                                    echo "</tr>";
                                                                                }
                                                                        ?>
                                                                </tbody>

                                                        </table>
                                                                              
                            </div>		
                            <!-- .block_content ends -->
				
                        <div class="bendl"></div>
                        <div class="bendr"></div>
					
	</div>		
<!-- .block ends -->