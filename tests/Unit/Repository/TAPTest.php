<?php

namespace Tests\Unit\Repository;

use App\Entity\SearchCriteria;
use App\Repository\TAP;
use Tests\TestCase;

class TAPTest extends TestCase
{

    public $xml = <<<EOT
<?xml version="1.0" encoding="UTF-8" ?>
<root>
  <row>
    <from_location>GRU</from_location>
    <to_location>LIS</to_location>
    <date>2020-12-02T00:00:00Z</date>
    <price>350</price>
    <currency>USD</currency>
  </row>
</root>
EOT;

    /**
     * @test
     */
    public function shouldGetFirstTicket()
    {

        $criteria = $this->getMockBuilder(SearchCriteria::class)->disableOriginalConstructor()->getMock();
        $criteria->method('match')->willReturn(true);

        $tap = new TAP($this->xml);
        $tickets = $tap->searchBy($criteria);

        $this->assertCount(1, $tickets);
        $this->assertEquals('GRU', $tickets->current()->getFrom());
        $this->assertEquals('LIS', $tickets->current()->getTo());

    }
}
