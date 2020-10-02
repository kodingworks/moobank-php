<?php

namespace Moobank\Nessage;

abstract class AbstractResponse
{
    protected $request;

    protected $data;

    public function __construct()
    {
        # code...
    }

    public function gteRequest()
    {
        # code...
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
}