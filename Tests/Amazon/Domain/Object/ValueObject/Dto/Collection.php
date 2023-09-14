<?php

namespace App\Tests\Amazon\Domain\Object\ValueObject\Dto;

class Collection
{
    // example : colloections[0] => ['id' => '1' , 'name' => 'akka' ,...]
    // example : colloections[1] => ['id' => '0' , 'name' => '' ,...]
    // example : colloections[2] => ['id' => null , 'name' => null ,...]
    private array $collections = [];

    private function __construct(){}

    public static function create(array $columns ,array $testCasesByType) :Collection
    {
        $instance = new Collection();
        $instance->collections = $instance->arrayObjectsList($columns ,$testCasesByType);
        return $instance;
    }

    public function arrayObjectsList(array $columns ,array $testCasesByType) :array
    {
        $arrayObjectsList = [];
        foreach($testCasesByType as $testCases){
            $arrayObjectsList[] = $this->arrayObject($columns ,$testCasesByType[$columns['type']]);
        }
        return $arrayObjectsList;
    }

    private function arrayObject(array $columns ,array $testCases) :array
    {
        $arrayObject = [];
        foreach($testCases as $case) {
            foreach ($columns as $col) {
                $arrayObject[] = TypeTest::create($col['name'] ,$case);
            }
        }
        return $arrayObject;
    }

    /**
     * @return array
     */
    public function get(): array
    {
        return $this->collections;
    }
}