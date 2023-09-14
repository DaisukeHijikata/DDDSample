<?php

use App\Models\Amazon\Domain\Object\Entity\OrderRequestPeriod;
use Carbon\Carbon;
use PHPUnit\Framework\TestCase;

class OrderRequestPeriodTest extends TestCase
{
    public function testCreateOrderRequestPeriod()
    {
        $start = '2022-12-01 10:00:00';
        $end = '2022-12-02 10:00:00';

        $expectedStart = Carbon::createFromFormat('Y-m-d H:i:s', $start, 'UTC')->toISOString();
        $expectedEnd = Carbon::createFromFormat('Y-m-d H:i:s', $end, 'UTC')->toISOString();

        $period = OrderRequestPeriod::create($start, $end);

        $this->assertInstanceOf(OrderRequestPeriod::class, $period);
        $this->assertEquals($expectedStart, $period->startAt()->toISOString());
        $this->assertEquals($expectedEnd, $period->endAt()->toISOString());
    }

    public function testConvertISO8601Format()
    {
        $date = '2022-12-01 10:00:00';
        $expected = Carbon::createFromFormat('Y-m-d H:i:s', $date, 'UTC')->toISOString();

        $period = new OrderRequestPeriod();
        $result = $period->convertISO8601Format($date);

        $this->assertEquals($expected, $result);
    }
}
