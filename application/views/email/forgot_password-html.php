<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head><title>Crear un nuevo password en <?php echo $site_name; ?></title></head>
<body>
<div style="max-width: 800px; margin: 0; padding: 30px 0;">
<table width="80%" border="0" cellpadding="0" cellspacing="0">
<tr>
<td width="5%"></td>
<td align="left" width="95%" style="font: 13px/18px Arial, Helvetica, sans-serif;">
<h2 style="font: normal 20px/23px Arial, Helvetica, sans-serif; margin: 0; padding: 0 0 18px; color: black;">Solicitud de cambio de Contraseña</h2>
Para crear una nueva contraseña solo sigue el siguiente enlace:<br />
<br />
<big style="font: 16px/18px Arial, Helvetica, sans-serif;"><b><a href="<?php echo site_url('/adm/ew/reset_password/'.$user_id.'/'.$new_pass_key); ?>" style="color: #3366cc;">Crear un nuevo password</a></b></big><br />
<br />
Si el link no funciona, Copia y Pega la siguiente dirección en la barra de direcciones de tu browser:<br />
<nobr><a href="<?php echo site_url('/adm/ew/reset_password/'.$user_id.'/'.$new_pass_key); ?>" style="color: #3366cc;"><?php echo site_url('/auth/reset_password/'.$user_id.'/'.$new_pass_key); ?></a></nobr><br />
<br />
<br />
Recibiste este email porque fue solicitado desde <a href="<?php echo site_url(''); ?>" style="color: #3366cc;"><?php echo $site_name; ?></a>. Si usted NO solicito este correo, por favor ignorelo y su contraseña permanecera igual.
<br />
<br />
Gracias,<br />
Sistema <?php echo $site_name; ?></td>
</tr>
</table>
</div>
</body>
</html>