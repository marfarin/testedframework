<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace IccTest\base\router;
use IccTest\base\Helpers\ApplicationHelper;
/**
 * Description of Request
 *
 * @author stager3
 */
class Request {
    
    private $argument = array(
        'router'=>"",
        'action'=>"",
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
            $this->set();
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
    
    private function setRouterAction($index, $key)
    {
        if (array_key_exists($index, $this->parseUri())) {
            $this->argument[$key] = \preg_replace("/^[A-Za-z0-9]*\=/", '', \preg_split("/\/\?|\&|\?|\//", $this->uri)[$index]);
        } else {
            $this->argument[$key] = '';
        }
    }
    
    private function setId()
    {   $testarray = array();
        foreach ($this->parseUri() as $key => $value) {
            if($key>2) {
                $testarray['_idkey'.$key] = \preg_replace("/^[A-Za-z0-9]*\=/","", $value);
            }
        }
        $this->argument['id'] = $testarray;
    }
    
    private function parseUri()
    {
        return \preg_split("/\/\?|\&|\?|\//", $this->uri);
    }
    
    private function set()
    {
        foreach ($this->argument as $key => $value) {
            $a_keys = \array_keys($this->argument);
            $index =  \array_search($key, $a_keys)+1;
            if($index===1 OR $index===2)
            {
                $this->setRouterAction($index, $key);
            } elseif($index>2) {
                $this->setId();
            }
                        
        }
    }
}
