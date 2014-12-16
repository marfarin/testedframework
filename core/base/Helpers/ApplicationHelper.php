<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace IccTest\base\Helpers;
use IccTest\base\Registry\BaseRegistry;
use IccTest\base\Registry\MyException;
use IccTest\base\Autoloader\Psr4AutoloaderClass;

/**
 * Description of ApplicationRegistry
 *
 * @author stager3
 */
class ApplicationHelper extends BaseRegistry {
    private static $instance;
    private static $data;
    private static $lock = array();
    private function __construct() {
        
    }
    static public function instance() {
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
            throw new MyException("переменная '$key' регистра заблокирована");
        }
    }
    static public function remove($key) {
        if(self::has($key) && self::hasLock($key)) {
            unset(self::$data[$key]);
        } else {
            throw new MyException("Удаление невозможно! Переменная регистра не существует или не заблокирована!");
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
    static public function show() {
        //echo 'data</br>';
        //print_r(self::$data);
        //echo '</br>lock</br>';
        //print_r(self::$lock);
        //echo '</br>tress 1 '.self::get('application_folder').'</br>';
    }
    public function init($start_config) {
        $dsn = self::get('start_init');
        //echo 'dsn '.$dsn.'</br>';
        if (!is_null($dsn)) {
            return;
        }
        if(is_array($start_config)) {
            self::getOptions($start_config);                    
        } else {
            self::ensure(is_array($start_config), "Передайте верный параметр начальной конфигурации");
        }
    }
    
    private static function getOptions($start_config) {
        
        self::ensure(is_array($start_config), "Файл конфигурации не найден");
        
        self::ensure(is_array($start_config['system_config']), 
                "Системная конфигурация повреждена");
        
        self::set('system_config', 
                $start_config['system_config']);
        
        self::lock('system_config');
        
        self::ensure(is_array($start_config['default_config']), 
                "Не найден раздел контроллера \"По умолчанию\"");
        self::set('default_config', 
                $start_config['default_config']);
        
        self::lock('default_config');
        $loader = new Psr4AutoloaderClass();
        $loader->register();
        $loader->addNamespace($start_config['system_config']['system_vendor'].'\base', $start_config['system_config']['system_folder'].'/base');
        $loader->addNamespace($start_config['system_config']['system_vendor'].'\MVC', $start_config['system_config']['system_folder'].'/MVC');
        self::ensure(is_array($start_config['user_config']), 
                "Системная конфигурация повреждена");
        self::set('routes', $start_config['user_config']['routes']);
        self::lock('routes');
        foreach ($start_config['user_config']['routes'] as $key => $value) {
            //self::set($key, $value);
            //self::lock($key);
            self::ensure(isset($value['vendor']), "Системная конфигурация повреждена");
            $loader->addNamespace($value['vendor'].'\controller', 'application/controllers');
            $loader->addNamespace($value['vendor'].'\model', 'application/models');
            $loader->addNamespace($value['vendor'].'\view', 'application/views');
        }
        self::unlock('start_init');
        self::set('start_init', true);
        self::lock('start_init');
        //self::show(); 
    }
    private static function ensure ($expr, $message) {
        if (!$expr) {
            throw new MyException($message);
        }
    }
    //put your code here
}
