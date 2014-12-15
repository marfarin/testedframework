<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace IccTest\MVC\controller;
use IccTest\MVC\view\View;
use IccTest\MVC\router\Request;

/**
 * Description of Command
 *
 * @author stager3
 */
abstract class Controller {
    public function __construct() {}
		
    final public function loadView($view = '' ) {
        return new View($view) ;
    }
		
}