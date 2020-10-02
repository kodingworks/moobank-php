<?php

namespace Moobank;

class Moobank
{
    protected $factory;

    public function __construct()
    {
        # code...
    }

    public function getFactory()
    {
        if (! $this->factory) {
            $this->factory = new GatewayFactory;
        }

        return $this->factory;
    }

    public function __call($method, $parameters)
    {
        $factory = $this->getFactory();
        return call_user_func_array([$factory, $method], $parameters);
    }
}