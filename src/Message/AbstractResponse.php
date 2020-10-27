<?php

namespace Moobank\Message;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\StreamInterface;

abstract class AbstractResponse implements ResponseInterface
{
    protected $request;

    protected $data;

    public function __construct(RequestInterface $request, $data)
    {
        $this->request = $request;
        $this->data = $data;
    }

    public function getRequest()
    {
        return $this->request;
    }

    public function getRaw()
    {
        return $this->data;
    }

    public function getData()
    {
        return $this->data;
    }

    public function getCode()
    {
        # code...
    }

    public function getMessage()
    {
        # code...
    }

    public function getStatusCode()
    {
        //
    }

    public function withStatus($code, $reasonPhrase = '')
    {
        //
    }

    public function getReasonPhrase()
    {
        //
    }

    public function getProtocolVersion()
    {
        //
    }

    public function withProtocolVersion($version)
    {
        //
    }

    public function getHeaders()
    {
        //
    }

    public function hasHeader($name)
    {
        //
    }

    public function getHeader($name)
    {
        //
    }

    public function getHeaderLine($name)
    {
        //
    }

    public function withHeader($name, $value)
    {
        //
    }

    public function withAddedHeader($name, $value)
    {
        //
    }

    public function withoutHeader($name)
    {
        //
    }

    public function getBody()
    {
        //
    }

    public function withBody(StreamInterface $body)
    {
        //parent::withBody($body);
    }

}