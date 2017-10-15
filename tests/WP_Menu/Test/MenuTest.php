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

namespace Josantonius\WP_Menu\Test;

use Josantonius\WP_Menu\WP_Menu,
    Josantonius\File\File;

/**
 * Tests class for WP_Menu library.
 * 
 * @since 1.0.4
 */
final class MenuTest extends \WP_UnitTestCase {

    /**
     * Settings to add menu or submenu.
     *
     * @since 1.0.4
     *
     * @var array
     */
    protected $params;

    /**
     * Instance of SampleClass.
     *
     * @since 1.0.4
     *
     * @var object
     */
    protected $SampleClass;

    /**
     * Setup.
     *
     * @since 1.0.4
     *
     * @uses SampleClass (Located in the tests/sample-plugin.php file)
     *
     * @return void
     */
    public function setUp() {

        parent::setUp();
        
        $adminID = $this->factory->user->create(

            ['role' => 'administrator']
        );
        
        wp_set_current_user($adminID);

        $this->SampleClass = new \SampleClass;

        $this->params = [

            'slug'       => 'plugin-options',               
            'name'       => __('Plugin Name',  'plugin-slug'),
            'title'      => __('Plugin Title', 'plugin-slug'),
            'capability' => 'manage_options',                     
            'icon_url'   => '//plugin-menu-admin.png',      
            'position'   => 25,
        ];

        add_action(

            'wp_menu/pre_add_menu_page',
            [$this->SampleClass, 'beforeAddMenu']
        );

        add_action(

            'wp_menu/after_add_menu_page',
            [$this->SampleClass, 'afterAddMenu']
        );
    }

    /**
     * Add menu without setting the name [RETURN FALSE].
     *
     * @since 1.0.4
     *
     * @return void
     */
    public function testAddMenuWithoutSettingName() {
        
        $this->assertFalse(

            WP_Menu::add('menu', [ 

                'slug' => 'plugin-options'
            ])
        );
    }

    /**
     * Add menu without setting the slug [RETURN FALSE].
     *
     * @since 1.0.4
     *
     * @return void
     */
    public function testAddMenuWithoutSettingSlug() {
        
        $this->assertFalse(

            WP_Menu::add('menu', [ 
            
                'name' => __('Plugin Name', 'plugin-slug')
            ])
        );
    }

    /**
     * Add menu without setting parameters [RETURN FALSE].
     *
     * @since 1.0.4
     *
     * @return void
     */
    public function testAddMenuWithoutSettingParameters() {
        
        $this->assertFalse(

            WP_Menu::add('menu')
        );
    }

    /**
     * Add menu with required params.
     *
     * @since 1.0.4
     *
     * @return void
     */
    public function testAddMenuWithRequiredParams() {

        set_current_screen('admin.php');

        $this->assertTrue(

            WP_Menu::add('menu', [ 

                'slug' => 'plugin-options',               
                'name' => __('Plugin Name', 'plugin-slug')
            ])
        );

        do_action('admin_menu');

        $before = 'Response from wp_menu/pre_add_menu_page action';

        $after = 'Response from wp_menu/after_add_menu_page action';

        $suffix = 'Hook suffix: load-toplevel_page_plugin-options';

        $this->expectOutputString($before . $after . $suffix);
    }

    /**
     * Add menu with required and optional params.
     *
     * @since 1.0.4
     *
     * @return void
     */
    public function testAddMenuRequiredAndOptionalParams() {

        set_current_screen('admin.php');

        $this->assertTrue(

            WP_Menu::add('menu', $this->params)
        );

        do_action('admin_menu');

        $before = 'Response from wp_menu/pre_add_menu_page action';

        $after = 'Response from wp_menu/after_add_menu_page action';

        $suffix = 'Hook suffix: load-toplevel_page_plugin-options';

        $this->expectOutputString($before . $after . $suffix);
    }

    /**
     * Add menu with associated method for output.
     *
     * @since 1.0.4
     *
     * @return void
     */
    public function testAddMenuWithOutputMethod() {

        set_current_screen('admin.php');

        $this->go_to(home_url('/') . 'wp-admin/admin.php?page=plugin-options');

        $this->assertTrue(

            WP_Menu::add(

                'menu', 
                $this->params,
                [$this->SampleClass, 'runPage']
            )
        );

        do_action('admin_menu');

        $before = 'Response from wp_menu/pre_add_menu_page action';

        $after = 'Response from wp_menu/after_add_menu_page action';

        $suffix = 'Hook suffix: load-toplevel_page_plugin-options';

        do_action('toplevel_page_plugin-options');

        $function = 'Response from runPage method';

        $this->expectOutputString($before . $after . $suffix . $function);
    }

