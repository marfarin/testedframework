<?php
namespace IccTest\base\FrontController;
use IccTest\MVC\router\Request;
use IccTest\base\Helpers\ApplicationHelper;
use IccTest\MVC\router\ControllerResolver;
//require_once 'core/base/Autoloader/PsrAutoloader.php';
class FrontController
{
    private $applicationHelper;
    private  static $instance;
    private function __construct() {}
    static function instance() {
        if(!self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    static function run($start_config) {
        $instance = new FrontController();
        $instance -> init($start_config);
        $instance->handleRequest();
    }
    
    function init($start_config) {
        $applicationHelper = ApplicationHelper::instance();
        $applicationHelper->init($start_config);
    }
    
    function handleRequest() {
        $request = new Request();
        $cmd_r = new ControllerResolver();
        $cmd = $cmd_r->getController($request);
        //$cmd->execute($request);
    }
}
?>