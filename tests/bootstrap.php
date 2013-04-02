<?php

// ****************************************
// PHP SETTINGS
// ****************************************
// Set php ini configurations
ini_set( 'display_errors', 0 ); // Do not display errors (error_handler and fatal_error_handler) should inform about them
ini_set( 'error_reporting', E_ALL );



// ****************************************
// GLOBAL PATHS
// ****************************************
$GLOBALS[ 'project_root_path' ] = dirname( __FILE__ ) . '/../';
$GLOBALS[ 'testdata_path' ] = dirname( __FILE__ ) . '/testdata';
$GLOBALS[ 'output_compare_path' ] = dirname( __FILE__ ) . '/output';



// ****************************************
// LOADERS
// ****************************************
require_once __DIR__ . '/../vendor/autoload.php';
