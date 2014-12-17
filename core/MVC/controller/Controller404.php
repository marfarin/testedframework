<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace IccTest\MVC\controller;

/**
 * Description of Controller404
 *
 * @author stager3
 */
class Controller404 extends Controller {
    //put your code here
        function indexAction() {
        //echo "</br>Конструктор класса BaseClass\n";

        $view = $this->loadView('TestController') ;
        //$View->view( 'TestController' ) ;
        $arr = array( 'name' => '404', 'facNo' => '404', 
            'age' => '404', 'url1' => '/route1/show/12/22', 
            'url2' => '/route2/show/12/22',
            'url3' => '/route/show/12/22',); 
        $view->set( $arr ) ;
        $view->render() ;
			
    }
}
