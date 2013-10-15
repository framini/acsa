<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Definicion para el contenido de menues basados en permisos
 * Notas:
 * texto_anchor: Es el texto a mostrar en pantalla para el boton
 * icono: Es la imagen que va a la izquierda del texto_anchor
|--------------------------------------------------------------------------
*/
# Mensajes generales
####################################################################################
$config['error_sin_permiso'] = array('texto' => 'No tienes permisos suficientes para realizar ninguna accion aqui', 'icono' => 'icon-minus-sign');
$config['ewarrant_confirmacion_firma'] = array('texto' => 'El eWarrant se ha firmado correctamente!', 'icono' => 'icon-ok');
$config['ewarrant_confirmacion_anulacion'] = array('texto' => 'El eWarrant se ha anulado correctamente!', 'icono' => 'icon-ok');
$config['ewarrant_error_firmado'] = array('texto' => 'El eWarrant ya esta firmado!', 'icono' => 'icon-remove');
$config['ewarrant_error_not_owner'] = array('texto' => 'No puedes firmar el eWarrant porque fuiste tu quien lo dio de alta!', 'icono' => 'icon-remove');
$config['ewarrant_error_no_puede_firmar'] = array('texto' => 'No puedes anular el eWarrant porque no fuiste tu quien lo dio de alta!', 'icono' => 'icon-remove');
$config['ewarrant_error_ya_anulado'] = array('texto' => 'El eWarrant ya esta anulado!', 'icono' => 'icon-remove');


# Mensajes de Error
####################################################################################
//Explicacion manejo de errores
//Las URI van a venir de la forma controladora/gestion/error
//Tomamos los items de error con la forma de la string "gestion-error". Ejemplo 3-1
//----------------------
// Gestionar Empresas = 3 en segmento 3 URI
//----------------------
$config['3-1'] = array('titulo' => 'La empresa se encuentra activada!', 'contenido' => 'La empresa que estas tratando de activar ya se encuentra activada!');


# Menu gestion eWarrants
####################################################################################
$config['emitir'] = array('texto_anchor' => 'Emitir', 'icono' => 'icon-plus-sign', 'boton_superior' => false);
$config['listar'] = array('texto_anchor' => 'Listar', 'icono' => 'icon-info-sign', 'boton_superior' => false);
$config['firma']  = array('texto_anchor' => 'Firmar', 'icono' => 'icon-ok-sign', 'boton_superior' => true, 'clase_boton' => 'btn btn-large btn-success enviar absoluto-r0-b0 margin-bot-none pull-right');
$config['anular'] = array('texto_anchor' => 'Anular', 'icono' => 'icon-remove-sign', 'boton_superior' => true, 'clase_boton' => 'btn btn-large btn-danger enviar absoluto-r0-b0 margin-bot-none pull-right');
$config['ver_pendientes'] = array('texto_anchor' => 'Ver Pendientes', 'icono' => 'icon-remove-sign', 'boton_superior' => true, 'clase_boton' => 'btn btn-large btn-danger enviar absoluto-r0-b0 margin-bot-none pull-right');
$config['gestionar_polizas'] = array('texto_anchor' => 'Gestionar Polizas', 'icono' => 'icon-remove-sign', 'boton_superior' => true, 'clase_boton' => 'btn btn-large btn-danger enviar absoluto-r0-b0 margin-bot-none pull-right');


# Menu Tablero
####################################################################################
$config['indicadores'] = array('texto_anchor' => 'Indicadores', 'icono' => 'icon-plus-sign', 'boton_superior' => false);
$config['tablero_control'] = array('texto_anchor' => 'Tablero', 'icono' => 'icon-briefcase', 'titulo_gestion' => 'Tablero de Control');
$config['gestionar_indicadores'] = array('texto_anchor' => 'Gestionar Indicadores', 'icono' => 'icon-briefcase', 'titulo_gestion' => 'Gestion Indicadores');
$config['alta_indicador'] = array('texto_anchor' => 'Alta Indicador', 'icono' => 'icon-plus icon-white', 'clase_boton' => 'btn btn-large btn-success pull-right', 'boton_superior' => true, 'titulo' => false);



