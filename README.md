
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

All child factory must extends from AbstractGateway

#### Request

Request handle data that sent to api, we prepare and manipulate data in here

All child request object must extends from AbstractRequest

#### Response

Response hold response data from api

All child response object must extends from AbstractResponse

### Creating plugin
- [Creating Factory](#creating-factory)
- [Creating Request](#creating-request)

#### Rules

- Plugin namespace should start with Moobank\
- Moobank has mode parameter, it used to switch environment, ie: live, development (detail can be found on request section)

#### Creating Factory

Factory is main class from plugin, we set access token and any default api requirement in here

- [Creating Base Factory](#creating-base-factory)
- [Creating Payment Factory](#creating-payment-factory)

##### Creating Base Factory

Here is base class that should exists in every factory object

```php

namespace Moobank\MandiriApi;

use Moobank\AbstractGateway;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestInterface;

class Factory extends AbstractGateway
{
    protected $accessToken;

    public function __construct(ClientInterface $httpClient = null, RequestInterface $httpRequest = null)
    {
        parent::__construct($httpClient, $httpRequest);
    }

    public function __get($property)
    {
        $className = sprintf('%1s\%2s', 'Moobank\MandiriApi', ucfirst(strtolower($property)));
        if (class_exists($className)) {

            $class  = new $className($this->httpClient, $this->httpRequest);
            $class->initialize($this->parameters->all());
            $class->setParameter('accessToken', $this->getToken());

            return $class;
        }

        throw new \Moobank\Exception\ClassNotFoundException;
    }

    public function getName()
    {
        return 'Mandiri Official API';
    }

    public function getModuleName()
    {
        return 'moobank.api.official.mandiri';
    }
}

```

**Description:**

| Method | Default Params | Description |
| - | - | - |
| __get | $property | We use magic method on banking factory, to route every request to another (banking, payment, etc) factory, in this code, we place the other factory on root src folder |
| getName | - | Return the plugin's name  |
| getModuleName | - | Return the plugin module's name, it must unique from other plugin  |

##### Creating Banking Factory

```php

namespace Moobank\MandiriApi;

use Moobank\AbstractGateway;
use Psr\Http\Client\ClientInterface;
use Moobank\Message\RequestInterface;

class Banking extends AbstractGateway
{
    public function __construct(ClientInterface $httpClient = null, RequestInterface $httpRequest = null)
    {
        $this->httpClient = $httpClient;
        $this->httpRequest = $httpRequest;
    }

    public function getName()
    {
        return 'Mandiri Official API - Banking Service';
    }

    public function getModuleName()
    {
        return 'service.api.official.mandiri';
    }

    public function inquiry(array $parameters = [])
    {
        //
    }

    public function balance(array $parameters = [])
    {
        //
    }
}

```

**Description:**

| Method | Default Params | Description |
| - | - | - |
| __get | $property | We use magic method on banking factory, to route every request to another (banking, payment, etc) factory, in this code, we place the other factory on root src folder |
| getName | - | Return the plugin's name  |
| getModuleName | - | Return the plugin module's name, it must unique from other plugin  |
| inquiry | $parameters | Inquiry transactions from accounts |
| balance | $parameters | Get current balance from accounts |

##### Creating Payment Factory

 // TODO LATER

#### Creating Request

##### Creating Inquiry Request

```php

namespace Moobank\MandiriApi\Message;

use Moobank\Message\AbstractRequest;

class BankingInquiryRequest extends AbstractRequest
{
    protected $endpoint = '';
    protected $sandboxEndpoint = '';

    protected $method = 'POST';

    public function getHeaders()
    {
        $headers = parent::getHeaders();

        return array_merge($headers, [
            // Set additional headers here
        ]);
    }

    public function getData()
    {
        return [
            // Data that will be sent to api
        ];
    }

    public function createResponse($response)
    {
        if (false === ($response instanceof \Psr\Http\Message\ResponseInterface)) {
            $response = new \Moobank\MandiriApi\Message\BankingInquiryResponse($this, $response);
        }

        $this->response = $response;

        return $this;
    }
}

```

**Description:**

| Property | Default Params | Description |
| - | - | - |
| endpoint | - | live api url, used when mode set to live |
| sandboxEndpoint | - | sandbox api url, used when mode set to sandbox |
| method | - | request method |

| Method | Default Params | Description |
| - | - | - |
| getHeaders | - | Return all headers that will be used when send request to api |
| getData | - | Data that will be sent to api |
| createResponse | - | Handling response data here |