# CRUD

This is where your description should go. Take a look at [contributing.md](contributing.md) to see a to do list.

## Installation

Via Composer

``` bash
$ composer require amttmg/crud
```

## Usage

Step-1: Generate Crud master file. It will be located on ``app/CrudGenerate`` folder.
``` bash
$ php artisan make:crud ModelName
```
Step-2: Find the newly generated file on ``app/CrudGenerate`` folder and edit what you want. You can add fields, change validations etc.

Step-3 After making crud file you have to generate ``model``, ``controller``, ``migration``, ``request`` and ``views``. to generate these files fun this command:

``` bash
$ php artisan crud:generate CrudFileClassName
```
It will be replace if files are already exist.
<br/>
<br/>
Thank You. Enjoy !!!


## License

license. Please see the [license file](license.md) for more information.

[ico-version]: https://img.shields.io/packagist/v/amttmg/crud.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/amttmg/crud.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/amttmg/crud/master.svg?style=flat-square
[ico-styleci]: https://styleci.io/repos/12345678/shield

[link-packagist]: https://packagist.org/packages/amttmg/crud
[link-downloads]: https://packagist.org/packages/amttmg/crud
[link-travis]: https://travis-ci.org/amttmg/crud
[link-styleci]: https://styleci.io/repos/12345678
[link-author]: https://github.com/amttmg
[link-contributors]: ../../contributors]
