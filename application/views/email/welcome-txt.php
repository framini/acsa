Bienvenido a <?php echo $site_name; ?>,

Para ingresar al sitio ingresa en el siguiente link::

<?php echo site_url('/auth/login/'); ?>

<?php if (strlen($username) > 0) { ?>

Tu username: <?php echo $username; ?>
<?php } ?>

Tu direccion de correo: <?php echo $email; ?>

<?php /* Your password: <?php echo $password; ?>

*/ ?>

Equipo <?php echo $site_name; ?>