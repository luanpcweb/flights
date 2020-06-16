<?php

namespace App\Exceptions;

use Exception;

class DepartureAirportCodeEmpty extends \UnexpectedValueException
{
    private $departureAirportCode;

    public function __construct($departureAirportCode)
    {
        $this->$departureAirportCode = $departureAirportCode;
    }

}
