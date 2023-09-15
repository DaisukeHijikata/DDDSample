<?php
namespace src\Amazon\Domain\Collection;
use ArrayIterator;
use IteratorAggregate;
use src\Amazon\Domain\Object\Entity\OrderDetail;

class OrderDetailList implements IteratorAggregate
{
    private array $collection = [];

    private function __construct()
    {
    }

    public static function create() :OrderDetailList
    {
        return new OrderDetailList();
    }

    public function add(OrderDetail $orderDetail) :OrderDetailList
    {
        $this->collection[] = $orderDetail;
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