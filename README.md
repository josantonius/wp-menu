# PHP WordPress Menu

[![Latest Stable Version](https://poser.pugx.org/josantonius/wp_menu/v/stable)](https://packagist.org/packages/josantonius/wp_menu) [![Total Downloads](https://poser.pugx.org/josantonius/wp_menu/downloads)](https://packagist.org/packages/josantonius/wp_menu) [![Latest Unstable Version](https://poser.pugx.org/josantonius/wp_menu/v/unstable)](https://packagist.org/packages/josantonius/wp_menu) [![License](https://poser.pugx.org/josantonius/wp_menu/license)](https://packagist.org/packages/josantonius/wp_menu) [![Travis](https://travis-ci.org/Josantonius/WP_Menu.svg)](https://travis-ci.org/Josantonius/WP_Menu)

[Versión en español](README-ES.md)

Add menu or submenu page in WordPress.

---

- [Installation](#installation)
- [Requirements](#requirements)
- [Quick Start and Examples](#quick-start-and-examples)
- [Available Methods](#available-methods)
- [Usage](#usage)
- [Action Hooks](#action-hooks)
- [Tests](#tests)
- [TODO](#-todo)
- [Contribute](#contribute)
- [Repository](#repository)
- [License](#license)
- [Copyright](#copyright)

---

## Installation

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

To install PHP Wordpress Menu library, simply:

    $ composer require Josantonius/WP_Menu

The previous command will only install the necessary files, if you prefer to download the entire source code (including tests, vendor folder, exceptions not used, docs...) you can use:

    $ composer require Josantonius/WP_Menu --prefer-source

Or you can also clone the complete repository with Git:

    $ git clone https://github.com/Josantonius/WP_Menu.git
    
## Requirements

This library is supported by PHP versions 5.6 or higher and is compatible with HHVM versions 3.0 or higher.

To use this library in HHVM (HipHop Virtual Machine) you will have to activate the scalar types. Add the following line "hhvm.php7.scalar_types = true" in your "/etc/hhvm/php.ini".

## Quick Start and Examples

To use this class, simply:

```php
<?php
require __DIR__ . '/vendor/autoload.php';

use Josantonius\WP_Menu\WP_Menu;
```

## Available Methods

Available methods in this library:

### add($type, $data, $function, $styles, $scripts)

Add WordPress menu/submenu.

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

**@return** → Boolean

## Usage

### Set menu params

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

### Add menu

Add menu without associated method.

```php
WP_Menu::add(
	'menu', 
	$params
);
```

Add menu with associated method for output.

```php
WP_Menu::add(
	'menu', 
	$params,
	[$this, 'runPage']
);
```

Add menu with associated methods for output and styles.

```php
WP_Menu::add(
	'menu', 
	$params,
	[$instance1, 'runPage'], 
	[$instance3, 'load_styles']
);
```

Add menu with associated methods for output, styles and scripts.

```php
WP_Menu::add(
	'menu', 
	$params,
	[$instance1, 'runPage'], 
	[$instance3, 'load_styles'],
	[$instance3, 'load_scripts']
);
```

Add menu with associated methods for output and scripts.

```php
WP_Menu::add(
	'menu', 
	$params,
	[$instance1, 'runPage'], 
	false,
	[$instance3, 'load_scripts']
);
```

### Set submenu params

```php
$params = [
	'slug'       => 'searchinside-options',
	'parent'     => 'searchinside-options',
	'name'       => __('Options', 'search-iniside'),
	'title'      => __('Options', 'search-iniside'),
	'capability' => 'manage_options',
];
```

### Add submenu

Add submenu without associated method:

```php
WP_Menu::add(
	'submenu', 
	$params
);
```

Add submenu with associated method for output.

```php
WP_Menu::add(
	'submenu',
	$params, 
	[$this, 'runPage']
);
```

Add submenu with associated methods for output and styles.

```php
WP_Menu::add(
	'submenu', 
	$params, 
	[$instance1, 'runPage'], 
	[$instance3, 'load_styles']
);
```

Add submenu with associated methods for output, styles and scripts.

```php
WP_Menu::add(
	'submenu', 
	$params, 
	[$instance1, 'runPage'], 
	[$instance3, 'load_styles'],
	[$instance3, 'load_scripts']
);
```

Add submenu with associated method for output and scripts.

```php
WP_Menu::add(
	'submenu', 
	$params, 
	[$instance1, 'runPage'], 
	false,
	[$instance3, 'load_scripts']
);
```

### Advanced example

```php
class SampleClass {

	public function __construct() {

        add_action('wp_menu/pre_add_menu_page', [$this, 'beforeAddMenu']);

        add_action('wp_menu/after_add_menu_page', [$this, 'afterAddMenu']);
 
        add_action('wp_menu/pre_add_submenu_page', [$this, 'beforeAddSubmenu']);

        add_action('wp_menu/after_add_submenu_page', [$this, 'afterAddSubmenu']);
	}
    
	public function runPage() {

		echo 'Response from runPage method';
	}

	public function addStyles() {

		echo 'Response from addStyles method';
	}

	public function addScripts() {

		echo 'Response from addScripts method';
	}

	public function beforeAddMenu() {

		echo 'Response from wp_menu/pre_add_menu_page action';
	}

	public function afterAddMenu($hook_suffix) {

		echo 'Response from wp_menu/after_add_menu_page action';

		echo 'Hook suffix: ' . $hook_suffix;
	}

	public function beforeAddSubmenu() {

		echo 'Response from wp_menu/pre_add_submenu_page action';
	}

	public function afterAddSubmenu($hook_suffix) {

		echo 'Response from wp_menu/after_add_submenu_page action';

		echo 'Hook suffix: ' . $hook_suffix;
	}
}

$SampleClass = new SampleClass;

/**
 * Add menu
 */ 
$params = [
	'slug'       => 'plugin-options',
    'name'       => __('Plugin Name',  'plugin-slug'),
    'title'      => __('Plugin Title', 'plugin-slug'),
	'capability' => 'manage_options',
	'icon_url'   => '//searchinside-menu-admin.png',
	'position'   => 25,
];

WP_Menu::add(
	'menu', 
	$params,
	[$SampleClass, 'runPage'], 
	[$SampleClass, 'addStyles'],
	[$SampleClass, 'addScripts']
);

/**
 * Add submenu
 */ 
$params = [
	'slug'       => 'sub-plugin-options',
	'parent'     => 'plugin-options',
    'name'       => __('Plugin Name',  'plugin-slug'),
    'title'      => __('Plugin Title', 'plugin-slug'),
	'capability' => 'manage_options',
];

WP_Menu::add(
	'submenu', 
	$params, 
	[$SampleClass, 'runPage'], 
	[$SampleClass, 'addStyles'],
	[$SampleClass, 'addScripts']
);

# When do_action('admin_menu');

	// Response from wp_menu/pre_add_menu_page action
    // Response from wp_menu/pre_add_submenu_page action
    
    // Response from wp_menu/after_add_menu_page action
    // Response from wp_menu/after_add_submenu_page action
    
    // Hook suffix: load-toplevel_page_plugin-options
    // Hook suffix: plugin-name_page_sub-plugin-options
    
# When do_action('toplevel_page_plugin-options');
	
    // Executed only if access the page associated with this menu.

		// Response from runPage method
    
# When do_action('plugin-name_page_sub-plugin-options');
	
    // Executed only if access the page associated with this submenu.

		// Response from runPage method

# When do_action('load-toplevel_page_plugin-options');
	
    // Executed only if access the page associated with this menu.

		// Response from addStyles method
        // Response from addScripts method
    
# When do_action('load-plugin-name_page_sub-plugin-options');
	
    // Executed only if access the page associated with this submenu.

		// Response from addStyles method
        // Response from addScripts method
```

## Action hooks

| Action | Description | Parameters
| --- | --- | --- |
| wp_menu/pre_add_menu_page | Before adding menu. | 
| wp_menu/after_add_menu_page | After adding menu. | **$page** Resulting page's hook_suffix, or false.
| wp_menu/pre_add_submenu_page | Before adding submenu. | 
| wp_menu/after_add_submenu_page | After adding submenu. | **$page** Resulting page's hook_suffix, or false.

### Tests 

To run [tests](tests/WP_Menu/Test) simply:

    $ git clone https://github.com/Josantonius/WP_Menu.git
    
    $ cd WP_Menu

    $ bash bin/install-wp-tests.sh wordpress_test root '' localhost latest

    $ phpunit

### ☑ TODO

- [x] Create tests
- [x] Improve documentation

## Contribute

1. Check for open issues or open a new issue to start a discussion around a bug or feature.
1. Fork the repository on GitHub to start making your changes.
1. Write one or more tests for the new feature or that expose the bug.
1. Make code changes to implement the feature or fix the bug.
1. Send a pull request to get your changes merged and published.

This is intended for large and long-lived objects.

## Repository

All files in this repository were created and uploaded automatically with [Reposgit Creator](https://github.com/Josantonius/BASH-Reposgit).

## License

This project is licensed under **MIT license**. See the [LICENSE](LICENSE) file for more info.

## Copyright

2017 Josantonius, [josantonius.com](https://josantonius.com/)

If you find it useful, let me know :wink:

You can contact me on [Twitter](https://twitter.com/Josantonius) or through my [email](mailto:hello@josantonius.com).
