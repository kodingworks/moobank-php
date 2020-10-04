<?php

use GuzzleHttp\Client;
use Moobank\AbstractGateway;
use PHPUnit\Framework\TestCase;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\UriInterface;
use Psr\Http\Message\StreamInterface;

class GatewayTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
    }

    public function testInitMoobank()
    {
        $moobank = new \Moobank\Moobank;

        $this->assertInstanceOf(\Moobank\Moobank::class, $moobank);
    }

    public function testCallGatewayFactory()
    {
        $moobank = new \Moobank\Moobank;
        $moobankFactory = $moobank->getFactory();

        $this->assertInstanceOf(\Moobank\GatewayFactory::class, $moobankFactory);
    }

    public function testCallChildPackage()
    {
        $request = new Request;
        // $psr7Factory = new Diactoros

        $moobank = new \Moobank\Moobank;
        $concrete = $moobank->create(ConcreteClass::class, new \GuzzleHttp\Client, $request);

        $this->assertEquals('Concrete Class', $concrete->getName());
    }

    public function testGetParameters()
    {
        $request = new Request;

        $moobank = new \Moobank\Moobank;
        $concrete = $moobank->create(ConcreteClass::class, new \GuzzleHttp\Client, $request);

        $concrete->setParameter('test', 123);
        $this->assertEquals($concrete->getParameter('test'), 123);
    }
}

// Concrete class to test gateway
class ConcreteClass extends AbstractGateway
{
    protected $parameters = [];

    public function __construct()
    {
        //
    }

    public function getDefaultHttpClient()
    {
        return new Client;
    }

    public function getName()
    {
        return 'Concrete Class';
    }

    public function getModuleName()
    {
        return 'class.concrete';
    }

    public function getParameter($key)
    {
        return $this->parameters[$key];
    }

    public function getParameters()
    {
        return $this->parameters;
    }

    public function setParameter($key, $val)
    {
        $this->parameters[$key] = $val;
    }
}

class Request implements RequestInterface
{
    public function getRequestTarget() {}
    public function withRequestTarget($requestTarget) {}
    public function getMethod() {}
    public function withMethod($method) {}
    public function getUri() {}
    public function withUri(UriInterface $uri, $preserveHost = false) {}

    public function getProtocolVersion() {}
    public function withProtocolVersion($version) {}
    public function getHeaders() {}
    public function hasHeader($name) {}
    public function getHeader($name) {}
    public function getHeaderLine($name) {}
    public function withHeader($name, $value) {}
    public function withAddedHeader($name, $value) {}
    public function withoutHeader($name) {}
    public function getBody() {}
    public function withBody(StreamInterface $body) {}
}