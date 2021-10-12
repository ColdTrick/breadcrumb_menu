<?php

return [
	'plugin' => [
		'version' => '2.0.1',
	],
	'settings' => [
		'move_owner_block' => 'yes',
		'remove_last_empty_item' => 'yes',
		'remove_last_self_item' => 'yes',
		'add_home_item' => 'no',
	],
	'hooks' => [
		'register' => [
			'menu:breadcrumbs' => [
				'ColdTrick\BreadcrumbMenu\BreadcrumbsMenu::addOwnerBlockMenu' => [],
			],
		],
		'prepare' => [
			'menu:breadcrumbs' => [
				'ColdTrick\BreadcrumbMenu\BreadcrumbsMenu::removeLastItem' => [],
				'ColdTrick\BreadcrumbMenu\BreadcrumbsMenu::addHomeItem' => [],
				'ColdTrick\BreadcrumbMenu\BreadcrumbsMenu::trimBreadcrumbText' => [],
				'ColdTrick\BreadcrumbMenu\BreadcrumbsMenu::trimBreadcrumbText' => ['priority' => 9999],
			],
			'breadcrumbs' => [
				\Elgg\Page\PrepareBreadcrumbsHandler::class => ['unregister' => true],
			],
		],
	],
];
