<?php

namespace App\Repository;

use App\CompanyRepository;
use App\Entity\SearchCriteria;
use App\Entity\Ticket;
use App\Entity\Tickets;


class TAP implements CompanyRepository
{

    private $source;

    public function __construct($source)
    {
        $this->source = $source;
    }

    public function searchBy(SearchCriteria $criteria): Tickets
    {
        $xml = new \SimpleXMLElement($this->source);
        $tickets = new Tickets;
        foreach ($xml->row as $ticketRaw) {
            $ticket = new Ticket(
                $ticketRaw->from_location,
                $ticketRaw->to_location,
                new \DateTime($ticketRaw->date),
                (float)$ticketRaw->price
            );

            if(!$criteria->match($ticket)) {
                continue;
            }

            if ($tickets->contains($ticket)) {
                continue;
            }

            $tickets->addTicket($ticket);
        }

        return $tickets;
    }
}
