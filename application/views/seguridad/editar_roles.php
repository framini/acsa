<script type="text/javascript"> 
    $(document).ready(function() {
        var site_root = <?php echo '"' . site_url('seguridad/gestionar_roles') . '"'; ?>;
        var dire;
        $('a.confirmar').click(function() { 
            $.blockUI({ message: $('#question'), css: { width: '275px' } });
            dire = $(this).attr('href');
            return false;
        }); 
 
        $('#yes').click(function() { 
            $.blockUI({ message: "<p>Eliminando role...</p>" }); 
            
            $.ajax({ 
                url: dire, 
                cache: false, 
                complete: function() {
                    window.location.replace(site_root);
                    $.unblockUI()
                } 
            }); 
        }); 
 
        $('#no').click(function() { 
            $.unblockUI();
            return false; 
        }); 
 
    }); 
</script> 
<div id="question" style="display:none; cursor: default; padding:10px;"> 
        <p>Confirmar la eliminacion?.</p> 
        <input type="button" id="yes" value="Yes" /> 
        <input type="button" id="no" value="No" /> 
</div> 
<div class="block">
			
        <div class="block_head">
                <div class="bheadl"></div>
                <div class="bheadr"></div>

                <h2>Roles</h2>
                <?php echo anchor('/seguridad/nuevo_role', "Agregar Role", "class='boton-top submit'");  ?>
                <!--<a href="#" class="boton-top submit">Agregar Role</a>-->
        </div>		
        <!-- .block_head ends -->

        <div class="block_content">
            
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

                <form action="" method="post">

                        <table cellpadding="0" cellspacing="0" width="100%" class="sortable">

                                <thead>
                                        <tr>
                                                <th width="10"><!--<input type="checkbox" class="check_all" />--></th>
                                                <th>ID</th>
                                                <th>Nombre del Role</th>
                                                <th>Descripcion</th>
                                                <th>Empresa</th>
                                                <th></th>
                                                 <th></th>
                                        </tr>
                                </thead>

                                <tbody>
                                        <?php 
                                                foreach($roles as $role)
                                                {
                                                    echo "<tr>";
                                                    echo '<td><!--<input type="checkbox" />--></td>';
                                                    echo '<td>' . $role['role_id'] .'</td>';
                                                    echo '<td>' . $role['nombre'] .'</td>';
                                                    echo '<td>' . $role['descripcion'] .'</td>';
                                                    echo '<td>' . $role['empresa'] .'</td>';
                                                    echo '<td class="delete">' . anchor('seguridad/modificar_role/' . $role['role_id'], 'Editar');
                                                    echo '<td class="delete">' . anchor('seguridad/eliminar_role/' . $role['role_id'], 'Eliminar', 'class="confirmar"');
                                                    echo "</tr>";
                                                }
                                        ?>
                                </tbody>

                        </table>


                        <!--
                        <div class="pagination right">
                                <a href="#">&laquo;</a>
                                <a href="#" class="active">1</a>
                                <a href="#">2</a>
                                <a href="#">3</a>
                                <a href="#">4</a>
                                <a href="#">5</a>
                                <a href="#">6</a>
                                <a href="#">&raquo;</a>
                        </div>	-->	<!-- .pagination ends -->

                </form>

        </div>		<!-- .block_content ends -->

        <div class="bendl"></div>
        <div class="bendr"></div>
</div>		
<!-- .block ends -->