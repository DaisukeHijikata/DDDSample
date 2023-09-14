<?php
namespace App\Models\Amazon\Domain\Collection;
use IteratorAggregate;
use ArrayIterator;
use App\Models\Amazon\Domain\Object\Entity\OrderItem as OriginOrderItem;

class OrderItemsList implements IteratorAggregate
{
    private array $collection;

    private function __construct()
    {
        $this->collection = array();
    }

    public static function create() :OrderItemsList
    {
        return new OrderItemsList();
    }

    public function add(OriginOrderItem $orderItem) :OrderItemsList
    {
        $this->collection[] = $orderItem;
        return $this;
    }

    public function get() :array
    {
        return $this->collection;
    }

    public function getIterator()
    {
        return new ArrayIterator($this->collection);
    }
}