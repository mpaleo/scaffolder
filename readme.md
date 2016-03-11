# Laravel scaffolder
![Scaffolder for laravel](https://cloud.githubusercontent.com/assets/5132565/11066969/17feb094-87a9-11e5-96cb-1402e4c7aaca.png)
[![Software license](https://img.shields.io/badge/license-MIT-blue.svg?style=flat-square)](LICENSE)
[![Laravel version](https://img.shields.io/badge/for%20laravel-5.2-orange.svg?style=flat-square)](https://github.com/laravel/framework/tree/5.2)
[![Waffle board](https://img.shields.io/badge/board-on%20waffle-blue.svg?style=flat-square)](https://waffle.io/mpaleo/scaffolder)
[![Gitter chat](https://img.shields.io/badge/chat-on%20gitter-blue.svg?style=flat-square)](https://gitter.im/mpaleo/scaffolder)

Remove the headache of creating over and over again the base code for most of your projects.
You are free to extend it the way you need. This package only generate things that you need to start, always keeping the code clean and abstract. Are you hungry ? Fork it !

## Installation
1. Get [laravel](http://laravel.com/docs/5.2#installation) up and running
2. Add the following packages to your composer.json

    ```json
    ...
    "laravelcollective/html": "5.2.*",
    "yajra/laravel-datatables-oracle": "~6.0",
    "mpaleo/view-tags": "~1.0",
    "mpaleo/scaffolder-theme-material": "~1.0",
    "mpaleo/scaffolder": "~2.0",
    ...
    ```
3. Update your packages

    ```bash
    composer update
    ````
4. Add the service providers to the providers array in `{laravel-root}\config\app.php`

    ```php
    ...
    ViewTags\ViewTagsServiceProvider::class,
    ScaffolderTheme\ScaffolderThemeServiceProvider::class,
    Scaffolder\ScaffolderServiceProvider::class,
    Yajra\Datatables\DatatablesServiceProvider::class,
    ...
    ```
5. Add the following aliases in `{laravel-root}\config\app.php`

    ```php
    ...
    'ViewTags'   => ViewTags\ViewTags::class,
    'Form'       => Collective\Html\FormFacade::class,
    'Html'       => Collective\Html\HtmlFacade::class,
    ...
    ```

## Getting started
First you need to publish the configuration files and assets

```bash
./artisan vendor:publish --provider="Scaffolder\ScaffolderServiceProvider"
./artisan vendor:publish --provider="ScaffolderTheme\ScaffolderThemeServiceProvider" --force
```

Here we are using the theme [mpaleo/scaffolder-theme-material](https://github.com/mpaleo/scaffolder-theme-material), but you can fork it, and do whatever you want/need :)

At this point, you already can start to scaffold things. You have two ways to use the package.

##### Command line way
When you execute the artisan publish command, the service provider creates the folder `{laravel-root}\scaffolder-config` that has the following structure:

```
- scaffolder-config
-- app.json
-- models
-- cache
```

The `app.json` file contains global settings, also you will get some demo files for models. All you need to scaffold an application is to edit the `app.json` file, and create the json files for the models you want. After you have all the files ready, you have the following commands:

This command generate the application using the files that you have provided.
```bash
./artisan scaffolder:generate
```

For instance, when you update the package, you should clear the cache files stored in `{laravel-root}\scaffolder-config\cache`
```bash
./artisan scaffolder:cache-clear
```

##### User interface way
All you need to do, is go to your `http://{crazyhost}/scaffolder/generator` and fill some inputs :)

##### Next steps
- Run migrations `./artisan migrate`
- [Wiki](https://github.com/mpaleo/scaffolder/wiki)
- [API Docs](http://mpaleo.github.io/scaffolder/api)

## Contributing
Just let me know your ideas and let's work together

### Coding style
It would be great if we follow the PSR-2 coding standard and the PSR-4 autoloading standard.

### License
The scaffolder package is licensed under the [MIT license](http://opensource.org/licenses/MIT)
