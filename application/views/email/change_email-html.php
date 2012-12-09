<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head><title>Tu nueva direccion de correo en <?php echo $site_name; ?></title></head>
<body>
<div style="max-width: 800px; margin: 0; padding: 30px 0;">
<table width="80%" border="0" cellpadding="0" cellspacing="0">
<tr>
<td width="5%"></td>
<td align="left" width="95%" style="font: 13px/18px Arial, Helvetica, sans-serif;">
<h2 style="font: normal 20px/23px Arial, Helvetica, sans-serif; margin: 0; padding: 0 0 18px; color: black;">Tu nueva direccion de correo en <?php echo $site_name; ?></h2>
Cambiaste tu direccion de correo en <?php echo $site_name; ?>.<br />
Sigue el siguiente enlace para confirmar el cambio de correo:<br />
<br />
<big style="font: 16px/18px Arial, Helvetica, sans-serif;"><b><a href="<?php echo site_url('/adm/ew/reset_email/'.$user_id.'/'.$new_email_key); ?>" style="color: #3366cc;">Confirma tu correo!</a></b></big><br />
<br />
Si el link no funciona copia y pega el siguiente enlace en tu browser:<br />
<nobr><a href="<?php echo site_url('/adm/ew/reset_email/'.$user_id.'/'.$new_email_key); ?>" style="color: #3366cc;"><?php echo site_url('/adm/ew/reset_email/'.$user_id.'/'.$new_email_key); ?></a></nobr><br />
<br />
<br />
Tu nueva direccion de correo es: <?php echo $new_email; ?><br />
<br />
<br />
Recibiste este correo porque solicitaste un cambio de correo en <a href="<?php echo site_url(''); ?>" style="color: #3366cc;"><?php echo $site_name; ?></a>. Si solicitaste por error un cambio de email, simplemente ignora este mensaje.<br />
<br />
<br />
Gracias,<br />
Equipo <?php echo $site_name; ?>
</td>
</tr>
</table>
</div>
</body>
</html>