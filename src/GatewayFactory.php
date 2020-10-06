<?php

/**
 * Gateway Factory Class
 *
 * @category Library
 * @package  Payment
 * @author   Mohamad Rafi <rafi.randoni@gmail.com>
 * @license  MIT
 */
namespace Moobank;

use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestInterface;

/**
 * Gateway Factory Class
 *
 * This class abstract a set of gateway
 *
 */
class GatewayFactory
{
    protected $gateways = [];

    public function __construct()
    {
        # code...
    }

    public function all()
    {
        return $this->gateways;
    }

    public function create(string $class, ClientInterface $httpClient = null, RequestInterface $request = null)
    {
        if (! class_exists($class)) {
            throw new \Moobank\Exception\ClassNotFoundException;
        }

        $className = (new \ReflectionClass($class))->name;
        if (! isset($this->gateways[$className])) {
            $this->gateways[$className] = new $class($httpClient, $request);
        }

        return $this->gateways[$className];
    }

    /* public function replace(GatewayInterface $oldClass, GatewayInterface $newClass)
    {
        if (isset($this->gateways[$oldClass])) {
            if (is_object($oldClass)) {
                $oldClassName = (new \ReflectionClass($oldClass))->name;
            } else {
                $oldClassName = $oldClass;
                $oldClass = new $oldClass();
            }
        }
    } */
}
