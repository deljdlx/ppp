<?php


require(__DIR__.'/../source/autoload.php');




class Test
{
	public function __construct() {

	}

	public function hello() {
		return 'hello';
	}
}

Trait World
{
	public function world() {
		return 'world';
	}
}

//=======================================================

$definition = new PPP\ClassDefinition();

$definition->extend('Test');
$definition->addTrait('World');



$definition->addMethod('say', function(string $string='hello world', $test=array('toto')) {
	return $string.' '.implode(' : ', $test);
});

$instance=$definition->getInstance();

echo "===========================================\n";
echo "Source code" . PHP_EOL;
echo $definition->getCode();
echo PHP_EOL;



echo "===========================================\n";
echo "Test hello method from class Test" . PHP_EOL;
echo $instance->hello();
echo PHP_EOL;


echo "===========================================\n";
echo "Test world method from trait World" . PHP_EOL;
echo $instance->world();
echo PHP_EOL;

echo "===========================================\n";
echo "Test hello() world()" . PHP_EOL;
echo $instance->hello(), ' ', $instance->world();
echo PHP_EOL;

echo "===========================================\n";
echo "Test say dynamic method" . PHP_EOL;
echo $instance->say('Say my name !');
echo PHP_EOL;


echo "===========================================\n";
echo "Is intance of Test ?" . PHP_EOL;
if($instance instanceof Test) {
	print_r("True instance of Test");
	echo PHP_EOL;
}

echo "===========================================\n";
echo "Is intance of World ?" . PHP_EOL;
print_r(class_uses($instance));
echo PHP_EOL;





