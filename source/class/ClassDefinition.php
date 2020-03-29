<?php

namespace PPP;

class ClassDefinition
{

    protected $extend = null;
    protected $traits = array();
    protected $methods = array();

    /**
     * @var ClassDefinitionCompiler
     */
    protected $compiler;

    public function __construct()
    {
        $this->compiler = new ClassDefinitionCompiler($this);
    }

    public function extend($className)
    {
        
        $this->extend = $className;
        
    }


    public function addMethod($name, $callback, $visibility = 'public')
    {
        $this->methods[$name] = array(
            'callback' => $callback,
            'visibility' => $visibility,
        );
        return $this;
    }

    public function addTrait($name)
    {
        $this->traits[$name] = array();
        return $this;
    }


    public function getTraits()
    {
        return $this->traits;
    }


    public function getMethods()
    {
        return $this->methods;
    }

    public function getExtend()
    {
        return $this->extend;
    }


    public function getInstance()
    {
        return $this->compiler->getInstance();
    }

    public function getCode()
    {
        $this->compiler->compile();
        return $this->compiler->getCode();
    }

}

//=======================================================