    /**
     * Add menu with associated methods for output and styles.
     *
     * @since 1.0.4
     *
     * @return void
     */
    public function testAddMenuWithOutputAndStylesMethods() {

        set_current_screen('admin.php');
        
        $this->go_to(home_url('/') . 'wp-admin/admin.php?page=plugin-options');

        $this->assertTrue(

            WP_Menu::add(

                'menu', 
                $this->params,
                [$this->SampleClass, 'runPage'],
                [$this->SampleClass, 'addStyles']
            )
        );

        do_action('admin_menu');

        $before = 'Response from wp_menu/pre_add_menu_page action';

        $after = 'Response from wp_menu/after_add_menu_page action';

        $suffix = 'Hook suffix: load-toplevel_page_plugin-options';

        do_action('toplevel_page_plugin-options');

        $function = 'Response from runPage method';

        do_action('load-toplevel_page_plugin-options');

        $styles = 'Response from addStyles method';

        $this->expectOutputString(

            $before . $after . $suffix . $function . $styles
        );
    }

    /**
     * Add menu with associated methods for output, styles and scripts.
     *
     * @since 1.0.4
     *
     * @return void
     */
    public function testAddMenuWithOutputAndStylesAndScriptsMethods() {

        set_current_screen('admin.php');

        $this->go_to(home_url('/') . 'wp-admin/admin.php?page=plugin-options');

        $this->assertTrue(

            WP_Menu::add(

                'menu', 
                $this->params,
                [$this->SampleClass, 'runPage'],
                [$this->SampleClass, 'addStyles'],
                [$this->SampleClass, 'addScripts']
            )
        );

        do_action('admin_menu');

        $before = 'Response from wp_menu/pre_add_menu_page action';

        $after = 'Response from wp_menu/after_add_menu_page action';

        $suffix = 'Hook suffix: load-toplevel_page_plugin-options';

        do_action('toplevel_page_plugin-options');

        $function = 'Response from runPage method';

        do_action('load-toplevel_page_plugin-options');

        $styles = 'Response from addStyles method';

        $scripts = 'Response from addScripts method';

        $this->expectOutputString(

            $before . $after . $suffix . $function . $styles . $scripts
        );
    }

    /**
     * Add menu with associated methods for output and scripts.
     *
     * @since 1.0.4
     *
     * @return void
     */
    public function testAddMenuWithOutputAndScriptsMethods() {

        set_current_screen('admin.php');

        $this->go_to(home_url('/') . 'wp-admin/admin.php?page=plugin-options');

        $this->assertTrue(

            WP_Menu::add(

                'menu', 
                $this->params,
                [$this->SampleClass, 'runPage'],
                false,
                [$this->SampleClass, 'addScripts']
            )
        );

        do_action('admin_menu');

        $before = 'Response from wp_menu/pre_add_menu_page action';

        $after = 'Response from wp_menu/after_add_menu_page action';

        $suffix = 'Hook suffix: load-toplevel_page_plugin-options';

        do_action('toplevel_page_plugin-options');

        $function = 'Response from runPage method';

        do_action('load-toplevel_page_plugin-options');

        $scripts = 'Response from addScripts method';

        $this->expectOutputString(

            $before . $after . $suffix . $function . $scripts
        );
    }

    /**
     * Access the page when the user does not have access permission.
     *
     * @since 1.0.4
     *
     * @expectedException WPDieException
     *
     * @return void
     */
    public function testAddMenuWithoutAccessToPage() {

        $editorID = $this->factory->user->create(

            ['role' => 'editor']
        );
        
        wp_set_current_user($editorID);

        set_current_screen('admin.php');

        $this->assertTrue(

            WP_Menu::add('menu', $this->params)
        );

        do_action('admin_menu');
    }

    /**
     * Tear down.
     *
     * @since 1.0.4
     *
     * @return void
     */
    public function tearDown() {
    
        parent::tearDown();  
    }
}
