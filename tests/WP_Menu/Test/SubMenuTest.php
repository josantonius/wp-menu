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
final class SubMenuTest extends \WP_UnitTestCase {

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

            'slug'       => 'sub-plugin-options',
            'parent'     => 'plugin-options',            
            'name'       => __('Plugin Name',  'plugin-slug'),
            'title'      => __('Plugin Title', 'plugin-slug'),
            'capability' => 'manage_options'
        ];

        add_action(

            'wp_menu/pre_add_submenu_page',
            [$this->SampleClass, 'beforeAddSubmenu']
        );

        add_action(

            'wp_menu/after_add_submenu_page',
            [$this->SampleClass, 'afterAddSubmenu']
        );
    }

    /**
     * Add submenu without setting the name [RETURN FALSE].
     *
     * @since 1.0.4
     *
     * @return void
     */
    public function testAddSubmenuWithoutSettingName() {
        
        $this->assertFalse(

            WP_Menu::add('submenu', [ 

                'slug'   => 'sub-plugin-options',
                'parent' => 'plugin-options',
            ])
        );
    }

    /**
     * Add submenu without setting the slug [RETURN FALSE].
     *
     * @since 1.0.4
     *
     * @return void
     */
    public function testAddSubmenuWithoutSettingSlug() {
        
        $this->assertFalse(

            WP_Menu::add('submenu', [ 
                
                'parent' => 'plugin-options',
                'name'   => __('Plugin Name', 'plugin-slug')
            ])
        );
    }

    /**
     * Add submenu without setting the parent [RETURN FALSE].
     *
     * @since 1.0.4
     *
     * @return void
     */
    public function testAddSubmenuWithoutSettingParent() {
        
        $this->assertFalse(

            WP_Menu::add('submenu', [ 
                
                'slug' => 'sub-plugin-options',
                'name' => __('Plugin Name', 'plugin-slug')
            ])
        );
    }

    /**
     * Add submenu without setting parameters [RETURN FALSE].
     *
     * @since 1.0.4
     *
     * @return void
     */
    public function testAddSubmenuWithoutSettingParameters() {
        
        $this->assertFalse(

            WP_Menu::add('submenu')
        );
    }

    /**
     * Add submenu with required params.
     *
     * @since 1.0.4
     *
     * @return void
     */
    public function testAddSubmenuWithRequiredParams() {

        set_current_screen('admin.php');

        $this->assertTrue(

            WP_Menu::add('submenu', [ 

                'slug'   => 'sub-plugin-options',
                'parent' => 'plugin-options',
                'name'   => __('Plugin Name', 'plugin-slug')
            ])
        );

        do_action('admin_menu');

        $before = 'Response from wp_menu/pre_add_submenu_page action';

        $after = 'Response from wp_menu/after_add_submenu_page action';

        $suffix = 'Hook suffix: load-plugin-name_page_sub-plugin-options';

        $this->expectOutputString($before . $after . $suffix);
    }

    /**
     * Add submenu with required and optional params.
     *
     * @since 1.0.4
     *
     * @return void
     */
    public function testAddSubmenuRequiredAndOptionalParams() {

        set_current_screen('admin.php');

        $this->assertTrue(

            WP_Menu::add('submenu', $this->params)
        );

        do_action('admin_menu');

        $before = 'Response from wp_menu/pre_add_submenu_page action';

        $after = 'Response from wp_menu/after_add_submenu_page action';

        $suffix = 'Hook suffix: load-plugin-name_page_sub-plugin-options';

        $this->expectOutputString($before . $after . $suffix);
    }

    /**
     * Add submenu with associated method for output.
     *
     * @since 1.0.4
     *
     * @return void
     */
    public function testAddSubmenuWithOutputMethod() {

        set_current_screen('admin.php');

        $this->go_to(home_url('/') . 'wp-admin/admin.php?page=plugin-options');

        $this->assertTrue(

            WP_Menu::add(

                'submenu', 
                $this->params,
                [$this->SampleClass, 'runPage']
            )
        );

        do_action('admin_menu');

        $before = 'Response from wp_menu/pre_add_submenu_page action';

        $after = 'Response from wp_menu/after_add_submenu_page action';

        $suffix = 'Hook suffix: load-plugin-name_page_sub-plugin-options';

        do_action('plugin-name_page_sub-plugin-options');

        $function = 'Response from runPage method';

        $this->expectOutputString($before . $after . $suffix . $function);
    }

    /**
     * Add submenu with associated methods for output and styles.
     *
     * @since 1.0.4
     *
     * @return void
     */
    public function testAddSubmenuWithOutputAndStylesMethods() {

        set_current_screen('admin.php');
        
        $this->go_to(home_url('/') . 'wp-admin/admin.php?page=plugin-options');

        $this->assertTrue(

            WP_Menu::add(

                'submenu', 
                $this->params,
                [$this->SampleClass, 'runPage'],
                [$this->SampleClass, 'addStyles']
            )
        );

        do_action('admin_menu');

        $before = 'Response from wp_menu/pre_add_submenu_page action';

        $after = 'Response from wp_menu/after_add_submenu_page action';

        $suffix = 'Hook suffix: load-plugin-name_page_sub-plugin-options';

        do_action('plugin-name_page_sub-plugin-options');

        $function = 'Response from runPage method';

        do_action('load-plugin-name_page_sub-plugin-options');

        $styles = 'Response from addStyles method';

        $this->expectOutputString(

            $before . $after . $suffix . $function . $styles
        );
    }

    /**
     * Add submenu with associated methods for output, styles and scripts.
     *
     * @since 1.0.4
     *
     * @return void
     */
    public function testAddSubmenuWithOutputAndStylesAndScriptsMethods() {

        set_current_screen('admin.php');

        $this->go_to(home_url('/') . 'wp-admin/admin.php?page=plugin-options');

        $this->assertTrue(

            WP_Menu::add(

                'submenu', 
                $this->params,
                [$this->SampleClass, 'runPage'],
                [$this->SampleClass, 'addStyles'],
                [$this->SampleClass, 'addScripts']
            )
        );

        do_action('admin_menu');

        $before = 'Response from wp_menu/pre_add_submenu_page action';

        $after = 'Response from wp_menu/after_add_submenu_page action';

        $suffix = 'Hook suffix: load-plugin-name_page_sub-plugin-options';

        do_action('plugin-name_page_sub-plugin-options');

        $function = 'Response from runPage method';

        do_action('load-plugin-name_page_sub-plugin-options');

        $styles = 'Response from addStyles method';

        $scripts = 'Response from addScripts method';

        $this->expectOutputString(

            $before . $after . $suffix . $function . $styles . $scripts
        );
    }

    /**
     * Add submenu with associated methods for output and scripts.
     *
     * @since 1.0.4
     *
     * @return void
     */
    public function testAddSubmenuWithOutputAndScriptsMethods() {

        set_current_screen('admin.php');

        $this->go_to(home_url('/') . 'wp-admin/admin.php?page=plugin-options');

        $this->assertTrue(

            WP_Menu::add(

                'submenu', 
                $this->params,
                [$this->SampleClass, 'runPage'],
                false,
                [$this->SampleClass, 'addScripts']
            )
        );

        do_action('admin_menu');

        $before = 'Response from wp_menu/pre_add_submenu_page action';

        $after = 'Response from wp_menu/after_add_submenu_page action';

        $suffix = 'Hook suffix: load-plugin-name_page_sub-plugin-options';

        do_action('plugin-name_page_sub-plugin-options');

        $function = 'Response from runPage method';

        do_action('load-plugin-name_page_sub-plugin-options');

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
    public function testAddSubmenuWithoutAccessToPage() {

        $editorID = $this->factory->user->create(

            ['role' => 'editor']
        );
        
        wp_set_current_user($editorID);

        set_current_screen('admin.php');

        $this->assertTrue(

            WP_Menu::add('submenu', $this->params)
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