# Menu gestion Seguridad
# Notas:
# texto_anchor: Es el texto a mostrar en pantalla para el boton
# icono: Es la imagen que va a la izquierda del texto_anchor
# titulo_gestion: El titulo que va arriba del box que especifica la gestion
####################################################################################
$config['gestionar_roles'] = array('texto_anchor' => 'Gestionar Roles', 'icono' => 'icon-tag', 'titulo_gestion' => 'Roles');
$config['gestionar_usuarios'] = array('texto_anchor' => 'Gestionar Usuarios', 'icono' => 'icon-user', 'titulo_gestion' => 'Usuarios');
$config['gestionar_productos'] = array('texto_anchor' => 'Gestionar Productos', 'icono' => 'icon-barcode', 'titulo_gestion' => 'Productos');
$config['gestionar_cuentas_registro'] = array('texto_anchor' => 'Gestionar Cuentas Registro', 'icono' => 'icon-briefcase', 'titulo_gestion' => 'Cuentas Registro');
$config['gestionar_cuentas_corrientes'] = array('texto_anchor' => 'Gestionar Cuentas Corrientes', 'icono' => 'icon-barcode', 'titulo_gestion' => 'Cuentas Corrientes');

# Menu gestion Personas
# Notas:
# texto_anchor: Es el texto a mostrar en pantalla para el boton
# icono: Es la imagen que va a la izquierda del texto_anchor
# titulo_gestion: El titulo que va arriba del box que especifica la gestion
####################################################################################
$config['gestionar_empresas'] = array('texto_anchor' => 'Gestionar Empresas', 'icono' => 'icon-home', 'titulo_gestion' => 'Empresas');

# Menu gestion Seguridad => Gestionar Roles
# Notas:
# texto_anchor: Es el texto a mostrar en pantalla para el boton
# icono: Es la imagen que va a la izquierda del texto_anchor
# clase_boton: Especifica la clase a implementar por el boton
# boton_superior: Especifica si el boton va en la parte superior de la pantalla
# titulo: Mensaje para ventana Pop-up
####################################################################################
$config['nuevo_role'] = array('texto_anchor' => 'Nuevo Role', 'icono' => 'icon-plus icon-white', 'clase_boton' => 'btn btn-large btn-success pull-right', 'boton_superior' => true, 'titulo' => false);
$config['modificar_role'] = array('texto_anchor' => 'Modificar', 'icono' => 'icon-pencil icon-white', 'clase_boton' => 'btn btn-info editar-role margin-bottom-5 btn-mini', 'boton_superior' => false, 'titulo' => false);
$config['eliminar_role'] = array('texto_anchor' => 'Eliminar', 'icono' => 'icon-trash', 'clase_boton' => 'btn btn-danger eliminar-role margin-bottom-5 btn-mini', 'boton_superior' => false, 'titulo' => "Confirma que desea eliminar el role?");

# Menu gestion Seguridad => Gestionar Usuarios
# Notas:
# texto_anchor: Es el texto a mostrar en pantalla para el boton
# icono: Es la imagen que va a la izquierda del texto_anchor
# clase_boton: Especifica la clase a implementar por el boton
# boton_superior: Especifica si el boton va en la parte superior de la pantalla
# titulo: Mensaje para ventana Pop-up
####################################################################################
$config['registro'] = array('texto_anchor' => 'Agregar Usuario', 'icono' => 'icon-user icon-white', 'clase_boton' => 'btn btn-large btn-success pull-right', 'boton_superior' => true, 'titulo' => false);
$config['editar_usuario'] = array('texto_anchor' => 'Editar', 'icono' => 'icon-pencil icon-white', 'clase_boton' => 'btn btn-info editar-usuario margin-bottom-5 btn-mini', 'boton_superior' => false, 'titulo' => false);
$config['cambiar_email'] = array('texto_anchor' => 'Cambiar email', 'icono' => 'icon-pencil icon-white', 'clase_boton' => 'btn cambiar-email-usuario btn-primary margin-bottom-5 btn-mini', 'boton_superior' => false);
$config['cambiar_password'] = array('texto_anchor' => 'Cambiar Password', 'icono' => 'icon-pencil icon-white', 'clase_boton' => 'btn cambiar-email-usuario btn-primary margin-bottom-5 btn-mini', 'boton_superior' => false);
$config['eliminar_user'] = array('texto_anchor' => 'Eliminar', 'icono' => 'icon-trash', 'clase_boton' => 'btn btn-danger eliminar-usuario margin-bottom-5 btn-mini', 'boton_superior' => false, 'titulo' => "Confirma que desea eliminar el usuario?");


