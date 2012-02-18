<?php
$role = array(
        'name'             => 'nombre',
        'value'             => set_value('nombre'),
        'maxlength'     => 80,
        'size'               => 30,
        'class'             => 'text',
);

$descripcion = array(
        'name'             => 'descripcion',
        'value'             => set_value('descripcion'),
        'size'               => 30,
        'class'             => 'textarea-mid',
);

$empresa_id = array(
        'name'             => 'empresa_id',
        'value'             => set_value('empresa_id'),
        'size'               => 30,
        'class'             => 'text',
);

?>

 <div class="block">
			
                            <div class="block_head">
                            <div class="bheadl"></div>
                            <div class="bheadr"></div>

                            <h2>Agregar  Role</h2>
                            </div>		
                            <!-- .block_head ends -->
				
				
				
                            <div class="block_content">
                                <?php
                                 
                                  $errorLogueo = '';//isset($errors[$login['name']]) ? $errors[$login['name']]:'';
                                  $errorPassword = ''; //isset($errors[$password['name']])?$errors[$password['name']]:'';
                                  //$errorNombreRole = isset($nombre_role) ? $nombre_role : '';
                                  
                                   if(isset($errors))
                                   {
                                       $errorNombreRole = isset($errors['nombre_role']) ? $errors['nombre_role'] : '';
                                   }
                                   else
                                   {
                                       $errorNombreRole = '';
                                   }
                                  
                                  //if(isset($errors)) print_r ($errors);
                                  
                                  if(form_error($role['name']) != '' || form_error($descripcion['name']) != '' || form_error($empresa_id['name']) != '' || $errorNombreRole != '')
                                  {
                                       echo "<div class='message errormsg'>";
                                                 echo form_error($role['name'],  '<p>', '</p>'); 
                                                 echo form_error($descripcion['name'],  '<p>', '</p>'); 
                                                 echo form_error($empresa_id['name'],  '<p>', '</p>');
                                                 
                                                 echo isset($errors['nombre_role']) ? "<p>" . $errors['nombre_role'] . "</p>" : '';
                                                // echo isset($errors[$login['name']]) ? "<p>" . $errors[$login['name']] . "</p>" : '';
                                                 
                                                // echo isset($errors[$password['name']])?"<p>" . $errors[$password['name']] . "</p>"  : '';
                                      echo "</div>";
                                  }
                                  ?>
                                
                                <?php echo form_open('seguridad/agregar_role'); ?>

                                                <p>
                                                    <?php echo form_label('Role', $role['name']); ?>
                                                </p>
                                                <p>
                                                    <?php echo form_input($role); ?>
                                                </p>
                                                
                                                <p>
                                                    <?php echo form_label('Descripcion', $descripcion['name']); ?>
                                                </p>
                                                <p>
                                                    <?php echo form_textarea($descripcion); ?>
                                                </p>
                                                
                                                <p></p>
                                                <?php if(isset($empresas)) { ?>
                                                <p>
                                                    <?php echo form_label('Empresa', $empresa_id['name']); ?>
                                                </p>
                                                <p>
                                                    <?php //echo form_input($empresa_id); ?>
                                                    <?php
                                                        echo '<select name="empresa_id" class="styled" id="empresas_dd">';
                                                        foreach($empresas as $empresa)
                                                        {
                                                           echo '<option value="' . $empresa['empresa_id'] . '">' . $empresa['nombre'] . "</option>";
                                                        }
                                                        echo '</select>';
                                                    ?>
                                                    
                                                </p>
                                                <?php } ?>
                                                <?php 
                                                echo '<p>';
                                                echo form_label('Permisos');
                                                echo '</p>';
                                                ?>
                                                <p>
                                                    <?php 
                                                    foreach($permisos as $permiso)
                                                    {
                                                       $id = $permiso['id'];
                                                       $permiso = $permiso['permiso'];
                                                       echo '<p>';
                                                       echo form_checkbox($permiso, $id, false);
                                                       echo " ";
                                                       echo form_label($permiso, $permiso);
                                                       echo '</p>';
                                                    }
                                                    ?>
                                                </p>
                                                <p>
                                                    <input type="submit" class="submit" value="Agregar" name="submit" />
                                                </p>
                                <?php echo form_close(); ?>
                                                                              
                            </div>		
                            <!-- .block_content ends -->
				
                        <div class="bendl"></div>
                        <div class="bendr"></div>
					
	</div>		
<!-- .block ends -->