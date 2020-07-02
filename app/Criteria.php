<?php
namespace App;

use App\Entity\Ticket;

interface Criteria
{
    public function match(Ticket $ticket): bool;
}
