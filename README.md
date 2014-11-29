# GinqCsv

CSV generator for CSV

## Install

composer.json:

```json
{
    "require": {
        "k1low/ginq-csv": "dev-master"
    }
}
```

## Usage

```php
<?php

use Ginq;
use Ginq\GinqCsv;

Ginq::register('Ginq\GinqCsv');

$data = array(
          array(
              'id' => 1,
              'title' => 'Title',
              'body' => 'Hello World',
              'created' => '2014-11-28 00:00:00',
          ),
          array(
              'id' => 2,
              'title' => 'タイトル',
              'body' => 'こんにちは世界',
              'created' => '2014-11-29 00:00:00',
          ),
        );
$result = Ginq::from($data)
            ->toCsv($options);
```
