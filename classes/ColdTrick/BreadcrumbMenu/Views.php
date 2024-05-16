<?php

namespace ColdTrick\BreadcrumbMenu;

/**
 * Various breadcrumb menu related callbacks
 */
class Views {
	
	/**
	 * Prevents the owner_block menu in the sidebar
	 *
	 * @param \Elgg\Event $event 'view_vars', 'page/elements/owner_block'
	 *
	 * @return array
	 */
	public static function preventOwnerBlockMenu(\Elgg\Event $event): array {
		$vars = $event->getValue();
		
		$vars['show_owner_block_menu'] = false;
		
		return $vars;
	}
}
