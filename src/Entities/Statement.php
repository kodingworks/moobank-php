<?php

namespace Moobank\Entities;

class Statement extends AbstractEntities
{
    public $date;
    public $branch;
    public $entry;
    public $amount;
    public $description;
    public $hash;
    public $balance;
}