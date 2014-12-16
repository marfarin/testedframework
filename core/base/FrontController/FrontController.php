<?php
namespace IccTest\base\FrontController;
use IccTest\base\router\Request;
use IccTest\base\Helpers\ApplicationHelper;
use IccTest\base\router\ControllerResolver;

class FrontController
{
    private  static $instance;
    private function __construct() {}
    static function instance($start_config) {
        if(!self::$instance) {
            self::$instance = new self();
            $instance = new FrontController();
            $instance->init($start_config);
            $instance->handleRequest();
        }
        return self::$instance;
    }
    /*static function run($start_config) {
        $instance = new FrontController();
        $instance -> init($start_config);
        $instance->handleRequest();
    }*/
    
    function init($start_config) {
        $applicationHelper = ApplicationHelper::instance();
        //ApplicationHelper::init($start_config);
        $applicationHelper->init($start_config);
    }
    
    function handleRequest() {
        $request = new Request();
        $cmd_r = new ControllerResolver();
        $cmd = $cmd_r->run($request);
        //$cmd->execute($request);
    }
}
?>