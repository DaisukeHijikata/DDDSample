<?php

namespace App\Tests\Amazon\Domain\Object\ValueObject;

class DtoFactory
{
    private static array $testCaseByType = [
        'integer' => [1, 0, -1, null],
        'text' => ['test', '', null],
        'timestamp' => ['2020-02-13 12:04:45.973321', null],
    ];

}