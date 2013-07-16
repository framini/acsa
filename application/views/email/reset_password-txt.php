Hi<?php if (strlen($username) > 0) { ?> <?php echo $username; ?><?php } ?>,

Ha cambiado su contraseña
<?php if (strlen($username) > 0) { ?>

Username: <?php echo $username; ?>
<?php } ?>

Email: <?php echo $email; ?>

Password : <?php echo $new_password; ?>

<?php /* Your new password: <?php echo $new_password; ?>

*/ ?>

Thank you,
The <?php echo $site_name; ?> Team