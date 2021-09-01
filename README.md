# Monolog Logger Extension for Symphony CMS

A [Monolog][ext-monolog] based logger that replaces the default logger in [Symphony CMS][ext-Symphony CMS].

-   [Installation](#installation)
-       [With Git and Composer](#with-git-and-composer)
-       [With Orchestra][#with-orchestra]
-   [Basic Usage](#basic-usage)
-   [About](#about)
    -   [Requirements](#dependencies)
    -   [Dependencies](#dependencies)
-   [Support](#support)
-   [Contributing](#contributing)
-   [License](#license)

## Installation

This is an extension for [Symphony CMS][ext-Symphony CMS]. Add it to the `/extensions` folder of your Symphony CMS installation, then enable it though the interface.

### With Git and Composer

```bash
$ git clone --depth 1 https://github.com/pointybeard/symext-logger_monolog.git logger_monolog
$ composer update -vv --profile -d ./logger_monolog
```
After finishing the steps above, enable "Monolog Logger" though the administration interface or, if using [Orchestra][ext-Orchestra], with `bin/extension enable logger_monolog`.

### With Orchestra

1. Add the following extension defintion to your `.orchestra/build.json` file in the `"extensions"` block:

```json
{
    "name": "logger_monolog",
    "repository": {
        "url": "https://github.com/pointybeard/symext-logger_monolog.git"
    }
}
```

2. Run the following command to rebuild your Extensions

```bash
$ bin/orchestra build \
    --skip-import-sections \
    --database-skip-import-data \
    --database-skip-import-structure \
    --skip-create-author \
    --skip-seeders \
    --skip-git-reset \
    --skip-composer \
    --skip-postbuild
```

## Basic Usage

After installation, enable this logger by going to your System Preferences and choosing "Monolog" from the "Logging" options.

### Set Logging Level for StreamHandler

By default, the logging level for the default StreamHandler is `WARNING`. To change this, modify your config.json to include the following:

    "logger_monolog": {
        "level": 100
    },

Where `level` can be any of the [supported logging levels](https://github.com/Seldaek/monolog/blob/main/doc/01-usage.md#log-levels).

### Adding More Handlers

By default, the Monolog Logger adds a file stream handler to mimic the standard Symphony log that is created in `manifest/logs/`. However, additional handlers can be added by accessing the Monolog Logger instance via `Symphony::Log()->getLogger()`. E.g.

    use Monolog\Logger;
    use Monolog\Handler\StreamHandler;
    use Symphony;

    Symphony::Log()->getLogger()->pushHandler(new StreamHandler(
        LOGS . "/monolog.errors.log",
        Logger::ERROR
    ));

See the [Monolog documentation](https://github.com/Seldaek/monolog/tree/main/doc) for more on this.

## About

### Requirements

- This extension works with PHP 7.4 or above.
- [Symphony CMS (Extended)](https://github.com/pointybeard/symphonycms)

### Dependencies

This extension depends on the following Composer libraries:

-   [Monolog - Logging for PHP][ext-monolog]
-   [Extended Base Class Library for Symphony CMS](https://github.com/pointybeard/symphony-extended)

## Support

If you believe you have found a bug, please report it using the [GitHub issue tracker][ext-issues],
or better yet, fork the library and submit a pull request.

## Contributing

We encourage you to contribute to this project. Please check out the [Contributing to this project][doc-CONTRIBUTING] documentation for guidelines about how to get involved.

## Author
-   Alannah Kearney - https://github.com/pointybeard
-   See also the list of [contributors][ext-contributor] who participated in this project

## License
"Monolog Logger Extension for Symphony CMS" is released under the MIT License. See [LICENCE][doc-LICENCE] for details.

[doc-CONTRIBUTING]: https://github.com/pointybeard/symext-logger_monolog/blob/master/CONTRIBUTING.md
[doc-LICENCE]: http://www.opensource.org/licenses/MIT
[ext-issues]: https://github.com/pointybeard/symext-logger_monolog/issues
[ext-Symphony CMS]: http://getsymphony.com
[ext-Orchestra]: https://github.com/pointybeard/orchestra
[ext-contributor]: https://github.com/pointybeard/symext-logger_monolog/contributors
[ext-monolog]: https://github.com/Seldaek/monolog
