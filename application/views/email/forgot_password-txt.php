Hola <?php if (strlen($username) > 0) { ?> <?php echo $username; ?><?php } ?>,

Para crear una nueva contraseña solo sigue el siguiente enlace:

<?php echo site_url('/auth/reset_password/'.$user_id.'/'.$new_pass_key); ?>


Recibiste este email porque fue solicitado desde <a href="<?php echo site_url(''); ?>" style="color: #3366cc;"><?php echo $site_name; ?></a>. Si usted NO solicito este correo, por favor ignorelo y su contraseña permanecera igual.


Gracias,
Sistema <?php echo $site_name; ?>