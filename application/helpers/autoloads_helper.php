<?php

function autoload_parsers($class_name) {
    $file = APPPATH . 'extensiones/' . $class_name . "/" .  $class_name. '.php';

    if (file_exists($file))
    {
        require($file);
    }
}

function autoload_clases($class_name) {
	$file = APPPATH . 'extensiones/' .  $class_name. '.php';

    if (file_exists($file))
    {
        require($file);
    }
}

spl_autoload_register('autoload_parsers');
spl_autoload_register('autoload_clases');