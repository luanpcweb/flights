<?php

namespace Test\Unit\Service;

use Tests\TestCase;
use App\Service\FlightSearcher;
use App\Entity\Tickets;
use App\Entity\Ticket;
use App\CompanyRepository;
use App\Entity\SearchResult;

use App\Exceptions\DepartureAirportCodeEmpty;
use App\Exceptions\DepartureWrongValue;

class FlightSearcherTest extends TestCase
{

    /**
     * @test
     */
    public function shouldSearchInOnlyOneCompany()
    {
        $tickets = new Tickets();
        $tickets->addTicket(
            new Ticket('GRU', 'LIS', new \DateTime('2020-03-10 10:10:10'), 10)
        );

        $company = $this->getMockBuilder(CompanyRepository::class)->getMock();
        $company->method('searchBy')->will(
            $this->onConsecutiveCalls($tickets, new Tickets())
        );

        $searcher = new FlightSearcher($company);

        $result = $searcher->search(
            'GRU',
            'LIS',
            new \DateTime('2020-03-31 00:10:10'),
            100
        );

        $this->assertEquals(1, $result->countDeparturesTickets());
        $this->assertEquals(0, $result->countReturnTickets());
    }

    /**
     * @test
     */
    public function shouldSearchInCompaniesMergingResults()
    {
        $ticket1 = new Ticket('GRU', 'LIS', new \DateTime('+10 minutes'), 10);
        $ticket2 = new Ticket('GRU', 'LIS', new \DateTime('+1 weel'), 30);

        $tickets1 = new Tickets();
        $tickets1->addTicket($ticket1);

        $tickets2 = new Tickets();
        $tickets2->addTicket($ticket2);

        $company1 = $this->getMockBuilder(CompanyRepository::class)->getMock();
        $company2 = $this->getMockBuilder(CompanyRepository::class)->getMock();

        $company1->method('searchBy')->will(
            $this->onConsecutiveCalls($tickets1, new Tickets())
        );

        $company2->method('searchBy')->will(
            $this->onConsecutiveCalls($tickets2, new Tickets())
        );

        $searcher = new FlightSearcher($company1, $company2);

        $result = $searcher->search(
            'LIS',
            'GRU',
            new \DateTime('now'),
            100
        );

        $this->assertEquals(2, $result->countDeparturesTickets());
        $this->assertEquals(0, $result->countReturnTickets());
        $this->assertTrue($result->contains($ticket1));
        $this->assertTrue($result->contains($ticket2));
    }

    /**
     * @test
     */
    public function shouldReturnDepartureAndReturnsTickets()
    {
        $departureTickets = new Tickets;
        $departureTickets->addTicket(
            new Ticket('GRU', 'LIS', new \DateTime('+10 minutes'), 10)
        );

        $returnTickets = new Tickets;
        $returnTickets->addTicket(
            new Ticket('LIS', 'GRU', new \DateTime('+24 hour'), 7)
        );
        $returnTickets->addTicket(
            new Ticket('LIS', 'GRU', new \DateTime('+25 hour'), 6)
        );

        $company = $this->createMock(CompanyRepository::class);
        $company->method('searchBy')->will(
            $this->onConsecutiveCalls($departureTickets, $returnTickets, 0)
        );

        $searcher = new FlightSearcher($company);
        $result = $searcher->search(
            'LIS',
            'GRU',
            new \DateTime('now'),
            100,
            new \DateTime('tomorrow')
        );

        $this->assertEquals(1, $result->countDeparturesTickets());
        $this->assertEquals(2, $result->countReturnTickets());
    }

    /**
     * @test
     */
    public function shouldNotListReturnsTicketsIfThereIsNoDepartureTicket()
    {
        $returnTickets = new Tickets;
        $returnTickets->addTicket(
            new Ticket('LIS', 'GRU', new \DateTime('+24 hour'), 7)
        );

        $returnTickets->addTicket(
            new Ticket('LIS', 'GRU', new \DateTime('+25 hour'), 6)
        );

        $company = $this->createMock(CompanyRepository::class);
        $company->method('searchBy')->will(
            $this->onConsecutiveCalls(new Tickets(), $returnTickets, 0)
        );

        $searcher = new FlightSearcher($company);
        $result = $searcher->search(
            'LIS',
            'GRU',
            new \DateTime('now'),
            100,
            new \DateTime('tomorrow')
        );

        $this->assertEquals(0, $result->countDeparturesTickets());
        $this->assertEquals(0, $result->countReturnTickets());
    }

    /**
     * @test
     */
    public function shouldNotSearchDepartureEmpty()
    {
        $departureTickets = new Tickets;
        $departureTickets->addTicket(
            new Ticket('LIS', 'GRU', new \DateTime('+20 hour'), 6)
        );

        $company = $this->createMock(CompanyRepository::class);
        $company->method('searchBy')->will(
            $this->onConsecutiveCalls($departureTickets, new Tickets())
        );

        $this->expectException(DepartureAirportCodeEmpty::class);

        $searcher = new FlightSearcher();
        $searcher->search(
            '',
            'GRU',
            new \DateTime('now'),
            100,
            new \DateTime('tomorrow')
        );
    }

    /**
     * @test
     * @dataProvider departureValidantionProvider
     */
    public function shouldNotSearchDepartureWrongValue($departure)
    {
        $departureTickets = new Tickets;
        $departureTickets->addTicket(
            new Ticket('LIS', 'GRU', new \DateTime('+12 hour'), 12)
        );

        $company = $this->createMock(CompanyRepository::class);
        $company->method('searchBy')->will(
            $this->onConsecutiveCalls($departureTickets, new Tickets())
        );

        $this->expectException(DepartureWrongValue::class);

        $searcher = new FlightSearcher();
        $searcher->search(
            $departure,
            'GRU',
            new \DateTime('now'),
            100,
            new \DateTime('tomorrow')
        );
    }

    public function departureValidantionProvider()
    {
        return [
            ['LI'],
            ['L1S'],
            ['@+='],
            ['@Rg'],
            ['GR&']
        ];
    }
}
