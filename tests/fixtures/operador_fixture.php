<?php

class OperadorFixture extends CakeTestFixture
{
	public $name = 'Operador';
	public $import = array('model' => 'Operador', 'connection' => 'test');
	
	public $records = array(
		array(
			'id' => 1, 
			'nome' => 'mkt', 
			'email' => 'mkt@mktvirtual.com.br', 
			'senha' => '123456', 
			'created' => '2011-04-14 00:00:00', 
			'modified' => '2011-04-14 00:00:00'
		),
		array(
			'id' => 2, 
			'nome' => 'plastic', 
			'email' => 'plastic@mktvirtual.com.br', 
			'senha' => '123456', 
			'created' => '2011-04-14 00:00:00', 
			'modified' => '2011-04-14 00:00:00'
		),
		array(
			'id' => 3, 
			'nome' => 'andre', 
			'email' => 'andre@mktvirtual.com.br', 
			'senha' => '123456', 
			'created' => '2011-04-14 00:00:00', 
			'modified' => '2011-04-14 00:00:00'
		)
	);
	
}