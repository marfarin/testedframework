<?php
namespace IccTest\base\FrontController;
use IccTest\base\router\Request;
use IccTest\base\Helpers\ApplicationHelper;
use IccTest\base\router\ControllerResolver;

class FrontController
{
    private  static $instance;
    private function __construct() {}
    static function instance($startConfig) {
        if(!self::$instance) {
            self::$instance = new self();
            $instance = new FrontController();
            $instance->init($startConfig);
            $instance->handleRequest();
        }
        return self::$instance;
    }
    /*static function run($start_config) {
        $instance = new FrontController();
        $instance -> init($start_config);
        $instance->handleRequest();
    }*/
    
    function init($startConfig) {
        $applicationHelper = ApplicationHelper::instance();
        //ApplicationHelper::init($start_config);
        $applicationHelper->init($startConfig);
    }
    
    function handleRequest() {
        $request = new Request();
        $controllerResolve = new ControllerResolver();
        $controllerResolve->run($request);
        //$cmd->execute($request);
    }
}
?>