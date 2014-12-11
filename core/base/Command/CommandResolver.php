<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace IccTest\base\Command;
use IccTest\base\FrontController\Request;
/**
 * Description of CommandResolver
 *
 * @author stager3
 */
class CommandResolver {
    private static $base_cmd;
    private static $default_cmd;
    
    function __construct() {
        if(!self::$base_cmd) {
            self::$base_cmd = new \ReflectionClass("\IccTest\Command\Command");
            self::$default_cmd = new DefaultCommand();           
        }
    }
    
    function getCommand(Request $request)
    {
        $cmd = $request->getProperty('cmd');
        $sep = DIRECTORY_SEPARATOR;
        if(!$cmd) {
            return self::$default_cmd;
        }
        $cmd = str_replace(array('.', $sep), "", $cmd);
        $filepath = "application{$sep}controllers{$sep}{$cmd}";
    }
    //put your code here
}