# Menu gestion Seguridad => Gestionar Cuentas registro
# Notas:
# texto_anchor: Es el texto a mostrar en pantalla para el boton
# icono: Es la imagen que va a la izquierda del texto_anchor
# clase_boton: Especifica la clase a implementar por el boton
# boton_superior: Especifica si el boton va en la parte superior de la pantalla
# titulo: Mensaje para ventana Pop-up
####################################################################################
$config['registro_cuenta_registro'] = array('texto_anchor' => 'Agregar Cuenta Registro', 'icono' => 'icon-user icon-white', 'clase_boton' => 'btn btn-large btn-success pull-right', 'boton_superior' => true, 'titulo' => false);
$config['modificar_cuenta_registro'] = array('texto_anchor' => 'Modificar', 'icono' => 'icon-pencil icon-white', 'clase_boton' => 'btn btn-info modificar-empresa margin-bottom-5 btn-mini', 'boton_superior' => false, 'titulo' => false);
$config['activar_cuenta_registro'] = array('texto_anchor' => 'Activar', 'icono' => 'icon-plus icon-white', 'clase_boton' => 'btn activar-empresa btn-warning margin-bottom-5 btn-mini', 'boton_superior' => false);
$config['eliminar_cuenta_registro'] = array('texto_anchor' => 'Eliminar', 'icono' => 'icon-trash', 'clase_boton' => 'btn btn-danger eliminar-empresa margin-bottom-5 btn-mini', 'boton_superior' => false, 'titulo' => "Confirma que desea eliminar la empresa?");


# Menu gestion Seguridad => Gestionar Empresas
# Notas:
# texto_anchor: Es el texto a mostrar en pantalla para el boton
# icono: Es la imagen que va a la izquierda del texto_anchor
# clase_boton: Especifica la clase a implementar por el boton
# boton_superior: Especifica si el boton va en la parte superior de la pantalla
# titulo: Mensaje para ventana Pop-up
####################################################################################
$config['registro_empresa'] = array('texto_anchor' => 'Agregar Empresa', 'icono' => 'icon-user icon-white', 'clase_boton' => 'btn btn-large btn-success pull-right', 'boton_superior' => true, 'titulo' => false);
$config['modificar_empresa'] = array('texto_anchor' => 'Modificar', 'icono' => 'icon-pencil icon-white', 'clase_boton' => 'btn btn-info modificar-empresa margin-bottom-5 btn-mini', 'boton_superior' => false, 'titulo' => false);
$config['activar_empresa'] = array('texto_anchor' => 'Activar', 'icono' => 'icon-plus icon-white', 'clase_boton' => 'btn activar-empresa btn-warning margin-bottom-5 btn-mini', 'boton_superior' => false);
$config['eliminar_empresa'] = array('texto_anchor' => 'Eliminar', 'icono' => 'icon-trash', 'clase_boton' => 'btn btn-danger eliminar-empresa margin-bottom-5 btn-mini', 'boton_superior' => false, 'titulo' => "Confirma que desea eliminar la empresa?");


# Menu gestion Seguridad => Gestionar Productos
# Notas:
# texto_anchor: Es el texto a mostrar en pantalla para el boton
# icono: Es la imagen que va a la izquierda del texto_anchor
# clase_boton: Especifica la clase a implementar por el boton
# boton_superior: Especifica si el boton va en la parte superior de la pantalla
# titulo: Mensaje para ventana Pop-up
####################################################################################
$config['registro_producto'] = array('texto_anchor' => 'Agregar Producto', 'icono' => 'icon-user icon-white', 'clase_boton' => 'btn btn-large btn-success pull-right', 'boton_superior' => true, 'titulo' => false);
$config['modificar_producto'] = array('texto_anchor' => 'Modificar', 'icono' => 'icon-pencil icon-white', 'clase_boton' => 'btn btn-info modificar-empresa margin-bottom-5 btn-mini', 'boton_superior' => false, 'titulo' => false);
$config['eliminar_producto'] = array('texto_anchor' => 'Eliminar', 'icono' => 'icon-trash', 'clase_boton' => 'btn btn-danger eliminar-empresa margin-bottom-5 btn-mini', 'boton_superior' => false, 'titulo' => "Confirma que desea eliminar la empresa?");
$config['comisiones'] = array('texto_anchor' => 'Modificar Comision', 'icono' => 'icon-pencil icon-white', 'clase_boton' => 'btn btn-info modificar-empresa margin-bottom-5 btn-mini', 'boton_superior' => false, 'titulo' => false);

