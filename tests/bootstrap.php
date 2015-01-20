<?php
/**
 * (c) 2014 by pete ruler, all rights reserved
 * User: peterruler
 * Date: 07.07.14
 * Time: 15:08
 */
namespace ch\keepitnative\formmailer;
$_SERVER['REMOTE_ADDR'] ='127.0.0.1';
$_SERVER['HTTP_USER_AGENT']='Mozilla/5.0 (Macintosh; Intel Mac OS X 10_9_4) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/36.0.1985.125 Safari/537.36';
$_GLOBALS['test'] = true;
use ch\keepitnative\formmailer\src\psr4autoloader\Psr4AutoloaderClass;
require_once __DIR__ . '/../src/psr4autoloader/Psr4AutoloaderClass.php';

// instantiate the loader
$loader = new Psr4AutoloaderClass();

// register the autoloader
$loader->register();

// register the base directories for the namespace prefix
$loader->addNamespace('ch\keepitnative\formmailer\src\\', __DIR__ . '/src');
/*
function autoload($className)
{
    //var_dump($className);exit;
    str_replace('werkstattmultimedia\formmailer','../src',$className);
    $className = ltrim($className, '\\');
    $fileName  = '';
    $namespace = '';
    if ($lastNsPos = strrpos($className, '\\')) {
        $namespace = substr($className, 0, $lastNsPos);
        $className = substr($className, $lastNsPos + 1);
        $fileName  = str_replace('\\', DIRECTORY_SEPARATOR, $namespace) . DIRECTORY_SEPARATOR;
    }
    $fileName .= str_replace('_', DIRECTORY_SEPARATOR, $className) . '.php';

    require $fileName;
}
spl_autoload_register('werkstattmultimedia\formmailer\autoload');
*/