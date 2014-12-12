<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace IccTest\MVC\controller;

/**
 * Description of Command
 *
 * @author stager3
 */
abstract class Controller {
    
    final function __construct() {
        
    }
    
    function execute($request)
    {
        $this->doExecute($request);
    }
    abstract function doExecute($request);
    //put your code here
}
