<?php

namespace App\Entity;

class SearchResult implements \JsonSerializable
{
    private $departureResult;
    private $returnResult;

    public function __construct(
        Tickets $departureResult,
        Tickets $returnResult
    ) {
        $this->departureResult = $departureResult;
        $this->returnResult = $returnResult;
    }

    public function countDeparturesTickets(): int
    {
        return count($this->departureResult);
    }

    public function countReturnTickets(): int
    {
        return count($this->returnResult);
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

        return [
            'departure' => $departureTickets,
            'return' => $returnTickets
        ];
    }
}
