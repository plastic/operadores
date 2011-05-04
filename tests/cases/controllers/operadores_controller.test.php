<?php
App::import('Controller', 'Operadores.Operadores');
App::import('Model', 'Operadores.Operador');
App::import('Component', array('Auth', 'Cookie', 'Session'));

class TestOperadoresController extends OperadoresController
{
	public $name = 'Operadores';
	public $autoRender = false;
	public $redirectUrl = null;
	
	public function beforeFilter() 
	{
		parent::beforeFilter();
		
		$this->Auth->authorize = 'controller';
		$this->Auth->userModel = 'Operadores.Operador';
		$this->Auth->fields = array('username' => 'email', 'password' => 'senha');
		$this->Auth->loginAction = array('plugin' => 'operadores', 'controller' => 'operadores', 'action' => 'login', 'prefix' => 'admin', 'admin' => true);
		$this->Auth->loginRedirect = $this->Session->read('Auth.redirect');
		$this->Auth->logoutRedirect = '/';
		$this->Auth->authError = __d('users', 'Sorry, but you need to login to access this location.', true);
		$this->Auth->loginError = __d('users', 'Invalid e-mail / password combination. Please try again', true);
		$this->Auth->autoRedirect = true;
	}
	
	public function setCookie($options = array()) 
	{
		parent::_setCookie($options);
	}
	
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
		$this->Operadores = new TestOperadoresController();
		$this->Operadores->params = array(
			'named' => array(),
			'url' => array()
		);
		$this->Operadores->constructClasses();
		$this->Operadores->Component->initialize($this->Operadores);
	}
	
	public function endTest() 
	{
		$this->Operadores->Session->destroy();
		unset($this->Operadores);
		ClassRegistry::flush();
	}
	
	private function __setPost($data = array()) 
	{
		$_SERVER['REQUEST_METHOD'] = 'POST';
		$this->Operadores->data = am($data, array('_method' => 'POST'));
	}

	private function __setGet() 
	{
		$_SERVER['REQUEST_METHOD'] = 'GET';
	}
	
	public function prepareForAction()
	{
		$this->Operadores->beforeFilter();
		$this->Operadores->Component->startup($this->Operadores);
	}
	
	public function testTagsControllerInstance() 
	{
		$this->assertTrue(is_a($this->Operadores, 'OperadoresController'));
	}
	
	public function testLoginAction()
	{
		$this->Operadores->params['action'] = 'login';
		$this->Operadores->Component->startup($this->Operadores);

		$this->Operadores->Operador->save(array(
			'Operador' => array(
				'id' => '5',
				'nome' => 'cakephp',
				'email' => 'cakephp@cakephp.com.br',
				'senha' => Security::hash('test', null, true)
			)
		), false);
		
		$this->__setPost( array(
			'Operador' => array(
				'email' => 'cakephp@cakephp.com.br',
				'senha' => 'test'
			)
		));
		
		$this->Operadores->beforeFilter();
		
		$this->Operadores->params = array(
			'plugin' => 'operadores',
			'controller' => 'operadores',
			'action' => 'login',
			'admin' => true,
			'url' => array(
				'url' => '/operadores/operadores/login'
			)
		);
		
		$this->Operadores->Component->startup($this->Operadores);
		$this->Operadores->admin_login();
		$this->assertEqual(Router::normalize($this->Operadores->redirectUrl), Router::normalize(Router::url($this->Operadores->Auth->loginRedirect)));
	}
	
	public function testActionAdminIndex()
	{
		$this->Operadores->Session->write('Message', array('msg' => 'logado com sucesso'));
		$this->assertTrue($this->Operadores->Session->check('Message'));
		
		$this->Operadores->Session->delete('Message');
		$this->assertFalse($this->Operadores->Session->check('Message'));
	}
	
}