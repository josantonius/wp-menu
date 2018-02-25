<?php
/**
 * Add menu or submenus in WordPress.
 *
 * @author    Josantonius <hello@josantonius.com>
 * @package   Josantonius\WP_Menu
 * @copyright 2017 - 2018 (c) Josantonius - WP_Menu
 * @license   https://opensource.org/licenses/MIT - The MIT License (MIT)
 * @link      https://github.com/Josantonius/WP_Menu
 * @since     1.0.0
 */

namespace Josantonius\WP_Menu;

/**
 * Add menu or submenus in WordPress.
 */
class WP_Menu {

	/**
	 * Settings to add menu or submenu.
	 *
	 * @var array
	 */
	protected static $data;

	/**
	 * Add menu or submenu.
	 *
	 * @param string $type → menu | submenu.
	 * @param array  $data → settings.
	 * @param mixed  $function → method to be called to output page content.
	 * @param mixed  $styles   → method to be called to load page styles.
	 * @param mixed  $scripts  → method to be called to load page scripts.
	 *
	 * @see https://github.com/Josantonius/WP_Menu#addtype-data-function-styles-scripts
	 *
	 * @return boolean
	 */
	public static function add( $type, $data = [], $function = 0, $styles = 0, $scripts = 0 ) {

		if ( ! is_admin() || ! self::required_params_exist( $type, $data ) ) {
			return false;
		}

		$data = self::set_params( $data, $function, $styles, $scripts );

		$slug = $data['slug'];

		self::$data[ $type ][ $slug ] = $data;

		add_action(
			'admin_menu', function() use ( $type, $slug ) {
				self::set( $type, $slug );
			}
		);

		return true;
	}

	/**
	 * Set menu/submenu parameters.
	 *
	 * @since 1.0.4
	 *
	 * @param array $data     → settings.
	 * @param mixed $function → method to be called to output page content.
	 * @param mixed $styles   → method to be called to load page styles.
	 * @param mixed $scripts  → method to be called to load page scripts.
	 *
	 * @return array parameters
	 */
	private static function set_params( $data, $function, $styles, $scripts ) {

		$params = [ 'title', 'capability', 'icon_url', 'position' ];

		foreach ( $params as $param ) {

			if ( isset( $data[ $param ] ) ) {
				continue;
			}

			switch ( $param ) {

				case 'title':
					$data[ $param ] = $data['name'];
					break;

				case 'capability':
					$data[ $param ] = 'manage_options';
					break;

				case 'icon_url':
					$data[ $param ] = '';
					break;

				case 'position':
					$data[ $param ] = null;
					break;
			}
		}

		$data['styles']  = $styles;
		$data['scripts'] = $scripts;

		$data['function'] = self::validate_method( $function ) ? $function : '';

		return $data;
	}

	/**
	 * Validate if the required parameters exist.
	 *
	 * @since 1.0.4
	 *
	 * @param string $type → menu | submenu.
	 * @param array  $data → settings.
	 *
	 * @return boolean
	 */
	private static function required_params_exist( $type, $data ) {

		$required = [ 'name', 'slug' ];

		if ( 'submenu' === $type ) {
			array_push( $required, 'parent' );
		}

		foreach ( $required as $field ) {
			if ( ! isset( $data[ $field ] ) || empty( $data[ $field ] ) ) {
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
	 * @param string $type → menu|submenu.
	 * @param string $slug → menu|submenu slug.
	 */
	private static function set( $type, $slug ) {

		global $pagenow;

		$data = self::$data[ $type ][ $slug ];

		do_action( 'wp_menu_pre_add_' . $type . '_page' );

		if ( 'menu' === $type ) {

			$page = add_menu_page(
				$data['title'],
				$data['name'],
				$data['capability'],
				$data['slug'],
				$data['function'],
				$data['icon_url'],
				$data['position']
			);

		} elseif ( 'submenu' === $type ) {

			$page = add_submenu_page(
				$data['parent'],
				$data['title'],
				$data['name'],
				$data['capability'],
				$data['slug'],
				$data['function']
			);
		}

		do_action( 'wp_menu_after_add_' . $type . '_page', 'load-' . $page );

		if ( ! $pagenow || 'admin.php' === $pagenow ) {
			self::set_action( $page, $data['styles'] );
			self::set_action( $page, $data['scripts'] );
		}
	}

	/**
	 * Check if method exists.
	 *
	 * @since 1.0.2
	 *
	 * @param array $method → [class|object, method].
	 *
	 * @return boolean
	 */
	private static function validate_method( $method ) {

		if ( $method && isset( $method[0] ) && isset( $method[1] ) ) {
			if ( method_exists( $method[0], $method[1] ) ) {
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
	 * @param string $page     → slug of the page associated with the menu.
	 * @param mixed  $function → method to be called to load styles or scripts.
	 *
	 * @return boolean
	 */
	private static function set_action( $page, $function ) {

		if ( self::validate_method( $function ) ) {
			return add_action( 'load-' . $page, $function );
		}

		return false;
	}
}
