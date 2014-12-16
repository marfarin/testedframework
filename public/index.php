<?php
use IccTest\base\FrontController\FrontController;
use vendor1\controller\TestController;
chdir(dirname(__DIR__));
//echo getcwd();
set_include_path(dirname(__DIR__));

//require_once 'core/';

		/*Тестовые команды*/
                //$whatINeed = explode('/', $_SERVER['REQUEST_URI']);
                //print_r($whatINeed);
                $url = filter_input(INPUT_SERVER, "REQUEST_URI");
                //print_r(preg_split("/\/\?|\&|\?|\//", $url));
                        //$urlParameters = http_build_query(filter_input_array (INPUT_GET, FILTER_SANITIZE_URL));
                  //      count(preg_split("/\/\?|\&|\?|\//", $url));
                    //    print_r($_GET);

//print_r( \preg_split("/\/\?|\&|\?|\//", $url));
require_once 'core/base/Autoloader/PsrAutoloader.php';
//require_once 'application/controllers/TestController.php';
$loader = new IccTest\base\Autoloader\Psr4AutoloaderClass();
$loader->register();
$loader->addNamespace('IccTest\base', 'core/base');
$loader->addNamespace('IccTest\MVC', 'core/MVC');
//echo '</br> Старт </br>';
$run = FrontController::instance(require 'config/FolderConfig.php');
//echo '</br> Стоп </br>';

//$rests2 = new testcontroller();
//\var_dump(class_exists('TestController'));
//echo '<pre>';print_r(get_included_files()); echo '</pre></br>';
	