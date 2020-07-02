<?php

namespace App;

use App\Criteria;
use App\Entity\Tickets;

interface CompanyRepository
{
    public function searchBy(Criteria $criteria): Tickets;
}
