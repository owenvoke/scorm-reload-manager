# scorm-reload-manager

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE.md)
[![Build Status][ico-travis]][link-travis]
[![Style CI][ico-styleci]][link-styleci]
[![Code Coverage][ico-code-quality]][link-code-quality]
[![Total Downloads][ico-downloads]][link-downloads]

A selection of classes for managing the SCORM Reload toolkit.

## Structure

```
bin/
src/
tests/
vendor/
```

## Install

Via Composer

``` bash
$ composer global require pxgamer/scorm-reload-manager
```

## Usage

Find out more about the Reload SCORM Player from their website at [Reload SCORM Player](http://www.reload.ac.uk/scormplayer.html).

**List commands:**  

```bash
scorm list
```

**List commands for a namespace:**

```bash
scorm list {namespace}
```

**Course**

Function    | Usage                    | Description
----------- | ------------------------ | ---------------------
Clear       | `scorm course:clear`     | Removes all courses in the current user's SCORM Reload directory.
Import      | `scorm course:import`    | Import a new SCORM package from a ZIP file.
List        | `scorm course:list`      | List all currently available SCORM packages.
Validate    | `scorm course:validate`  | Validate the XML manifest for each available SCORM package.

**Learner**

Function    | Usage                    | Description
----------- | ------------------------ | ---------------------
ID          | `scorm learner:id`       | Update the default learner's student id for Reload.
Name        | `scorm learner:name`     | Update the default learner's name for Reload.

**Prefs**

Function    | Usage                    | Description
----------- | ------------------------ | ---------------------
Folder      | `scorm prefs:folder`     | Set the default folder directory.
Navigation  | `scorm prefs:navigation` | Enable or disable the navigation.
Port        | `scorm prefs:port`       | Set the Reload serving port.
Progress    | `scorm prefs:progress`   | Enable or disable checking the auto-progression of items.
Support     | `scorm prefs:support`    | Enable or disable checking the support folder.
Theme       | `scorm prefs:theme`      | Set the Reload SCORM Player theme.
Tree        | `scorm prefs:tree`       | Enable or disable the tree view.

## Change log

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Testing

``` bash
$ composer test
```

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) and [CODE_OF_CONDUCT](CODE_OF_CONDUCT.md) for details.

## Security

If you discover any security related issues, please email owzie123@gmail.com instead of using the issue tracker.

## Credits

- [pxgamer][link-author]
- [All Contributors][link-contributors]

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

[ico-version]: https://img.shields.io/packagist/v/pxgamer/scorm-reload-manager.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/pxgamer/scorm-reload-manager/master.svg?style=flat-square
[ico-styleci]: https://styleci.io/repos/101203462/shield
[ico-code-quality]: https://img.shields.io/codecov/c/github/pxgamer/scorm-reload-manager.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/pxgamer/scorm-reload-manager.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/pxgamer/scorm-reload-manager
[link-travis]: https://travis-ci.org/pxgamer/scorm-reload-manager
[link-styleci]: https://styleci.io/repos/101203462
[link-code-quality]: https://codecov.io/gh/pxgamer/scorm-reload-manager
[link-downloads]: https://packagist.org/packages/pxgamer/scorm-reload-manager
[link-author]: https://github.com/pxgamer
[link-contributors]: ../../contributors
