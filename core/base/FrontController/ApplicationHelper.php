<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace base\FrontController;
use base\Registry\ApplicationRegistry;
use base\Registry\MyException;

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
        /*$options = 1;
        print get_class($options);
        $dsn = (string)$options->dsn;
        $this->ensure($options instanceof \ArrayObject, "Файл конфигурации испорчен");
        $this->ensure($dsn, "DSN не найден");*/
        print_r($this->config);
        $tmp = $this->config;
        foreach ($tmp as $key => $value) {
            echo 'sisi '.$key.'</br>';
            switch ($key) {
                case "application_folder":
                    $this->ensure(($value!='' && $value!=NULL), 'Отсутствует директория пользовательских файлов');
                    ApplicationRegistry::set($key, $value);
                    ApplicationRegistry::lock($key);
                    break 1;
                case "application_subfolder":
                    $this->ensure(($value!='' && $value!=NULL), 'Отсутствует директория пользовательских файлов');
                    foreach ($value as $subKey => $subValue) {
                        switch ($subKey) {
                            case "controllers_folder":
                                $this->ensure(($subValue!='' && $subValue!=NULL), 'Отсутствует директория пользовательских файлов');
                                ApplicationRegistry::set($subKey, $subValue);
                                ApplicationRegistry::lock($subKey);
                                break 1;
                            case "models_folder":
                                $this->ensure(($subValue!='' && $subValue!=NULL), 'Отсутствует директория пользовательских файлов');
                                ApplicationRegistry::set($subKey, $subValue);
                                ApplicationRegistry::lock($subKey);
                                break 1;
                            case "views_folder":
                                $this->ensure(($subValue!='' && $subValue!=NULL), 'Отсутствует директория пользовательских файлов');
                                ApplicationRegistry::set($subKey, $subValue);
                                ApplicationRegistry::lock($subKey);
                                break 1;
                            default:
                                $this->ensure(array_key_exists($subKey, $value), 'Конфигурационыый файл поврежден! Не хватает необходимых полей');
                                break 1;
                        }
                    }
                    break 1;
                case "system_folder":
                    $this->ensure(($value!='' && $value!=NULL), 'Отсутствует директория пользовательских файлов');
                    ApplicationRegistry::set($key, $value);
                    ApplicationRegistry::lock($key);
                    break 1;
                default:
                    $this->ensure(array_key_exists($key, $tmp), 'Конфигурационыый файл поврежден! Не хватает необходимых полей');
                    break 1;
            }
            ApplicationRegistry::unlock('start_init');
            ApplicationRegistry::set('start_init', true);
            ApplicationRegistry::lock('start_init');
            //ApplicationRegistry::show();    
        }
    }
    
    private function ensure ($expr, $message) {
        if (!$expr) {
            throw new MyException();
        }
    }
    //put your code here
}
