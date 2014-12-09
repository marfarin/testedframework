<?php
use base\FrontController\FrontController;
use module1\testcontroller;
chdir(dirname(__DIR__));
echo getcwd();
set_include_path(dirname(__DIR__));

//require_once 'core/';

		/*Тестовые команды*/


require_once 'core/base/Autoloader/autoloader.php';
base\Autoloader\Loader::initAutoloader(require 'config/folder_config.php');
$run = FrontController::run(require 'config/folder_config.php');
$rests2 = new testcontroller();
echo '<pre>';print_r(get_included_files()); echo '</pre></br>';
	