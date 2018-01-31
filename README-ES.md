# PHP WordPress Menu

[![Latest Stable Version](https://poser.pugx.org/josantonius/WP_Menu/v/stable)](https://packagist.org/packages/josantonius/WP_Menu) [![Latest Unstable Version](https://poser.pugx.org/josantonius/WP_Menu/v/unstable)](https://packagist.org/packages/josantonius/WP_Menu) [![License](https://poser.pugx.org/josantonius/WP_Menu/license)](LICENSE) [![Codacy Badge](https://api.codacy.com/project/badge/Grade/26d441f10c114cfdaf6c15ce74e8f316)](https://www.codacy.com/app/Josantonius/WP_Menu?utm_source=github.com&amp;utm_medium=referral&amp;utm_content=Josantonius/WP_Menu&amp;utm_campaign=Badge_Grade) [![Total Downloads](https://poser.pugx.org/josantonius/WP_Menu/downloads)](https://packagist.org/packages/josantonius/WP_Menu) [![Travis](https://travis-ci.org/Josantonius/WP_Menu.svg)](https://travis-ci.org/Josantonius/WP_Menu) [![WP](https://img.shields.io/badge/WordPress-Standar-1abc9c.svg)](https://github.com/WordPress-Coding-Standards/WordPress-Coding-Standards/) [![CodeCov](https://codecov.io/gh/Josantonius/WP_Menu/branch/master/graph/badge.svg)](https://codecov.io/gh/Josantonius/WP_Menu)

[English version](README.md)

Agregar menú o submenús en WordPress.

---

- [Requisitos](#requisitos)
- [Instalación](#instalación)
- [Métodos disponibles](#métodos-disponibles)
- [Cómo empezar](#cómo-empezar)
- [Uso](#uso)
- [Action Hooks](#action-hooks)
- [Tests](#tests)
- [Tareas pendientes](#-tareas-pendientes)
- [Contribuir](#contribuir)
- [Repositorio](#repositorio)
- [Licencia](#licencia)
- [Copyright](#copyright)

---

## Requisitos

Esta biblioteca es soportada por versiones de **PHP 5.6** o superiores y es compatible con versiones de **HHVM 3.0** o superiores.

## Instalación 

La mejor forma de instalar esta extensión es a través de [Composer](http://getcomposer.org/download/).

Para instalar **PHP WP_Menu library**, simplemente escribe:

    $ composer require Josantonius/WP_Menu

El comando anterior sólo instalará los archivos necesarios, si prefieres **descargar todo el código fuente** puedes utilizar:

    $ composer require Josantonius/WP_Menu --prefer-source

También puedes **clonar el repositorio** completo con Git:

    $ git clone https://github.com/Josantonius/WP_Menu.git

O **instalarlo manualmente**:

[Download WP_Menu.php](https://raw.githubusercontent.com/Josantonius/WP_Menu/master/src/class-wp-menu.php):

    $ wget https://raw.githubusercontent.com/Josantonius/WP_Menu/master/src/class-wp-menu.php

## Métodos disponibles

Métodos disponibles en esta biblioteca:

### - Agregar menu/submenu:

```php
WP_Menu::add($type, $data, $function, $styles, $scripts);
```

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

**@return** (boolean)

## Cómo empezar

Para utilizar esta clase con **Composer**:

```php
require __DIR__ . '/vendor/autoload.php';

use Josantonius\WP_Menu;
```

Si la instalaste **manualmente**, utiliza:

```php
require_once __DIR__ . '/class-wp-menu.php';

use Josantonius\WP_Menu\WP_Menu;
```

## Uso

### - Ajustar parámetros del menú:

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

### - Agregar menú:

**Añadir menú sin método asociado.**

```php
WP_Menu::add(
    'menu', 
    $params
);
```

**Agregar menú con método asociado para la salida.**

```php
WP_Menu::add(
    'menu', 
    $params,
    [$this, 'run_page']
);
```

**Agregar menú con métodos de salida y estilos asociados.**

```php
WP_Menu::add(
    'menu', 
    $params,
    [$instance1, 'run_page'], 
    [$instance3, 'load_styles']
);
```

**Agregar menú con métodos de salida, estilos y scripts asociados.**

```php
WP_Menu::add(
    'menu', 
    $params,
    [$instance1, 'run_page'], 
    [$instance3, 'load_styles'],
    [$instance3, 'load_scripts']
);
```

**Agregar menú con métodos de salida y scripts asociados.**

```php
WP_Menu::add(
    'menu', 
    $params,
    [$instance1, 'run_page'], 
    false,
    [$instance3, 'load_scripts']
);
```

### - Ajustar parámetros de submenú:

```php
$params = [
    'slug'       => 'searchinside-options',
    'parent'     => 'searchinside-options',
    'name'       => __('Options', 'search-iniside'),
    'title'      => __('Options', 'search-iniside'),
    'capability' => 'manage_options',
];
```

### - Agregar submenú:

**Agregar submenú sin método asociado:**

```php
WP_Menu::add(
    'submenu', 
    $params
);
```

**Agregar submenú con método asociado para salida:**

```php
WP_Menu::add(
    'submenu',
    $params, 
    [$this, 'run_page']
);
```

**Agregar submenú con método asociado para salida y estilos:**

```php
WP_Menu::add(
    'submenu', 
    $params, 
    [$instance1, 'run_page'], 
    [$instance3, 'load_styles']
);
```

**Agregar submenú con método asociado para salida, estilos y scripts:**

```php
WP_Menu::add(
    'submenu', 
    $params, 
    [$instance1, 'run_page'], 
    [$instance3, 'load_styles'],
    [$instance3, 'load_scripts']
);
```

**Agregar submenú con método asociado para salida y scripts:**

```php
WP_Menu::add(
    'submenu', 
    $params, 
    [$instance1, 'run_page'], 
    false,
    [$instance3, 'load_scripts']
);
```

### - Ejemplo avanzado:

```php
class Sample_Class {

    public function __construct() {

        add_action( 'wp_menu/pre_add_menu_page', [ $this, 'before_add_menu' ] );
        add_action( 'wp_menu/after_add_menu_page', [ $this, 'after_add_menu' ] );
        add_action( 'wp_menu/pre_add_submenu_page', [ $this, 'before_add_submenu' ] );
        add_action( 'wp_menu/after_add_submenu_page', [ $this, 'after_add_submenu' ] );
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

        echo 'Response from wp_menu/pre_add_menu_page action';
    }

    public function after_add_menu( $hook_suffix ) {

        echo 'Response from wp_menu/after_add_menu_page action';
        echo 'Hook suffix: ' . $hook_suffix;
    }

    public function before_add_submenu() {

        echo 'Response from wp_menu/pre_add_submenu_page action';
    }

    public function after_add_submenu( $hook_suffix ) {

        echo 'Response from wp_menu/after_add_submenu_page action';
        echo 'Hook suffix: ' . $hook_suffix;
    }
}

$sample_class = new Sample_Class();

/**
 * Agregar menú
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
 * Agregar submenú
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

# Cuando se lanza do_action('admin_menu');

    // Respuesta desde la acción wp_menu/pre_add_menu_page
    // Respuesta desde la acción wp_menu/pre_add_submenu_page
    
    // Respuesta desde la acción wp_menu/after_add_menu_page
    // Respuesta desde la acción wp_menu/after_add_submenu_page
    
    // Hook suffix: load-toplevel_page_plugin-options
    // Hook suffix: plugin-name_page_sub-plugin-options
    
# Cuando se lanza do_action('toplevel_page_plugin-options');
    
    // Se ejecuta solo si se accede a la página asociada a este menú.

        // Respuesta desde el método run_page
    
# Cuando se lanza do_action('plugin-name_page_sub-plugin-options');
    
    // Se ejecuta solo si se accede a la página asociada a este submenú.

        // Respuesta desde el método run_page

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

| Acción | Descripción | Parámetros
| --- | --- | --- |
| wp_menu/pre_add_menu_page | Antes de agregar menú. |
| wp_menu/after_add_menu_page | Después de agregar menú. | **$page** Hook_suffix de la página resultante o false.
| wp_menu/pre_add_submenu_page | Antes de agregar submenú. |
| wp_menu/after_add_submenu_page | Después de agregar submenú. | **$page** Hook_suffix de la página resultante o false.

## Tests 

Para ejecutar las [pruebas](tests) necesitarás [Composer](http://getcomposer.org/download/) y seguir los siguientes pasos:

    $ git clone https://github.com/Josantonius/WP_Menu.git
    
    $ cd WP_Menu

    $ composer install

Ejecutar pruebas unitarias con [PHPUnit](https://phpunit.de/):

    $ composer phpunit

Ejecutar pruebas de estándares de código para [WordPress](https://github.com/WordPress-Coding-Standards/WordPress-Coding-Standards/) con [PHPCS](https://github.com/squizlabs/PHP_CodeSniffer):

    $ composer phpcs

Ejecutar pruebas con [PHP Mess Detector](https://phpmd.org/) para detectar inconsistencias en el estilo de codificación:

    $ composer phpmd

Ejecutar todas las pruebas anteriores:

    $ composer tests

## ☑ Tareas pendientes

- [ ] Añadir nueva funcionalidad.
- [ ] Mejorar pruebas.
- [ ] Mejorar documentación.
- [ ] Crear pruebas para cuando el usuario no tiene la capacidad de acceder a una página.
- [ ] Refactorizar código para las reglas de estilo de código deshabilitadas. Ver [phpmd.xml](phpmd.xml) y [.php_cs.dist](.php_cs.dist).

## Contribuir

Si deseas colaborar, puedes echar un vistazo a la lista de
[issues](https://github.com/Josantonius/WP_Menu/issues) o [tareas pendientes](#-tareas-pendientes).

**Pull requests**

* [Fork and clone](https://help.github.com/articles/fork-a-repo).
* Ejecuta el comando `composer install` para instalar dependencias.
  Esto también instalará las [dependencias de desarrollo](https://getcomposer.org/doc/03-cli.md#install).
* Ejecuta el comando `composer fix` para estandarizar el código.
* Ejecuta las [pruebas](#tests).
* Crea una nueva rama (**branch**), **commit**, **push** y envíame un
  [pull request](https://help.github.com/articles/using-pull-requests).

## Repositorio

La estructura de archivos de este repositorio se creó con [PHP-Skeleton](https://github.com/Josantonius/PHP-Skeleton).

## Licencia

Este proyecto está licenciado bajo **licencia MIT**. Consulta el archivo [LICENSE](LICENSE) para más información.

## Copyright

2017 -2018 Josantonius, [josantonius.com](https://josantonius.com/)

Si te ha resultado útil, házmelo saber :wink:

Puedes contactarme en [Twitter](https://twitter.com/Josantonius) o a través de mi [correo electrónico](mailto:hello@josantonius.com).
