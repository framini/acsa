<?php if(isset($cuentasregistro)) { ?>
         <?php
            foreach($cuentasregistro as $crd)
            {
               echo '<option value="' . $crd['cuentaregistro_id'] . '">' . $crd['nombre'] . "</option>";
            }
         ?>
<?php } ?>