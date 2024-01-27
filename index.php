<?php

use Mailer\Http\Kernel;

/*
|--------------------------------------------------------------------------
| Register Auto Loader and Base Directory
|--------------------------------------------------------------------------
| We are adding this composer so that we don't need worry about including all
| of our files and registering their namespaces.
|*/

require_once __DIR__ . '/vendor/autoload.php';

$configs = require __DIR__ . '/configuration.php';

error_reporting($configs['level']);
ini_set('display_errors', $configs['debug']);

/*
|--------------------------------------------------------------------------
| Register HTTP Kernel
|--------------------------------------------------------------------------
| As we are serving HTTP request; this kernel will handle all its requirements
|*/

/**
 * TODO: Create top level container which will create and provide all singletons
 * As of now all classes which needs to be singleton are creating their instance
 */
$kernel = Kernel::getInstance();

$kernel->bootstrap();

$response = $kernel->serve();

$kernel->terminate($response);
