<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace IccTest\base\FrontController;
use IccTest\base\Registry\ApplicationRegistry;
/**
 * Description of Request
 *
 * @author stager3
 */
class Request {
    
    private $argument = array(
        'use'=>"",
        'action'=>"",
        'controller'=>"",
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
            //ApplicationRegistry::show();
            $routingRule = ApplicationRegistry::get('routes');
            //print_r($routingRule[$serachRouter]);
            if(isset($routingRule[$serachRouter])) {
                $this->argument['controller'] = $routingRule[$serachRouter]['controllerclass'];
                $this->argument['use'] = $routingRule[$serachRouter]['vendor'].'\controller\\'.$routingRule[$serachRouter]['controllerclass'];
                $this->argument['action'] = $this->addAction();
                $this->argument['id'] = $this->addId();
                print_r($this->argument);
            } else {
                echo '404';
            }
            return TRUE;
        }
    }
    
    function getArgument($key)
    {
        if(isset($this->$argument[$key])) {
            return $this->$argument[$key];
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
        //echo '</br>'.$this->addControllerUri().'</br>';
        //echo preg_replace("/^[A-Za-z0-9]*\=/","", $this->addControllerUri());
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
        
        return \preg_replace("/^[A-Za-z0-9]*\=/",'', \preg_split("/\/\?|\&|\?|\//", $this->uri)[2]);
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
}
