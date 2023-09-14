<?php

use App\Models\Amazon\Domain\Object\ValueObject\AmazonOrderId;
use PHPUnit\Framework\TestCase;

class AmazonOrderIdTest extends TestCase
{
    public function testCreateValidOrderId()
    {
        $validOrderId = "123-1234567-1234567";
        $amazonOrderId = AmazonOrderId::create($validOrderId);
        $this->assertInstanceOf(AmazonOrderId::class, $amazonOrderId);
        $this->assertEquals($validOrderId, $amazonOrderId->get());
    }

    public function testCreateInvalidOrderId()
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage("AmzonOrderId のフォーマットが正しくありません。");

        $invalidOrderId = "123-123456-123456";
        AmazonOrderId::create($invalidOrderId);
    }
}