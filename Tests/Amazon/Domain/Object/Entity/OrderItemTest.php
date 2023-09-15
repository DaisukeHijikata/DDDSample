<?php

use AmazonPHP\SellingPartner\Model\Orders\Order;
use AmazonPHP\SellingPartner\Model\Orders\OrderItem as AmazonPHPOrderItem;
use PHPUnit\Framework\TestCase;
use src\Amazon\Domain\Object\Entity\OrderItem;

class OrderItemTest extends TestCase
{
    protected function tearDown(): void
    {
        Mockery::close();
    }

    public function testOrderItemCreation()
    {
        $order = Mockery::mock(Order::class);
        $amazonOrderItem = Mockery::mock(AmazonPHPOrderItem::class);

        $orderItem = OrderItem::create($order, $amazonOrderItem);

        $this->assertSame($order, $orderItem->order());
        $this->assertSame($amazonOrderItem, $orderItem->orderItem());
    }
}
