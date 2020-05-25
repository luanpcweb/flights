<?php

namespace App\Repository;

use App\Adapter;

class Flight
{

    private $sources;

    public function __construct(array $sources)
    {
        $this->sources = $sources;
    }

    public function loadData()
    {
        $unionSources = [];
        for($i=0; $i < count($this->sources); $i++) {
            $unionSources = array_merge($unionSources, $this->sources[$i]);
        }
        return $unionSources;
    }

    public function findAll($from, $to, $departureDate, $returnDate, $maxPrice)
    {
        $sources = $this->loadData();



    }
}
