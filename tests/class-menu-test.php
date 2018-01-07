<?php
/**
 * Add menu or submenus in WordPress.
 *
 * @author    Josantonius - hello@josantonius.com
 * @package   Josantonius\WP_Image
 * @copyright 2017 - 2018 (c) Josantonius - WP_Menu
 * @license   https://opensource.org/licenses/MIT - The MIT License (MIT)
 * @link      https://github.com/Josantonius/WP_Menu
 * @since     1.0.4
 */

namespace Josantonius\WP_Menu\Test;

use Josantonius\WP_Menu\WP_Menu;

/**
 * Tests class for WP_Menu library.
 */
final class Menu_Test extends \WP_UnitTestCase {

	/**
	 * WP_Menu instance.
	 *
	 * @since 1.0.5
	 *
	 * @var object
	 */
	protected $wp_menu;

	/**
	 * Instance of Sample_Plugin.
	 *
	 * @var object
	 */
	protected $sample_plugin;

	/**
	 * Settings to add menu or submenu.
	 *
	 * @var array
	 */
	protected $params;

	/**
	 * Setup.
	 *
	 * @uses Sample_Plugin (Located in the tests/sample-plugin.php file)
	 */
	public function setUp() {

		parent::setUp();

		$admin_id = $this->factory->user->create(
			[ 'role' => 'administrator' ]
		);

		wp_set_current_user( $admin_id );

		$this->wp_menu = new WP_Menu();

		$this->sample_plugin = new Sample_Plugin();

		$this->params = [
			'slug'       => 'plugin-options',
			'name'       => __( 'Plugin Name', 'plugin-slug' ),
			'title'      => __( 'Plugin Title', 'plugin-slug' ),
			'capability' => 'manage_options',
			'icon_url'   => '//plugin-menu-admin.png',
			'position'   => 25,
		];

		add_action(
			'wp_menu/pre_add_menu_page',
			[ $this->sample_plugin, 'before_add_menu' ]
		);

		add_action(
			'wp_menu/after_add_menu_page',
			[ $this->sample_plugin, 'after_add_menu' ]
		);
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
	 * Add menu without setting the name [RETURN FALSE].
	 */
	public function test_add_menu_without_setting_name() {

		$menu = $this->wp_menu;

		$this->assertFalse(
			$menu::add(
				'menu', [
					'slug' => 'plugin-options',
				]
			)
		);
	}

	/**
	 * Add menu without setting the slug [RETURN FALSE].
	 */
	public function test_add_menu_without_setting_slug() {

		$menu = $this->wp_menu;

		$this->assertFalse(
			$menu::add(
				'menu', [
					'name' => __( 'Plugin Name', 'plugin-slug' ),
				]
			)
		);
	}

	/**
	 * Add menu without setting parameters [RETURN FALSE].
	 */
	public function test_add_menu_without_setting_parameters() {

		$menu = $this->wp_menu;

		$this->assertFalse(
			$menu::add( 'menu' )
		);
	}

	/**
	 * Add menu with required params.
	 */
	public function test_add_menu_with_required_params() {

		$menu = $this->wp_menu;

		set_current_screen( 'admin.php' );

		$this->assertTrue(
			$menu::add(
				'menu', [
					'slug' => 'plugin-options',
					'name' => __( 'Plugin Name', 'plugin-slug' ),
				]
			)
		);

		do_action( 'admin_menu' );

		$before = 'Response from wp_menu/pre_add_menu_page action';
		$after  = 'Response from wp_menu/after_add_menu_page action';
		$suffix = 'Hook suffix: load-toplevel_page_plugin-options';

		$this->expectOutputString( $before . $after . $suffix );
	}

	/**
	 * Add menu with required and optional params.
	 */
	public function test_add_menu_required_and_optional_params() {

		$menu = $this->wp_menu;

		set_current_screen( 'admin.php' );

		$this->assertTrue(
			$menu::add( 'menu', $this->params )
		);

		do_action( 'admin_menu' );

		$before = 'Response from wp_menu/pre_add_menu_page action';
		$after  = 'Response from wp_menu/after_add_menu_page action';
		$suffix = 'Hook suffix: load-toplevel_page_plugin-options';

		$this->expectOutputString( $before . $after . $suffix );
	}

	/**
	 * Add menu with associated method for output.
	 */
	public function test_add_menu_with_output_method() {

		$menu = $this->wp_menu;

		set_current_screen( 'admin.php' );

		$this->go_to( home_url( '/' ) . 'wp-admin/admin.php?page=plugin-options' );

		$this->assertTrue(
			$menu::add(
				'menu',
				$this->params,
				[ $this->sample_plugin, 'run_page' ]
			)
		);

		do_action( 'admin_menu' );

		$before = 'Response from wp_menu/pre_add_menu_page action';
		$after  = 'Response from wp_menu/after_add_menu_page action';
		$suffix = 'Hook suffix: load-toplevel_page_plugin-options';

		do_action( 'toplevel_page_plugin-options' );

		$function = 'Response from run_page method';

		$this->expectOutputString( $before . $after . $suffix . $function );
	}

	/**
	 * Add menu with associated methods for output and styles.
	 */
	public function test_add_menu_with_output_and_styles_methods() {

		$menu = $this->wp_menu;

		set_current_screen( 'admin.php' );

		$this->go_to( home_url( '/' ) . 'wp-admin/admin.php?page=plugin-options' );

		$this->assertTrue(
			$menu::add(
				'menu',
				$this->params,
				[ $this->sample_plugin, 'run_page' ],
				[ $this->sample_plugin, 'add_styles' ]
			)
		);

		do_action( 'admin_menu' );

		$before = 'Response from wp_menu/pre_add_menu_page action';
		$after  = 'Response from wp_menu/after_add_menu_page action';
		$suffix = 'Hook suffix: load-toplevel_page_plugin-options';

		do_action( 'toplevel_page_plugin-options' );

		$function = 'Response from run_page method';

		do_action( 'load-toplevel_page_plugin-options' );

		$styles = 'Response from add_styles method';

		$this->expectOutputString(
			$before . $after . $suffix . $function . $styles
		);
	}

	/**
	 * Add menu with associated methods for output, styles and scripts.
	 */
	public function test_add_menu_with_output_and_styles_and_scripts_methods() {

		$menu = $this->wp_menu;

		set_current_screen( 'admin.php' );

		$this->go_to( home_url( '/' ) . 'wp-admin/admin.php?page=plugin-options' );

		$this->assertTrue(
			$menu::add(
				'menu',
				$this->params,
				[ $this->sample_plugin, 'run_page' ],
				[ $this->sample_plugin, 'add_styles' ],
				[ $this->sample_plugin, 'add_scripts' ]
			)
		);

		do_action( 'admin_menu' );

		$before = 'Response from wp_menu/pre_add_menu_page action';
		$after  = 'Response from wp_menu/after_add_menu_page action';
		$suffix = 'Hook suffix: load-toplevel_page_plugin-options';

		do_action( 'toplevel_page_plugin-options' );

		$function = 'Response from run_page method';

		do_action( 'load-toplevel_page_plugin-options' );

		$styles  = 'Response from add_styles method';
		$scripts = 'Response from add_scripts method';

		$this->expectOutputString(
			$before . $after . $suffix . $function . $styles . $scripts
		);
	}

	/**
	 * Add menu with associated methods for output and scripts.
	 */
	public function test_add_menu_with_output_and_scripts_methods() {

		$menu = $this->wp_menu;

		set_current_screen( 'admin.php' );

		$this->go_to( home_url( '/' ) . 'wp-admin/admin.php?page=plugin-options' );

		$this->assertTrue(
			$menu::add(
				'menu',
				$this->params,
				[ $this->sample_plugin, 'run_page' ],
				false,
				[ $this->sample_plugin, 'add_scripts' ]
			)
		);

		do_action( 'admin_menu' );

		$before = 'Response from wp_menu/pre_add_menu_page action';
		$after  = 'Response from wp_menu/after_add_menu_page action';
		$suffix = 'Hook suffix: load-toplevel_page_plugin-options';

		do_action( 'toplevel_page_plugin-options' );

		$function = 'Response from run_page method';

		do_action( 'load-toplevel_page_plugin-options' );

		$scripts = 'Response from add_scripts method';

		$this->expectOutputString(
			$before . $after . $suffix . $function . $scripts
		);
	}

	/**
	 * Access the page when the user does not have access permission.
	 *
	 * @expectedException WPDieException
	 */
	public function test_add_menu_without_access_to_page() {

		$menu = $this->wp_menu;

		$editor_id = $this->factory->user->create(
			[ 'role' => 'editor' ]
		);

		wp_set_current_user( $editor_id );

		set_current_screen( 'admin.php' );

		$this->assertTrue(
			$menu::add( 'menu', $this->params )
		);

		do_action( 'admin_menu' );
	}

	/**
	 * Tear down.
	 */
	public function tearDown() {

		parent::tearDown();
	}
}
