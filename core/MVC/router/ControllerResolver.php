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
    private static $default_param;
    private static $default_class;
    //private static $default_action;
    
    function __construct() {
        if(!self::$base_cmd) {
            self::$base_cmd = new \ReflectionClass("IccTest\MVC\controller\Controller");
            $ruleRouting = ApplicationRegistry::get("default_config");
            $use = $ruleRouting['vendor'].'\controller\\'.$ruleRouting['default_controller'];
            $action = $ruleRouting['default_action'].'Action';
            $param = $ruleRouting['default_params'];
            self::$default_param = $param;
            //self::$default_cmd = new DefaultController();
            if(new $use) {
                $controllerClass = new \ReflectionClass($use);
                if($controllerClass->isSubclassOf(self::$base_cmd)) {
                    self::$default_class = $controllerClass->newInstance();
                    $method = $controllerClass->getMethod($action);
                    self::$default_cmd = $method;
                    //$method->invokeArgs($controllerClass->newInstance(), $param);
                } else {
                    echo '404(1)';
                }
            } else {
                echo '404(2)';
            }
        }
    }
    
    function getController(Request $request)
    {
        $router = $request->getArgument('router');
        $action = $request->getArgument('action');
        $param = $request->getArgument('id');
        $sep = DIRECTORY_SEPARATOR;
        //echo $router;
        if(!$router or $router=='') {
            //return self::$default_cmd;
            self::$default_cmd->invokeArgs( self::$default_class, self::$default_param);
        } else {
            $ruleRouting = ApplicationRegistry::get("routes");
            if(array_key_exists($router, $ruleRouting))
            {
                $use = $ruleRouting[$router]['vendor'].'\controller\\'.$ruleRouting[$router]['controllerclass'];

                if(!isset($action)) {
                    $action = $ruleRouting[$router]['defailtAction'].'Action';
                } else {
                   $action = $action.'Action'; 
                }
                //echo $use;
                if(new $use) {
                    if(!method_exists($use, $action)) {
                        $action = $ruleRouting[$router]['defailtAction'].'Action';
                    }
                    $controllerClass = new \ReflectionClass($use);
                    if($controllerClass->isSubclassOf(self::$base_cmd)) {
                        //$class = $controllerClass->newInstance();
                        $method = $controllerClass->getMethod($action);
                        $method->invokeArgs($controllerClass->newInstance(), $param);
                    } else {
                        echo '404(1)';
                    }
                } else {
                    echo '404(2)';
                }
            } else {
                echo '404(3)';
            }
        }
        
        //$router = str_replace(array('.', $sep), "", $cmd);
        //$filepath = "application{$sep}controllers{$sep}{$cmd}";
    }
    //put your code here
}
