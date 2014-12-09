<?php
use FrontController\FrontController;
use module1\testcontroller;
chdir(dirname(__DIR__));
echo getcwd();
set_include_path(dirname(__DIR__));

//require_once 'core/';

		/*Тестовые команды*/


require_once 'core/Autoloaders/autoloader.php';
\Autoloader\Loader::initAutoloader(require 'config/folder_config.php');
$rests = new FrontController();
$rests2 = new testcontroller();
echo '<pre>';print_r(get_included_files()); echo '</pre></br>';
	