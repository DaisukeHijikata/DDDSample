<?php

namespace src\Collection;

use App\Models\Collection\Entity;
use src\Entity\EntityInterface;

class EntityCollection {
    /** @var Entity[] */
    private array $entities;

    private function __construct(){}

    public static function create() :EntityCollection
    {
        return new EntityCollection();
    }

    public function add(EntityInterface $entity) :EntityCollection
    {
        return $this;
    }

    public function get() :array
    {
        return $this->entities;
    }
}