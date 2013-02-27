<?php

// Parameters
$build_dir = $argv[1];
$filename = $argv[2];
$version = $argv[3];


$build_dir_fullpath = __DIR__ . DIRECTORY_SEPARATOR . $build_dir;
$pharName = "$build_dir_fullpath/$filename" . '_' . $version . '.phar';

if( file_exists( $pharName ) )
{
  unlink( $pharName );
}

$p = new Phar( $pharName );
$p->CompressFiles( Phar::GZ );
$p->setSignatureAlgorithm( Phar::SHA1 );

$p->startBuffering();
//$p = $p->convertToExecutable( Phar::ZIP );

$p->buildFromDirectory( __DIR__, '/bin/' );
$p->buildFromDirectory( __DIR__, '/vendor/' );
$p->buildFromDirectory( __DIR__, '/src/' );

$p->stopBuffering();

$stub = '<?php Phar::mapPhar(); require_once "phar://" . __FILE__ . "/bin/console.php"; __HALT_COMPILER();';
$p->setStub( $stub );
