<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace base\Registry;

/**
 * Description of ApplicationRegistry
 *
 * @author stager3
 */
class ApplicationRegistry {
    private static $instance;
    private static $data;
    private static $lock = array();
    private function __construct() {
        
    }
    static function instance() {
        if(!isset(self::$instance)) {
            self::$instance = new self();     
        }
        return self::$instance;
    }
    static public function get($key, $defailt = NULL) {
        if(self::has($key))
        {
            return self::$data[$key];
        } else {
            return $defailt;
        }
    }
    static public function set($key,$value) {
        if(!self::hasLock($key)) {
            self::$data[$key] = $value;
        } else {
            throw new Exception("переменная регистра заблокирована");
        }
    }
    static public function remove($key) {
        if(self::has($key) && self::hasLock($key)) {
            unset(self::$data[$key]);
        } else {
            throw new Exception("Удаление невозможно! Переменная регистра не существует или не заблокирована!");
        }
    }
    static private function has($key) {
        return isset(self::$data[$key]);
    }
    static public function lock($key) {
        self::$lock[$key] = TRUE;
    }
    static private function hasLock($key) {
        return isset(self::$lock[$key]);
    }
    static public function unlock($key) {
        if(self::hasLock($key)) {
            unset(self::$lock[$key]);
        }
    }
    //put your code here
}
