<?php

namespace App\Repository;

use App\CompanyRepository;
use App\Entity\SearchCriteria;
use App\Entity\Tickets;
use App\Entity\Ticket;

class TAM implements CompanyRepository
{
    private $source;

    public function __construct($source)
    {
        $this->source = $source;
    }

    public function searchBy(SearchCriteria $criteria): Tickets
    {
        $ticketsRaw = \json_decode($this->source, true);

        $tickets = new Tickets;
        foreach ($ticketsRaw as $ticketRaw) {
            $ticket = new Ticket(
                $ticketRaw['departure_airport'],
                $ticketRaw['destination_airport'],
                new \DateTime($ticketRaw['date']),
                $ticketRaw['price']
            );

            if (!$criteria->match($ticket)) {
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
