# PHP WordPress Menu

[![Latest Stable Version](https://poser.pugx.org/josantonius/wp_menu/v/stable)](https://packagist.org/packages/josantonius/wp_menu) [![Total Downloads](https://poser.pugx.org/josantonius/wp_menu/downloads)](https://packagist.org/packages/josantonius/wp_menu) [![Latest Unstable Version](https://poser.pugx.org/josantonius/wp_menu/v/unstable)](https://packagist.org/packages/josantonius/wp_menu) [![License](https://poser.pugx.org/josantonius/wp_menu/license)](https://packagist.org/packages/josantonius/wp_menu)

[English version](README.md)

Agregar menú o submenús en WordPress.

---

- [Instalación](#instalación)
- [Requisitos](#requisitos)
- [Cómo empezar y ejemplos](#cómo-empezar-y-ejemplos)
- [Uso](#uso)
- [TODO](#-todo)
- [Contribuir](#contribuir)
- [Repositorio](#repositorio)
- [Licencia](#licencia)
- [Copyright](#copyright)

---

### Instalación 

La mejor forma de instalar esta extensión es a través de [composer](http://getcomposer.org/download/).

Para instalar PHP WordPress Menu library, simplemente escribe:

    $ composer require Josantonius/WP_Menu

El comando anterior sólo instalará los archivos necesarios, si prefieres descargar todo el código fuente (incluyendo tests, directorio vendor, excepciones no utilizadas, documentos...) puedes utilizar:

    $ composer require Josantonius/WP_Menu --prefer-source

También puedes clonar el repositorio completo con Git:

    $ git clone https://github.com/Josantonius/WP_Menu.git
    
### Requisitos

Esta ĺibrería es soportada por versiones de PHP 5.6 o superiores y es compatible con versiones de HHVM 3.0 o superiores.

Para utilizar esta librería en HHVM (HipHop Virtual Machine) tendrás que activar los tipos escalares. Añade la siguiente ĺínea "hhvm.php7.scalar_types = true" en tu "/etc/hhvm/php.ini".

### Cómo empezar y ejemplos

Para utilizar esta librería, simplemente:

```php
require __DIR__ . '/vendor/autoload.php';

use Josantonius\WP_Menu\WP_Menu;
```
### Uso

Ejemplo de uso para esta librería:

```php
<?php
require __DIR__ . '/vendor/autoload.php';

use Josantonius\WP_Menu\WP_Menu;

$menu = [
	'slug'       => 'searchinside-options',					// Required
	'name'       => __('Search Inside', 'search-iniside'),  // Required
	'title'      => __('Search Inside', 'search-iniside'),  // Optional
	'capability' => 'manage_options',					    // Optional
	'icon_url'   => '//searchinside-menu-admin.png',		// Optional
	'position'   => 25,										// Optional
];

WP_Menu::add('menu', $menu);

$submenu = [
	'slug'       => 'searchinside-options',				// Required
	'parent'     => 'searchinside-options',				// Required
	'name'       => __('Options', 'search-iniside'),	// Required
	'title'      => __('Options', 'search-iniside'),	// Optional
	'capability' => 'manage_options',					// Optional
];

WP_Menu::add('submenu', $submenu, [$this, 'runPage']);
```


### ☑ TODO

- [ ] Agregar tests

### Contribuir
1. Comprobar si hay incidencias abiertas o abrir una nueva para iniciar una discusión en torno a un fallo o función.
1. Bifurca la rama del repositorio en GitHub para iniciar la operación de ajuste.
1. Escribe una o más pruebas para la nueva característica o expón el error.
1. Haz cambios en el código para implementar la característica o reparar el fallo.
1. Envía pull request para fusionar los cambios y que sean publicados.

Esto está pensado para proyectos grandes y de larga duración.

### Repositorio

Los archivos de este repositorio se crearon y subieron automáticamente con [Reposgit Creator](https://github.com/Josantonius/BASH-Reposgit).

### Licencia

Este proyecto está licenciado bajo **licencia MIT**. Consulta el archivo [LICENSE](LICENSE) para más información.

### Copyright

2017 Josantonius, [josantonius.com](https://josantonius.com/)

Si te ha resultado útil, házmelo saber :wink:

Puedes contactarme en [Twitter](https://twitter.com/Josantonius) o a través de mi [correo electrónico](mailto:hello@josantonius.com).
