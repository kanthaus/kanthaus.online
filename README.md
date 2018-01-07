Website for kanthaus.online, based on the [Grav](https://getgrav.org/) CMS.

# Licence

* Our website content is CC0 except third party content is referenced. Refer to [CC0 Licence text](LICENCE).
* The grav CMS is licenced under MIT. Refer to [MIT Licence text](LICENCE.txt).

# Requirements

- PHP 5.5.9 or higher. Check the [required modules list](https://learn.getgrav.org/basics/requirements#php-requirements)
- [Composer](https://getcomposer.org/download/)

# QuickStart

```
git clone https://github.com/kanthaus/kanthaus.online
cd kanthaus.online
composer install
php -S localhost:8000 system/router.php
```

Now open http://localhost:8000 in your browser.

Check out the [install procedures](https://learn.getgrav.org/basics/installation) for more information.

# Adding Functionality

You can download [plugins](https://getgrav.org/downloads/plugins) or [themes](https://getgrav.org/downloads/themes) manually from the appropriate tab on the [Downloads page on https://getgrav.org](https://getgrav.org/downloads), but the preferred solution is to use the [Grav Package Manager](https://learn.getgrav.org/advanced/grav-gpm) or `GPM`:

```
$ bin/gpm index
```

This will display all the available plugins and then you can install one or more with:

```
$ bin/gpm install <plugin/theme>
```

# Updating

To update Grav you should use the [Grav Package Manager](https://learn.getgrav.org/advanced/grav-gpm) or `GPM`:

```
$ bin/gpm selfupgrade
```

To update plugins and themes:

```
$ bin/gpm update
```

# Getting Started

* [What is Grav?](https://learn.getgrav.org/basics/what-is-grav)
* [Install](https://learn.getgrav.org/basics/installation) Grav in few seconds
* Understand the [Configuration](https://learn.getgrav.org/basics/grav-configuration)

# Exploring More

* Have a look at our [Basic Tutorial](https://learn.getgrav.org/basics/basic-tutorial)
* Dive into more [advanced](https://learn.getgrav.org/advanced) functions
