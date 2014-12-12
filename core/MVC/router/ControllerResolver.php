<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace IccTest\MVC\router;
use IccTest\MVC\router\Request;
use IccTest\MVC\controller\Controller;
use IccTest\MVC\controller\DefaultController;
use IccTest\base\Registry\ApplicationRegistry;
/**
 * Description of CommandResolver
 *
 * @author stager3
 */
class ControllerResolver {
    private static $base_cmd;
    private static $default_cmd;
    
    function __construct() {
        if(!self::$base_cmd) {
            self::$base_cmd = new \ReflectionClass("IccTest\MVC\controller\Controller");
            self::$default_cmd = new DefaultController();           
        }
    }
    
    function getController(Request $request)
    {
        $router = $request->getArgument('router');
        $action = $request->getArgument('action');
        $param = $request->getArgument('id');
        $sep = DIRECTORY_SEPARATOR;
        if(!$router) {
            return self::$default_cmd;
        }
        $ruleRouting = ApplicationRegistry::get("routes");
        if(array_key_exists($router, $ruleRouting))
        {
            $use = $ruleRouting[$router]['vendor'].'\controller\\'.$ruleRouting[$router]['controllerclass'];
            $controller = $ruleRouting[$router]['controllerclass'];
            if(!isset($action)) {
                $action = $ruleRouting[$router]['defailtAction'].'Action';
            } else {
               $action = $action.'Action'; 
            }
            //use $use;
            if(class_exists($use)) {
                if(!method_exists($use, $action)) {
                    $action = $ruleRouting[$router]['defailtAction'].'Action';
                }
                $controllerClass = new \ReflectionClass($use);
                if($controllerClass->isSubclassOf(self::$base_cmd)) {
                    return $controllerClass->newInstance();
                } else {
                    echo '404';
                }
            } else {
                echo '404';
            }
        } else {
            echo '404';
        }
        
        //$router = str_replace(array('.', $sep), "", $cmd);
        //$filepath = "application{$sep}controllers{$sep}{$cmd}";
    }
    //put your code here
}
