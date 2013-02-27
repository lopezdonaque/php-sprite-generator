# PHP Sprite Generator


## Install dependencies for development

* Check if "phar" files are allowed

```
/etc/php5/cli/conf.d/suhosin.ini
suhosin.executor.include.whitelist = phar
```

* Install development dependencies

```
ant composer
```


## Build phar package

* Execute default ant target

```
ant
```


## Phar usage

```
php php-sprite-generator_1.0.2.phar generator:generate --help
```
