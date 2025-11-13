<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route['default_controller'] = 'welcome';
$route['admin/dashboard'] = 'admin';  // Redirige admin/dashboard a admin
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

$route['admin/actividades'] = 'admin/actividades';
$route['admin/obtener_todas_actividades'] = 'admin/obtener_todas_actividades';

$route['recepcionista/atenciones'] = 'recepcionista/atenciones';
$route['recepcionista/atenciones/eutanasias'] = 'recepcionista/atenciones/eutanasias';
$route['recepcionista/atenciones/cirugias'] = 'recepcionista/cirugias';
$route['recepcionista/atenciones/sedaciones'] = 'recepcionista/sedaciones';
$route['recepcionista/ver_atencion/(:num)'] = 'recepcionista/ver_atencion/$1';

$route['recepcionista/autorizaciones'] = 'recepcionista/autorizaciones/index';
$route['recepcionista/autorizaciones/sedacion/crear'] = 'recepcionista/autorizaciones/sedacion_crear';
$route['recepcionista/autorizaciones/sedacion/guardar'] = 'recepcionista/autorizaciones/sedacion_guardar';
$route['recepcionista/autorizaciones/cirugia/crear'] = 'recepcionista/autorizaciones/cirugia_crear';
$route['recepcionista/autorizaciones/cirugia/guardar'] = 'recepcionista/autorizaciones/cirugia_guardar';
$route['recepcionista/autorizaciones/eutanasia/crear'] = 'recepcionista/eutanasia_crear';
$route['recepcionista/autorizaciones/cirugia/crear'] = 'recepcionista/cirugia_crear';
$route['recepcionista/autorizaciones/sedacion/crear'] = 'recepcionista/sedacion_crear';
$route['recepcionista/autorizaciones/eutanasia/guardar'] = 'recepcionista/guardar_autorizacion_eutanasia';
$route['recepcionista/autorizaciones/cirugia/guardar'] = 'recepcionista/guardar_autorizacion_cirugia';
$route['recepcionista/autorizaciones/sedacion/guardar'] = 'recepcionista/guardar_autorizacion_sedacion';
$route['recepcionista/autorizaciones/seleccionar_tipo'] = 'recepcionista/autorizaciones/seleccionar_tipo';

$route['veterinario'] = 'veterinario/index';
$route['veterinario/dashboard'] = 'veterinario/index';
$route['veterinario/get_urgencias_pendientes'] = 'veterinario/get_urgencias_pendientes_veterinario';
$route['veterinario/get_total_mascotas'] = 'veterinario/get_total_mascotas_veterinario';
$route['veterinario/get_urgencias_tabla'] = 'veterinario/get_urgencias_tabla_veterinario';
$route['veterinario/atenciones'] = 'veterinario/atenciones';
$route['veterinario/atenciones/historial'] = 'veterinario/atenciones';
$route['veterinario/atenciones/sedaciones'] = 'veterinario/sedaciones';
$route['veterinario/atenciones/cirugias'] = 'veterinario/cirugias';
$route['veterinario/atenciones/eutanasias'] = 'veterinario/atenciones_eutanasias';
$route['veterinario/atenciones_urgencias'] = 'veterinario/atenciones_urgencias';
$route['veterinario/imprimir_urgencia/(:num)'] = 'veterinario/imprimir_urgencia/$1';
$route['veterinario/emergencias'] = 'veterinario/emergencias';
$route['veterinario/emergencias/ver/(:num)'] = 'veterinario/ver_emergencia/$1';

$route['veterinario/vacunas'] = 'veterinario/vacunas';
$route['veterinario/vacunas/crear'] = 'veterinario/vacunas_crear';
$route['veterinario/vacunas/guardar'] = 'veterinario/vacunas_guardar';

$route['veterinario/desparacitaciones'] = 'veterinario/desparacitaciones/index';
$route['veterinario/desparacitaciones/crear'] = 'veterinario/desparacitaciones/crear';
$route['veterinario/desparacitaciones/guardar'] = 'veterinario/desparacitaciones/guardar';
$route['setup/db_init'] = 'setup/db_init';
