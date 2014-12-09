<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace base\FrontController;
use base\Registry\ApplicationRegistry;

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
    
    function init() {
        $dsn = 1;
        if (!is_null($dsn)) {
            return;
        }
        $this->getOptions();
    }
    
    private function getOptions() {
        $this->ensure(file_exists($this->config), "Файл конфигурации не найден");
        $options = 1;
        print get_class($options);
        $dsn = (string)$options->dsn;
        $this->ensure($options instanceof \ArrayObject, "Файл конфигурации испорчен");
        $this->ensure($dsn, "DSN не найден");
    }
    
    private function ensure ($expr, $message) {
        if (!$expr) {
            throw new AppExeption($message);
        }
    }
    //put your code here
}
