<?php

namespace App\Tests\Amazon\Domain\Object\Entity;

use App\Models\Amazon\Domain\Object\Entity\AmazonFbaOrder;
use App\Models\Amazon\Domain\Object\ValueObject\AmazonFbaOrder as AmazonFbaOrderValueObject;
use App\Models\Entity\PalSku;
use PHPUnit\Framework\TestCase;
use Mockery;
use Exception;

class AmazonFbaOrderTest extends TestCase
{
    private AmazonFbaOrder $amazonFbaOrder;

    protected function setUp(): void
    {
        parent::setUp();
        //TODO: Initialize the $amazonFbaOrder here, probably by creating a mock
        $this->amazonFbaOrder = AmazonFbaOrder::createByArrayObject([]);
    }

    public function testCreateByArrayObject(): void
    {
        // TODO: Add assertions here to verify the created instance
        $this->assertInstanceOf(AmazonFbaOrder::class, $this->amazonFbaOrder);
    }

    public function testValueObject(): void
    {
        // TODO: Add assertions here to verify the created instance
        $this->assertInstanceOf(AmazonFbaOrderValueObject::class, $this->amazonFbaOrder->amazonFbaOrder());
    }

    public function testIsUpdate(): void
    {
        $arrayObject['akakuro_div'] = 1;
        $this->amazonFbaOrder->setAmazonFbaOrder(AmazonFbaOrderValueObject::createByArrayObject($arrayObject));
        // TODO: Prepare your AmazonFbaOrder instance for testing isUpdate()
        // For example, you might want to set the akakuroDiv() value to 1
        $result = $this->amazonFbaOrder->isUpdate();
        // TODO: Add assertions here
        $this->assertTrue($result);
    }

    public function testIsCreate(): void
    {
        $arrayObject['akakuro_div'] = 2;
        $this->amazonFbaOrder->setAmazonFbaOrder(AmazonFbaOrderValueObject::createByArrayObject($arrayObject));
        // TODO: Prepare your AmazonFbaOrder instance for testing isCreate()
        // For example, you might want to set the akakuroDiv() value to 2
        $result = $this->amazonFbaOrder->isCreate();
        // TODO: Add assertions here
        $this->assertTrue($result);
    }

    public function testSetSku(): void
    {
        $sku = Mockery::mock(PalSku::class); // TODO: Initialize this with valid values
        $this->amazonFbaOrder->setSku($sku);
        // TODO: Add assertions here
        $this->assertSame($sku, $this->amazonFbaOrder->sku());
    }

    public function testSetSkuAlreadySet(): void
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('SKUは既にセットされております。 Failed setSku');

        $sku1 = Mockery::mock(PalSku::class); // TODO: Initialize this with valid values
        $this->amazonFbaOrder->setSku($sku1);

        $sku2 = Mockery::mock(PalSku::class); // TODO: Initialize this with valid values
        $this->amazonFbaOrder->setSku($sku2);  // This should throw an Exception
    }

    // Do similar tests for setPalProduct() and palProduct()
}
