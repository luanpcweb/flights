<?php

namespace App\Service;

use App\Entity\SearchCriteria;
use App\Entity\SearchResult;
use App\Entity\Tickets;
use App\CompanyRepository;

use App\Exceptions\DepartureAirportCodeEmpty;
use App\Exceptions\DepartureDateEmpty;

class FlightSearcher
{

    private $companies;

    public function __construct(CompanyRepository ...$companies)
    {
        $this->companies = $companies;
    }

    public function search(
        string $departureAirportCode,
        string $destinationAirportCode,
        \Datetime $departureDate,
        float $price = null,
        \Datetime $returnDate = null
    ) {

        if ($price === null) {
            $price = PHP_FLOAT_MAX;
        }

        if(!$departureAirportCode) {
            throw new DepartureAirportCodeEmpty($departureAirportCode);
        }

        if(!$departureDate) {
            throw new DepartureDateEmpty($departureDate);
        }

        $departureTickets = $this->searchOnCompanies(
            new SearchCriteria($departureAirportCode, $destinationAirportCode, $departureDate, $price)
        );

        $returnTickets = new Tickets();
        if(count($departureTickets) > 0) {
            $returnTickets = $this->searchOnCompanies(
                new SearchCriteria($destinationAirportCode, $departureAirportCode, $returnDate, $price)
            );
        }

        return new SearchResult(
            $departureTickets,
            $returnTickets
        );

    }

    private function searchOnCompanies(SearchCriteria $criteria)
    {
        $tickets = new Tickets;
        foreach($this->companies as $company) {
            $foundTickets = $company->searchBy($criteria);
            $tickets->addTickets($foundTickets);
        }

        return $tickets;
    }
}
