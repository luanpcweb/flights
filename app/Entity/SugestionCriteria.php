<?php
namespace App\Entity;

use App\Criteria;

class SugestionCriteria implements Criteria
{
    private $from;
    private $to;
    private $maxPrice;
    private $date;

    public function __construct(
        string $from,
        string $to,
        \DateTime $date,
        float $maxPrice
    )
    {
        $this->from = $from;
        $this->to = $to;
        $this->maxPrice = $maxPrice;
        $this->date = $date;
    }

    public function match(Ticket $ticket): bool
    {

        if ($ticket->getFrom() != $this->from ||
            ($this->to != null and $ticket->getTo() != $this->to)
        ) {
            return false;
        }

        if ($this->maxPrice !== null && $ticket->getPrice() > $this->maxPrice) {
            return false;
        }

        if ($ticket->getPrice() < $this->maxPrice and
            $ticket->getDepartureDayString() < $this->date->format('Y-m-d') and
            $ticket->getDepartureDayString() >= $this->dateSub($this->date)
        ) {
            return true;
        }

        if ($ticket->getPrice() < $this->maxPrice and
            $ticket->getDepartureDayString() > $this->date->format('Y-m-d') and
            $this->dateAdd($this->date) <= $ticket->getDepartureDayString()
        ) {
            return true;
        }

        return false;
    }

    private function dateSub($date)
    {
        $date->sub(new \DateInterval('P2D'));
        return $date->format('Y-m-d');
    }

    private function dateAdd($date)
    {
        $date->add(new \DateInterval('P2D'));
        return $date->format('Y-m-d');
    }
}
