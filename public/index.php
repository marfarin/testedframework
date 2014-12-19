<?php
use IccTest\base\FrontController\FrontController;

chdir(dirname(__DIR__));
set_include_path(dirname(__DIR__));

require_once 'core/base/Autoloader/PsrAutoloader.php';
$loader = new IccTest\base\Autoloader\Psr4AutoloaderClass();
$loader->register();
$loader->addNamespace('IccTest\base', 'core/base');
$loader->addNamespace('IccTest\MVC', 'core/MVC');
$run = FrontController::instance(require 'config/FolderConfig.php');
