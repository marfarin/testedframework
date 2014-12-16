<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace IccTest\MVC\router;
use IccTest\base\Helpers\ApplicationHelper;
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
            ApplicationHelper::set($this->uri, $this->argument);
        }
    }
    
    protected function init() {
        $this->uri = $this->parseRequest();
        if(null!==ApplicationHelper::get($this->uri))
        {
            $this->argument = ApplicationHelper::get($this->uri);
            //print_r($this->argument);
            return false;
        } else {
            $serachRouter = $this->addRouter();
            //echo $serachRouter;
            $this->argument['router'] = $serachRouter;
            $this->argument['action'] = $this->addAction();
            $this->argument['id'] = $this->addId();
            //print_r($this->argument);
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
    
    protected function parseRequest()
    {
        return Filter_input(\INPUT_SERVER, "REQUEST_URI");
    }
    
    private function addRouter()
    {
        $actionUri = \preg_split("/\/\?|\&|\?|\//", $this->uri);
        if (array_key_exists(1, $actionUri)) {
            return \preg_replace("/^[A-Za-z0-9]*\=/", '', \preg_split("/\/\?|\&|\?|\//", $this->uri)[1]);
        } else {
            return '';
        }
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
}
