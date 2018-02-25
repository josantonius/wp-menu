<?php
/**
 * Add menu or submenus in WordPress.
 *
 * @author    Josantonius <hello@josantonius.com>
 * @package   Josantonius\WP_Image
 * @copyright 2017 - 2018 (c) Josantonius - WP_Menu
 * @license   https://opensource.org/licenses/MIT - The MIT License (MIT)
 * @link      https://github.com/Josantonius/WP_Menu
 * @since     1.0.4
 */

namespace Josantonius\WP_Menu;

/**
 * Tests class for WP_Menu library.
 */
final class Submenu_Test extends \WP_UnitTestCase {

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
			'slug'       => 'sub-plugin-options',
			'parent'     => 'plugin-options',
			'name'       => __( 'Plugin Name', 'plugin-slug' ),
			'title'      => __( 'Plugin Title', 'plugin-slug' ),
			'capability' => 'manage_options',
		];

		add_action(
			'wp_menu_pre_add_submenu_page',
			[ $this->sample_plugin, 'before_add_submenu' ]
		);

		add_action(
			'wp_menu_after_add_submenu_page',
			[ $this->sample_plugin, 'after_add_submenu' ]
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
	 * Add submenu without setting the name [RETURN FALSE].
	 */
	public function testAddSubmenuWithoutSettingName() {

		$menu = $this->wp_menu;

		$this->assertFalse(
			$menu::add(
				'submenu', [
					'slug'   => 'sub-plugin-options',
					'parent' => 'plugin-options',
				]
			)
		);
	}

	/**
	 * Add submenu without setting the slug [RETURN FALSE].
	 */
	public function testAddSubmenuWithoutSettingSlug() {

		$menu = $this->wp_menu;

		$this->assertFalse(
			$menu::add(
				'submenu', [
					'parent' => 'plugin-options',
					'name'   => __( 'Plugin Name', 'plugin-slug' ),
				]
			)
		);
	}

	/**
	 * Add submenu without setting the parent [RETURN FALSE].
	 */
	public function testAddSubmenuWithoutSettingParent() {

		$menu = $this->wp_menu;

		$this->assertFalse(
			$menu::add(
				'submenu', [
					'slug' => 'sub-plugin-options',
					'name' => __( 'Plugin Name', 'plugin-slug' ),
				]
			)
		);
	}

	/**
	 * Add submenu without setting parameters [RETURN FALSE].
	 */
	public function testAddSubmenuWithoutSettingParameters() {

		$menu = $this->wp_menu;

		$this->assertFalse(
			$menu::add( 'submenu' )
		);
	}

	/**
	 * Add submenu with required params.
	 */
	public function testAddSubmenuWithRequiredParams() {

		$menu = $this->wp_menu;

		set_current_screen( 'admin.php' );

		$this->assertTrue(
			$menu::add(
				'submenu', [
					'slug'   => 'sub-plugin-options',
					'parent' => 'plugin-options',
					'name'   => __( 'Plugin Name', 'plugin-slug' ),
				]
			)
		);

		do_action( 'admin_menu' );

		$before = 'Response from wp_menu_pre_add_submenu_page action';
		$after  = 'Response from wp_menu_after_add_submenu_page action';
		$suffix = 'Hook suffix: load-plugin-name_page_sub-plugin-options';

		$this->expectOutputString( $before . $after . $suffix );
	}

	/**
	 * Add submenu with required and optional params.
	 */
	public function testAddSubmenuRequiredAndOptionalParams() {

		$menu = $this->wp_menu;

		set_current_screen( 'admin.php' );

		$this->assertTrue(
			$menu::add( 'submenu', $this->params )
		);

		do_action( 'admin_menu' );

		$before = 'Response from wp_menu_pre_add_submenu_page action';
		$after  = 'Response from wp_menu_after_add_submenu_page action';
		$suffix = 'Hook suffix: load-plugin-name_page_sub-plugin-options';

		$this->expectOutputString( $before . $after . $suffix );
	}

	/**
	 * Add submenu with associated method for output.
	 */
	public function testAddSubmenuWithOutputMethod() {

		$menu = $this->wp_menu;

		set_current_screen( 'admin.php' );

		$this->go_to( home_url( '/' ) . 'wp-admin/admin.php?page=plugin-options' );

		$this->assertTrue(
			$menu::add(
				'submenu',
				$this->params,
				[ $this->sample_plugin, 'run_page' ]
			)
		);

		do_action( 'admin_menu' );

		$before = 'Response from wp_menu_pre_add_submenu_page action';
		$after  = 'Response from wp_menu_after_add_submenu_page action';
		$suffix = 'Hook suffix: load-plugin-name_page_sub-plugin-options';

		do_action( 'plugin-name_page_sub-plugin-options' );

		$function = 'Response from run_page method';

		$this->expectOutputString( $before . $after . $suffix . $function );
	}

	/**
	 * Add submenu with associated methods for output and styles.
	 */
	public function testAddSubmenuWithOutputAndStylesMethods() {

		$menu = $this->wp_menu;

		set_current_screen( 'admin.php' );

		$this->go_to( home_url( '/' ) . 'wp-admin/admin.php?page=plugin-options' );

		$this->assertTrue(
			$menu::add(
				'submenu',
				$this->params,
				[ $this->sample_plugin, 'run_page' ],
				[ $this->sample_plugin, 'add_styles' ]
			)
		);

		do_action( 'admin_menu' );

		$before = 'Response from wp_menu_pre_add_submenu_page action';
		$after  = 'Response from wp_menu_after_add_submenu_page action';
		$suffix = 'Hook suffix: load-plugin-name_page_sub-plugin-options';

		do_action( 'plugin-name_page_sub-plugin-options' );

		$function = 'Response from run_page method';

		do_action( 'load-plugin-name_page_sub-plugin-options' );

		$styles = 'Response from add_styles method';

		$this->expectOutputString(
			$before . $after . $suffix . $function . $styles
		);
	}

	/**
	 * Add submenu with associated methods for output, styles and scripts.
	 */
	public function testAddSubmenuWithOutputAndStylesAndScriptsMethods() {

		$menu = $this->wp_menu;

		set_current_screen( 'admin.php' );

		$this->go_to( home_url( '/' ) . 'wp-admin/admin.php?page=plugin-options' );

		$this->assertTrue(
			$menu::add(
				'submenu',
				$this->params,
				[ $this->sample_plugin, 'run_page' ],
				[ $this->sample_plugin, 'add_styles' ],
				[ $this->sample_plugin, 'add_scripts' ]
			)
		);

		do_action( 'admin_menu' );

		$before = 'Response from wp_menu_pre_add_submenu_page action';
		$after  = 'Response from wp_menu_after_add_submenu_page action';
		$suffix = 'Hook suffix: load-plugin-name_page_sub-plugin-options';

		do_action( 'plugin-name_page_sub-plugin-options' );

		$function = 'Response from run_page method';

		do_action( 'load-plugin-name_page_sub-plugin-options' );

		$styles  = 'Response from add_styles method';
		$scripts = 'Response from add_scripts method';

		$this->expectOutputString(
			$before . $after . $suffix . $function . $styles . $scripts
		);
	}

	/**
	 * Add submenu with associated methods for output and scripts.
	 */
	public function testAddSubmenuWithOutputAndScriptsMethods() {

		$menu = $this->wp_menu;

		set_current_screen( 'admin.php' );

		$this->go_to( home_url( '/' ) . 'wp-admin/admin.php?page=plugin-options' );

		$this->assertTrue(
			$menu::add(
				'submenu',
				$this->params,
				[ $this->sample_plugin, 'run_page' ],
				false,
				[ $this->sample_plugin, 'add_scripts' ]
			)
		);

		do_action( 'admin_menu' );

		$before = 'Response from wp_menu_pre_add_submenu_page action';
		$after  = 'Response from wp_menu_after_add_submenu_page action';
		$suffix = 'Hook suffix: load-plugin-name_page_sub-plugin-options';

		do_action( 'plugin-name_page_sub-plugin-options' );

		$function = 'Response from run_page method';

		do_action( 'load-plugin-name_page_sub-plugin-options' );

		$scripts = 'Response from add_scripts method';

		$this->expectOutputString(
			$before . $after . $suffix . $function . $scripts
		);
	}

	/**
	 * Tear down.
	 */
	public function tearDown() {

		parent::tearDown();
	}
}
