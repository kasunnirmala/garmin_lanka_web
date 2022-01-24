<?php
if ( ! defined( 'ABSPATH' ) ) {
	die();
}

if ( isset( $optimize ) && $optimize ) {
	require RIODE_ADMIN . '/customizer/dynamic/dynamic_conditions.php';
}
