<?php

namespace App\Core;

use App\Core\Adapters\Theme;

class Bootstrap {
	// Private Properties
	private static $menu;

	private static $horizontalMenu;

    private static $horizontalAdminMenu;

	// Private Methods
	private static function initLayout() {
		Theme::addHtmlAttribute('body', 'id', 'kt_body');

		if ( Theme::getOption('layout', 'main/body/background-image') ) {
			Theme::addHtmlAttribute('body', 'style', 'background-image: url(' . Theme::getOption('layout', 'main/body/background-image') . ')');
		}

		if ( Theme::getOption('layout', 'main/body/class')) {
			Theme::addHtmlClass('body', Theme::getOption('layout', 'main/body/class') );
		}

		if ( Theme::getOption('layout', 'main/body/attributes')) {
			Theme::addHtmlAttributes('body', Theme::getOption('layout', 'main/body/attributes') );
		}

        if ( Theme::getOption('layout', 'loader/display') === true ) {
			Theme::addHtmlClass('body', 'page-loading-enabled');
			Theme::addHtmlClass('body', 'page-loading');
		}

		//Theme::addHtmlClass('body', 'modal-open');
		if (Theme::getOption("layout", "main/type") === "default") {
			Theme::addPageJs('js/custom/widgets.js');
			Theme::addPageJs('js/custom/apps/chat/chat.js');
			Theme::addPageJs('js/custom/modals/create-app.js');
			Theme::addPageJs('js/custom/modals/upgrade-plan.js');

			if (Theme::getMode() !== 'release') {
				Theme::addPageJs('js/custom/intro.js');
			}
		}
	}

	private static function initHeader() {
        if (Theme::getOption('layout', 'header/width') == 'fluid') {
            Theme::addHtmlClass('header-container', 'container-fluid');
        } else {
            Theme::addHtmlClass('header-container', 'container');
        }

		if (Theme::getOption('layout', 'header/fixed/desktop') === true) {
			Theme::addHtmlClass('body', 'header-fixed');
		}

        if (Theme::getOption('layout', 'header/fixed/tablet-and-mobile') === true) {
			Theme::addHtmlClass('body', 'header-tablet-and-mobile-fixed');
		}
	}

	private static function initToolbar() {
		if (Theme::getOption('layout', 'toolbar/display') === false) {
			return;
		}

		Theme::addHtmlClass('body', 'toolbar-enabled');

		if (Theme::getOption('layout', 'toolbar/width') == 'fluid') {
			Theme::addHtmlClass('toolbar-container', 'container-fluid');
		} else {
			Theme::addHtmlClass('toolbar-container', 'container');
		}

		if (Theme::getOption('layout', 'toolbar/fixed/desktop') === true) {
			Theme::addHtmlClass('body', 'toolbar-fixed');
		}

		if (Theme::getOption('layout', 'toolbar/fixed/tablet-and-mobile') === true) {
			Theme::addHtmlClass('body', 'toolbar-tablet-and-mobile-fixed');
		}

		// Height setup
		$type = Theme::getOption('layout', 'toolbar/layout');
		$typeOptions = Theme::getOption('layout', 'toolbar/layouts/' . $type);

		if ($typeOptions) {
			if (isset($typeOptions['height'])) {
				Theme::addCssVariable('body', '--kt-toolbar-height', $typeOptions['height']);
			}

			if (isset($typeOptions['height-tablet-and-mobile'])) {
				Theme::addCssVariable('body', '--kt-toolbar-height-tablet-and-mobile', $typeOptions['height-tablet-and-mobile']);
			}
		}
	}

	private static function initPageTitle() {
		if (Theme::getOption('layout', 'page-title/display') === false) {
			return;
		}

		if (Theme::getOption('layout', 'page-title/direction') == 'column') {
			Theme::addHtmlClass('page-title', 'flex-column align-items-start me-3');
		} else {
			Theme::addHtmlClass('page-title', 'align-items-center flex-wrap me-3');
		}

		if (Theme::getOption('layout', 'page-title/responsive') === true) {
			Theme::addHtmlClass('page-title', 'mb-5 mb-lg-0');

			$attr = array();
			$attr['data-kt-swapper'] = 'true';
			$attr['data-kt-swapper-mode'] = 'prepend';
			$attr['data-kt-swapper-parent'] = "{default: '#kt_content_container', '" . Theme::getOption('layout', 'page-title/responsive-breakpoint') . "': '" . Theme::getOption('layout', 'page-title/responsive-target') . "'}";

			Theme::addHtmlAttributes('page-title', $attr);
		}
	}

