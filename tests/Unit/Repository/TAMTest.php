<?php

namespace Tests\Unit\Repository;

use App\Entity\SearchCriteria;
use App\Repository\TAM;
use Tests\TestCase;

class TAMTest extends TestCase
{
    public $json = <<<EOT
    [{
        "departure_airport": "GRU",
        "destination_airport": "LIS",
        "date": "2020-12-02T10:00:00-01:00",
        "price": 400,
        "currency": "USD",
        "fare": false
    }]
    EOT;

    /**
     * @test
     */
    public function shouldGetFirstTicket()
    {
        $criteria = $this->getMockBuilder(SearchCriteria::class)->disableOriginalConstructor()->getMock();
        $criteria->method('match')->willReturn(true);

        $tam = new TAM($this->json);
        $tickets = $tam->searchBy($criteria);

        $this->assertCount(1, $tickets);

    }
}
