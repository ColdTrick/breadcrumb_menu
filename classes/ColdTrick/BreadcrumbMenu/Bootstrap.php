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
		
		$hooks->unregisterHandler('prepare', 'breadcrumbs', 'elgg_prepare_breadcrumbs');
	}
}
