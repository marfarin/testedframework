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
        //echo "</br>Конструктор класса BaseClass\n";

        $View = $this->loadView('TestController') ;
        //$View->view( 'TestController' ) ;
        $arr = array( 'name' => 'Хелло Ворлд', 'facNo' => '223322223322', 
            'age' => '27', 'url1' => '/route1/show/12/22', 
            'url2' => '/route2/show/12/22',
            'url3' => '/route/show/12/22',); 
        $View->set( $arr ) ;
        $View->render() ;
			
    }
    function showAction($id, $id2) {
        $View = $this->loadView('TestController') ;
        //$View->view( 'TestController' ) ;
        $arr = array( 'name' => $id, 'facNo' => '223322223322', 'age' => $id2,
            'url1' => '/route1/show/12/22', 
            'url2' => '/route2/show/12/22',
            'url3' => '/route/show/12/22',);
        $View->set( $arr ) ;
        $View->render() ;
    }
}