<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// Modifica el hook para usar un enfoque diferente
$hook['post_controller_constructor'] = array(
    'class'    => 'RoleCheck',
    'function' => 'verify',
    'filename' => 'RoleCheck.php',
    'filepath' => 'hooks',
    'params'   => array()
);
