<?php

	return [
		'mysql' => [
			'host' 		=> 'dropbox',
			'db' 		=> 'api',
			'username'	=> 'mysql',
			'password' 	=> 'mysql'
		],
		'table' => [
			'organizations' => [
				'id' 	=> 'id',
				'name' 	=> 'name',
				'pass'	=> 'password',
				'salt' 	=> 'salt',
				'token'	=> 'token'
			],
			'clients'	=> [
				'id' 		=> 'id',
				'from' 		=> 'departure',
				'to' 		=> 'arrival',
				'time' 		=> 'time',
				'accepted' 	=> 'accepted',
				'pay'		=> 'payment',
				'chat'		=> 'chat'
			],
			'access'	=> [
				'token'		=> 'token'
			]
		]
	];