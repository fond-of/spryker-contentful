<?php

$pathToAutoloader = codecept_root_dir('vendor/autoload.php');

if (!file_exists($pathToAutoloader)) {
    $pathToAutoloader = codecept_root_dir('../../vendor/autoload.php');
}

if (!file_exists($pathToAutoloader)) {
    $pathToAutoloader = codecept_root_dir('../../autoload.php');
}

if (!file_exists($pathToAutoloader)) {
    $pathToAutoloader = codecept_root_dir('../../../../autoload.php');
}

require_once $pathToAutoloader;
