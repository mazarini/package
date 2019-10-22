
# mazarini/package

[![Build Status](https://travis-ci.org/mazarini/package.svg?branch=master)](https://travis-ci.org/mazarini/package)

List the installed packages, the required packages and the reasons for installing the packages.

## Install
```
composer require mazarini/package
```

## Command
1. bin/console package:require
2. bin/console package:installed
3. bin/console package:why
3. bin/console package:recipe
4. bin/console package:file

## Exemple package:require
```
+--------------------------+-------------+-------------+---------+---------+
| package                  | require     | version     | install | version |
+--------------------------+-------------+-------------+---------+---------+
| ext-mbstring             | require     | *           |         | 7.2.23  |
| php                      | require     | ^7.1.3|^8.0 |         | 7.2.23  |
| symfony/console          | require     | ^4.3|^5.0   |         | v4.3.5  |
| symfony/dotenv           | require     | ^4.3|^5.0   |         | v4.3.5  |
| symfony/flex             | require     | ^1.4        |         | v1.4.6  |
| symfony/framework-bundle | require     | ^4.3|^5.0   |         | v4.3.5  |
| symfony/test-pack        | require-dev | ^1.0        | dev     | v1.0.6  |
| symfony/yaml             | require     | ^4.3|^5.0   |         | v4.3.5  |
+--------------------------+-------------+-------------+---------+---------+
```

## Exemple package:installed
```
+------------------------------------+-----+---------+-------------+-------------+
| package                            | dev | version | require     | version     |
+------------------------------------+-----+---------+-------------+-------------+
| composer-plugin-api                |     |         |             |             |
| ext-mbstring                       |     | 7.2.23  | require     | *           |
| ext-xml                            |     | 7.2.23  |             |             |
| php                                |     | 7.2.23  | require     | ^7.1.3|^8.0 |
| psr/cache                          |     | 1.0.1   |             |             |
| psr/container                      |     | 1.0.0   |             |             |
| psr/log                            |     | 1.1.0   |             |             |
| symfony/browser-kit                | dev | v4.3.5  |             |             |
| symfony/cache                      |     | v4.3.5  |             |             |
| symfony/cache-contracts            |     | v1.1.7  |             |             |
| symfony/config                     |     | v4.3.5  |             |             |
| symfony/console                    |     | v4.3.5  | require     | ^4.3|^5.0   |
| symfony/css-selector               | dev | v4.3.5  |             |             |
| symfony/debug                      |     | v4.3.5  |             |             |
| symfony/dependency-injection       |     | v4.3.5  |             |             |
| symfony/dom-crawler                | dev | v4.3.5  |             |             |
| symfony/dotenv                     |     | v4.3.5  | require     | ^4.3|^5.0   |
| symfony/event-dispatcher           |     | v4.3.5  |             |             |
| symfony/event-dispatcher-contracts |     | v1.1.7  |             |             |
| symfony/filesystem                 |     | v4.3.5  |             |             |
| symfony/finder                     |     | v4.3.5  |             |             |
| symfony/flex                       |     | v1.4.6  | require     | ^1.4        |
| symfony/framework-bundle           |     | v4.3.5  | require     | ^4.3|^5.0   |
| symfony/http-foundation            |     | v4.3.5  |             |             |
| symfony/http-kernel                |     | v4.3.5  |             |             |
| symfony/mime                       |     | v4.3.5  |             |             |
| symfony/phpunit-bridge             | dev | v4.3.5  |             |             |
| symfony/polyfill-ctype             |     | v1.12.0 |             |             |
| symfony/polyfill-intl-idn          |     | v1.12.0 |             |             |
| symfony/polyfill-mbstring          |     | v1.12.0 |             |             |
| symfony/polyfill-php72             |     | v1.12.0 |             |             |
| symfony/polyfill-php73             |     | v1.12.0 |             |             |
| symfony/routing                    |     | v4.3.5  |             |             |
| symfony/service-contracts          |     | v1.1.7  |             |             |
| symfony/test-pack                  | dev | v1.0.6  | require-dev | ^1.0        |
| symfony/var-exporter               |     | v4.3.5  |             |             |
| symfony/yaml                       |     | v4.3.5  | require     | ^4.3|^5.0   |
+------------------------------------+-----+---------+-------------+-------------+
37 packages.
```

## Exemple package:why
```
+------------------------------------+--------------------------+-------------+
| why is installed ?                 | because package          | composer    |
+------------------------------------+--------------------------+-------------+
| composer-plugin-api                | symfony/flex             | require     |
| ext-xml                            | symfony/framework-bundle | require     |
| php                                | symfony/console          | require     |
| php                                | symfony/dotenv           | require     |
| php                                | symfony/flex             | require     |
| php                                | symfony/framework-bundle | require     |
| php                                | symfony/test-pack        | require-dev |
| php                                | symfony/yaml             | require     |
| psr/cache                          | symfony/framework-bundle | require     |
| psr/container                      | symfony/console          | require     |
| psr/container                      | symfony/framework-bundle | require     |
| psr/log                            | symfony/framework-bundle | require     |
| symfony/browser-kit                | symfony/test-pack        | require-dev |
| symfony/cache                      | symfony/framework-bundle | require     |
| symfony/cache-contracts            | symfony/framework-bundle | require     |
| symfony/config                     | symfony/framework-bundle | require     |
| symfony/css-selector               | symfony/test-pack        | require-dev |
| symfony/debug                      | symfony/framework-bundle | require     |
| symfony/dependency-injection       | symfony/framework-bundle | require     |
| symfony/dom-crawler                | symfony/test-pack        | require-dev |
| symfony/event-dispatcher           | symfony/framework-bundle | require     |
| symfony/event-dispatcher-contracts | symfony/framework-bundle | require     |
| symfony/filesystem                 | symfony/framework-bundle | require     |
| symfony/finder                     | symfony/framework-bundle | require     |
| symfony/http-foundation            | symfony/framework-bundle | require     |
| symfony/http-kernel                | symfony/framework-bundle | require     |
| symfony/mime                       | symfony/framework-bundle | require     |
| symfony/phpunit-bridge             | symfony/test-pack        | require-dev |
| symfony/polyfill-ctype             | symfony/framework-bundle | require     |
| symfony/polyfill-ctype             | symfony/test-pack        | require-dev |
| symfony/polyfill-ctype             | symfony/yaml             | require     |
| symfony/polyfill-intl-idn          | symfony/framework-bundle | require     |
| symfony/polyfill-mbstring          | symfony/console          | require     |
| symfony/polyfill-mbstring          | symfony/framework-bundle | require     |
| symfony/polyfill-mbstring          | symfony/test-pack        | require-dev |
| symfony/polyfill-php72             | symfony/framework-bundle | require     |
| symfony/polyfill-php73             | symfony/console          | require     |
| symfony/polyfill-php73             | symfony/framework-bundle | require     |
| symfony/routing                    | symfony/framework-bundle | require     |
| symfony/service-contracts          | symfony/console          | require     |
| symfony/service-contracts          | symfony/framework-bundle | require     |
| symfony/var-exporter               | symfony/framework-bundle | require     |
+------------------------------------+--------------------------+-------------+
```

## Exemple package:recipe
```
+--------------------------+-------------------------------------+--------+
| Package                  | File                                | delete |
+--------------------------+-------------------------------------+--------+
| symfony/console          | bin/console                         |        |
| symfony/console          | config/bootstrap.php                |        |
| symfony/flex             | .env                                |        |
| symfony/framework-bundle | config/services.yaml                |        |
| symfony/framework-bundle | src/Controller/.gitignore           | delete |
| symfony/framework-bundle | public/index.php                    | delete |
| symfony/framework-bundle | src/Kernel.php                      |        |
| symfony/framework-bundle | config/packages/test/framework.yaml |        |
| symfony/framework-bundle | config/packages/framework.yaml      |        |
| symfony/framework-bundle | config/packages/cache.yaml          | delete |
| symfony/framework-bundle | config/bootstrap.php                |        |
| symfony/phpunit-bridge   | .env.test                           |        |
| symfony/phpunit-bridge   | bin/phpunit                         |        |
| symfony/phpunit-bridge   | config/bootstrap.php                |        |
| symfony/phpunit-bridge   | phpunit.xml.dist                    |        |
| symfony/phpunit-bridge   | tests/.gitignore                    | delete |
| symfony/routing          | config/packages/dev/routing.yaml    | delete |
| symfony/routing          | config/packages/routing.yaml        | delete |
| symfony/routing          | config/packages/test/routing.yaml   | delete |
| symfony/routing          | config/routes.yaml                  | delete |
+--------------------------+-------------------------------------+--------+
```

## Exemple package:file
```
+-------------------------------------+--------+--------------------------+
| File                                | delete | package                  |
+-------------------------------------+--------+--------------------------+
| .env                                |        | symfony/flex             |
| .env.test                           |        | symfony/phpunit-bridge   |
| bin/console                         |        | symfony/console          |
| bin/phpunit                         |        | symfony/phpunit-bridge   |
| config/bootstrap.php                |        | symfony/phpunit-bridge   |
| config/bootstrap.php                |        | symfony/framework-bundle |
| config/bootstrap.php                |        | symfony/console          |
| config/packages/cache.yaml          | delete | symfony/framework-bundle |
| config/packages/dev/routing.yaml    | delete | symfony/routing          |
| config/packages/framework.yaml      |        | symfony/framework-bundle |
| config/packages/routing.yaml        | delete | symfony/routing          |
| config/packages/test/framework.yaml |        | symfony/framework-bundle |
| config/packages/test/routing.yaml   | delete | symfony/routing          |
| config/routes.yaml                  | delete | symfony/routing          |
| config/services.yaml                |        | symfony/framework-bundle |
| phpunit.xml.dist                    |        | symfony/phpunit-bridge   |
| public/index.php                    | delete | symfony/framework-bundle |
| src/Controller/.gitignore           | delete | symfony/framework-bundle |
| src/Kernel.php                      |        | symfony/framework-bundle |
| tests/.gitignore                    | delete | symfony/phpunit-bridge   |
+-------------------------------------+--------+--------------------------+
```
