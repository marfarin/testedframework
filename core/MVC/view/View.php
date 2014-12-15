<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace IccTest\MVC\view;

/**
 * Description of View
 *
 * @author stager3
 */
class View {
    private $view = '' ;
		
    private $vars = array() ;
		
    private $render ;
    
    public function __construct($view = '' ) {
        if( !empty( $view ) ) {
            $this->view = $view ;
        } else {
            throw new \Exception("Не указан view");
        }
    }
    
    public function __set( $key, $value ) {
            $this->vars[ $key ] = $value ;
    }
    
    public function set( $var, $value = '' ) {
        if( is_array( $var ) ) { // array( 'var1' => 'value1', 'var2' => 'value2' )
            $keys = array_keys( $var ) ; // array( 'var1', 'var2' )
            $values = array_values( $var ) ; // array( 'value1', 'value2' )
            $this->vars = array_merge( $this->vars, array_combine( $keys, $values ) ) ;
        } else {
            $this->vars[ $var ] = $value ;
        }
    }
    
    public function view( $view ) {
        $this->view = $view ;
    }
    
    public function render( $render = true ) {
        if ($render === false) {
            $this->render = false;
        }
        if ($this->render === false) {
            return false;
        }

        $ext = ".php";
			
        $this->view = "application/views/" . $this->view . $ext ;
        unset( $render, $ext ) ;
			
        extract( $this->vars, EXTR_OVERWRITE ) ;
        ob_start() ;
        include $this->view ;
        header( 'Content-length: ' . ob_get_length() ) ;
			
        $this->render = false ;
    }
    //put your code here
}
