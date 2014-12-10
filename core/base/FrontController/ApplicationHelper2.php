<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace IccTest\base\FrontController;
use IccTest\base\Registry\ApplicationRegistry;
use IccTest\base\Registry\MyException;

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
        echo 'dsn '.$dsn.'</br>';
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
        
        $this->ensure(is_array($this->config['user_config']), 
                "Системная конфигурация повреждена");
        
        foreach ($this->config['user_config'] as $key => $value) {
            ApplicationRegistry::set($key, $value);
            ApplicationRegistry::lock($key);
        }
        ApplicationRegistry::unlock('start_init');
        ApplicationRegistry::set('start_init', true);
        ApplicationRegistry::lock('start_init');
        ApplicationRegistry::show(); 
    }
    
    private function ensure ($expr, $message) {
        if (!$expr) {
            throw new MyException();
        }
    }
    //put your code here
}
