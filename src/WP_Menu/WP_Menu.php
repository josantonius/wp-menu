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
     *        string $data['name']       // (required)
     *        string $data['slug']       // (required)
     *        string $data['parent']     // (required)
     *        string $data['title']      // (optional)
     *        string $data['capability'] // (optional)
     *        mixed  $data['function']   // (optional)
     *        string $data['icon_url']   // (optional)
     *        int    $data['position']   // (optional)
     *
     * @param mixed $function → method to be called to output page content
     * @param mixed $styles   → method to be called to load page styles
     * @param mixed $scripts  → method to be called to load page scripts
     *
     * @return boolean
     */
    static function add($type, $data=[], $function=0, $styles=0, $scripts=0) {

        if (!is_admin() || !self::_requiredParamsExist($type, $data)) {

            return false;
        }

        $data = self::_setParams($data, $function, $styles, $scripts);

        $slug = $data['slug'];

        self::$data[$type][$slug] = $data;

        add_action('admin_menu', function() use ($type, $slug) {
            
            self::_set($type, $slug);
        });

        return true;
    }

    /**
     * Set menu/submenu parameters.
     *
     * @since 1.0.4
     *
     * @param array $data     → settings
     * @param mixed $function → method to be called to output page content
     * @param mixed $styles   → method to be called to load page styles
     * @param mixed $scripts  → method to be called to load page scripts
     *
     * @return array parameters
     */
    private static function _setParams($data, $function, $styles, $scripts) {

        $params = ['title', 'capability', 'icon_url', 'position'];

        foreach ($params as $param) {

            if (isset($data[$param])) { continue; }

            switch ($param) {

                case 'title':
                    $data[$param] = $data['name'];
                    break;

                case 'capability':
                    $data[$param] = 'manage_options';
                    break;

                case 'icon_url':
                    $data[$param] = '';
                    break;

                case 'position':
                    $data[$param] = null;
                    break;
            }
        }

        $data['styles']  = $styles;
        $data['scripts'] = $scripts;

        $data['function'] = self::_validateMethod($function) ? $function : '';

        return $data;
    }

    /**
     * Validate if the required parameters exist.
     *
     * @since 1.0.4
     *
     * @param string $type → menu | submenu
     * @param array  $data → settings
     *
     * @return boolean
     */
    private static function _requiredParamsExist($type, $data) {

        $required = ['name', 'slug'];

        if ($type === 'submenu') { 

            array_push($required, 'parent'); 
        }

        foreach ($required as $field) {

            if (!isset($data[$field]) || empty($data[$field])) {

                return false;
            }
        }

        return true;
    }

    /**
     * Set menu and submenu admin.
     *
     * @since 1.0.1
     *
     * @param string $type → menu|submenu
     * @param string $slug → menu|submenu slug
     *
     * @return void
     */
    private static function _set($type, $slug) {

        global $pagenow;

        $data = self::$data[$type][$slug];

        self::_checkPermissions($data['capability']);

        do_action('wp_menu/pre_add_' . $type . '_page');

        if ($type === 'menu') {

            $page = add_menu_page(
                $data['title'], 
                $data['name'], 
                $data['capability'], 
                $data['slug'], 
                $data['function'],
                $data['icon_url'], 
                $data['position']
            );

        } else {

            $page = add_submenu_page(
                $data['parent'], 
                $data['title'], 
                $data['name'], 
                $data['capability'], 
                $data['slug'], 
                $data['function']
            );
        }

        do_action('wp_menu/after_add_' . $type . '_page', 'load-' . $page);
        
        if (!$pagenow || $pagenow === 'admin.php') {

            self::_setAction($page, $data['styles']);
            self::_setAction($page, $data['scripts']);
        }
    }

    /**
     * Validate permissions.
     *
     * @since 1.0.2
     *
     * @uses current_user_can() → specific capability
     * @uses wp_die()           → kill WordPress execution and show error
     *
     * @return void
     */
    private static function _checkPermissions($capability) {

        if (!current_user_can($capability)) {

            $message = __('You don\'t have permissions to access this page.');

            wp_die($message);
        }
    }

    /**
     * Check if method exists.
     *
     * @since 1.0.2
     *
     * @param array $method → [class|object, method]
     *
     * @return boolean
     */
    private static function _validateMethod($method) {

        if ($method && isset($method[0]) && isset($method[1])) {

            if (method_exists($method[0], $method[1])) {

                return true;
            }
        } 

        return false;
    }

    /**
     * Add actions to load styles and scripts.
     * 
     * This will be executed only when loading this page.
     *
     * @since 1.0.2
     *
     * @param string $page     → slug of the page associated with the menu
     * @param mixed  $function → method to be called to load styles or scripts
     *
     * @return boolean
     */
    private static function _setAction($page, $function) {

        if (self::_validateMethod($function)) {

            return add_action('load-' . $page, $function);
        }

        return false;
    }
}
