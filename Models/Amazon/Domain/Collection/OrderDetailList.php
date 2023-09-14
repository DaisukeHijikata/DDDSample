<?php
namespace App\Models\Amazon\Domain\Collection;
use App\Models\Amazon\Domain\Object\Entity\OrderDetail;
use IteratorAggregate;
use ArrayIterator;
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