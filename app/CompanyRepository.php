<?php

namespace App;

use App\Entity\SearchCriteria;
use App\Entity\Tickets;

interface CompanyRepository
{
    public function searchBy(SearchCriteria $criteria): Tickets;
}

