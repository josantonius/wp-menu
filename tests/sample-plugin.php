<?php 
/**
 * Add menu or submenus in WordPress.
 * 
 * @author     Josantonius - hello@josantonius.com
 * @copyright  Copyright (c) 2017
 * @license    https://opensource.org/licenses/MIT - The MIT License (MIT)
 * @link       https://github.com/Josantonius/WP_Menu
 * @since      1.0.4
 */

class SampleClass {

	public function runPage() {

		echo 'Response from runPage method';
	}

	public function addStyles() {

		echo 'Response from addStyles method';
	}

	public function addScripts() {

		echo 'Response from addScripts method';
	}

	public function beforeAddMenu() {

		echo 'Response from wp_menu/pre_add_menu_page action';
	}

	public function afterAddMenu($hook_suffix) {

		echo 'Response from wp_menu/after_add_menu_page action';

		echo 'Hook suffix: ' . $hook_suffix;
	}

	public function beforeAddSubmenu() {

		echo 'Response from wp_menu/pre_add_submenu_page action';
	}

	public function afterAddSubmenu($hook_suffix) {

		echo 'Response from wp_menu/after_add_submenu_page action';

		echo 'Hook suffix: ' . $hook_suffix;
	}
}