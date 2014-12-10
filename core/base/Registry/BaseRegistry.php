<?php
namespace IccTest\base\Registry;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Registry
 *
 * @author stager3
 */
abstract class BaseRegistry {
    abstract protected static function get($key, $default = NULL);
    abstract protected static function set($key,$val);
    abstract protected static function remove($key);
    //put your code here
}


