# PPP PHP Preprocessor

Warning ! This is just a proof of concept. How to generate php class dynamicaly.


## Exemple
```php
//=======================================================
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

$instance = $definition->getInstance();

echo $instance->hello(), ' ', $instance->world();

```
