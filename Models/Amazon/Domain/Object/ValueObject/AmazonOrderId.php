<?php

namespace App\Models\Amazon\Domain\Object\ValueObject;
use Exception;

class AmazonOrderId
{
    private string $value = '';
    private function __construct(string $value){
        $this->value = $value;
    }

    public static function create(string $value) :AmazonOrderId
    {
        $instance = new AmazonOrderId($value);
        if( ! $instance->isValid($value)){
            throw new Exception("AmzonOrderId のフォーマットが正しくありません。");
        }
        return $instance;
    }

    private function isValid(string $value) :bool
    {
        $pattern = '/^\d{3}-\d{7}-\d{7}$/';
        if (preg_match($pattern, $value) === 1) {
            return true;
        }
        return false;
    }

    public function get() :string
    {
        return  $this->value;
    }

}