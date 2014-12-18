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

        $view = $this->loadView('TestController') ;
        //$View->view( 'TestController' ) ;
        $arr = array( 'name' => 'Хелло Ворлд22', 'facNo' => '223322223322', 
            'age' => '27', 'url1' => '/route1/show/12/22', 
            'url2' => '/route2/show/12/22',
            'url3' => '/route/show/12/22',);
        //$view->setLayout('NonDefaultLayout');   
        $view->set( $arr ) ;
        $view->render() ;
			
    }
    function showAction($id1, $id2) {
        $view = $this->loadView('TestController') ;
        //$View->view( 'TestController' ) ;
        $arr = array( 'name' => $id1, 'facNo' => '223322223322', 'age' => $id2,
            'url1' => '/route1/show/12/22', 
            'url2' => '/route2/show/12/22',
            'url3' => '/route/show/12/22',);
        $view->setLayout('NonDefaultLayout');   
        $view->set( $arr ) ;
        $view->render() ;
    }
}