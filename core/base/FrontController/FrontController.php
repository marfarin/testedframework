<?php
namespace IccTest\base\FrontController;
use IccTest\base\FrontController\Request;
require_once 'core/base/Autoloader/PsrAutoloader.php';
class FrontController
{
    private $applicationHelper;
    private function __construct() {}
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
        $cmd_r = 1;//CommandResolver
        $cmd = 2;
        //$cmd->execute($request);
    }
}
?>