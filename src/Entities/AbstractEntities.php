<?php

namespace Moobank\Entities;

abstract class AbstractEntities
{
    public function __construct(?array $data = null)
    {
        $this->applyData($data);
    }

    public function applyData(?array $data = null)
    {
        foreach ($data as $key => $value) {
            if (property_exists($this, $key)) {
                $this->{$key} = $value;
            }
        }
    }
}