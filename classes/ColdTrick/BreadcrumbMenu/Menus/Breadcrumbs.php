<?php

namespace ColdTrick\BreadcrumbMenu\Menus;

use Elgg\Menu\MenuItems;
use Elgg\Menu\PreparedMenu;

/**
 * Various breadcrumb menu related callbacks
 */
class Breadcrumbs {
	
	/**
	 * Add the Owner_block menu to the breadcrumbs menu
	 *
	 * @param \Elgg\Event $event 'register', 'menu:breadcrumbs'
	 *
	 * @return null|MenuItems
	 */
	public static function addOwnerBlockMenu(\Elgg\Event $event): ?MenuItems {
		$page_owner = elgg_get_page_owner_entity();
		if (!$page_owner instanceof \ElggUser && !$page_owner instanceof \ElggGroup) {
			return null;
		}
		
		/* @var $return MenuItems */
		$return = $event->getValue();
		if (!$return->count()) {
			return null;
		}
		
		if (elgg_get_plugin_setting('move_owner_block', 'breadcrumb_menu') === 'no') {
			return null;
		}
		
		$owner_item = false;
		/* @var $menu_item \ElggMenuItem */
		foreach ($return as $menu_item) {
			$match_found = false;
			
			if ($menu_item->getHref() === $page_owner->getURL()) {
				$match_found = true;
			} elseif ($menu_item->getText() === $page_owner->getDisplayName()) {
				$match_found = true;
			}
			
			if (!$match_found) {
				continue;
			}
			
			$owner_item = $menu_item;
			break;
		}
		
		if (empty($owner_item)) {
			return null;
		}
		
		$owner_block = elgg()->menus->getUnpreparedMenu('owner_block', [
			'entity' => $page_owner,
		]);
		
		if (!$owner_block->getItems()->count()) {
			return null;
		}
		
		$owner_item->setData('child_menu', [
			'display' => 'dropdown',
			'data-position' => json_encode([
				'my' => 'left top',
				'at' => 'left bottom+8px',
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
	 * @param \Elgg\Event $event 'prepare', 'menu:breadcrumbs'
	 *
	 * @return null|PreparedMenu
	 */
	public static function removeLastItem(\Elgg\Event $event): ?PreparedMenu {
		/* @var $return PreparedMenu */
		$return = $event->getValue();
		if (!$return->count()) {
			return null;
		}
		
		/* @var $items \ElggMenuItem[] */
		$items = $return->getItems('default');
		if (empty($items)) {
			return null;
		}
		
		/* @var $last_item \ElggMenuItem */
		$last_item = end($items);
		
		$remove_last_item = false;
		
		if (!$remove_last_item && elgg_get_plugin_setting('remove_last_empty_item', 'breadcrumb_menu') === 'yes') {
			if (!$last_item->getChildren() && elgg_is_empty($last_item->getHref())) {
				$remove_last_item = true;
			}
		}
		
		if (!$remove_last_item && elgg_get_plugin_setting('remove_last_self_item', 'breadcrumb_menu') === 'yes') {
			$current_page = elgg_get_current_url();
			$menu_link = $last_item->getHref();
			
			if (!$last_item->getChildren() && elgg_http_url_is_identical($current_page, $menu_link)) {
				$remove_last_item = true;
			}
		}
		
		if (!$remove_last_item) {
			return null;
		}
		
		array_pop($items);
		
		if (!empty($items)) {
			$return->getSection('default')->fill($items);
		} else {
			$return->remove('default');
		}
		
		return $return;
	}
	
	/**
	 * Trim breadcrumb menu items to max length
	 *
	 * @param \Elgg\Event $event 'prepare', 'menu:breadcrumbs'
	 *
	 * @return PreparedMenu
	 */
	public static function trimBreadcrumbText(\Elgg\Event $event): PreparedMenu {
		/* @var $return PreparedMenu */
		$return = $event->getValue();
		
		/* @var $menu_section \Elgg\Menu\MenuSection */
		foreach ($return as $menu_section) {
			/* @var $menu_item \ElggMenuItem */
			foreach ($menu_section as $memu_item) {
				$memu_item->setText(elgg_get_excerpt($memu_item->getText(), 100));
			}
		}
		
		return $return;
	}
	
	/**
	 * Adds a home item
	 *
	 * @param \Elgg\Event $event 'prepare', 'menu:breadcrumbs'
	 *
	 * @return null|PreparedMenu
	 */
	public static function addHomeItem(\Elgg\Event $event): ?PreparedMenu {
		if (elgg_get_plugin_setting('add_home_item', 'breadcrumb_menu') === 'no') {
			return null;
		}
		
		/* @var $return PreparedMenu */
		$return = $event->getValue();

		/* @var $items \ElggMenuItem[] */
		$items = $return->getItems('default');
		if (empty($items)) {
			return null;
		}
		
		array_unshift($items, \ElggMenuItem::factory([
			'name' => 'breadcrumb_home',
			'icon' => 'home',
			'text' => false,
			'title' => elgg_echo('breadcrumb_menu:menu:home'),
			'href' => elgg_get_site_url(),
		]));
		
		$return->getSection('default')->fill($items);
		
		return $return;
	}
}
