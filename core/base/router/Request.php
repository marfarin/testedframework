<?php
namespace IccTest\base\router;

use IccTest\base\Helpers\ApplicationHelper;

class Request
{
    
    private $argument = array(
        'router'=>"",
        'action'=>"",
        'id'=>array(),
    );
    private $uri;
    
    public function __construct()
    {
        if ($this->init()) {
            ApplicationHelper::set($this->uri, $this->argument);
        }
    }
    
    protected function init()
    {
        $this->parseRequest();
        if (null!=ApplicationHelper::get($this->uri)) {
            $this->argument = ApplicationHelper::get($this->uri);
            //print_r($this->argument);
            return false;
        } else {
            $this->setAllArguments();
            //print_r($this->argument);
            return true;
        }
    }
    
    public function getArgument($key)
    {
        if (\array_key_exists($key, $this->argument)) {
            if (isset($this->argument[$key])) {
                return $this->argument[$key];
            }
        } else {
            return false;
        }

    }
    
    protected function parseRequest()
    {
         $this->uri = Filter_input(\INPUT_SERVER, "REQUEST_URI");
    }
    
    private function setRouterAndAction($index, $key)
    {
        if (\array_key_exists($index, $this->splitUri())) {
            $this->argument[$key] = \preg_replace(
                "/^[A-Za-z0-9]*\=/",
                '',
                \preg_split("/\/\?|\&|\?|\//", $this->uri)[$index]
            );
        } else {
            $this->argument[$key] = '';
        }
    }
    
    private function setId()
    {   $testarray = array();
        foreach ($this->splitUri() as $key => $value) {
            if ($key>2) {
                $testarray['_idkey'.$key] = \preg_replace(
                    "/^[A-Za-z0-9]*\=/",
                    "",
                    $value
                );
            }
        }
        $this->argument['id'] = $testarray;
    }
    
    private function splitUri()
    {
        return \preg_split("/\/\?|\&|\?|\//", $this->uri);
    }
    
    private function setAllArguments()
    {
        
        $argKeys = \array_keys($this->argument);
        foreach ($argKeys as $key) {
            $index =  \array_search($key, $argKeys)+1;
            if ($index===1 or $index===2) {
                $this->setRouterAndAction($index, $key);
            } elseif ($index>2) {
                $this->setId();
            }
                        
        }
    }
}