	private static function initContent() {
		if (Theme::getOption('layout', 'content/width') == 'fluid') {
            Theme::addHtmlClass('content-container', 'container-fluid');
        } else if (Theme::getOption('layout', 'content/width') == 'fixed') {
            Theme::addHtmlClass('content-container', 'container');
        }

		if (Theme::getOption('layout', 'content/class')) {
			Theme::addHtmlClass('content', Theme::getOption('layout', 'content/class'));
		}

		if (Theme::getOption('layout', 'content/container-class')) {
			Theme::addHtmlClass('content-container', Theme::getOption('layout', 'content/container-class'));
		}
	}

	private static function initAside() {
		// Check if aside is displayed
		if (Theme::getOption('layout', 'aside/display') != true) {
			return;
		}

		Theme::addHtmlClass('body', 'aside-enabled');
		Theme::addHtmlClass('aside', 'aside-' . Theme::getOption('layout', 'aside/theme'));

		// Fixed aside
		if (Theme::getOption('layout', 'aside/fixed')) {
			Theme::addHtmlClass('body', 'aside-fixed');
		}

		// Default minimized
		if (Theme::getOption('layout', 'aside/minimized')) {
			Theme::addHtmlAttribute('body', 'data-kt-aside-minimize', 'on');
		}

		// Hoverable on minimize
		if (Theme::getOption('layout', 'aside/hoverable')) {
			Theme::addHtmlClass('aside', 'aside-hoverable');
		}
	}

	private static function initAsideMenu() {
		if (Theme::getOption('layout', 'aside/menu') === 'documentation') {
			self::$menu = new Menu( Theme::getOption('menu', 'documentation'), Theme::getPagePath() );
		} else {
			self::$menu = new Menu( Theme::getOption('menu', 'main'), Theme::getPagePath() );
		}

		if (Theme::getOption('layout', 'aside/menu-icons-display') === false) {
			self::$menu->displayIcons(false);
		}

		self::$menu->setIconType(Theme::getOption('layout', 'aside/menu-icon'));
	}

	private static function initHorizontalMenu() {
		self::$horizontalMenu = new Menu( Theme::getOption('menu', 'horizontal'), Theme::getPagePath() );
		self::$horizontalMenu->setItemLinkClass('py-3');
		self::$horizontalMenu->setIconType(Theme::getOption('layout', 'header/menu-icon'));
	}
    private static function initHorizontalAdminMenu() {
		self::$horizontalAdminMenu = new Menu( Theme::getOption('menu', 'horizontal-admin'), Theme::getPagePath() );
		self::$horizontalAdminMenu->setItemLinkClass('py-3');
		self::$horizontalAdminMenu->setIconType(Theme::getOption('layout', 'header/menu-icon'));
	}

	private static function initFooter() {
		if (Theme::getOption('layout', 'footer/width') == 'fluid') {
			Theme::addHtmlClass('footer-container', 'container-fluid');
		} else {
			Theme::addHtmlClass('footer-container', 'container');
		}
	}

	// Public Methods
	public static function run() {
		// Init layout
		self::initLayout();

		if ( Theme::getOption('layout', 'main/type') !== 'default') {
			return;
		}

		self::initHeader();
		self::initPageTitle();
		self::initToolbar();
		self::initContent();
		self::initAside();
		self::initFooter();

		self::initAsideMenu();
		self::initHorizontalMenu();
        self::initHorizontalAdminMenu();
	}

	public static function getAsideMenu() {
		return self::$menu;
	}

	public static function getHorizontalMenu() {
		return self::$horizontalMenu;
	}
    public static function getHorizontalAdminMenu() {
		return self::$horizontalAdminMenu;
	}

	public static function isDocumentationMenu() {
		return (Theme::getOption('layout', 'aside/menu') === 'documentation');
	}

	public static function getBreadcrumb() {
		$options = array(
			'skip-active' => false
		);

		if ( Bootstrap::isDocumentationMenu() ) {
			$path = Theme::getPagePath();
			$path_parts = explode("/", $path);
			$title = Util::camelize($path_parts[1], '-');

			$options['home'] = array(
				'title' => $title,
				'active' => false
			);
		}

		return Bootstrap::getAsideMenu()->getBreadcrumb($options);
	}
}
