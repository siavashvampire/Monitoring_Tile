<?php
return [
	'info' => [
		'name' => rlang('headerAnnounceApp'),
		'description' => rlang('headerAnnounceDescription'),
		'version' => '1.0.0.0',
		'author' => 'erfan ebrahimi',
		'support' => 'http://erfanebrahimi.ir',
	],
	'configuration' => [
		'link' => [
			'type' => 'url',
			'status' => 'required',
			'title' => rlang('linkT'),
			'description' => '',
			'value' => '',
			'valueDe' => [
			],
		],
		'bgImage' => [
			'type' => 'url',
			'status' => 'required',
			'title' => rlang('bgImageT'),
			'description' => '',
			'value' => '',
			'valueDe' => [
			],
		],
		'title' => [
			'type' => 'text',
			'status' => 'required',
			'title' => rlang('announceT'),
			'description' => '',
			'value' => '',
			'valueDe' => [
			],
		],
		'height' => [
			'type' => 'number',
			'status' => 'required',
			'title' => rlang('heightT'),
			'description' => '',
			'value' => '',
			'valueDe' => [
			],
		]
	]
];