# PHP WordPress Menu

[![Latest Stable Version](https://poser.pugx.org/josantonius/wp_menu/v/stable)](https://packagist.org/packages/josantonius/wp_menu) [![Total Downloads](https://poser.pugx.org/josantonius/wp_menu/downloads)](https://packagist.org/packages/josantonius/wp_menu) [![Latest Unstable Version](https://poser.pugx.org/josantonius/wp_menu/v/unstable)](https://packagist.org/packages/josantonius/wp_menu) [![License](https://poser.pugx.org/josantonius/wp_menu/license)](https://packagist.org/packages/josantonius/wp_menu) [![Travis](https://travis-ci.org/Josantonius/WP_Menu.svg)](https://travis-ci.org/Josantonius/WP_Menu)

[English version](README.md)

Agregar menú o submenús en WordPress.

---

- [Instalación](#instalación)
- [Requisitos](#requisitos)
- [Cómo empezar y ejemplos](#cómo-empezar-y-ejemplos)
- [Métodos disponibles](#métodos-disponibles)
- [Uso](#uso)
- [Action Hooks](#action-hooks)
- [Tests](#tests)
- [Tareas pendientes](#-tareas-pendientes)
- [Contribuir](#contribuir)
- [Repositorio](#repositorio)
- [Licencia](#licencia)
- [Copyright](#copyright)

---

## Instalación 

La mejor forma de instalar esta extensión es a través de [composer](http://getcomposer.org/download/).

Para instalar PHP WordPress Menu library, simplemente escribe:

    $ composer require Josantonius/WP_Menu

El comando anterior sólo instalará los archivos necesarios, si prefieres descargar todo el código fuente (incluyendo tests, directorio vendor, excepciones no utilizadas, documentos...) puedes utilizar:

    $ composer require Josantonius/WP_Menu --prefer-source

También puedes clonar el repositorio completo con Git:

    $ git clone https://github.com/Josantonius/WP_Menu.git
    
## Requisitos

Esta biblioteca es soportada por versiones de PHP 5.6 o superiores y es compatible con versiones de HHVM 3.0 o superiores.

Para utilizar esta biblioteca en HHVM (HipHop Virtual Machine) tendrás que activar los tipos escalares. Añade la siguiente ĺínea "hhvm.php7.scalar_types = true" en tu "/etc/hhvm/php.ini".

## Cómo empezar y ejemplos

Para utilizar esta biblioteca, simplemente:

```php
<?php
require __DIR__ . '/vendor/autoload.php';

use Josantonius\WP_Menu\WP_Menu;
```

## Métodos disponibles

Métodos disponibles en esta biblioteca:

### add($type, $data, $function, $styles, $scripts)

Agregar menu/submenu.

| Atributo | Descripción | Tipo de dato | Requerido | Por defecto
| --- | --- | --- | --- | --- |
| $type | 'menu' o 'submenu' | string | Sí | |
 ---
| Atributo | Clave | Descripción | Tipo de dato | Requerido | Por defecto
| --- | --- | --- | --- | --- | --- |
| $data | | Configuraciones | array | Sí | |
|  | name | Nombre del menu/mubmenu | string | Sí | |
|  | slug | Slug del menu/mubmenu | string | Sí | |
|  | title | Título del menu/mubmenu  | string | No | $data['name'] |
|  | capability | Capacidad requerida | string | No | 'manage_options' |
|  | icon_url | **Solo para menús** - La URL del icono que se utilizará para este menú. SVG codificado con base64 usando un URI de datos, el cual será coloreado para que coincida con la combinación de colores. Esto debería comenzar con' data: image/svg+xml; base64,'. Nombre de una clase de estilos de Dashicons para usar un icono de fuente, por ejemplo' dashicons-chart-pie'. None para dejar div.wp-menu-image empty como icono y que pueda ser añadido vía CSS. | string | No | '' |
|  | position | **Solo para menús** - Orden en el que aparecerá el campo dentro del menú. | int | No | null |
|  |parent | **Solo para submenús** - El nombre del slug para el menú principal | string | Sí | |
 ---
| Atributo | Descripción | Tipo de dato | Requerido | Por defecto
| --- | --- | --- | --- | --- |
| $function | Función a la que se llamará para imprimir la página | callable | No | false |
 ---
| Atributo | Descripción | Tipo de dato | Requerido | Por defecto
| --- | --- | --- | --- | --- |
| $styles | Función a la que se llamará para cargar estilos | callable | No | false |
 ---
| Atributo | Descripción | Tipo de dato | Requerido | Por defecto
| --- | --- | --- | --- | --- |
| $scripts | Función a la que se llamará para cargar scripts | callable | No | false |

**@return** → Boolean

## Uso

### Ajustar parámetros del menú

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

### Agregar menú

Añadir menú sin método asociado.

```php
WP_Menu::add(
	'menu', 
	$params
);
```

Agregar menú con método asociado para la salida.

```php
WP_Menu::add(
	'menu', 
	$params,
	[$this, 'runPage']
);
```

Agregar menú con métodos de salida y estilos asociados.

```php
WP_Menu::add(
	'menu', 
	$params,
	[$instance1, 'runPage'], 
	[$instance3, 'load_styles']
);
```

Agregar menú con métodos de salida, estilos y scripts asociados.

```php
WP_Menu::add(
	'menu', 
	$params,
	[$instance1, 'runPage'], 
	[$instance3, 'load_styles'],
	[$instance3, 'load_scripts']
);
```

Agregar menú con métodos de salida y scripts asociados.

```php
WP_Menu::add(
	'menu', 
	$params,
	[$instance1, 'runPage'], 
	false,
	[$instance3, 'load_scripts']
);
```

### Ajustar parámetros de submenú

```php
$params = [
	'slug'       => 'searchinside-options',
	'parent'     => 'searchinside-options',
	'name'       => __('Options', 'search-iniside'),
	'title'      => __('Options', 'search-iniside'),
	'capability' => 'manage_options',
];
```

### Agregar submenú

Agregar submenú sin método asociado:

```php
WP_Menu::add(
	'submenu', 
	$params
);
```

Agregar submenú con método asociado para salida:

```php
WP_Menu::add(
	'submenu',
	$params, 
	[$this, 'runPage']
);
```

Agregar submenú con método asociado para salida y estilos:

```php
WP_Menu::add(
	'submenu', 
	$params, 
	[$instance1, 'runPage'], 
	[$instance3, 'load_styles']
);
```

Agregar submenú con método asociado para salida, estilos y scripts:

```php
WP_Menu::add(
	'submenu', 
	$params, 
	[$instance1, 'runPage'], 
	[$instance3, 'load_styles'],
	[$instance3, 'load_scripts']
);
```

Agregar submenú con método asociado para salida y scripts:

```php
WP_Menu::add(
	'submenu', 
	$params, 
	[$instance1, 'runPage'], 
	false,
	[$instance3, 'load_scripts']
);
```

### Ejemplo avanzado

```php
class SampleClass {

	public function __construct() {

        add_action('wp_menu/pre_add_menu_page', [$this, 'beforeAddMenu']);

        add_action('wp_menu/after_add_menu_page', [$this, 'afterAddMenu']);
 
        add_action('wp_menu/pre_add_submenu_page', [$this, 'beforeAddSubmenu']);

        add_action('wp_menu/after_add_submenu_page', [$this, 'afterAddSubmenu']);
	}
    
	public function runPage() {

		echo 'Respuesta desde el método runPage';
	}

	public function addStyles() {

		echo 'Respuesta desde el método addStyles';
	}

	public function addScripts() {

		echo 'Respuesta desde el método addScripts';
	}

	public function beforeAddMenu() {

		echo 'Respuesta desde la acción wp_menu/pre_add_menu_page';
	}

	public function afterAddMenu($hook_suffix) {

		echo 'Respuesta desde la acción wp_menu/after_add_menu_page';

		echo 'Hook suffix: ' . $hook_suffix;
	}

	public function beforeAddSubmenu() {

		echo 'Respuesta desde la acción wp_menu/pre_add_submenu_page';
	}

	public function afterAddSubmenu($hook_suffix) {

		echo 'Respuesta desde la acción wp_menu/after_add_submenu_page';

		echo 'Hook suffix: ' . $hook_suffix;
	}
}

$SampleClass = new SampleClass;

/**
 * Agregar menú
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
 * Agregar submenú
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

# Cuando se lanza do_action('admin_menu');

	// Respuesta desde la acción wp_menu/pre_add_menu_page
    // Respuesta desde la acción wp_menu/pre_add_submenu_page
    
    // Respuesta desde la acción wp_menu/after_add_menu_page
    // Respuesta desde la acción wp_menu/after_add_submenu_page
    
    // Hook suffix: load-toplevel_page_plugin-options
    // Hook suffix: plugin-name_page_sub-plugin-options
    
# Cuando se lanza do_action('toplevel_page_plugin-options');
	
    // Se ejecuta solo si se accede a la página asociada a este menú.

		// Respuesta desde el método runPage
    
# Cuando se lanza do_action('plugin-name_page_sub-plugin-options');
	
    // Se ejecuta solo si se accede a la página asociada a este submenú.

		// Respuesta desde el método runPage

# Cuando se lanza do_action('load-toplevel_page_plugin-options');
	
    // Se ejecuta solo si se accede a la página asociada a este menú.

		// Respuesta desde el método addStyles
        // Respuesta desde el método addScripts
    
# Cuando se lanza do_action('load-plugin-name_page_sub-plugin-options');
	
    // Se ejecuta solo si se accede a la página asociada a este submenú.

		// Respuesta desde el método addStyles
        // Respuesta desde el método addScripts
```

## Action hooks

| Acción | Descripción | Parameters
| --- | --- | --- |
| wp_menu/pre_add_menu_page | Antes de agregar menú. |
| wp_menu/after_add_menu_page | Después de agregar menú. | **$page** Hook_suffix de la página resultante o false.
| wp_menu/pre_add_submenu_page | Antes de agregar submenú. |
| wp_menu/after_add_submenu_page | Después de agregar submenú. | **$page** Hook_suffix de la página resultante o false.

### Tests 

Para ejecutar las [pruebas](tests/WP_Menu/Test) simplemente:

    $ git clone https://github.com/Josantonius/WP_Menu.git
    
    $ cd WP_Menu

    $ bash bin/install-wp-tests.sh wordpress_test root '' localhost latest

    $ phpunit

### ☑ Tareas pendientes

- [x] Completar tests
- [ ] Mejorar la documentación

## Contribuir

1. Comprobar si hay incidencias abiertas o abrir una nueva para iniciar una discusión en torno a un fallo o función.
1. Bifurca la rama del repositorio en GitHub para iniciar la operación de ajuste.
1. Escribe una o más pruebas para la nueva característica o expón el error.
1. Haz cambios en el código para implementar la característica o reparar el fallo.
1. Envía pull request para fusionar los cambios y que sean publicados.

Esto está pensado para proyectos grandes y de larga duración.

## Repositorio

Los archivos de este repositorio se crearon y subieron automáticamente con [Reposgit Creator](https://github.com/Josantonius/BASH-Reposgit).

## Licencia

Este proyecto está licenciado bajo **licencia MIT**. Consulta el archivo [LICENSE](LICENSE) para más información.

## Copyright

2017 Josantonius, [josantonius.com](https://josantonius.com/)

Si te ha resultado útil, házmelo saber :wink:

Puedes contactarme en [Twitter](https://twitter.com/Josantonius) o a través de mi [correo electrónico](mailto:hello@josantonius.com).
