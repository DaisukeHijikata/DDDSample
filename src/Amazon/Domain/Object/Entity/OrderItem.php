<?php
namespace src\Amazon\Domain\Object\Entity;

use AmazonPHP\SellingPartner\Model\Orders\Order;
use AmazonPHP\SellingPartner\Model\Orders\OrderItem as AmazonPHPOrderItem;

class OrderItem
{
    private ?Order $order = null;
    private ?AmazonPHPOrderItem $orderItem = null;
    private function __construct(Order $order ,AmazonPHPOrderItem $orderItem)
    {
        $this->order= $order;
        $this->orderItem = $orderItem;
    }
    public static function create(Order $order ,AmazonPHPOrderItem $orderItem) :OrderItem
    {
        return new OrderItem($order ,$orderItem);
    }

    /**
     * @return Order|null
     */
    public function order(): ?Order
    {
        return $this->order;
    }

    /**
     * @return AmazonPHPOrderItem|null
     */
    public function orderItem(): ?AmazonPHPOrderItem
    {
        return $this->orderItem;
    }



}