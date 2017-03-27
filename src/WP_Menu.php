<?php 
/**
 * Add menu or submenus in WordPress.
 * 
 * @author     Josantonius - hello@josantonius.com
 * @copyright  Copyright (c) 2017
 * @license    https://opensource.org/licenses/MIT - The MIT License (MIT)
 * @link       https://github.com/Josantonius/WP_Menu
 * @since      1.0.0
 */

namespace Josantonius\WP_Menu;

/**
 * Add menu or submenus in WordPress.
 *
 * @since 1.0.0
 */
class WP_Menu {

    /**
     * Settings to add menu or submenu.
     *
     * @since 1.0.0
     *
     * @var array
     */
    protected static $data = [];

    /**
     * Add menu or submenu.
     *
     * @since 1.0.0
     *
     * @param string $type → menu | submenu
     * @param array  $data → settings
     *
     *        string  $data['name']       // (required for menu)
     *        string  $data['parent']     // (optional for submenu)
     *        string  $data['title']      // (optional)
     *        string  $data['capability'] // (optional)
     *        string  $data['slug']       // (optional)
     *        mixed   $data['function']   // (optional)
     *        string  $data['icon_url']   // (optional)
     *        int     $data['position']   // (optional)
     *
     * @return boolean
     */
    public static function add($type, $data = [], $function = '') {

        if (!isset($data['name']) || empty($data['name'])) {

            return false;
        }

        if (!isset($data['title'])) {

            $data['title'] = $data['name'];
        }

        if (!isset($data['capability'])) {

            $data['capability'] = 'manage-options';
        }

        if (!isset($data['slug'])) {

            $data['slug'] = sanitize_title($data['name']);
        }

        self::$data['capability'] = $data['capability'];

        $checkPermissions = __CLASS__ .'::checkPermissions';

        $data['function'] = empty($function) ? $checkPermissions : $function;

        $data['icon_url'] = isset($data['icon_url']) ? $data['icon_url'] : '';
        $data['position'] = isset($data['position']) ? $data['position'] : 20;

        if ($type === 'submenu') {

            $slug = self::$data['menu']['slug'];

            $data['parent'] = isset($data['parent']) ? $data['parent'] :$slug;
        }

        self::$data[$type] = $data;

        $type = ucfirst($type); 

        return add_action('admin_menu', __CLASS__ .'::add' . $type);
    }
  
    /**
     * Custom menu admin.
     *
     * @since 1.0.0
     *
     * @uses add_menu_page() → add a top-level menu page
     */
    public static function addMenu() {

         add_menu_page(
            self::$data['menu']['title'], 
            self::$data['menu']['name'], 
            self::$data['menu']['capability'], 
            self::$data['menu']['slug'], 
            self::$data['menu']['function'],
            self::$data['menu']['icon_url'], 
            self::$data['menu']['position']
        );
    }

    /**
     * Add submenu admin.
     *
     * @since 1.0.0
     *
     * @uses add_submenu_page() → add a submenu page
     *
     * @return boolean
     */
    public static function addSubmenu() {

        add_submenu_page(
            self::$data['submenu']['parent'], 
            self::$data['submenu']['title'], 
            self::$data['submenu']['name'], 
            self::$data['submenu']['capability'], 
            self::$data['submenu']['slug'], 
            self::$data['submenu']['function']
        );
    }

    /**
     * Validate permissions.
     *
     * @since 1.0.0
     *
     * @uses current_user_can() → specific capability
     * @uses wp_die()           → kill WordPress execution and show error
     */
    public static function checkPermissions() {

        if (!current_user_can(self::$data['capability'])) {

            $message = __('You don\'t have permissions to access this page.');

            wp_die($message);
        }
    }
}
