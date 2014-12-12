<?php
namespace vendor1\controller;
use IccTest\MVC\controller\Controller;
//require_once 'core/singleton.php';
class TestController extends Controller
{
	/*function __construct() {
		//echo "</br>Конструктор класса BaseClass\n";
	}*/
        function indexAction() {
            echo "</br>Конструктор класса BaseClass\n";
        }

    public function doExecute(\IccTest\MVC\router\Request $request) {
        
    }

}