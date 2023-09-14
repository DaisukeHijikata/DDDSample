<?php

namespace App\Tests\Amazon\Domain\Object\ValueObject\Dto;

class TypeTest
{
    private string $name = '';
    private string $expect = '';

    private function __construct(string $name ,string $expect){
        $this->name = $name;
        $this->expect = $expect;
    }

    public static function create(string $name ,string $expect) :TypeTest
    {
        return new TypeTest($name ,$expect);
    }

    /**
     * @return string
     */
    public function name(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function expect(): string
    {
        return $this->expect;
    }
}