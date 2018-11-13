<?php

/* @var $plugin ElggPlugin */
$plugin = elgg_extract('entity', $vars);

echo elgg_view_field([
	'#type' => 'checkbox',
	'#label' => elgg_echo('breadcrumb_menu:settings:move_owner_block'),
	'#help' => elgg_echo('breadcrumb_menu:settings:move_owner_block:help'),
	'name' => 'params[move_owner_block]',
	'value' => 'yes',
	'default' => 'no',
	'checked' => $plugin->move_owner_block === 'yes',
	'switch' => true,
]);

echo elgg_view_field([
	'#type' => 'checkbox',
	'#label' => elgg_echo('breadcrumb_menu:settings:remove_last_empty_item'),
	'#help' => elgg_echo('breadcrumb_menu:settings:remove_last_empty_item:help'),
	'name' => 'params[remove_last_empty_item]',
	'value' => 'yes',
	'default' => 'no',
	'checked' => $plugin->remove_last_empty_item === 'yes',
	'switch' => true,
]);
