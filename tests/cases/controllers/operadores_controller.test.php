<?php
App::import('Controller', 'Operadores.Operadores');
App::import('Model', 'Operadores.Operador');

class TestOperadoresController extends OperadoresController
{
	public $autoRender = false;
	public $redirectUrl = null;
	
	public function redirect($url, $status = null, $exit = true) 
	{
		$this->redirectUrl = $url;
	}
	
	public function render($action = null, $layout = null, $file = null) 
	{
		$this->renderedView = $action;
	}
}

class OperadoresControllerTest extends CakeTestCase
{
	public $fixture = array('plugin.operadores.operador');
	public $Operadores = null;
	
	public function startTest() 
	{
		$this->Operadores = ClassRegistry::init('TestOperadoresController');
		$this->Operadores->params = array(
			'named' => array(),
			'url' => array()
		);
		$this->Operadores->constructClasses();
	}
	
	public function endTest() 
	{
		unset($this->Operadores);
		ClassRegistry::flush();
	}
	
	public function testTagsControllerInstance() 
	{
		$this->assertTrue(is_a($this->Operadores, 'OperadoresController'));
	}
	
}