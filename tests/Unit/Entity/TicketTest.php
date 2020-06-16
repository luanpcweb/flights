<?php

namespace Tests\Unit\Entity;

use App\Entity\Ticket;
use Tests\TestCase;

class TicketTest extends TestCase
{

    /**
     * @test
     */
    public function shouldReturnDayDate()
    {
        $from = 'GRU';
        $to = 'LIS';
        $date = new \DateTime('2021-01-03 01:30:32');

        $ticket = new Ticket($from, $to, $date, 12);

        $expected = '2021-01-03';

        $this->assertEquals($expected, $ticket->getDepartureDayString());
    }

    /**
     * @test
     */
    public function shouldReturnToHashString()
    {
        $from = 'GRU';
        $to = 'LIS';
        $date = new \DateTime('2021-01-03 01:30:32');
        $ticket = new Ticket($from, $to, $date, 12);

        $expected = 'GRU-LIS-20210103013032-12';

        $this->assertEquals($expected, $ticket->toHashString());
    }
}
