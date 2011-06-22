<?php 
class OperadorShell extends Shell 
{
	public $uses = array('Operadores.Operador');
	
	public function main() 
	{
		App::import('Component', 'Auth');
		$this->Auth = new AuthComponent(null);
		
		$this->out('Gerador de operadores:');
		$this->hr();
		
		while (empty($username)) 
		{
			$username = $this->in('Nome:');
			if (empty($username)) 
				$this->out('Nome obrigatorio!');
		}
		
		while (empty($email)) 
		{
			$email = $this->in('E-mail:');
			if (empty($email) || !eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$", $email) ) 
				$this->out('E-mail obrigatorio!');
		}
		
		while (empty($pwd1)) 
		{
			$pwd1 = $this->in('Senha:');
			if (empty($pwd1)) 
				$this->out('Senha obrigatoria!');
		}
		
		while (empty($pwd2)) 
		{
			$pwd2 = $this->in('Confirme a senha:');
			if ($pwd1 !== $pwd2) {
				$this->out('A senha nao casou com a preenchida anteriormente!');
				$pwd2 = NULL;
			}
		}
		
		$this->Operador->create();
		
		$dados = array(
			'nome' => $username,
			'email' => $email,
			'senha' => $this->Auth->password($pwd1)
		);
		
		if ( $this->Operador->save($dados, false) ) 
			$this->out('Operador adicionado com sucesso!!!');
		else
			$this->out('Operador invalido!!!');
	}
}