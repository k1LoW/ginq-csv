# GinqCsv [![Build Status](https://travis-ci.org/k1LoW/ginq-csv.svg?branch=master)](https://travis-ci.org/k1LoW/ginq-csv)

CSV generator for Ginq

## Install

composer.json:

```json
{
    "require": {
        "k1low/ginq-csv": "~0.9.3"
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

// output string
// "1","Title","Hello World","2014-11-28 00:00:00"
// "2","タイトル","こんにちは世界","2014-11-29 00:00:00"


```
