<?php

namespace src\Amazon\Domain\Object\ValueObject\old;

use App\Models\ValueObject\Page;
use Exception;

class NextToken
{
    private string $value = '';

    private function __construct(){}

    public static function create(Page $order) :NextToken
    {
        $instance = new NextToken();
        $orderApi = $sellingPartnerSDK->orders();

        $params = [
            'marketplace_ids' => ['/* YOUR MARKETPLACE IDS */'],
            'created_after' => new \DateTimeImmutable('-3 days'),
        ];

        $page = $orderApi->getOrders($params);
        while(true){

        }

        if( ! $instance->isValid($email)){
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