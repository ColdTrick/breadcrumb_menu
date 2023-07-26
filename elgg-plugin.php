<?php

return [
	'plugin' => [
		'version' => '4.0.1',
	],
	'settings' => [
		'move_owner_block' => 'yes',
		'remove_last_self_item' => 'yes',
		'add_home_item' => 'no',
	],
	'events' => [
		'register' => [
			'menu:breadcrumbs' => [
				'ColdTrick\BreadcrumbMenu\Menus\Breadcrumbs::addOwnerBlockMenu' => [],
			],
		],
		'prepare' => [
			'menu:breadcrumbs' => [
				'ColdTrick\BreadcrumbMenu\Menus\Breadcrumbs::removeLastItem' => [],
				'ColdTrick\BreadcrumbMenu\Menus\Breadcrumbs::addHomeItem' => [],
			],
		],
	],
];
