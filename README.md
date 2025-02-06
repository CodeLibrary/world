# CodeLibrary / World

PHP package as service for endpoint resource of countries and their associated 
data.

## Installation

Add this package directly with composer:

```bash
composer require codelibrary/world
# or
composer require codelibrary/world -n # --no-interaction (Docker SSH reasons)
```

## Build and run for dev environment

The `docker build` command will copy the local content to the container. So use
`docker run -v` (or `--volume`) option to bind with local content:

```bash
cd /path/to/project/
docker build -t [IMAGE_NAME] .
docker run -d -v .:/var/www/html --name [NEW_CONTAINER_NAME] [IMAGE_NAME]
docker exec -it [NEW_CONTAINER_NAME] /bin/bash
```

## Usage

```php
use CodeLibrary\World\CountryFinder;

// optional params
$extraCountryData = [
    [
        'name' => ['official' => 'Hellenic Republic'], // already existing key
        'altSpellings' => ['hellenicccccccc'], // new custom values
    ],
    [
        'name' => ['official' => 'Kingdom of Spain'],
        'altSpellings' => ['The Kingdom of Spain'],
    ],
];

$finder = new CountryFinder($extraCountryData);

$finder->name('invalid country name here'); // throw 'InvalidCountryNameException'

$country1 = $finder->name('Hellenicccccccc');
$country2 = $finder->name('the kingdom of spain');

$country2->hasName('spain'); // (bool) true
$country2->hasName('spain, the kindom of'); // (bool) false
echo $country2->name('fra'); // Royaume d'Espagne
echo $country2->nameCommon('fra'); // Espagne
```

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) and
[CODE OF CONDUCT](CODE_OF_CONDUCT.md) for details.

## Change log

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed
recently.

## Security

If you discover any security related issues, please email to
niks986@gmail.com instead of using the issue tracker.

## Credits

- [Nikola Zeravcic][link-author_nikola]

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more
information.

[link-author_nikola]: https://github.com/zeravcic
