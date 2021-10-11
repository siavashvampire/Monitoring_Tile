<?php
return [
	'info' => [
		'name' => rlang('constructionApp'),
		'description' => rlang('constructionDescription'),
		'version' => '1.0.0.0',
		'author' => 'erfan ebrahimi',
		'support' => 'http://erfanebrahimi.ir',
	],
	'configuration' => [
		'constructionIsActive' => [
			'type' => 'select',
			'status' => 'required',
			'title' => rlang('isUnderconstruction'),
			'description' => '',
			'value' => rlang('no'),
			'valueDe' => [
				rlang('yes'),
				rlang('no'),
			],
		],
		'constructionIsActiveDebug' => [
			'type' => 'select',
			'status' => 'required',
			'title' => rlang('constructionPageDebugger'),
			'description' => '',
			'value' => rlang('requiredDontShow'),
			'valueDe' => [
				rlang('requiredDontShow'),
				rlang('systemDefault'),
			],
		],
		'constructionLink' => [
			'type' => 'url',
			'status' => 'required',
			'title' => rlang('constructionLink'),
			'description' => '',
			'value' => '',
			'valueDe' => [
			],
		],
		'constructionCookie' => [
			'type' => 'text',
			'status' => 'required',
			'title' => rlang('constructionCookie'),
			'description' => rlang('constructionCookieDescription'),
			'value' => '',
			'valueDe' => [
			],
		]
	]
];