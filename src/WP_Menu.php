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
    protected static $data;

    /**
     * Add menu or submenu.
     *
     * @since 1.0.0
     *
     * @param string $type → menu | submenu
     * @param array  $data → settings
     *
     *        string  $data['name']       // (required)
     *        string  $data['slug']       // (required)
     *        string  $data['parent']     // (required)
     *        string  $data['title']      // (optional)
     *        string  $data['capability'] // (optional)
     *        mixed   $data['function']   // (optional)
     *        string  $data['icon_url']   // (optional)
     *        int     $data['position']   // (optional)
     *
     * @return boolean
     */
    public static function add($type, $data = [], $function = '') {

        $required = ['name', 'slug'];

        if ($type === 'submenu') { array_push($required, 'parent'); }

        foreach ($required as $field) {

            if (!isset($data[$field]) || empty($data[$field])) {

                return false;
            }
        }

        if (!isset($data['title'])) {

            $data['title'] = $data['name'];
        }

        if (!isset($data['capability'])) {

            $data['capability'] = 'manage-options';
        }
        
        $data['function'] = $function;

        $data['icon_url'] = isset($data['icon_url']) ? $data['icon_url'] : '';
        $data['position'] = isset($data['position']) ? $data['position'] : 20;
        
        self::$data[$type][$data['slug']] = $data;

        add_action('admin_menu', __CLASS__ .'::'. $type .'_'. $data['slug']);

        return true;
    }

    /**
     * Validate permissions.
     *
     * @since 1.0.0
     *
     * @uses current_user_can() → specific capability
     * @uses wp_die()           → kill WordPress execution and show error
     */
    public static function checkPermissions($capability) {

        if (!current_user_can($capability)) {

            $message = __('You don\'t have permissions to access this page.');

            wp_die($message);
        }
    }

    /**
     * Add menu and submenu admin.
     *
     * @param string $index
     * @param array  $params
     */
    public static function __callstatic($index, $params = null) {

        $index = explode('_', $index);

        $type = $index[0];
        $slug = $index[1];

        $data = self::$data[$type][$slug];

        self::checkPermissions($data['capability']);

        if ($type === 'menu') {

             add_menu_page(
                $data['title'], 
                $data['name'], 
                $data['capability'], 
                $data['slug'], 
                $data['function'],
                $data['icon_url'], 
                $data['position']
            );

        } else {

            add_submenu_page(
                $data['parent'], 
                $data['title'], 
                $data['name'], 
                $data['capability'], 
                $data['slug'], 
                $data['function']
            );
        }
    }
}
