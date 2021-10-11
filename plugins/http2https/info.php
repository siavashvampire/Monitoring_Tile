<?php
return [
	'info' => [
		'name' => rlang('http2httpsApp'),
		'description' => rlang('http2httpsDescription'),
		'version' => '1.0.0.0',
		'author' => 'erfan ebrahimi',
		'support' => 'http://erfanebrahimi.ir',
	],
	'configuration' => [
		'http2https' => [
			'type' => 'select',
			'status' => 'required',
			'title' => rlang('http2httpsT'),
			'description' => '',
			'value' => rlang('dontChange'),
			'valueDe' => [
				rlang('dontChange'),
				rlang('http2https'),
				rlang('https2http'),
			],
		],
		'www2ww' => [
			'type' => 'select',
			'status' => 'required',
			'title' => rlang('www2wwT'),
			'description' => '',
			'value' => rlang('dontChange'),
			'valueDe' => [
				rlang('dontChange'),
				rlang('www2ww'),
				rlang('ww2www'),
			],
		]
	]
];