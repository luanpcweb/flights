<?php

namespace App\Exceptions;

use Exception;

class DepartureWrongValue extends \UnexpectedValueException
{
    private $departure;

    public function __construct($departure)
    {
        $this->departure = $departure;
    }
}
