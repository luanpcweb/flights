<?php
namespace App\Entity;

class Flight
{

    private $departureAirport;
    private $destinationAirport;
    private $date;
    private $price;
    private $currency;

    public function __construct(string $departureAirport, string $destinationAirport,
        \DateTime $date, string $price, string $currency)
    {
        $this->departureAirport = $departureAirport;
        $this->destinationAriport = $destinationAriport;
        $this->date = $date;
        $this->price = $price;
        $this->currency = $currency;
    }

    public getDepartureAirport() :string
    {
        return $this->departureAirport;
    }

    public getDestinationAirpot() :string
    {
        return $this->destinationAirport;
    }

    public function getDate() :DateTime
    {
        return $this->date;
    }

    public function getPrice() :string
    {
        return $this->price;
    }

    public function getCurrency() :string
    {
        return $this->currency;
    }
}
