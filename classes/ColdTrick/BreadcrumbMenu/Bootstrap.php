<?php

namespace ColdTrick\BreadcrumbMenu;

use Elgg\DefaultPluginBootstrap;

class Bootstrap extends DefaultPluginBootstrap {
	
	/**
	 * {@inheritDoc}
	 */
	public function init() {
		
		// plugin hooks
		$hooks = $this->elgg()->hooks;
		$hooks->registerHandler('register', 'menu:breadcrumbs', __NAMESPACE__ . '\BreadcrumbsMenu::addOwnerBlockMenu');
		
		$hooks->registerHandler('prepare', 'menu:breadcrumbs', __NAMESPACE__ . '\BreadcrumbsMenu::removeLastItem');
		$hooks->registerHandler('prepare', 'menu:breadcrumbs', __NAMESPACE__ . '\BreadcrumbsMenu::trimBreadcrumbText');
		$hooks->registerHandler('prepare', 'menu:breadcrumbs', __NAMESPACE__ . '\BreadcrumbsMenu::addHomeItem', 9999);
		
		$hooks->unregisterHandler('prepare', 'breadcrumbs', 'elgg_prepare_breadcrumbs');
	}
}
