<?php

namespace Moobank;

use GuzzleHttp\Client;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestInterface;
use Symfony\Component\HttpFoundation\ParameterBag;

abstract class AbstractGateway implements GatewayInterface
{
    protected $httpClient;
    protected $httpRequest;
    protected $parameters;

    public function __construct(ClientInterface $httpClient = null, RequestInterface $httpRequest = null)
    {
        $this->httpClient = $httpClient ?: $this->getDefaultHttpClient();
        $this->httpRequest = $httpRequest ?: $this->getDefaultHttpRequest();

        $this->initialize();
    }

    abstract public function __get($property);

    public function getDefaultHttpClient() {
        return new Client();
    }

    public function getDefaultHttpRequest()
    {
        # code...
    }

    abstract public function getName();

    abstract public function getModuleName();

    public function getDefaultParameters(): Array
    {
        return [];
    }

    public function getParameters()
    {
        return $this->parameters->all();
    }

    public function getParameter($key)
    {
        return $this->parameters->get($key);
    }

    public function initialize(array $parameters = null)
    {
        $this->parameters = new ParameterBag;

        if (! is_null($parameters)) {
            $this->parameters->add($parameters);
        }

        if ($defaultParameters = $this->getDefaultParameters()) {
            foreach ($defaultParameters as $key => $value) {
                $this->parameters->set($key, $value);
            }
        }
    }

    public function setParameter($key, $value)
    {
        $this->parameters->set($key, $value);
    }

    public function getCurrency()
    {
        return $this->parameters->get('currency');
    }

    public function setCurrency(string $currency = null)
    {
        $this->parameters->set('currency', $currency);
    }

    public function createRequest($class, array $parameters = null)
    {
        if (is_null($parameters)) {
            $parameters = [];
        }

        $this->parameters->add($parameters);

        $class = new $class($this->httpClient, $this->httpRequest);
        return $class->initialize($this->parameters->all());
    }
}