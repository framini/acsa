Hi<?php if (strlen($username) > 0) { ?> <?php echo $username; ?><?php } ?>,

Cambiaste tu direccion de correo en <?php echo $site_name; ?>.
Sigue el siguiente enlace para confirmar el cambio de correo:

<?php echo site_url('/adm/ew/reset_email/'.$user_id.'/'.$new_email_key); ?>


Tu nueva direccion de correo es: <?php echo $new_email; ?>

Recibiste este correo porque solicitaste un cambio de correo en <?php echo $site_name; ?>. Si solicitaste por error un cambio de email, simplemente ignora este mensaje.

Gracias,
Equipo <?php echo $site_name; ?>