<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace IccTest\MVC\router;
use IccTest\base\Registry\ApplicationRegistry;
/**
 * Description of Request
 *
 * @author stager3
 */
class Request {
    
    private $argument = array(
        'action'=>"",
        'router'=>"",
        'id'=>array(),
    );
    private $uri;
    
    function __construct() {
        if($this->init()) {
            ApplicationRegistry::set($this->uri, $this->argument);
        }
    }
    
    protected function init() {
        $this->uri = $this->parseRequest();
        if(null!==ApplicationRegistry::get($this->uri))
        {
            $this->argument = ApplicationRegistry::get($this->uri);
            print_r($this->argument);
            return false;
        } else {
            $serachRouter = $this->serachRouter();
            echo $serachRouter;
            $this->argument['router'] = $serachRouter;
            $this->argument['action'] = $this->addAction();
            $this->argument['id'] = $this->addId();
            print_r($this->argument);
            return TRUE;
        }
    }
    
    function getArgument($key)
    {
        //echo 'ska';
        if(\array_key_exists($key, $this->argument)) {
            if(isset($this->argument[$key])) {
                return $this->argument[$key];
            }
        } else {
            return false;
        }

    }
    
    protected function setArgument($key, $val) {
        $this->$argument[$key] = $val;
    }
    
    /*protected function addFeedback($msg) {
        array_push($this->feedback, $msg);
    }
    
    function getFeedback() {
        return $this->feedback;
    }
    
    function getFeedbackString($separator = "\n") {
        return implode($separator, $this->feedback);
    }*/
    protected function parseRequest()
    {
        return Filter_input(\INPUT_SERVER, "REQUEST_URI");
    }
    
    private function serachRouter()
    {
        return preg_replace("/^[A-Za-z0-9]*\=/","", $this->addControllerUri());
    }
    
    private function addControllerUri()
    {
        return \preg_split("/\/\?|\&|\?|\//", $this->uri)[1];
    }
    
    private function isGet($param) 
    {
        return \preg_match('/\=/', $param);
    }
    private function addAction()
    {
        $actionUri = \preg_split("/\/\?|\&|\?|\//", $this->uri);
        if (array_key_exists(2, $actionUri)) {
            return \preg_replace("/^[A-Za-z0-9]*\=/", '', \preg_split("/\/\?|\&|\?|\//", $this->uri)[2]);
        } else {
            return '';
        }
    }
    private function addId()
    {   $testarray = array();
        $array = \preg_split("/\/\?|\&|\?|\//", $this->uri);
        foreach ($array as $key => $value) {
            if($key>2) {
                $testarray['_idkey'.$key] = \preg_replace("/^[A-Za-z0-9]*\=/","", $value);
            }
        }
        return $testarray;
    }
    
    public function getUri()
    {
        if(isset($this->uri)) {
            return $this->uri;
        }
    }
}
