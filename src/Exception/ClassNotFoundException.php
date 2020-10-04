<?php

namespace Moobank\Exception;

class ClassNotFoundException extends \Exception implements MoobankException
{
    protected $message = 'Class Not Found';
}