<?php

namespace Moobank\Entities;

class Balance extends AbstractEntities
{
    public $currency = 'IDR';
    public $balance = [
        'available' => 0,
        'float' => 0,
        'hold' => 0,
    ];
}