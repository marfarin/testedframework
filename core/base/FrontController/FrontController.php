<?php
namespace IccTest\base\FrontController;
use IccTest\MVC\router\Request;
use IccTest\base\Helpers\ApplicationHelper;
require_once 'core/base/Autoloader/PsrAutoloader.php';
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
        $cmd_r = 1;//new CommandResolver();
        $cmd = 2;//cmd_r->getCommand($request)
        //$cmd->execute($request);
    }
}
?>