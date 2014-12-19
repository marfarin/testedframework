<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace IccTest\MVC\view\layout;

/**
 * Description of Layout
 *
 * @author stager3
 */


class Layout
{
    protected $content;
    protected $layout;
    
    public function setContent($content)
    {
        $this->content = $content;
    }

    public function setLayout($layout)
    {
        $ext = ".php";
        if ($layout!='' and $layout!=false) {
            $this->layout =	"application/views/layout/" . $layout . $ext ;
        } else {
            $this->layout =	"core/MVC/view/layout/DefaultLayout". $ext ;
        }
    }
}
