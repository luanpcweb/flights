<?php

namespace App\Service;

use App\Entity\SearchCriteria;
use App\Entity\SugestionCriteria;
use App\Entity\SearchResult;
use App\Entity\Tickets;
use App\CompanyRepository;

use App\Exceptions\DepartureAirportCodeEmpty;
use App\Exceptions\DepartureWrongValue;
use phpDocumentor\Reflection\Types\Boolean;

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
        \Datetime $returnDate = null,
        bool $sugestions = false
    ) {
        if ($price === null) {
            $price = PHP_FLOAT_MAX;
        }

        if (!$departureAirportCode) {
            throw new DepartureAirportCodeEmpty($departureAirportCode);
        }

        if (strlen($departureAirportCode) < 3) {
            throw new DepartureWrongValue($departureDate);
        }

        if (!preg_match('/^[A-Za-z]+$/i', $departureAirportCode)) {
            throw new DepartureWrongValue($departureDate);
        }

        if ($departureAirportCode === $destinationAirportCode) {
            return new SearchResult(
                new Tickets(),
                new Tickets()
            );
        }

        $departureTickets = $this->searchOnCompanies(
            new SearchCriteria($departureAirportCode, $destinationAirportCode, $departureDate, $price)
        );

        $returnTickets = new Tickets();
        if (count($departureTickets) > 0 and $returnDate != null) {
            $returnTickets = $this->searchOnCompanies(
                new SearchCriteria($destinationAirportCode, $departureAirportCode, $returnDate, $price)
            );
        }

        if ($sugestions) {

            $sugestionTickets = $this->sugestionsOfSerachOnCampanies(
                new SugestionCriteria($departureAirportCode, $destinationAirportCode, $departureDate, $price)
            );

            return new SearchResult(
                $departureTickets,
                $returnTickets,
                $sugestionTickets
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
        foreach ($this->companies as $company) {
            $foundTickets = $company->searchBy($criteria);
            $tickets->addTickets($foundTickets);
        }

        return $tickets;
    }

    private function sugestionsOfSerachOnCampanies(SugestionCriteria $sugestionCriteria)
    {
        $tickets = new Tickets;
        foreach ($this->companies as $company) {
            $foundTickets = $company->searchBy($sugestionCriteria);
            $tickets->addTickets($foundTickets);
        }

        return $tickets;
    }
}