# Menu gestion Seguridad => Gestionar Cuentas Corrientes
# Notas:
# texto_anchor: Es el texto a mostrar en pantalla para el boton
# icono: Es la imagen que va a la izquierda del texto_anchor
# clase_boton: Especifica la clase a implementar por el boton
# boton_superior: Especifica si el boton va en la parte superior de la pantalla
# titulo: Mensaje para ventana Pop-up
####################################################################################
$config['registro_cuenta_corriente'] = array('texto_anchor' => 'Agregar Cuenta Corriente', 'icono' => 'icon-user icon-white', 'clase_boton' => 'btn btn-large btn-success pull-right', 'boton_superior' => true, 'titulo' => false);
$config['modificar_cuenta_corriente'] = array('texto_anchor' => 'Modificar', 'icono' => 'icon-pencil icon-white', 'clase_boton' => 'btn btn-info modificar-empresa margin-bottom-5 btn-mini', 'boton_superior' => false, 'titulo' => false);
//$config['eliminar_producto'] = array('texto_anchor' => 'Eliminar', 'icono' => 'icon-trash', 'clase_boton' => 'btn btn-danger eliminar-empresa margin-bottom-5 btn-mini', 'boton_superior' => false, 'titulo' => "Confirma que desea eliminar la empresa?");

# Menu gestion Seguridad => Gestionar Polizas
# Notas:
# texto_anchor: Es el texto a mostrar en pantalla para el boton
# icono: Es la imagen que va a la izquierda del texto_anchor
# clase_boton: Especifica la clase a implementar por el boton
# boton_superior: Especifica si el boton va en la parte superior de la pantalla
# titulo: Mensaje para ventana Pop-up
####################################################################################
$config['registro_poliza'] = array('texto_anchor' => 'Agregar Poliza', 'icono' => 'icon-user icon-white', 'clase_boton' => 'btn btn-large btn-success pull-right', 'boton_superior' => true, 'titulo' => false);
$config['modificar_poliza'] = array('texto_anchor' => 'Modificar', 'icono' => 'icon-pencil icon-white', 'clase_boton' => 'btn btn-info modificar-empresa margin-bottom-5 btn-mini', 'boton_superior' => false, 'titulo' => false);
//$config['eliminar_poliza'] = array('texto_anchor' => 'Eliminar', 'icono' => 'icon-trash', 'clase_boton' => 'btn btn-danger eliminar-empresa margin-bottom-5 btn-mini', 'boton_superior' => false, 'titulo' => "Confirma que desea eliminar la poliza?");


# Seccion Admin => Forms
# Notas:
# texto_anchor: Es el texto a mostrar en pantalla para el boton
# icono: Es la imagen que va a la izquierda del texto_anchor
# clase_boton: Especifica la clase a implementar por el boton
# boton_superior: Especifica si el boton va en la parte superior de la pantalla
# titulo: Mensaje para ventana Pop-up
####################################################################################
$config['alta_formulario'] = array('texto_anchor' => 'Crear Formulario', 'icono' => 'icon-th-list icon-white', 'clase_boton' => 'btn btn-large btn-success pull-right', 'boton_superior' => true, 'titulo' => false);
$config['alta_grupos_fields'] = array('texto_anchor' => 'Crear Grupo de Fields', 'icono' => 'icon-folder-open icon-white', 'clase_boton' => 'btn btn-large btn-success pull-right', 'boton_superior' => true, 'titulo' => false);
$config['alta_fields'] = array('texto_anchor' => 'Crear Field', 'icono' => 'icon-align-justify icon-white', 'clase_boton' => 'btn btn-large btn-success pull-right', 'boton_superior' => true, 'titulo' => false);

$config['baja_field'] = array('texto_anchor' => 'Eliminar', 'icono' => 'icon-remove icon-white', 'clase_boton' => 'btn btn-danger eliminar-empresa margin-bottom-5 btn-mini', 'boton_superior' => false, 'titulo' => false);
$config['baja_grupo_field'] = array('texto_anchor' => 'Eliminar', 'icono' => 'icon-remove icon-white', 'clase_boton' => 'btn btn-danger eliminar-empresa margin-bottom-5 btn-mini', 'boton_superior' => false, 'titulo' => false);
$config['baja_formulario'] = array('texto_anchor' => 'Eliminar', 'icono' => 'icon-remove icon-white', 'clase_boton' => 'btn btn-danger eliminar-empresa margin-bottom-5 btn-mini', 'boton_superior' => false, 'titulo' => false);

$config['modificar_field'] = array('texto_anchor' => 'Modificar', 'icono' => 'icon-pencil icon-white', 'clase_boton' => 'btn btn-info modificar-field margin-bottom-5 btn-mini', 'boton_superior' => false, 'titulo' => false);
$config['modificar_grupo_field'] = array('texto_anchor' => 'Modificar', 'icono' => 'icon-pencil icon-white', 'clase_boton' => 'btn btn-info modificar-field margin-bottom-5 btn-mini', 'boton_superior' => false, 'titulo' => false);
$config['modificar_form'] = array('texto_anchor' => 'Modificar', 'icono' => 'icon-pencil icon-white', 'clase_boton' => 'btn btn-info modificar-field margin-bottom-5 btn-mini', 'boton_superior' => false, 'titulo' => false);

