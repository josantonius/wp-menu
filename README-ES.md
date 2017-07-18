# PHP WordPress Menu

[![Latest Stable Version](https://poser.pugx.org/josantonius/wp_menu/v/stable)](https://packagist.org/packages/josantonius/wp_menu) [![Total Downloads](https://poser.pugx.org/josantonius/wp_menu/downloads)](https://packagist.org/packages/josantonius/wp_menu) [![Latest Unstable Version](https://poser.pugx.org/josantonius/wp_menu/v/unstable)](https://packagist.org/packages/josantonius/wp_menu) [![License](https://poser.pugx.org/josantonius/wp_menu/license)](https://packagist.org/packages/josantonius/wp_menu)

[English version](README.md)

Agregar menú o submenús en WordPress.

---

- [Instalación](#instalación)
- [Requisitos](#requisitos)
- [Cómo empezar y ejemplos](#cómo-empezar-y-ejemplos)
- [Uso](#uso)
- [Action Hooks](#action-hooks)
- [TODO](#-todo)
- [Contribuir](#contribuir)
- [Repositorio](#repositorio)
- [Licencia](#licencia)
- [Copyright](#copyright)

---

<p align="center"><strong>Echa un vistazo al código</strong></p>

<p align="center">
  <a href="https://youtu.be/b8o5cW6AjQo" title="Echa un vistazo al código">
  	<img src="https://raw.githubusercontent.com/Josantonius/PHP-Algorithm/master/resources/youtube-thumbnail.jpg">
  </a>
</p>

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

### Establecer parámetros para menú

```php
$params = [
	'slug'       => 'searchinside-options',                // Required
	'name'       => __('Search Inside', 'search-iniside'), // Required
	'title'      => __('Search Inside', 'search-iniside'), // Optional
	'capability' => 'manage_options',                      // Optional
	'icon_url'   => '//searchinside-menu-admin.png',       // Optional
	'position'   => 25,                                    // Optional
];
```

### Agregar menú

Agregar menú sin método asociado a la salida de la página.
```php
WP_Menu::add(
	'menu', 
	$params
);
```

Agregar menú con el método a ejecutar en la salida de la página. Si no se indican métodos para cargar scripts y estilos y existen los métodos "addStyles" y "addScripts" en la instancia ($this en este caso) se cargarán de forma predeterminada.
```php
WP_Menu::add(
	'menu', 
	$params,
	[$this, 'runPage']
);
```

Agregar menú con el método a ejecutar en la salida de la página y métodos asociados para la carga de estilos y scripts.
```php
WP_Menu::add(
	'menu',
	$params,
	[$this, 'runPage'], 
	'load_styles',		// It would be the same as: [$this, 'load_styles']
	'load_scripts'		// It would be the same as: [$this, 'load_scripts']
);
```

Agregar menú con el método a ejecutar en la salida de la página y métodos asociados para la carga de estilos y scripts agregando cada objeto de manera individual.
```php
WP_Menu::add(
	'menu', 
	$params,
	[$instance1, 'runPage'], 
	[$instance3, 'load_styles'],
	[$instance3, 'load_scripts']
);
```

### Establecer parámetros para submenú

```php
$params = [
	'slug'       => 'searchinside-options',          // Required
	'parent'     => 'searchinside-options',          // Required
	'name'       => __('Options', 'search-iniside'), // Required
	'title'      => __('Options', 'search-iniside'), // Optional
	'capability' => 'manage_options',                // Optional
];
```

### Agregar submenú

Agregar submenú sin método asociado a la salida de la página.
```php
WP_Menu::add(
	'submenu', 
	$params
);
```

Agregar submenú con el método a ejecutar en la salida de la página. Si no se indican métodos para cargar scripts y estilos y existen los métodos "addStyles" y "addScripts" en la instancia ($this en este caso) se cargarán de forma predeterminada.
```php
WP_Menu::add(
	'submenu',
	$params, 
	[$this, 'runPage']
);
```

Agregar submenú con el método a ejecutar en la salida de la página y métodos asociados para la carga de estilos y scripts.
```php
WP_Menu::add(
	'submenu', 
	$params, 
	[$this, 'runPage'], 
	'load_styles',		// It would be the same as: [$this, 'load_styles']
	'load_scripts'		// It would be the same as: [$this, 'load_scripts']
);
```

Agregar submenú con el método a ejecutar en la salida de la página y métodos asociados para la carga de estilos y scripts agregando cada objeto de manera individual.
```php
WP_Menu::add(
	'submenu', 
	$params, 
	[$instance1, 'runPage'], 
	[$instance3, 'load_styles'],
	[$instance3, 'load_scripts']
);
```

## Action hooks

| Acción | Descripción | Parameters
| --- | --- | --- |
| wp_menu/pre_add_menu_page | Antes de agregar menú. |
| wp_menu/after_add_menu_page | Después de agregar menú. | **$page** Hook_suffix de la página resultante o false.
| wp_menu/pre_add_submenu_page | Antes de agregar submenú. |
| wp_menu/after_add_submenu_page | Después de agregar submenú. | **$page** Hook_suffix de la página resultante o false.

## ☑ TODO

- [ ] Agregar tests

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
