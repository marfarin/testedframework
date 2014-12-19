<?php

namespace IccTest\base\router;

use IccTest\base\router\Request;

use IccTest\base\Helpers\ApplicationHelper;

class ControllerResolver
{
    private static $baseCmd;
    private static $defaultCmd;
    private static $rules = array('vendor'=>'',
        'defaultAction'=>'',
        'controllerclass'=>'',
        );
    private static $use;

    
    public function __construct()
    {
        if (!self::$baseCmd) {
            self::$baseCmd = new \ReflectionClass("IccTest\MVC\controller\Controller");
            self::$defaultCmd = new \ReflectionClass("IccTest\MVC\controller\Controller");
        }
    }
    
    public function run(Request $request)
    {
        $params = $this->getRequestParam($request);
        $this->setRules($params['router']);
        $this->setController($params['action'], $params['param']);
    }
    
    private function getRequestParam(Request $request)
    {
        $router = $request->getArgument('router');
        $action = $request->getArgument('action');
        if ($router!='') {
            $param = $request->getArgument('id');
        } else {
            $param = ApplicationHelper::get("default_config")['default_params'];
        }
        return array('router'=>$router, 'action'=>$action, 'param'=>$param);
    }
    
    private function setRules($router)
    {
        
        if ($router!='') {
            $rules = ApplicationHelper::get("routes");
            if (array_key_exists($router, $rules)) {
                $this->initRule($rules[$router]);
            } else {
                $rules = ApplicationHelper::get("system_config");
                $this->initRule($rules['route404']);
            }
        } else {
            $rules = ApplicationHelper::get("default_config");
            $this->initRule($rules);
        }
    }
    
    private function setController($action, $param)
    {
        if (!isset($action)) {
            $action = self::$rules['defaultAction'].'Action';
        } else {
            $action = $action.'Action';
        }
        $this->callUse($action, $param);
    }
    
    private function callUse($action, $param)
    {
        if (new self::$use) {
            if (!method_exists(self::$use, $action)) {
                $action = self::$rules['defaultAction'].'Action';
            }
            $this->callController($action, $param);
        } else {
            $this->call404();
        }
    }
    

    private function call404()
    {
        $rules = ApplicationHelper::get("system_config");
        $this->initRule($rules['route404']);
        $this->callController(self::$rules['defaultAction']);
    }


    private function callController($action, $param = array())
    {
        $controllerClass = new \ReflectionClass(self::$use);
        if ($controllerClass->isSubclassOf(self::$baseCmd)) {
            $method = $controllerClass->getMethod($action);
            $method->invokeArgs($controllerClass->newInstance(), $param);
        } else {
            $this->call404();
        }
    }
    
    private function initRule($helperRule)
    {
        self::$rules['vendor'] = $helperRule['vendor'];
        self::$rules['defaultAction'] = $helperRule['defaultAction'];
        self::$rules['controllerclass'] = $helperRule['controllerclass'];
        self::$use = self::$rules['vendor'].'\controller\\'.self::$rules['controllerclass'];
    }
}
