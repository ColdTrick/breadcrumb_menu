<?php

return [
	'plugin' => [
		'version' => '6.0',
	],
	'events' => [
		'register' => [
			'menu:breadcrumbs' => [
				'ColdTrick\BreadcrumbMenu\Menus\Breadcrumbs::addOwnerBlockMenu' => [],
			],
		],
		'view_vars' => [
			'page/elements/owner_block' => [
				'ColdTrick\BreadcrumbMenu\Views::preventOwnerBlockMenu' => [],
			],
		],
	],
];
