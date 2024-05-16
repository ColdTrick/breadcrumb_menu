<?php

namespace ColdTrick\BreadcrumbMenu\Menus;

use Elgg\Menu\MenuItems;

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
		
		$owner_block = elgg()->menus->getUnpreparedMenu('owner_block', ['entity' => $page_owner]);
		
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
}
