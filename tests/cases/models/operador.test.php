<?php
App::import('Model', 'Operadores.Operador');

class TestOperador extends Operador
{
	public $name = 'TestOperador';
	public $useDbConfig = 'test';
	public $cacheSources = false;
}

class OperadorTestCase extends CakeTestCase
{
	public $fixtures = array('plugin.operadores.operador');
	
	public function startTest() 
	{
		$this->Operador = ClassRegistry::init('TestOperador');
	}

	public function endTest() 
	{
		unset($this->Operador);
		ClassRegistry::flush();
	}
	
	public function testOperadorInstance() 
	{
		$this->assertTrue(is_a($this->Operador, 'Operador'));
	}
	
	public function testOperadorFind() 
	{
		$this->Operador->recursive = -1;
		
		$results = $this->Operador->find('first', array(
			'conditions' => array('id' => 1)
		));
		
		$this->assertTrue(!empty($results));
		$this->assertNotNull($results);
		$this->assertTrue(is_array($results));
		
		$expected = array(
			'TestOperador' => array(
				'id' => 1,
				'nome' => 'mkt',
				'email' => 'mkt@mktvirtual.com.br',
				'senha' => '123456', 
				'created' => '2011-04-14 00:00:00', 
				'modified' => '2011-04-14 00:00:00'
			)
		);
		$this->assertEqual($results, $expected);
	}
	
	public function testOperadorValidation()
	{
		$this->Operador->create();
		
		$data = array(
			'nome' => null,
			'email' => 'sadfsdaf',
			'senha' => '123456',
			'confirm' => '654321'
		);
		
		$this->Operador->set($data);
		$this->assertFalse($this->Operador->validates());
		$this->Operador->save($data);
		
		$data['nome'] = 'Andre Andrade Gomes';
		$this->Operador->save($data);
		$this->assertFalse(array_key_exists('nome', $this->Operador->validationErrors));
		
		$data['email'] = 'andre@mktvirtual.com.br';
		$this->Operador->save($data);
		$this->assertTrue(array_key_exists('email', $this->Operador->validationErrors));
		
		$data['email'] = 'andre.seduc@gmail.com';
		$this->Operador->save($data);
		$this->assertFalse(array_key_exists('email', $this->Operador->validationErrors));
		
		$data['confirm'] = '123456';
		$this->asserttrue($this->Operador->save($data));
		$this->assertFalse(array_key_exists('senha', $this->Operador->validationErrors));
	}
	
	public function testOperadorUpdate()
	{
		$operador_id = 1;
		$this->Operador->id = 4587455;
		$this->assertFalse($this->Operador->exists());
		$this->assertFalse($this->Operador->read());
		
		$this->Operador->id = $operador_id;
		$this->assertTrue($this->Operador->exists());
		$this->assertTrue($this->Operador->read());
		
		$data = array(
			'TestOperador' => array(
				'id' => 1,
				'nome' => 'eeeeeee',
				'email' => 'mkt@mktvirtual.com.br',
				'senha' => '12356',
				'confirm' => '123456'
			)
		);
		
		$this->Operador->set($data);
		$this->assertFalse($this->Operador->validates());
		
		unset($data['TestOperador']['senha']);
		unset($data['TestOperador']['confirm']);
		unset($this->Operador->validate['senha']);
		
		$this->Operador->data = array();
		$this->Operador->validationErrors = array();
		
		$this->Operador->set($data);
		$this->assertTrue($this->Operador->validates());
		$this->assertTrue($this->Operador->save($data));
	}
	
	public function testMethodEqualFields()
	{
		$this->assertFalse($this->Operador->equalFields());
		
		$data = array();
		$data['senha'] = '123456';
		
		$this->Operador->data = array(
			'TestOperador' => array(
				'senha' => '123456',
				'confirm' => '123456'
			)
		);
		
		$this->assertTrue($this->Operador->equalFields($data, 'senha', 'confirm'));
	}
	
}