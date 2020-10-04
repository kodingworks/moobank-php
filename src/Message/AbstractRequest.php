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

    protected $endpoint = null;

    protected $method = 'POST';

    public function __construct(ClientInterface $httpClient, RequestInterface $httpRequest)
    {
        $this->httpClient = $httpClient;
        $this->httpRequest = $httpRequest;

        $this->initialize();
    }

    public function initialize(array $parameters = [])
    {
        $this->parameters = new ParameterBag();
        if (! empty($parameters)) {
            foreach ($parameters as $key => $value) {
                $this->parameters->set($key, $value);
            }
        }
    }

    public function getMethod()
    {
        return $this->method;
    }

    public function getEndpoint()
    {
        return $this->endpoint;
    }

    public function getHeaders()
    {
        return [
            'Cache-Control' => 'no-cache',
        ];
    }

    public function getOptions()
    {
        return [
            'headers' => $this->getHeaders(),
            'verify' => false,
            'timeout' => 30
        ];
    }

    public function getData()
    {
        $data = [];

        return $data;
    }

    public function sendData($data)
    {
        try {
            $httpResponse = $this->httpClient->request($this->getMethod(), $this->getEndpoint(), $this->getOptions());
        } catch (\Exception $e) {}
    }

    public function send()
    {
        $data = $this->getData();

        return $this->sendData($data);
    }
}