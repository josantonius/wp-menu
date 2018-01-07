# CHANGELOG

## 1.0.5 - 2018-01-07

* Implemented `PHP Mess Detector` to detect inconsistencies in code styles.

* Implemented `PHP Code Beautifier and Fixer` to fixing errors automatically.

* Implemented `PHP Coding Standards Fixer` to organize PHP code automatically according to PSR standards.

* Implemented `WordPress PHPCS code standard` from all library PHP files.

* Implemented `Codacy` to automates code reviews and monitors code quality over time.

* Implemented `Codecov` to coverage reports.

* Deprecated `Josantonius\WP_Register\WP_Register::deleteAttachedImages()` method.

* Added `Josantonius\WP_Register\WP_Register::delete_all_attachment()` method.

## 1.0.4 - 2017-10-14

* Unit tests supported by `PHPUnit` were added.

* The repository was synchronized with `Travis CI` to implement continuous integration.

* Added `WP_Menu/src/bootstrap.php` file

* Added `WP_Menu/tests/bootstrap.php` file.
* Added `WP_Menu/tests/sample-plugin.php` file.

* Added `WP_Menu/phpunit.xml.dist` file.
* Added `WP_Menu/_config.yml` file.
* Added `WP_Menu/.travis.yml` file.

* Added `WP_Menu/bin/install-wp-tests.sh` file.

* Added `Josantonius\WP_Menu\WP_Menu::_setParams()` method.
* Added `Josantonius\WP_Menu\WP_Menu::_requiredParamsExist()` method.

* Added `Josantonius\WP_Menu\Test\FrontEndTest` class.
* Added `Josantonius\WP_Menu\Test\FrontEndTest->setUp()` method.
* Added `Josantonius\WP_Menu\Test\FrontEndTest->testAddMenuFromFrontEnd()` method.
* Added `Josantonius\WP_Menu\Test\FrontEndTest->testAddSubmenuFromFrontEnd()` method.
* Added `Josantonius\WP_Menu\Test\FrontEndTest->tearDown()` method.

* Added `Josantonius\WP_Menu\Test\MenuTest` class.
* Added `Josantonius\WP_Menu\Test\MenuTest->setUp()` method.
* Added `Josantonius\WP_Menu\Test\MenuTest->testAddMenuWithoutSettingName()` method.
* Added `Josantonius\WP_Menu\Test\MenuTest->testAddMenuWithoutSettingSlug()` method.
* Added `Josantonius\WP_Menu\Test\MenuTest->testAddMenuWithoutSettingParameters()` method.
* Added `Josantonius\WP_Menu\Test\MenuTest->testAddMenuWithRequiredParams()` method.
* Added `Josantonius\WP_Menu\Test\MenuTest->testAddMenuRequiredAndOptionalParams()` method.
* Added `Josantonius\WP_Menu\Test\MenuTest->testAddMenuWithOutputMethod()` method.
* Added `Josantonius\WP_Menu\Test\MenuTest->testAddMenuWithOutputAndStylesMethods()` method.
* Added `Josantonius\WP_Menu\Test\MenuTest->testAddMenuWithOutputAndStylesAndScriptsMethods()` method.
* Added `Josantonius\WP_Menu\Test\MenuTest->testAddMenuWithOutputAndScriptsMethods()` method.
* Added `Josantonius\WP_Menu\Test\MenuTest->testAddMenuWithoutAccessToPage()` method.
* Added `Josantonius\WP_Menu\Test\MenuTest->tearDown()` method.

* Added `Josantonius\WP_Menu\Test\SubMenuTest` class.
* Added `Josantonius\WP_Menu\Test\SubMenuTest->setUp()` method.
* Added `Josantonius\WP_Menu\Test\SubMenuTest->testAddSubmenuWithoutSettingName()` method.
* Added `Josantonius\WP_Menu\Test\SubMenuTest->testAddSubmenuWithoutSettingSlug()` method.
* Added `Josantonius\WP_Menu\Test\SubMenuTest->testAddSubmenuWithoutSettingParent()` method.
* Added `Josantonius\WP_Menu\Test\SubMenuTest->testAddSubmenuWithoutSettingParameters()` method.
* Added `Josantonius\WP_Menu\Test\SubMenuTest->testAddSubmenuWithRequiredParams()` method.
* Added `Josantonius\WP_Menu\Test\SubMenuTest->testAddSubmenuRequiredAndOptionalParams()` method.
* Added `Josantonius\WP_Menu\Test\SubMenuTest->testAddSubmenuWithOutputMethod()` method.
* Added `Josantonius\WP_Menu\Test\SubMenuTest->testAddSubmenuWithOutputAndStylesMethods()` method.
* Added `Josantonius\WP_Menu\Test\SubMenuTest->testAddSubmenuWithOutputAndStylesAndScriptsMethods()` method.
* Added `Josantonius\WP_Menu\Test\SubMenuTest->testAddSubmenuWithOutputAndScriptsMethods()` method.
* Added `Josantonius\WP_Menu\Test\SubMenuTest->testAddSubmenuWithoutAccessToPage()` method.
* Added `Josantonius\WP_Menu\Test\SubMenuTest->tearDown()` method.

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