<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace IccTest\MVC\controller;
use IccTest\MVC\router\Request;
/**
 * Description of DefaultCommand
 *
 * @author stager3
 */
class DefaultController extends Controller {
    function doExecute(Request $request) {
        $request->addFeedback($msg);
    }
    //put your code here
}
