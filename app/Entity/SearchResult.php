<?php

namespace App\Entity;

class SearchResult implements \JsonSerializable
{
    private $departureResult;
    private $returnResult;
    private $sugestionTickets;

    public function __construct(
        Tickets $departureResult,
        Tickets $returnResult,
        Tickets $sugestionTickets = null
    ) {
        $this->departureResult = $departureResult;
        $this->returnResult = $returnResult;
        $this->sugestionTickets = $sugestionTickets;
    }

    public function countDeparturesTickets(): int
    {
        return count($this->departureResult);
    }

    public function countReturnTickets(): int
    {
        return count($this->returnResult);
    }

    public function countSugestionTickets(): int
    {
        return count($this->sugestionTickets);
    }

    public function contains(Ticket $ticket): bool
    {
        if ($this->departureResult->contains($ticket)) {
            return true;
        }

        if ($this->returnResult->contains($ticket)) {
            return true;
        }

        return false;
    }

    public function jsonSerialize()
    {
        $departureTickets = [];
        foreach ($this->departureResult as $ticket) {
            $departureTickets[] = [
                'from' => $ticket->getFrom(),
                'to' => $ticket->getTo(),
                'price' => $ticket->getPrice(),
                'date' => $ticket->getDateString(),
            ];
        }

        $returnTickets = [];
        foreach ($this->returnResult as $ticket) {
            $returnTickets[] = [
                'from' => $ticket->getFrom(),
                'to' => $ticket->getTo(),
                'price' => $ticket->getPrice(),
                'date' => $ticket->getDateString()
            ];
        }

        if ($this->sugestionTickets) {
            $sugestionTickets = [];
            foreach ($this->sugestionTickets as $ticket) {
                $sugestionTickets[] = [
                    'from' => $ticket->getFrom(),
                    'to' => $ticket->getTo(),
                    'price' => $ticket->getPrice(),
                    'date' => $ticket->getDateString()
                ];
            }

            return [
                'departure' => $departureTickets,
                'return' => $returnTickets,
                'sugestions' => $sugestionTickets
            ];
        }

        return [
            'departure' => $departureTickets,
            'return' => $returnTickets
        ];
    }
}
