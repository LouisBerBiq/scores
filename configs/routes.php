<?php
return [
	[
		'method' => 'GET',
		'action' => '',
		'resource' => '',
		'controller' => 'Dashboard',
		'callback' => 'index'
	],
	[
		'method' => 'POST',
		'action' => 'store',
		'resource' => 'match',
		'controller' => 'MatchClass',
		'callback' => 'store'
	],
	[
		'method' => 'POST',
		'action' => 'store',
		'resource' => 'team',
		'controller' => 'Team',
		'callback' => 'store'
	],
	[
		'method' => 'GET',
		'action' => 'create',
		'resource' => 'team',
		'controller' => 'Team',
		'callback' => 'create'
	],
	[
		'method' => 'GET',
		'action' => 'create',
		'resource' => 'match',
		'controller' => 'MatchClass',
		'callback' => 'create'
	],
	[
		'method' => 'GET',
		'action' => 'show',
		'resource' => 'login',
		'controller' => 'Login',
		'callback' => 'create'
	],
	[
		'method' => 'POST',
		'action' => 'check',
		'resource' => 'login',
		'controller' => 'Login',
		'callback' => 'check'
	],
];