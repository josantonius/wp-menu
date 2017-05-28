# CHANGELOG

## 1.0.3 - 2017-05-28

* Added the following actions hooks:

	wp_menu/pre_add_menu_page      | Before adding menu
	wp_menu/after_add_menu_page    | After adding menu.
	wp_menu/pre_add_submenu_page   | Before adding submenu
	wp_menu/after_add_submenu_page | After adding submenu.

## 1.0.2 - 2017-05-24

* Added option to indicate methods to load styles and scripts by passing them as attributes in the WP_Menu::add() method.

* Deleted `Josantonius\WP_Menu\WP_Menu::checkPermissions()` method.

* Added `Josantonius\WP_Menu\WP_Menu::_checkPermissions()` method.
* Added `Josantonius\WP_Menu\WP_Menu::_validateMethod()` method.
* Added `Josantonius\WP_Menu\WP_Menu::_setAction()` method.

## 1.0.1 - 2017-05-23

* The magic method was removed to correct the "Method does not exist" error.

* Deleted `Josantonius\WP_Menu\WP_Menu::__callstatic()` method.

* Added `Josantonius\WP_Menu\WP_Menu::_set()` method.

## 1.0.0 - 2017-03-26

* Added `Josantonius\WP_Menu\WP_Menu` class.
* Added `Josantonius\WP_Menu\WP_Menu::add()` method.
* Added `Josantonius\WP_Menu\WP_Menu::checkPermissions()` method.
* Added `Josantonius\WP_Menu\WP_Menu::__callstatic()` method.