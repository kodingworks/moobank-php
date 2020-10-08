# Moobank

**Core component for the moobank payment library**

Moobank is multi payment gateway on PHP

## Table Of Contents
- [Installation](#install)
- [Basic Example](#basic-usage)
- [Create Your Own Plugin](#create-plugin)

## Installation

> Because moobank is on private repository, so we need setup additional configuration on out composer to installing it

Put this on your composer.json
```json
{
    "require": [
        "moobank/moobank": "@dev",
        ...
    ],
    "repositories": [
        {
            "type": "git",
            "url": "https://gitlab.com/koding-works/moobank/moobank-mandiri-official-api.git"
        }
    ],
    ...
}
```

then do composer update from your terminal

```
composer update
```

## Basic Usage

Init library
```php
$moobank = new Moobank\Moobank;
```

Call the plugin

The first parameter filled with plugin factory

The second parameter filled with http client, here we use guzzle
```php
$moobankFactory = $moobank->create(\Path\To\Plugin::class, new \GuzzleHttp\Client);
```

Do the works

Inquiry transactions
```php
$inquiry = $moobankFactory->banking->inquiry($params);

// Get response's data
var_dump($inquiry->getResponse()->getData());
```

Get current balance
```php
$balance = $moobankFactory->banking->balance($params);

// Get response's data
var_dump($balance->getResponse()->getData());
```

## Create Your Own Plugin

### Basic Concept

Here are the basic concept you must know if you wanted to create your own payment plugin

#### Gateway

Like its name, this is the gateway for the all plugin that use moobank, it is a factory that produce plugin

#### Request



#### Response