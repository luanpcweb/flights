<?php

namespace App\Entity;

class SearchCriteria
{
    private $from;
    private $to;
    private $date;
    private $maxPrice;

    public function __construct(
        string $from,
        string $to,
        \DateTime $date = null,
        float $maxPrice = null
    ) {
        $this->from = $from;
        $this->to = $to;
        $this->date = $date;
        $this->maxPrice = $maxPrice;
    }

    public function match(Ticket $ticket): bool
    {
        if ($ticket->getFrom() != $this->from ||
            $ticket->getTo() != $this->to
        ) {
            return false;
        }

        if ($this->maxPrice !== null && $ticket->getPrice() > $this->maxPrice) {
            return false;
        }

        if ($this->date === null) {
            return true;
        }

        return $this->date->format('Y-m-d') === $ticket->getDepartureDayString();
    }
}
