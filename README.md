# PHP WordPress Menu

[![Latest Stable Version](https://poser.pugx.org/josantonius/wp-menu/v/stable)](https://packagist.org/packages/josantonius/wp-menu)
[![License](https://poser.pugx.org/josantonius/wp-menu/license)](LICENSE)

[Versión en español](README-ES.md)

Add menu or submenu page in WordPress.

---

- [Requirements](#requirements)
- [Installation](#installation)
- [Available Methods](#available-methods)
- [Quick Start](#quick-start)
- [Usage](#usage)
- [Action Hooks](#action-hooks)
- [Tests](#tests)
- [Sponsor](#Sponsor)
- [License](#license)

---

## Requirements

This library is supported by **PHP versions 5.6** or higher and is compatible with **HHVM versions 3.0** or higher.

## Installation

The preferred way to install this extension is through [Composer](http://getcomposer.org/download/).

To install **WP_Menu library**, simply:

    composer require josantonius/wp-menu

The previous command will only install the necessary files, if you prefer to **download the entire source code** you can use:

    composer require josantonius/wp-menu --prefer-source

You can also **clone the complete repository** with Git:

    git clone https://github.com/josantonius/wp-menu.git

Or **install it manually**:

[Download WP_Menu.php](https://raw.githubusercontent.com/josantonius/wp-menu/master/src/class-wp-menu.php):

    wget https://raw.githubusercontent.com/josantonius/wp-menu/master/src/class-wp-menu.php

## Available Methods

Available methods in this library:

### - Add WordPress menu/submenu

```php
WP_Menu::add($type, $data, $function, $styles, $scripts);
```

| Atttribute | Description | Type | Required | Default
| --- | --- | --- | --- | --- |
| $type | 'menu' or 'submenu' | string | Yes | |
 ---
| Atttribute | key | Description | Type | Required | Default
| --- | --- | --- | --- | --- | --- |
| $data | | Settings | array | Yes | |
|  | name | Menu/Submenu name | string | Yes | |
|  | slug | Menu/Submenu slug | string | Yes | |
|  | title | Menu/Submenu title  | string | No | $data['name'] |
|  | capability | Capability required | string | No | 'manage_options' |
|  | icon_url | **Only for menus** - The URL to the icon to be used for this menu. Pass a base64-encoded SVG using a data URI, which will be colored to match the color scheme. This should begin with 'data:image/svg+xml;base64,'. Pass the name of a Dashicons helper class to use a font icon, e.g. 'dashicons-chart-pie'. Pass 'none' to leave div.wp-menu-image empty so an icon can be added via CSS. | string | No | '' |
|  | position | **Only for menus** - The position in the menu order this one should appear. | int | No | null |
|  |parent | **Only for submenus** - The slug name for the parent menu | string | Yes | |
 ---
| Atttribute | Description | Type | Required | Default
| --- | --- | --- | --- | --- |
| $function | Function to be called to output | callable | No | false |
 ---
| Atttribute | Description | Type | Required | Default
| --- | --- | --- | --- | --- |
| $styles | Function to be called to load page styles | callable | No | false |
 ---
| Atttribute | Description | Type | Required | Default
| --- | --- | --- | --- | --- |
| $scripts | Function to be called to load page scripts | callable | No | false |

**@return** (boolean)

## Quick Start

To use this library with **Composer**:

```php
require __DIR__ . '/vendor/autoload.php';

use Josantonius\WP_Menu;
```

Or If you installed it **manually**, use it:

```php
require_once __DIR__ . '/class-wp-menu.php';

use Josantonius\WP_Menu\WP_Menu;
```

## Usage

### - Set menu params

```php
$params = [
    'slug'       => 'searchinside-options',
    'name'       => __('Search Inside', 'search-iniside'),
    'title'      => __('Search Inside', 'search-iniside'),
    'capability' => 'manage_options',
    'icon_url'   => '//searchinside-menu-admin.png',
    'position'   => 25,
];
```

### - Add menu

**Add menu without associated method.**

```php
WP_Menu::add(
    'menu', 
    $params
);
```

**Add menu with associated method for output.**

```php
WP_Menu::add(
    'menu', 
    $params,
    [$this, 'run_page']
);
```

**Add menu with associated methods for output and styles.**

```php
WP_Menu::add(
    'menu', 
    $params,
    [$instance1, 'run_page'], 
    [$instance3, 'load_styles']
);
```

**Add menu with associated methods for output, styles and scripts.**

```php
WP_Menu::add(
    'menu', 
    $params,
    [$instance1, 'run_page'], 
    [$instance3, 'load_styles'],
    [$instance3, 'load_scripts']
);
```

**Add menu with associated methods for output and scripts.**

```php
WP_Menu::add(
    'menu', 
    $params,
    [$instance1, 'run_page'], 
    false,
    [$instance3, 'load_scripts']
);
```

### - Set submenu params

```php
$params = [
    'slug'       => 'searchinside-options',
    'parent'     => 'searchinside-options',
    'name'       => __('Options', 'search-iniside'),
    'title'      => __('Options', 'search-iniside'),
    'capability' => 'manage_options',
];
```

### - Add submenu

**Add submenu without associated method:**

```php
WP_Menu::add(
    'submenu', 
    $params
);
```

**Add submenu with associated method for output.**

```php
WP_Menu::add(
    'submenu',
    $params, 
    [$this, 'run_page']
);
```

**Add submenu with associated methods for output and styles.**

```php
WP_Menu::add(
    'submenu', 
    $params, 
    [$instance1, 'run_page'], 
    [$instance3, 'load_styles']
);
```

**Add submenu with associated methods for output, styles and scripts.**

```php
WP_Menu::add(
    'submenu', 
    $params, 
    [$instance1, 'run_page'], 
    [$instance3, 'load_styles'],
    [$instance3, 'load_scripts']
);
```

**Add submenu with associated method for output and scripts.**

```php
WP_Menu::add(
    'submenu', 
    $params, 
    [$instance1, 'run_page'], 
    false,
    [$instance3, 'load_scripts']
);
```

### - Advanced example

```php
class Sample_Class {

    public function __construct() {

        add_action( 'wp_menu_pre_add_menu_page', [ $this, 'before_add_menu' ] );
        add_action( 'wp_menu_after_add_menu_page', [ $this, 'after_add_menu' ] );
        add_action( 'wp_menu_pre_add_submenu_page', [ $this, 'before_add_submenu' ] );
        add_action( 'wp_menu_after_add_submenu_page', [ $this, 'after_add_submenu' ] );
    }

    public function run_page() {

        echo 'Response from run_page method';
    }

    public function add_styles() {

        echo 'Response from add_styles method';
    }

    public function add_scripts() {

        echo 'Response from add_scripts method';
    }

    public function before_add_menu() {

        echo 'Response from wp_menu_pre_add_menu_page action';
    }

    public function after_add_menu( $hook_suffix ) {

        echo 'Response from wp_menu_after_add_menu_page action';
        echo 'Hook suffix: ' . $hook_suffix;
    }

    public function before_add_submenu() {

        echo 'Response from wp_menu_pre_add_submenu_page action';
    }

    public function after_add_submenu( $hook_suffix ) {

        echo 'Response from wp_menu_after_add_submenu_page action';
        echo 'Hook suffix: ' . $hook_suffix;
    }
}

$sample_class = new Sample_Class();

/**
 * Add menu
 */
$params = [
    'slug'       => 'plugin-options',
    'name'       => __( 'Plugin Name', 'plugin-slug' ),
    'title'      => __( 'Plugin Title', 'plugin-slug' ),
    'capability' => 'manage_options',
    'icon_url'   => '//searchinside-menu-admin.png',
    'position'   => 25,
];

WP_Menu::add(
    'menu',
    $params,
    [ $sample_class, 'run_page' ],
    [ $sample_class, 'add_styles' ],
    [ $sample_class, 'add_scripts' ]
);

/**
 * Add submenu
 */
$params = [
    'slug'       => 'sub-plugin-options',
    'parent'     => 'plugin-options',
    'name'       => __( 'Plugin Name', 'plugin-slug' ),
    'title'      => __( 'Plugin Title', 'plugin-slug' ),
    'capability' => 'manage_options',
];

WP_Menu::add(
    'submenu',
    $params,
    [ $sample_class, 'run_page' ],
    [ $sample_class, 'add_styles' ],
    [ $sample_class, 'add_scripts' ]
);

# When do_action('admin_menu');

    // Response from wp_menu_pre_add_menu_page action
    // Response from wp_menu_pre_add_submenu_page action
    
    // Response from wp_menu_after_add_menu_page action
    // Response from wp_menu_after_add_submenu_page action
    
    // Hook suffix: load-toplevel_page_plugin-options
    // Hook suffix: plugin-name_page_sub-plugin-options
    
# When do_action('toplevel_page_plugin-options');
    
    // Executed only if access the page associated with this menu.

        // Response from run_page method
    
# When do_action('plugin-name_page_sub-plugin-options');
    
    // Executed only if access the page associated with this submenu.

        // Response from run_page method

# When do_action('load-toplevel_page_plugin-options');
    
    // Executed only if access the page associated with this menu.

        // Response from add_styles method
        // Response from add_scripts method
    
# When do_action('load-plugin-name_page_sub-plugin-options');
    
    // Executed only if access the page associated with this submenu.

        // Response from add_styles method
        // Response from add_scripts method
```

## Action hooks

| Action | Description | Parameters
| --- | --- | --- |
| wp_menu_pre_add_menu_page | Before adding menu. |
| wp_menu_after_add_menu_page | After adding menu. | **$page** Resulting page's hook_suffix, or false.
| wp_menu_pre_add_submenu_page | Before adding submenu. |
| wp_menu_after_add_submenu_page | After adding submenu. | **$page** Resulting page's hook_suffix, or false.

## Tests

To run [tests](tests) you just need [composer](http://getcomposer.org/download/) and to execute the following:

    git clone https://github.com/josantonius/wp-menu.git
    
    cd WP_Menu

    bash bin/install-wp-tests.sh wordpress_test root '' localhost latest

    composer install

Run unit tests with [PHPUnit](https://phpunit.de/):

    composer phpunit

Run [WordPress](https://github.com/WordPress-Coding-Standards/WordPress-Coding-Standards/) code standard tests with [PHPCS](https://github.com/squizlabs/PHP_CodeSniffer):

    composer phpcs

Run [PHP Mess Detector](https://phpmd.org/) tests to detect inconsistencies in code style:

    composer phpmd

Run all previous tests:

    composer tests

## Sponsor

If this project helps you to reduce your development time,
[you can sponsor me](https://github.com/josantonius#sponsor) to support my open source work :blush:

## License

This repository is licensed under the [MIT License](LICENSE).

Copyright © 2017-2022, [Josantonius](https://github.com/josantonius#contact)
