<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head><title>Bienvenido <?php echo $site_name; ?>!</title></head>
<body>
<div style="max-width: 800px; margin: 0; padding: 30px 0;">
<table width="80%" border="0" cellpadding="0" cellspacing="0">
<tr>
<td width="5%"></td>
<td align="left" width="95%" style="font: 13px/18px Arial, Helvetica, sans-serif;">
<h2 style="font: normal 20px/23px Arial, Helvetica, sans-serif; margin: 0; padding: 0 0 18px; color: black;">Bienvenido a <?php echo $site_name; ?>!</h2>
Para ingresar al sitio ingresa en el siguiente link:<br />
<br />
<big style="font: 16px/18px Arial, Helvetica, sans-serif;"><b><a href="<?php echo site_url('/ew/login/'); ?>" style="color: #3366cc;">Ingresar!</a></b></big><br />
<br />
Si el link no funciona copia y pega el siguiente link en tu browser:<br />
<nobr><a href="<?php echo site_url('/auth/login/'); ?>" style="color: #3366cc;"><?php echo site_url('/ew/login/'); ?></a></nobr><br />
<br />
<br />
<?php if (strlen($username) > 0) { ?>Tu username es: <?php echo $username; ?><br /><?php } ?>
Tu dirección de correo: <?php echo $email; ?><br />
Tu password: <?php echo $password; ?><br />
<?php /* Your password: <?php echo $password; ?><br /> */ ?>
<br />
<br />
Equipo <?php echo $site_name; ?>
</td>
</tr>
</table>
</div>
</body>
</html>