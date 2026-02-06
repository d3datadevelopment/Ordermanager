# D3 Ordermanager Tests

## Requirements

Please install the packages listed in the composer.json in "require-dev". Unfortunately Composer does not provide an automatic installation.

### Configuration

Make sure the module has been activated with a valid license key.
Configure the error reporting to `error_reporting(E_ALL & ~E_DEPRECATED & ~E_USER_DEPRECATED &~ E_WARNING);` in the `config.inc.php` due some deprecation issues in original OXID code

Deactivate all modules that overload the same classes. This can interfere with the execution of the tests, regardless of the compatibility of the production mode.

## Unit Tests

commands are described in composer.json scripts section
