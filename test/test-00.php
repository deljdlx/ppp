<?php


require(__DIR__.'/../vendor/autoload.php');




class Test
{
	public function __construct() {

	}

	public function hello() {
		echo 'hello world';
	}
}

Trait Yolo
{
	public function toto() {
		return 'toto';
	}
}


//=======================================================



$definition=new PPP\ClassDefinition();
$definition->extend('Test');

$definition->addTrait('Yolo');

$definition->addMethod('yolo', function(string $string='hello world', $test=array('toto')) {
	return $string.' '.implode(' : ', $test);
});



$instance=$definition->getInstance();



echo '<pre id="' . __FILE__ . '-' . __LINE__ . '" style="border: solid 1px rgb(255,0,0); background-color:rgb(255,255,255)">';
echo '<div style="background-color:rgba(100,100,100,1); color: rgba(255,255,255,1)">' . __FILE__ . '@' . __LINE__ . '</div>';
print_r($instance->yolo());
echo '</pre>';


if($instance instanceof Test) {
	echo '<pre id="' . __FILE__ . '-' . __LINE__ . '" style="border: solid 1px rgb(255,0,0); background-color:rgb(255,255,255)">';
	echo '<div style="background-color:rgba(100,100,100,1); color: rgba(255,255,255,1)">' . __FILE__ . '@' . __LINE__ . '</div>';
	print_r("ok instance of test");
	echo '</pre>';
}





