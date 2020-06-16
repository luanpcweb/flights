<?php

namespace Test\Unit\Entity;

use App\Entity\SearchCriteria;
use App\Entity\Ticket;
use Tests\TestCase;

class Criteira extends TestCase
{

    /**
     * @test
     */
    public function shloudmatchWithTicketBasedWithoutPrice()
    {
        $from = 'GRU';
        $to = 'LIS';
        $date = new \DateTime('20210-01-01');
        $ticket = new Ticket($from, $to, $date, 10);

        $criteria = new SearchCriteria($from, $to, $date);

        $this->assertTrue($criteria->match($ticket));
    }

    /**
     * @test
     */
    public function shouldMatchWithTicketBasedWithPrice()
    {
        $from = 'GRU';
        $to = 'LIS';
        $date = new \DateTime('2021-01-01');
        $ticket = new Ticket($from, $to, $date, 10);

        $criteria = new SearchCriteria($from, $to, $date, 11);

        $this->assertTrue($criteria->match($ticket));
    }

    /**
     * @test
     */
    public function shouldNotMatchWithTicketBecauseOfTheMaxPrice()
    {
        $from = 'GRU';
        $to = 'LIS';
        $date = new \DateTime('2021-01-01');
        $ticket = new Ticket($from, $to, $date, 12);

        $criteria = new SearchCriteria($from, $to, $date, 11);

        $this->assertFalse($criteria->match($ticket));
    }

    /**
     * @test
     */
    public function shouldNotMatchWithTicketBecauseOfDeparture()
    {
        $from = 'GRU';
        $to = 'LIS';
        $date = new \DateTime('2021-01-01');
        $ticket = new Ticket($from, $to, $date, 12);

        $criteria = new SearchCriteria('POR', $to, $date);

        $this->assertFalse($criteria->match($ticket));
    }

    /**
     * @test
     */
    public function shouldNotMatchWithTicketBecauseOfDestination()
    {
        $from = 'GRU';
        $to = 'LIS';
        $date = new \DateTime('2021-01-01');
        $ticket = new Ticket($from, $to, $date, 12);

        $criteria = new SearchCriteria($from, 'POR', $date);

        $this->assertFalse($criteria->match($ticket));
    }

    /**
     * @test
     */
    public function shouldNotMatchWithTicketBecauseOfDate()
    {
        $from = 'GRU';
        $to = 'LIS';
        $date = new \DateTime('2021-01-01');
        $ticket = new Ticket($from, $to, $date, 12);

        $criteria = new SearchCriteria($from, $to, new \DateTime('2022-02-02'));

        $this->assertFalse($criteria->match($ticket));
    }
}
