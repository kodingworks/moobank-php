<?php

use GuzzleHttp\Client;
use Moobank\AbstractGateway;
use PHPUnit\Framework\TestCase;

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
        $concrete = $moobank->create(new ConcreteClass, new \GuzzleHttp\Client, $request);

        $this->assertEquals('Concrete Class', $concrete->getName());
    }

    public function testGetParameters()
    {
        $moobank = new \Moobank\Moobank;
        $moobank->setParameter('test', 123);

        var_dump($moobank->getParameters());
        exit;
    }
}

// Concrete class to test gateway
class ConcreteClass extends AbstractGateway
{
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

    public function getParameters()
    {
        return ['id'];
    }
}