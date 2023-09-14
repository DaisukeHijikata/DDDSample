<?php

namespace ValueObject\old;

use Exception;

class MaxResultsPerPage
{
    const LIMIT = 15;
    private int $value = 0;

    private function __construct(){}

    public static function create(int $value) :MaxResultsPerPage
    {
        $instance = new MaxResultsPerPage();
        if( ! $instance->isValid($value)){
            throw new Exception("一回のリクエストで受け取れるオーダーの件数が限界値を超えています。");
        }
        return $instance;
    }

    private function isValid(int $value = 0) :bool
    {
        if ($value > self::LIMIT) {
            return false;
        }
        return true;
    }

    public function get() :int
    {
        return  $this->value;
    }

}