<?php
class Operador extends OperadoresAppModel 
{
	public $name = 'Operador';
	public $useTable = 'operadores';
	
	public $validate = array(
		'nome' => array(
			'rule' => 'notEmpty'
		),
		'email' => array(
			'notEmpty' => array(
				'rule' => 'notEmpty'
			),
			'unique' => array(
				'rule' => 'isUnique',
				'message' => 'E-mail já cadastrado',
				'on' => 'create'
			),
			'email' => array(
				'rule' => 'email',
				'message' => 'Digite um e-mail valido'
			)
		),
		'senha' => array(
			'notEmpty' => array(
				'rule' => 'notEmpty'
			),
			'minLength' => array(
				'rule' => array('minLength', '6')
			),
			'confirm' => array(
				'rule' => array('equalFields', 'senha', 'confirm'),
				'message' => 'Senhas diferentes'
			)
		)
	);
	
	public function equalFields($data = null, $field1 = null, $field2 = null) 
	{
		if (isset($field1) && isset($field2) && isset($this->data[$this->alias][$field2])) 
			return $data[$field1] == $this->data[$this->alias][$field2];
		else
			return false;
	}
}