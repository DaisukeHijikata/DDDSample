<?php
use PHPUnit\Framework\TestCase;
use App\Models\Amazon\Domain\Object\ValueObject\OrderStatus;

final class OrderStatusTest extends TestCase
{
    public function testShippedStatusCanBeCreated()
    {
        $status = OrderStatus::shipped();
        $this->assertInstanceOf(OrderStatus::class, $status);
        $this->assertEquals('Shipped', $status->getString());
    }

    public function testCanceledStatusCanBeCreated()
    {
        $status = OrderStatus::canceled();
        $this->assertInstanceOf(OrderStatus::class, $status);
        $this->assertEquals('Canceled', $status->getString());
    }

    public function testInvalidStatusCannotBeCreated()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid OrderStatus given');

        new OrderStatus('InvalidStatus');
    }
}