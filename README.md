# php-argv
[![Latest Stable Version](https://poser.pugx.org/phlnx/php-argv/v/stable)](https://packagist.org/packages/samejack/php-argv)
[![Build Status](https://travis-ci.org/phlnx/php-argv.svg?branch=master)](https://travis-ci.org/samejack/php-argv) [![Coverage Status](https://coveralls.io/repos/samejack/php-argv/badge.svg?branch=master)](https://coveralls.io/r/samejack/php-argv?branch=master)
[![License](https://poser.pugx.org/phlnx/php-argv/license)](https://packagist.org/packages/samejack/php-argv)

PHP CLI (command-line interface) argurments parser, derived from [samejack/php-argv](https://github.com/samejack/php-argv) with slight modifications.
## Install by composer
```bash
composer require phlnx/php-argv
```

The general idea is this:
* The function will return an array of two elements: `switch` and `param`. Those two elements are in turn arrays.
* The array `params` will have arguments that do not begin with either `-` or `--`. It will be indexed incrementally from 0.
* The array `switch` will have arguments that either begin with `-` or `--`.
* If an argument begins with `--`, it will be returned as a **key** in the `switch` array. If it is passed in the form `--argument=value`, then the value associated with the key will be as passed; otherwise it will be `true`.
* If an argument begins with `-`, and it consists of a **single letter**, it will be returned as a **key** in the `switch` array. If it is passed in the form `-a=value`, then the value associated with the key will be as passed; otherwise it will be `true`.
* If an argument begins with `-`, contains no equal (`-`) sign and is composed of multiple letters, such letters will be **all** returned as keys in the `switch` array.

## CLI Examples
```bash
$ ./example/bin-cli -h=127.0.0.1 -u=user -p=passwd --debug --max-size=3 test
Array
(
    [switch] => Array
        (
            [h] => 127.0.0.1
            [u] => user
            [p] => passwd
            [debug] => 1
            [max-size] => 3
        )

    [param] => Array
        (
            [0] => test
        )
)
```

```bash
$ ./example/bin-cli -asd -u=user -p=passwd --debug --max-size=3 test
Array
(
    [switch] => Array
        (
            [a] => true
            [s] => true
            [d] => true
            [u] => user
            [p] => passwd
            [debug] => true
            [max-size] => 3
        )
    [param] => Array
        (
            [0] => test
        )
)
```

If a single-letter argument beginning with `-` does *not* have an equal sign right after it, what follows will be interpreted as a parameter, and it will be returned with a value of `true` (see `-h` here):

```bash
$ ./example/bin-cli -h 127.0.0.1 --debug --max-size=3 test
Array
(
    [switch] => Array
        (
            [h] => true
            [debug] => true
            [max-size] => 3
        )

    [param] => Array
        (
            [0] => 127.0.0.1
            [1] => test
        )
)
```


## PHP Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

$argvParser = new \phlnx\PHP\ArgvParser();

$string = '-h=127.0.0.1 -u=user -p=passwd --debug --max-size=3 test';

print_r($argvParser->parse($string));
```
Output:
```php
Array
(
    [switch] => Array
        (
            [u] => user
            [p] => passwd
            [debug] => 1
            [max-size] => 3
        )

    [param] => Array
        (
            [0] => test
        )
)
```


## License
Apache License 2.0
