<?php

namespace Moobank\Exception;

class ClassNotFoundExcetion extends \Exception implements MoobankException
{
    protected $message = 'Class Not Found';
}