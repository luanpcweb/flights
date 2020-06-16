<?php

namespace App\Exceptions;

use Exception;

class DepartureDateEmpty extends \UnexpectedValueException
{
    private $departureDate;

    public function __construct($departureDate)
    {
        $this->departureDate = $departureDate;
    }
}
