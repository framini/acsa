<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Detalles del Website
|
| Estos detalles son utilizados en emails por la libreria auth_frr.
|--------------------------------------------------------------------------
*/
$config['website_name'] = 'eWarrants';
$config['webmaster_email'] = 'franramini@arnet.com.ar';

/*
|--------------------------------------------------------------------------
| Settings de Seguridad
|
| auth_frr usa la libreria PasswordHash para operar con passwords hasheados.
| 'phpass_hash_portable' = Para determinar si los passwords pueden ser volcados y exportados en otro servidor.
|                                       si esta puesto en FALSE, no se va a poder usar la misma base de datos en un servidor distinto.
| 'phpass_hash_strength' = Password hash strength.
|--------------------------------------------------------------------------
*/
$config['phpass_hash_portable'] = TRUE;
$config['phpass_hash_strength'] = 8;

/*
|--------------------------------------------------------------------------
| Settings de Registracion
|
| 'allow_registration' = Determina si el registro de nuevos usuarios esta habilitado o no. FALSE no permite nuevos registro de usuario
| 'captcha_registration' = Para usar CAPTCHA en el proceso de registro
| 'email_activation' = Requiere que el usuario active su cuenta a traves de la cuenta de correo que registro.
| 'email_activation_expire' = El tiempo que tiene que transcurrir para que las cuentas que no han sido activadas sean borradas de la BD. El default es 48 hr (60*60*24*2).
| 'email_account_details' = Envia un mail con los detalles de la cuenta creada (Solo cuando 'email_activation' es FALSE).
| 'use_username' = Si username es requerido o no.
|
| 'username_min_length' = Min length para el username
| 'username_max_length' = Max length para el username.
| 'password_min_length' = Min length para el password.
| 'password_max_length' = Max length para el password.
|--------------------------------------------------------------------------
*/
$config['allow_registration'] = TRUE;
$config['captcha_registration'] = FALSE;
$config['email_activation'] = FALSE;
$config['email_activation_expire'] = 60*60*24*2;
$config['email_account_details'] = TRUE;
$config['use_username'] = TRUE;

$config['username_min_length'] = 4;
$config['username_max_length'] = 20;
$config['password_min_length'] = 4;
$config['password_max_length'] = 20;

/*
|--------------------------------------------------------------------------
| Settings para el Login
|
| 'login_by_username' = El username puede ser usado para el login.
| 'login_by_email' = El email puede ser usado para el login.
| Al menos una de las 2 opciones de arriba tiene que estar en TRUE.
| 'login_by_username' solamente tiene sentido cuando 'use_username' es TRUE.
|
| 'login_record_ip' = Guarda en la base de datos la direccion IP del usuario durante el proceso de Login.
| 'login_record_time' = Guarda en la base de datos la hora en la que el usuario se logueo en el sistema
|
| 'login_count_attempts' = Cuenta los intentos fallidos de logueo.
| 'login_max_attempts' = Numero maximo de intentos fallidos antes de efectuar una determinada accion. Ahora muestra el CAPTCHA
| 'login_attempt_expire' = El tiempo que dura cada registro attempt a logueo en la DB. El default es 24 hr (60*60*24).
| 'login_ban_time' = El tiempo que dura el ban tras haber alcanzado el login_max_attempts.
|--------------------------------------------------------------------------
*/
$config['login_by_username'] = TRUE;
$config['login_by_email'] = TRUE;
$config['login_record_ip'] = TRUE;
$config['login_record_time'] = TRUE;
$config['login_count_attempts'] = TRUE;
$config['login_max_attempts'] = 5;
$config['login_attempt_expire'] = 60*60*24;
$config['login_ban_time'] = 60;

/*
|--------------------------------------------------------------------------
| Settings para el Auto login
|
| 'autologin_cookie_name' = nombre de la cookie del Auto login.
| 'autologin_cookie_life' = Auto login cookie life before expired. Default is 2 months (60*60*24*31*2).
| 'autologin_cookie_life' = vida de la cookie de autologin antes de que expire. El default es 1 semana (60*60*24*7).
|--------------------------------------------------------------------------
*/
$config['autologin_cookie_name'] = 'autologin';
$config['autologin_cookie_life'] = 60*60*24*7;

/*
|--------------------------------------------------------------------------
| Settings para Forgot password
|
| 'forgot_password_expire' = El tiempo antes de que la password key se vuelva invalida. El default es 15 minutos.
|--------------------------------------------------------------------------
*/
$config['forgot_password_expire'] = 60*15;

/*
|--------------------------------------------------------------------------
| Database settings
|
| 'db_table_prefix' = Prefijo de tabla que va a ser agregado a cada nombre de tabla usada por la libreria
| (except 'ci_sessions' table).
|--------------------------------------------------------------------------
*/
$config['db_table_prefix'] = '';