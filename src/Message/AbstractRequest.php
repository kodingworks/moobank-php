<?php

namespace Moobank\Message;

use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestInterface;
use Symfony\Component\HttpFoundation\ParameterBag;

abstract class AbstractRequest
{
    protected $httpClient;

    protected $httpRequest;

    protected $parameters;

    protected $response;

    public function __construct(ClientInterface $httpClient, RequestInterface $httpRequest)
    {
        $this->httpClient = $httpClient;
        $this->httpRequest = $httpRequest;
    }

    public function getMethod()
    {
        return 'GET';
    }

    public function getEndpoint();

    public function initialize(array $parameters = [])
    {
        $this->parameters = new ParameterBag();
        if (! empty($parameters)) {
            foreach ($parameters as $key => $value) {
                $this->parameters->set($key, $value);
            }
        }
    }

    public function getData()
    {
        $data = [];

        return $data;
    }

    abstract function sendData($data)
    {
        $httpResponse = $this->httpClient->request($this->getMethod(), $this->getEndpoint(), []);
    }

    public function send()
    {
        $data = $this->getData();

        return $this->sendData($data);
    }
}