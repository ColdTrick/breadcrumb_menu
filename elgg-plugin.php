<?php

return [
	'plugin' => [
		'version' => '4.0.1',
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
