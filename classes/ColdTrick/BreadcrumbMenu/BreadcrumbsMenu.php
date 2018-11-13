<?php

namespace ColdTrick\BreadcrumbMenu;

use Elgg\Menu\MenuItems;
use Elgg\Menu\PreparedMenu;

class BreadcrumbsMenu {
	
	/**
	 * Add the Owner_block menu to the breadcrumbs menu
	 *
	 * @param \Elgg\Hook $hook 'register', 'menu:breadcrumbs'
	 *
	 * @return void|MenuItems
	 */
	public static function addOwnerBlockMenu(\Elgg\Hook $hook) {
		
		$page_owner = elgg_get_page_owner_entity();
		if (!$page_owner instanceof \ElggUser && !$page_owner instanceof \ElggGroup) {
			return;
		}
		
		/* @var $return MenuItems */
		$return = $hook->getValue();
		if (!$return->count()) {
			return;
		}
		
		if (elgg_get_plugin_setting('move_owner_block', 'breadcrumb_menu') === 'no') {
			return;
		}
		
		$owner_item = false;
		/* @var $menu_item \ElggMenuItem */
		foreach ($return as $menu_item) {
			$match_found = false;
			
			if ($menu_item->getHref() === $page_owner->getURL()) {
				$match_found = true;
			} elseif($menu_item->getText() === $page_owner->getDisplayName()) {
				$match_found = true;
			}
			
			if (!$match_found) {
				continue;
			}
			
			$owner_item = $menu_item;
			break;
		}
		
		if (empty($owner_item)) {
			return;
		}
		
		$owner_block = elgg()->menus->getUnpreparedMenu('owner_block', [
			'entity' => $page_owner,
		]);
		if (!$owner_block->getItems()->count()) {
			return;
		}
		
		$owner_item->setData('child_menu', [
			'display' => 'dropdown',
			'data-position' => json_encode([
				'my' => 'right top',
				'at' => 'right bottom+8px',
				'collision' => 'fit fit',
			]),
		]);
		$owner_item->setName('page_owner');
		
		/* @var $menu_item \ElggMenuItem */
		foreach ($owner_block->getItems() as $menu_item) {
			$menu_item->setParentName($owner_item->getName());
			
			$return[] = $menu_item;
		}
		
		return $return;
	}
	
	/**
	 * Potentialy remove the last item from the breadcrumb menu
	 *
	 * @param \Elgg\Hook $hook 'prepare', 'menu:breadcrumbs'
	 *
	 * @return void|MenuItems
	 */
	public static function removeLastItem(\Elgg\Hook $hook) {
		
		/* @var $return PreparedMenu */
		$return = $hook->getValue();
		if (!$return->count()) {
			return;
		}
		
		/* @var $items \ElggMenuItem[] */
		$items = $return->getItems('default');
		if (empty($items)) {
			return;
		}
		
		/* @var $last_item \ElggMenuItem */
		$last_item = end($items);
		
		$remove_last_item = false;
		
		if (elgg_get_plugin_setting('remove_last_empty_item', 'breadcrumb_menu') === 'yes') {
			if (elgg_is_empty($last_item->getHref())) {
				$remove_last_item = true;
			}
		}
		
		if (!$remove_last_item) {
			return;
		}
		
		array_pop($items);
		
		$return->getSection('default')->fill($items);
		
		return $return;
	}
	
	/**
	 * Trim breadcrumb menu items to max length
	 *
	 * @param \Elgg\Hook $hook 'prepare', 'menu:breadcrumbs'
	 *
	 * @return PreparedMenu
	 */
	public static function trimBreadcrumbText(\Elgg\Hook $hook) {
		
		/* @var $return PreparedMenu */
		$return = $hook->getValue();
		
		/* @var $menu_section \Elgg\Menu\MenuSection */
		foreach ($return as $menu_section) {
			/* @var $menu_item \ElggMenuItem */
			foreach ($menu_section as $memu_item) {
				$memu_item->setText(elgg_get_excerpt($memu_item->getText(), 100));
			}
		}
		
		return $return;
	}
}
