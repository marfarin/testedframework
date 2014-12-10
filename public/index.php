<?php
use IccTest\base\FrontController\FrontController;
use vendor1\module1\testcontroller;
chdir(dirname(__DIR__));
echo getcwd();
set_include_path(dirname(__DIR__));

//require_once 'core/';

		/*Тестовые команды*/


require_once 'core/base/Autoloader/PsrAutoloader.php';

$loader = new IccTest\base\Autoloader\Psr4AutoloaderClass();
$loader->register();
$loader->addNamespace('IccTest\base', 'core/base');
$loader->addNamespace('IccTest\MVC', 'core/MVC');
$run = FrontController::run(require 'config/FolderConfig.php');
$rests2 = new testcontroller();
echo '<pre>';print_r(get_included_files()); echo '</pre></br>';
	