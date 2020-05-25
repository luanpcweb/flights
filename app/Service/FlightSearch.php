<?php

namespace App\Service;

use App\Repository\Flight;

class FlightSearch
{

    private $flightRepository;

    public function __construct(Flight $flightRepository)
    {
        $this->flightRepository = $flightRepository;
    }
}

