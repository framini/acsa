<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');

require_once(APPPATH . 'clases/Producto.php');

abstract class Creator {
	function factory() {
	}
}
