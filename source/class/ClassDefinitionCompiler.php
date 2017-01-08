<?php


namespace PPP;
use \ReflectionFunction;



class ClassDefinitionCompiler
{

	protected $code='';
	protected $classDefinition;

	protected $extend=null;
	protected $methods=array();
	protected $traits=array();


	public function __construct($classDefinition) {
		$this->classDefinition=$classDefinition;

		$this->methods=$this->classDefinition->getMethods();
		$this->extend=$this->classDefinition->getExtend();
		$this->traits=$this->classDefinition->getTraits();
	}




	public function compile() {
		$extend='';
		if($this->extend) {
			$extend=' extends '.$this->extend.' ';
		}


		$traitBuffer='';
		foreach ($this->traits as $name=>$descriptor) {
			$traitBuffer.='use '.$name;


			$traitBuffer.=';';
		}


		$methodString='';
		foreach ($this->methods as $name => $descriptor) {

			$callback=$descriptor['callback'];
			$reflector=new ReflectionFunction($callback);
			$parameters=$reflector->getParameters();

			$parameterString='';
			foreach ($parameters as $parameter) {
				$parameterString.=$this->compileParameter($parameter);
				$parameterString.=',';
			}
			if($parameterString) {
				$parameterString=substr($parameterString, 0, -1);
			}

			$methodString.='    '.$descriptor['visibility'].' function '.$name.' ('.$parameterString.') {
				return call_user_func_array(
					array($this->methods["'.$name.'"], "__invoke"),
					func_get_args()
				);
            }
            ';
		}


		$code='
            $instance=new Class '.$extend.'{
                '.$traitBuffer.'
                protected $methods=array();
                
                public function ___setMethod($name, $callback) {
                    $this->methods[$name]=$callback;
                    return $this;
                }
                
                '.$methodString.'
            };
        ';
		$this->code=$code;
		return $this;
	}


	public function getCode() {
		if(!$this->code) {
			$this->compile();
		}
		return $this->code;
	}

	public function getInstance() {
		$instance=null;
		eval($this->getCode());

		foreach ($this->methods as $name => $descriptor) {
			$instance->___setMethod($name, $descriptor['callback']);
		}
		return $instance;
	}




	protected function compileParameter($parameter) : string {

		$parameterString='$'.$parameter->name;


		// && $parameter->getDefaultValue()
		if($parameter->isOptional()) {

			$defaultValue=$parameter->getDefaultValue();

			if(is_string($defaultValue)) {
				$parameterString.='='."'".$defaultValue."'";
			}
			else if(is_array($defaultValue)) {

				$parameterString.='='.var_export($defaultValue, true);
			}
			else {
				$parameterString.='='.$defaultValue;
			}
		}

		return $parameterString;
	}

}

