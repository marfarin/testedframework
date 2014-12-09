<?php
namespace base\FrontController;
//use base\FrontController\Request;
//require_once 'core/singleton.php';
class FrontController
{
    private $applicationHelper;
    private function __construct() {}
    static function run() {
        $instance = new FrontController();
        $instance -> init();
        $instance->handleRequest();
    }
    
    function init() {
        $applicationHelper = ApplicationHelper::instance();
        $applicationHelper->init();
    }
    
    function handleRequest() {
        $request = new Request();
        $cmd_r = 1;
        $cmd = 2;
        $cmd->execute($request);
    }
}
?>