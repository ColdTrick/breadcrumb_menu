<?php

return [
	'plugin' => [
		'version' => '5.0',
	],
	'settings' => [
		'move_owner_block' => 'yes',
	],
	'events' => [
		'register' => [
			'menu:breadcrumbs' => [
				'ColdTrick\BreadcrumbMenu\Menus\Breadcrumbs::addOwnerBlockMenu' => [],
			],
		],
	],
];
