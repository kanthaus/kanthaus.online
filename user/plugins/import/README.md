# Grav Import Plugin

This plugin allows you to import YAML and JSON files into the header of your pages, facilitating custom actions/settings. This fork is now the master repository for this plugin in GPM.

There are no dependencies

## Installation

Installing the Import plugin can be done in one of two ways. Using the GPM (Grav Package Manager), manual installation via a zip file.

### GPM Installation (Preferred)

The simplest way to install this plugin is via the [Grav Package Manager (GPM)](http://learn.getgrav.org/advanced/grav-gpm) through your system's Terminal (also called the command line). From the root of your Grav install type:

    $ bin/gpm install import

This will install the Import plugin into your `/user/plugins` directory within Grav. Its files can be found under `/your/site/grav/user/plugins/import`.

### Manual Installation

To manually install this plugin, just download the zip version of this repository and unzip it under `/your/site/grav/user/plugins`. Then, rename the folder to `import`. You can find these files either on [GitHub](https://github.com/Perlkonig/grav-plugin-import) or via [GetGrav.org](http://getgrav.org/downloads/plugins).

You should now have all the plugin files under

    /your/site/grav/user/plugins/import

## Configuration

There are currently no settings to configure for this plugin.  In the future, user settings may become available.  If so, `import` will allow you to use the Grav Admin Plugin to adjust these settings as needed.

## Usage

  * Add an `imports` field to your page header. You can include a a single file:
    
    ```yaml
    imports: 'file1.yaml'
    ``` 

    Or you can add multiple files:

    ```yaml
    imports:
      - 'file1.yaml'
      - 'user://data/file2.json'
    ```

    When multiple files are requested, the plugin uses [PHP's `basename` function](https://secure.php.net/manual/en/function.basename.php) to determine the file name and uses that as a key in a hash that contains all the imported data (see below).

  * File names must end in either `.yaml` or `.json`, otherwise they are ignored.

  * By default, the plugin looks for files in the same folder as the page itself. But you can also use Grav's resource locator syntax (e.g., prefix filenames with `user://data/` to anchor your search in the `user/data` folder).

  * The imported data becomes a part of `page.header.imports`, which can be accessed via Twig.

The contents of these files is up to you, and you will need to determine how you are going to use them in your code.  The goal is to make the data in the YAML files available to themes and plugins to expand the functionality of Grav in an open-ended fashion.

### Examples

[A demo is available on my website.](https://perlkonig.com/demos/import)

#### Single file

```
imports: 'file.yaml'
```

The plugin would look for `file.yaml` in the same folder as the page file. The data would be available via Twig as `{{ page.header.imports.X }}`.

#### Multiple files

```
imports:
    - 'file1.yaml'
    - 'user://data/scratch/file2.json'
```

The plugin would look for `file1.yaml` in the same folder as the page file. It would look for `file2.json` in `user/data/scratch`. The data would available as `{{ page.header.imports.file1.X }}` and `{{ page.header.imports['scratch/file2'] }}`.

## Updating

As development for the Import plugin continues, new versions may become available that add additional features and functionality, improve compatibility with newer Grav releases, and generally provide a better user experience. Updating Import is easy, and can be done through Grav's GPM system, as well as manually.

### GPM Update (Preferred)

The simplest way to update this plugin is via the [Grav Package Manager (GPM)](http://learn.getgrav.org/advanced/grav-gpm). You can do this with this by navigating to the root directory of your Grav install using your system's Terminal (also called command line) and typing the following:

    bin/gpm update import

This command will check your Grav install to see if your GitHub plugin is due for an update. If a newer release is found, you will be asked whether or not you wish to update. To continue, type `y` and hit enter. The plugin will automatically update and clear Grav's cache.

### Manual Update

Manually updating Import is pretty simple. Here is what you will need to do to get this done:

* Delete the `your/site/user/plugins/import` directory.
* Download the new version of the Import plugin from either [GitHub](https://github.com/Perlkonig/grav-plugin-import) or [GetGrav.org](http://getgrav.org/downloads/plugins).
* Unzip the zip file in `your/site/user/plugins` and rename the resulting folder to `import`.
* Clear the Grav cache. The simplest way to do this is by going to the root Grav directory in terminal and typing `bin/grav clear-cache`.

> Note: Any changes you have made to any of the files listed under this directory will also be removed and replaced by the new set. Any files located elsewhere (for example a YAML settings file placed in `user/config/plugins`) will remain intact.

## Attribution (original)

**Special thanks to the Grav team and @rhukster for giving me a starting point and direction for this plugin.**