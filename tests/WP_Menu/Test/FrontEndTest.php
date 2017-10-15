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
final class FrontEndTest extends \WP_UnitTestCase {

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
    }

    /**
     * Add menu from front-end [RETURN FALSE].
     *
     * @since 1.0.4
     *
     * @return void
     */
    public function testAddMenuFromFrontEnd() {
        
        $this->assertFalse(

            WP_Menu::add('menu', [ 

                'slug' => 'plugin-options',               
                'name' => __('Plugin Name', 'plugin-slug')
            ])
        );
    }

    /**
     * Add submenu from front-end [RETURN FALSE].
     *
     * @since 1.0.4
     *
     * @return void
     */
    public function testAddSubmenuFromFrontEnd() {

        $this->assertFalse(

            WP_Menu::add('submenu', [ 

                'slug'   => 'plugin-options',
                'parent' => 'plugin-options',
                'name'   => __('Plugin Name', 'plugin-slug')
            ])
        );
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
