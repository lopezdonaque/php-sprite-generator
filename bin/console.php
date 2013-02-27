<?php

// Set php ini configurations
ini_set( 'display_errors', 0 ); // Do not display errors (error_handler and fatal_error_handler) should inform about them
ini_set( 'error_reporting', E_ALL );

require_once __DIR__ . '/../vendor/autoload.php';

$application = new \Symfony\Component\Console\Application();
$application->add( new \SpriteGenerator\GeneratorCommand() );
$application->run();
