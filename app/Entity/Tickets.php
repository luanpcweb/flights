<?php

namespace App\Entity;

class Tickets implements \Countable, \Iterator
{
    private $tickets = [];
    private $position = 0;

    public function addTicket(Ticket $ticket)
    {
        $this->tickets[] = $ticket;
    }

    public function addTickets(Tickets $tickets)
    {
        $this->tickets = array_merge(
            $this->tickets,
            $tickets->getTicketsAsArray()
        );
    }

    public function count()
    {
        return count($this->tickets);
    }

    public function current(): Ticket
    {
        return $this->tickets[$this->position];
    }

    public function key()
    {
        return $this->position;
    }

    public function next()
    {
        return ++$this->position;
    }

    public function rewind()
    {
        $this->position = 0;
    }

    public function valid()
    {
        return isset($this->tickets[$this->position]);
    }

    public function getTicketsAsArray(): array
    {
        return $this->tickets;
    }

    public function contains(Ticket $ticket): bool
    {
        foreach ($this->tickets as $internalTicket) {
            if($internalTicket->toHashString() === $ticket->toHashString()) {
                return true;
            }
        }

        return false;
    }

}
