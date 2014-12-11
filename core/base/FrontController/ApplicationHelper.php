<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace IccTest\base\FrontController;
use IccTest\base\Registry\ApplicationRegistry;
use IccTest\base\Registry\MyException;
use IccTest\base\Autoloader\Psr4AutoloaderClass;
//require_once 'core/base/Autoloader/PsrAutoloader.php';
/**
 * Description of ApplicationHelper
 *
 * @author stager3
 */
class ApplicationHelper {
    private  static $instance;
    private $config;
    
    private function __construct() {
        
    }
    
    static function instance() {
        if(!self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    
    function init($start_config) {
        $dsn = ApplicationRegistry::get('start_init');
        //echo 'dsn '.$dsn.'</br>';
        if (!is_null($dsn)) {
            return;
        }
        if(is_array($start_config)) {
            $this->config = $start_config;
            $this->getOptions();                    
        } else {
            $this->ensure(is_array($start_config), "Передайте верный параметр начальной конфигурации");
        }
    }
    
    private function getOptions() {
        
        $this->ensure(is_array($this->config), "Файл конфигурации не найден");
        
        $this->ensure(is_array($this->config['system_config']), 
                "Системная конфигурация повреждена");
        
        ApplicationRegistry::set('system_config', 
                $this->config['system_config']);
        
        ApplicationRegistry::lock('system_config');
        
        $loader = new Psr4AutoloaderClass();
        $loader->register();
        $loader->addNamespace($this->config['system_config']['system_vendor'].'\base', $this->config['system_config']['system_folder'].'/base');
        $loader->addNamespace($this->config['system_config']['system_vendor'].'\MVC', $this->config['system_config']['system_folder'].'/MVC');
        $this->ensure(is_array($this->config['user_config']), 
                "Системная конфигурация повреждена");
        ApplicationRegistry::set('routes', $this->config['user_config']['routes']);
        ApplicationRegistry::lock('routes');
        foreach ($this->config['user_config']['routes'] as $key => $value) {
            //ApplicationRegistry::set($key, $value);
            //ApplicationRegistry::lock($key);
            $this->ensure(isset($value['vendor']), "Системная конфигурация повреждена");
            $loader->addNamespace($value['vendor'].'\controller', 'application/controllers');
            $loader->addNamespace($value['vendor'].'\model', 'application/models');
            $loader->addNamespace($value['vendor'].'\view', 'application/views');
        }
        ApplicationRegistry::unlock('start_init');
        ApplicationRegistry::set('start_init', true);
        ApplicationRegistry::lock('start_init');
        //ApplicationRegistry::show(); 
    }
    
    private function ensure ($expr, $message) {
        if (!$expr) {
            throw new MyException($message);
        }
    }
    //put your code here
}
