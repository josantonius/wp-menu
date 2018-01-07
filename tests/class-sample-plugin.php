<?php
/**
 * Add menu or submenus in WordPress.
 *
 * @author    Josantonius - hello@josantonius.com
 * @package   Josantonius\WP_Menu
 * @copyright 2017 - 2018 (c) Josantonius - WP_Menu
 * @license   https://opensource.org/licenses/MIT - The MIT License (MIT)
 * @link      https://github.com/Josantonius/WP_Menu
 * @since     1.0.4
 */

namespace Josantonius\WP_Menu\Test;

/**
 * Sample plugin class.
 */
class Sample_Plugin {

	/**
	 * Run page.
	 */
	public function run_page() {

		echo 'Response from run_page method';
	}

	/**
	 * Add styles.
	 */
	public function add_styles() {

		echo 'Response from add_styles method';
	}

	/**
	 * Add scripts.
	 */
	public function add_scripts() {

		echo 'Response from add_scripts method';
	}

	/**
	 * Before add menu.
	 */
	public function before_add_menu() {

		echo 'Response from wp_menu/pre_add_menu_page action';
	}

	/**
	 * After add menu.
	 *
	 * @param string $hook_suffix → suffix.
	 */
	public function after_add_menu( $hook_suffix ) {

		echo 'Response from wp_menu/after_add_menu_page action';

		echo 'Hook suffix: ' . $hook_suffix;
	}

	/**
	 * Before add menu.
	 */
	public function before_add_submenu() {

		echo 'Response from wp_menu/pre_add_submenu_page action';
	}

	/**
	 * After add submenu.
	 *
	 * @param string $hook_suffix → suffix.
	 */
	public function after_add_submenu( $hook_suffix ) {

		echo 'Response from wp_menu/after_add_submenu_page action';

		echo 'Hook suffix: ' . $hook_suffix;
	}
}
