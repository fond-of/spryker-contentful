<?php

require_once __DIR__ . '/../vendor/autoload.php';

define('APPLICATION_STORE', 'UNIT');
define('APPLICATION_ENV', \Spryker\Shared\Config\Environment::TESTING);
define('APPLICATION_ROOT_DIR', \org\bovigo\vfs\vfsStream::setup('root')->url());
