# kaiseki/config

Type-safe access to array configuration, with dot-notation paths.

Wrap a config array (or pull one from a PSR-11 container) and read values with typed accessors that
throw on a missing key or a wrong type — so a typo or a misconfigured value fails loudly instead of
silently returning `null`.

## Installation

```bash
composer require kaiseki/config
```

Requires PHP 8.2 or newer.

## Usage

```php
use Kaiseki\Config\NestedArrayConfig;

$config = new NestedArrayConfig([
    'db' => [
        'host' => 'localhost',
        'port' => 3306,
    ],
]);

$config->string('db.host'); // "localhost"
$config->int('db.port');    // 3306
$config->has('db.user');    // false
```

Paths are dot-separated. Typed getters (`string()`, `int()`, `float()`, `bool()`, `array()`) throw
`UnknownKeyException` if the path is missing and `InvalidValueException` if the value is not of the
expected type.

### Defaults and nullables

```php
$config->string('db.user', 'root');      // default when the key is absent
$config->get('db.password', null, true); // allow null (nullable)
```

### From a PSR-11 container

`Config::fromContainer()` reads the `config` entry from a container:

```php
use Kaiseki\Config\Config;

$config = Config::fromContainer($container); // expects $container->get('config')
```

`Config::initClassMap()` resolves a map of keys to class instances from the container:

```php
$map = Config::initClassMap($container, ['logger' => LoggerInterface::class]);
// ['logger' => <instance from container>]
```

## Development

```bash
composer install
composer check   # check-deps, cs-check, phpstan, phpunit
```

## License

MIT — see [LICENSE](LICENSE).
