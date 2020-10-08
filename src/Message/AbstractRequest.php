<?php

namespace Moobank\Message;

use Psr\Http\Client\ClientInterface;
use Moobank\Message\RequestInterface;
use Moobank\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;
use Symfony\Component\HttpFoundation\ParameterBag;
use Symfony\Component\HttpFoundation\Response;
use Psr\Http\Message\UriInterface;

abstract class AbstractRequest implements RequestInterface
{
    protected $httpClient;

    protected $httpRequest;

    protected $parameters;

    protected $response;

    protected $endpoint = null;

    protected $method = 'POST';

    public function __construct(ClientInterface $httpClient = null, RequestInterface $httpRequest = null)
    {
        $this->httpClient = $httpClient;
        $this->httpRequest = $httpRequest;

        $this->initialize();
    }

    public function initialize(array $parameters = null)
    {
        $this->parameters = new ParameterBag();
        if (! empty($parameters)) {
            foreach ($parameters as $key => $value) {
                $this->parameters->set($key, $value);
            }
        }

        return $this;
    }

    public function getMethod()
    {
        return $this->method;
    }

    public function getEndpoint()
    {
        if ($mode = $this->parameters->get('mode', 'sandbox')) {
            if ($modeEndpoint = $this->getModeEndpoint($mode)) {
                return $modeEndpoint;
            }
        }

        return $this->endpoint;
    }

    public function getModeEndpoint($mode)
    {
        if (property_exists($this, $mode.'Endpoint')) {
            return $this->{$mode.'Endpoint'};
        }

        return false;
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
            'timeout' => 30,
            'debug' => $this->parameters->get('debug', false)
        ];
    }

    public function getData()
    {
        $data = [];

        return $data;
    }

    public function sendData($data)
    {
        $options = $this->getOptions();
        $options['json'] = $data;

        try {
            $httpResponse = $this->httpClient->request($this->getMethod(), $this->getEndpoint(), $options);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }

        $response = $httpResponse->getBody()->getContents();

        if ($temp = json_decode($response)) {
            if (json_last_error() === JSON_ERROR_NONE) {
                $response = $temp;
            }
        }

        return $this->createResponse($response);
    }

    public function send()
    {
        $data = $this->getData();

        return $this->sendData($data);
    }

    abstract public function createResponse($response);

    public function getResponse()
    {
        return $this->response;
    }

    public function getRequestTarget()
    {
        //
    }

    public function withRequestTarget($requestTarget)
    {
        //
    }

    public function withMethod($method)
    {
        //
    }

    public function getUri()
    {
        //
    }

    public function withUri(UriInterface $uri, $preserveHost = false)
    {
        //
    }

    public function getProtocolVersion() {}
    public function withProtocolVersion($version) {}
    public function hasHeader($name) {}
    public function getHeader($name) {}
    public function getHeaderLine($name) {}
    public function withHeader($name, $value) {}
    public function withAddedHeader($name, $value) {}
    public function withoutHeader($name) {}
    public function getBody() {}
    public function withBody(StreamInterface $body) {}
}