<?php
/**
 * Add menu or submenus in WordPress.
 *
 * @author    Josantonius <hello@josantonius.com>
 * @package   Josantonius\WP_Menu
 * @copyright 2017 - 2018 (c) Josantonius - WP_Menu
 * @license   https://opensource.org/licenses/MIT - The MIT License (MIT)
 * @link      https://github.com/Josantonius/WP_Menu
 * @since     1.0.4
 */

namespace Josantonius\WP_Menu;

/**
 * Tests class for WP_Menu library.
 */
final class Front_End_Test extends \WP_UnitTestCase {

	/**
	 * WP_Menu instance.
	 *
	 * @since 1.0.5
	 *
	 * @var object
	 */
	protected $wp_menu;

	/**
	 * Setup.
	 *
	 * @uses SampleClass (Located in the tests/sample-plugin.php file)
	 */
	public function setUp() {

		parent::setUp();

		$this->wp_menu = new WP_Menu();
	}

	/**
	 * Check if it is an instance of WP_Menu.
	 *
	 * @since 1.0.5
	 */
	public function test_is_instance_of() {

		$this->assertInstanceOf(
			'Josantonius\WP_Menu\WP_Menu',
			$this->wp_menu
		);
	}

	/**
	 * Add menu from front-end [RETURN FALSE].
	 */
	public function test_add_menu_from_front_end() {

		$menu = $this->wp_menu;

		$this->assertFalse(
			$menu::add(
				'menu', [
					'slug' => 'plugin-options',
					'name' => __( 'Plugin Name', 'plugin-slug' ),
				]
			)
		);
	}

	/**
	 * Add submenu from front-end [RETURN FALSE].
	 */
	public function test_add_submenu_from_front_end() {

		$menu = $this->wp_menu;

		$this->assertFalse(
			$menu::add(
				'submenu', [
					'slug'   => 'plugin-options',
					'parent' => 'plugin-options',
					'name'   => __( 'Plugin Name', 'plugin-slug' ),
				]
			)
		);
	}

	/**
	 * Tear down.
	 */
	public function tearDown() {

		parent::tearDown();
	}
}