$config['fields'] = array('texto_anchor' => 'Ver Fields', 'icono' => 'icon-align-justify icon-white', 'clase_boton' => 'btn btn-primary modificar-field margin-bottom-5 btn-mini', 'boton_superior' => false, 'titulo' => false);
$config['grupos_fields'] = array('texto_anchor' => 'Ver Grupos Fields', 'icono' => 'icon-folder-open icon-white', 'clase_boton' => 'btn btn-primary modificar-field margin-bottom-5 btn-mini', 'boton_superior' => false, 'titulo' => false);

# Menu gestion Admin => Gestionar Roles
# Notas:
# texto_anchor: Es el texto a mostrar en pantalla para el boton
# icono: Es la imagen que va a la izquierda del texto_anchor
# clase_boton: Especifica la clase a implementar por el boton
# boton_superior: Especifica si el boton va en la parte superior de la pantalla
# titulo: Mensaje para ventana Pop-up
####################################################################################
$config['alta_formulario_gestion_forms'] = array('texto_anchor' => 'Crear formulario', 'icono' => 'icon-user', 'clase_boton' => 'btn btn-large btn-success pull-right', 'boton_superior' => true, 'titulo' => false);
$config['modificar_form_gestion_forms'] = array('texto_anchor' => 'Modificar Form', 'icono' => 'icon-pencil', 'clase_boton' => 'btn btn-info editar-usuario margin-bottom-5', 'boton_superior' => false, 'titulo' => false);
$config['alta_grupos_fields_gestion_grupos_fields'] = array('texto_anchor' => 'Crear Grupo Fields', 'icono' => 'icon-pencil', 'clase_boton' => 'btn cambiar-email-usuario btn-primary margin-bottom-5', 'boton_superior' => false);
$config['modificar_grupo_fields_gestion_grupos_fields'] = array('texto_anchor' => 'Modificar Grupo Fields', 'icono' => 'icon-pencil', 'clase_boton' => 'btn cambiar-email-usuario btn-primary margin-bottom-5', 'boton_superior' => false);
$config['alta_fields_gestion_fields'] = array('texto_anchor' => 'Crear Field', 'icono' => 'icon-trash', 'clase_boton' => 'btn btn-danger eliminar-usuario margin-bottom-5', 'boton_superior' => false);
$config['modificar_field_gestion_fields'] = array('texto_anchor' => 'Modificar Field', 'icono' => 'icon-trash', 'clase_boton' => 'btn btn-danger eliminar-usuario margin-bottom-5', 'boton_superior' => false);


# Template Manager
# Notas:
# grupo sirve para diferenciar a cual de los dos divs pertence cada boton
####################################################################################
$config['alta_grupos'] = array('texto_anchor' => 'Crear Grupo', 'icono' => 'icon-plus icon-white', 'boton_superior' => true, 'grupo' => 'grupos', 'clase_boton' => 'btn btn-small btn-success posicion-6-top-right pull-right');
$config['editar_grupo_templates'] = array('texto_anchor' => 'Modificar grupo', 'icono' => 'icon-pencil', 'boton_superior' => true, 'clase_boton' => 'btn btn-small posicion-6-top-right pull-right bot-mod-grupo-template' , 'grupo' => 'templates');
$config['baja_grupo_template']  = array('texto_anchor' => 'Eliminar grupo', 'icono' => 'icon-remove', 'boton_superior' => true, 'clase_boton' => 'btn btn-small posicion-6-top-right pull-right bot-elim-grupo-template', 'grupo' => 'templates');
$config['alta_templates'] = array('texto_anchor' => 'Crear Template', 'icono' => 'icon-plus icon-white', 'boton_superior' => true, 'clase_boton' => 'btn btn-small btn-success posicion-6-top-right pull-right bot-crear-template margen-6-der', 'grupo' => 'templates');
$config['editar_templates'] = array('texto_anchor' => 'Modificar', 'icono' => 'icon-remove-sign', 'boton_superior' => false, 'clase_boton' => 'btn btn-small posicion-6-top-right pull-right bot-mod-grupo-template', 'grupo' => 'templates');
$config['baja_template'] = array('texto_anchor' => 'Eliminar', 'icono' => 'icon-remove', 'boton_superior' => false, 'clase_boton' => 'btn btn-small posicion-6-top-right pull-right bot-elim-grupo-template', 'grupo' => 'templates');