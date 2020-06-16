<?php

namespace App\Entity;

class Ticket
{

    private $from;
    private $to;
    private $date;
    private $price;

    public function __construct(
        string $from,
        string $to,
        \DateTime $date,
        float $price
    ) {
        $this->from = $from;
        $this->to = $to;
        $this->date = $date;
        $this->price = $price;
    }

    public function toHashString(): string
    {
        return sprintf('%s-%s-%s-%s', $this->from, $this->to, $this->date->format('YmdHis'), $this->price);
    }

    public function getDateString(): string
    {
        return $this->date->format('Y-m-d H:i:s');
    }

    public function getDepartureDayString(): string
    {
        return $this->date->format('Y-m-d');
    }

    public function getFrom(): string
    {
        return $this->from;
    }

    public function getTo(): string
    {
        return $this->to;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

}
