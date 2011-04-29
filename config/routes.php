<?php

Router::connect('/controle', array('plugin' => 'operadores', 'controller' => 'operadores', 'action' => 'login', 'admin' => true));

Router::connect('/admin/operadores/:action/*', array(
	'admin'      => true, 
	'prefix'     => 'admin',
	'plugin'     => 'operadores', 
	'controller' => 'operadores'
));