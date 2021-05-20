<?php
return [
	[
		'method' => 'GET',
		'action' => '',
		'resource' => '',
		'callback' => '\controllers\Page\dashboard'
	],
	[
		'method' => 'POST',
		'action' => 'store',
		'resource' => 'match',
		'callback' => '\controllers\Match\store'
	],
	[
		'method' => 'POST',
		'action' => 'store',
		'resource' => 'team',
		'callback' => '\controllers\Team\store'
	]
];