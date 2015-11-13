# Laravel scaffolder
![Scaffolder for laravel](https://cloud.githubusercontent.com/assets/5132565/11066969/17feb094-87a9-11e5-96cb-1402e4c7aaca.png)
[![Software license](https://img.shields.io/badge/license-MIT-blue.svg?style=flat-square)](LICENSE)
[![Quality score](https://img.shields.io/scrutinizer/g/mpaleo/scaffolder.svg?style=flat-square)](https://scrutinizer-ci.com/g/mpaleo/scaffolder)
[![Laravel version](https://img.shields.io/badge/for%20laravel-5.1-orange.svg?style=flat-square)](https://github.com/laravel/framework/tree/5.1)

Remove the headache of creating over and over again the base code for most of your projects. Scaffolder is tailored following the principle that the development process must be a happy thing so, code and enjoy !
You are free to extend it the way you need. This package only generate things that you need to start, always keeping the code clean and abstract. Are you hungry ? Fork it !

## Installation
1. Add the following packages to your composer.json

    ```json
    "laravelcollective/html": "5.1.*",
    "yajra/laravel-datatables-oracle": "~5.0",
    "mpaleo/scaffolder-theme-material": "dev-master",
    "mpaleo/scaffolder": "dev-master",
    ```
2. Update your packages

    ```bash
    composer update
    ````
3. Add the service providers to the providers array in `{laravel-root}\config\app.php`

    ```php
    ScaffolderTheme\ScaffolderThemeServiceProvider::class,
    Scaffolder\ScaffolderServiceProvider::class,
    yajra\Datatables\DatatablesServiceProvider::class,
    ```
4. Add the following aliases

    ```php
    'Form'       => Collective\Html\FormFacade::class,
    'Html'       => Collective\Html\HtmlFacade::class,
    'Datatables' => yajra\Datatables\Datatables::class,
    ```

## Getting started
First you need to publish the configuration files and assets

```bash
./artisan vendor:publish --provider="Scaffolder\ScaffolderServiceProvider"
./artisan vendor:publish --provider="ScaffolderTheme\ScaffolderThemeServiceProvider" --force
```

Here we are using the theme [mPaleo/scaffolder-theme-material](https://github.com/mPaleo/scaffolder-theme-material), but you can fork it, and do whatever you want/need :)

At this point, you already can start to scaffold things. You have two ways to use the package.

##### Command line way (Hardcore devs)
When you execute the artisan publish command, the service provider creates the folder `{laravel-root}\scaffolder-config` that has the following structure:

```
- scaffolder-config
-- app.json
-- models
-- cache
```

app.json contains the scaffolder global configuration and models contains the models files. All you need to scaffold an application is to edit the `app.json` file, and create the json files for the models you want. After you have all the files ready, you have the following commands:

This command generate the application using the files that you have provided.
```bash
./artisan mpaleo.scaffolder:generate
```

For instance, when you update the package, you should clear the cache files stored in `{laravel-root}\scaffolder-config\cache`
```bash
./artisan mpaleo.scaffolder:cache:clear
```

##### User interface way (Lazy devs)
All you need to do, is go to your `http://{crazyhost}/scaffolder/generator` and fill some inputs :)

##### Next steps
Check out the [Wiki](https://github.com/mPaleo/scaffolder/wiki) to get more information about things that you need to know

## Contributing
Just let me know your ideas and let's work together

### License
The scaffolder package is licensed under the [MIT license](http://opensource.org/licenses/MIT)
