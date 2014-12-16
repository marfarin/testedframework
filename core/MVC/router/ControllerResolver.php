<?php

namespace IccTest\MVC\router;
use IccTest\MVC\router\Request;
use IccTest\base\Helpers\ApplicationHelper;

class ControllerResolver {
    private static $base_cmd;
    private static $default_cmd;
    private static $rules = array('vendor'=>'',
        'defaultAction'=>'',
        'controllerclass'=>'',
        );

    
    function __construct() {
        if(!self::$base_cmd) {
            self::$base_cmd = new \ReflectionClass("IccTest\MVC\controller\Controller");
            self::$default_cmd = new \ReflectionClass("IccTest\MVC\controller\Controller");
        }
    }
    
    public function run(Request $request)
    {
        $params = $this->getParam($request);
        $this->setRules($params['router']);

        if($params['router']=='') {
            $this->setController($params['router'], $params['action'], $params['param']);
        } else {
            $this->setController($params['router'], $params['action'], $params['param']);
        }
    }
    
     private function setController($router, $action, $param) { 
        $use = self::$rules['vendor'].'\controller\\'.self::$rules['controllerclass'];
        if(!isset($action)) {
            $action = self::$rules['defaultAction'].'Action';
        } else {
            $action = $action.'Action'; 
        }
        $result = $this->callUse($use, $action, $param, $router);
    }
    
    private function callUse($use, $action, $param, $router)
    {
        if(new $use) {
            if(!method_exists($use, $action)) {
               $action = self::$rules['defaultAction'].'Action';
            }
            $controllerClass = new \ReflectionClass($use);
            if($controllerClass->isSubclassOf(self::$base_cmd)) {
                //$class = $controllerClass->newInstance();
                $method = $controllerClass->getMethod($action);
                $method->invokeArgs($controllerClass->newInstance(), $param);
                return true;
            } else {
                echo '404(1)';
                return false;
            }
        } else {
            echo '404(2)';
            return false;
        }
    }
    
    private function setRules($router) {
        
        if($router!='') {
            $rules = ApplicationHelper::get("routes");
            if(array_key_exists($router, $rules)) {
                self::$rules['vendor'] = $rules[$router]['vendor'];
                self::$rules['defaultAction'] = $rules[$router]['defailtAction'];
                self::$rules['controllerclass'] = $rules[$router]['controllerclass'];
            }
            else {
                //echo 404;
                self::$rules['vendor'] = 'IccTest\MVC';
                self::$rules['defaultAction'] = 'index';
                self::$rules['controllerclass'] = 'Controller404';
            }
        } else {
            $rules = ApplicationHelper::get("default_config");
            self::$rules['vendor'] = $rules['vendor'];
            self::$rules['defaultAction'] = $rules['defailtAction'];
            self::$rules['controllerclass'] = $rules['controllerclass'];
        }
        
    }
    
    private function getParam(Request $request) {
        $router = $request->getArgument('router');
        $action = $request->getArgument('action');
        if($router!='') {
            $param = $request->getArgument('id');
        } else {
            $param = ApplicationHelper::get("default_config")['default_params'];
        }
        return array('router'=>$router, 'action'=>$action, 'param'=>$param);
    }
}
