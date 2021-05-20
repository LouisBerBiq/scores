<?php
return [
	[
		'method' => 'GET',
		'action' => '',
		'resource' => '',
		'controller' => 'page',
		'callback' => '\controllers\Page\dashboard'
	],
	[
		'method' => 'POST',
		'action' => 'store',
		'resource' => 'match',
		'controller' => 'match',
		'callback' => '\controllers\Match\store'
	],
	[
		'method' => 'POST',
		'action' => 'store',
		'resource' => 'team',
		'controller' => 'team',
		'callback' => '\controllers\Team\store'
	],
	[
		'method' => 'GET',
		'action' => 'create',
		'resource' => 'team',
		'controller' => 'team',
		'callback' => '\controllers\Team\create'
	],
	[
		'method' => 'GET',
		'action' => 'create',
		'resource' => 'match',
		'controller' => 'Match',
		'callback' => '\controllers\Match\create'
	]
];