# ParcelTrap Skeleton Driver

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE.md)
[![Build Status][ico-github-actions]][link-github-actions]
[![Static Analysis][ico-static-analysis]][link-static-analysis]
[![Total Downloads][ico-downloads]][link-downloads]
[![Buy us a tree][ico-treeware-gifting]][link-treeware-gifting]

A Skeleton driver for ParcelTrap

## Install

Via Composer

```shell
composer require parceltrap/driver-skeleton
```

## Usage

Add the following to the `drivers` section of your `config/parceltrap.php` file:

```
'skeleton' => [
    'api_key' => env('PARCELTRAP_SKELETON_API_KEY'),
],
```

```php
use ParcelTrap\ParcelTrap;

/** @var ParcelTrap $parcelTrap */
$parcelTrap->driver('skeleton');
```

Configure the relevant environment variables in your `.env` file.

## Change log

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Testing

```shell
composer test
```

## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.

## Security

If you discover any security related issues, please email security@voke.dev instead of using the issue tracker.

## Credits

- [Owen Voke][link-author]
- [All Contributors][link-contributors]

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

## Treeware

You're free to use this package, but if it makes it to your production environment you are required to buy the world a tree.

It’s now common knowledge that one of the best tools to tackle the climate crisis and keep our temperatures from rising above 1.5C is to plant trees. If you support this package and contribute to the Treeware forest you’ll be creating employment for local families and restoring wildlife habitats.

You can buy trees [here][link-treeware-gifting].

Read more about Treeware at [treeware.earth][link-treeware].

[ico-version]: https://img.shields.io/packagist/v/parceltrap/driver-skeleton.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-github-actions]: https://img.shields.io/github/actions/workflow/status/parceltrap/driver-skeleton/tests.yml?branch=main&style=flat-square&label=Tests
[ico-static-analysis]: https://img.shields.io/github/actions/workflow/status/parceltrap/driver-skeleton/static.yml?branch=main&style=flat-square&label=Static%20Analysis
[ico-downloads]: https://img.shields.io/packagist/dt/parceltrap/driver-skeleton.svg?style=flat-square
[ico-treeware-gifting]: https://img.shields.io/badge/Treeware-%F0%9F%8C%B3-lightgreen?style=flat-square

[link-packagist]: https://packagist.org/packages/parceltrap/driver-skeleton
[link-github-actions]: https://github.com/parceltrap/driver-skeleton/actions
[link-static-analysis]: https://github.com/parceltrap/driver-skeleton/actions/workflows/static.yml
[link-downloads]: https://packagist.org/packages/parceltrap/driver-skeleton
[link-treeware]: https://treeware.earth
[link-treeware-gifting]: https://ecologi.com/owenvoke?gift-trees
[link-author]: https://github.com/owenvoke
[link-contributors]: ../../contributors
