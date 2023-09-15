<?php

namespace src\Amazon\Domain\Object\ValueObject\old;

use Exception;

class Email
{
    private string $value = '';

    private function __construct(string $value){
        $this->value = $value;
    }

    public static function create(string $value) :Email
    {
        $instance = new Email($value);
        if( ! $instance->isValid($value)){
            throw new Exception("正しくない Email アドレスが渡されました");
        }
        return $instance;
    }

    private function isValid(string $email) :bool
    {
        if ( ! filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return false;
        }
        return true;
    }

    public function get() :string
    {
        return  $this->value;
    }

}