<?php

namespace App\Tests\Amazon\Domain\Object\ValueObject;

use App\Models\Amazon\Domain\Object\ValueObject\AmazonFbaOrder;
use Carbon\Carbon;
use PHPUnit\Framework\TestCase;

class AmazonFbaOrderTest extends TestCase
{
    private array $properties = [];

    private static array $testCaseByType = [
        'integer' => [1, 0, -1, null],
        'text' => ['test', '', null],
        'timestamp' => ['2020-02-13 12:04:45.973321', null],
    ];

    private static array $columns = [
        ['name' => 'oi_id' ,'type' => 'integer'],
        ['name' => 'mkr_id' ,'type' => 'integer'],
        ['name' => 'brd_id' ,'type' => 'integer'],
        ['name' => 'shop_pro_id' ,'type' => 'integer'],
        ['name' => 'shop_clr_id' ,'type' => 'integer'],
        ['name' => 'shop_size_id' ,'type' => 'integer'],
        ['name' => 'akakuro_div' ,'type' => 'integer'],
        ['name' => 'proc_date' ,'type' => 'timestamp'],
        ['name' => 'order_id' ,'type' => 'text'],
        ['name' => 'shop_code' ,'type' => 'text'],
        ['name' => 'shop_sku_code' ,'type' => 'text'],
        ['name' => 'jan_code' ,'type' => 'text'],
        ['name' => 'sale_div' ,'type' => 'integer'],
        ['name' => 'sale_price_exc_tax' ,'type' => 'integer'],
        ['name' => 'sale_price_inc_tax' ,'type' => 'integer'],
        ['name' => 'sale_method_div' ,'type' => 'integer'],
        ['name' => 'share_stock_dispatch_flg' ,'type' => 'integer'],
        ['name' => 'amount' ,'type' => 'integer'],
        ['name' => 'assign_no' ,'type' => 'text'],
        ['name' => 'reg_date' ,'type' => 'timestamp'],
        ['name' => 'asin' ,'type' => 'text'],
        ['name' => 'purchase_date' ,'type' => 'text'],
        ['name' => 'title' ,'type' => 'text'],
        ['name' => 'quantity_ordered' ,'type' => 'integer'],
        ['name' => 'quantity_shipped' ,'type' => 'integer'],
        ['name' => 'gift_message_text' ,'type' => 'text'],
        ['name' => 'gift_wrap_level' ,'type' => 'integer'],
        ['name' => 'item_price' ,'type' => 'integer'],
        ['name' => 'shipping_amount' ,'type' => 'integer'],
        ['name' => 'gift_wrap_price_amount' ,'type' => 'integer'],
        ['name' => 'item_tax_amount' ,'type' => 'integer'],
        ['name' => 'shipping_tax_amount' ,'type' => 'integer'],
        ['name' => 'gift_wrap_tax_amount' ,'type' => 'integer'],
        ['name' => 'shipping_discount_amount' ,'type' => 'integer'],
        ['name' => 'promotion_discount_amount' ,'type' => 'integer'],
        ['name' => 'shop_cancel_flg' ,'type' => 'integer'],
        ['name' => 'cancel_reason' ,'type' => 'text'],
        ['name' => 'payment_method' ,'type' => 'text'],
        ['name' => 'item_tax_rate' ,'type' => 'text'],
        ['name' => 'tax_div' ,'type' => 'integer'],
        ['name' => 'status' ,'type' => 'text'],
    ];

    private function createNormalCase() :array
    {
        $testCases = [];
        foreach (self::$columns as $column) {
            $testCases[$column['name']] = self::$testCaseByType[$column['type']][0];
        }
        return $testCases;
    }


    protected function setUp(): void
    {
        $this->properties = $this->createNormalCase();
    }

    public function testCreateByArrayObject()
    {
        $this->properties = $this->createNormalCase();
        $amazonFbaOrder = AmazonFbaOrder::createByArrayObject($this->properties);

        $this->assertSame($this->properties['oi_id'], $amazonFbaOrder->oiId());
        $this->assertSame($this->properties['mkr_id'], $amazonFbaOrder->mkrId());
        $this->assertSame($this->properties['brd_id'], $amazonFbaOrder->brdId());
        $this->assertSame($this->properties['shop_pro_id'], $amazonFbaOrder->shopProId());
        $this->assertSame($this->properties['shop_clr_id'], $amazonFbaOrder->shopClrId());
        $this->assertSame($this->properties['shop_size_id'], $amazonFbaOrder->shopSizeId());
        $this->assertSame($this->properties['akakuro_div'], $amazonFbaOrder->akakuroDiv());
        $this->assertSame($this->properties['proc_date'], $amazonFbaOrder->procDateToPostgresFormat());
        $this->assertSame($this->properties['order_id'], $amazonFbaOrder->orderId());
        $this->assertSame($this->properties['shop_code'], $amazonFbaOrder->shopCode());
        $this->assertSame($this->properties['shop_sku_code'], $amazonFbaOrder->shopSkuCode());
        $this->assertSame($this->properties['jan_code'], $amazonFbaOrder->janCode());
        $this->assertSame($this->properties['sale_div'], $amazonFbaOrder->saleDiv());
        $this->assertSame($this->properties['sale_price_exc_tax'], $amazonFbaOrder->salePriceExcTax());
        $this->assertSame($this->properties['sale_price_inc_tax'], $amazonFbaOrder->salePriceIncTax());
        $this->assertSame($this->properties['sale_method_div'], $amazonFbaOrder->saleMethodDiv());
        $this->assertSame($this->properties['share_stock_dispatch_flg'], $amazonFbaOrder->shareStockDispatchFlg());
        $this->assertSame($this->properties['amount'], $amazonFbaOrder->amount());
        $this->assertSame($this->properties['assign_no'], $amazonFbaOrder->assignNo());
        $this->assertSame($this->properties['reg_date'], $amazonFbaOrder->regDateToPostgresFormat());
        $this->assertSame($this->properties['asin'], $amazonFbaOrder->asin());
        $this->assertSame($this->properties['purchase_date'], $amazonFbaOrder->purchaseDate());
        $this->assertSame($this->properties['title'], $amazonFbaOrder->title());
        $this->assertSame($this->properties['quantity_ordered'], $amazonFbaOrder->quantityOrdered());
        $this->assertSame($this->properties['quantity_shipped'], $amazonFbaOrder->quantityShipped());
        $this->assertSame($this->properties['gift_message_text'], $amazonFbaOrder->giftMessageText());
        $this->assertSame($this->properties['gift_wrap_level'], $amazonFbaOrder->giftWrapLevel());
        $this->assertSame($this->properties['item_price'], $amazonFbaOrder->itemPrice());
        $this->assertSame($this->properties['shipping_amount'], $amazonFbaOrder->shippingAmount());
        $this->assertSame($this->properties['gift_wrap_price_amount'], $amazonFbaOrder->giftWrapPriceAmount());
        $this->assertSame($this->properties['item_tax_amount'], $amazonFbaOrder->itemTaxAmount());
        $this->assertSame($this->properties['shipping_tax_amount'], $amazonFbaOrder->shippingTaxAmount());
        $this->assertSame($this->properties['gift_wrap_tax_amount'], $amazonFbaOrder->giftWrapTaxAmount());
        $this->assertSame($this->properties['shipping_discount_amount'], $amazonFbaOrder->shippingDiscountAmount());
        $this->assertSame($this->properties['promotion_discount_amount'], $amazonFbaOrder->promotionDiscountAmount());
        $this->assertSame($this->properties['shop_cancel_flg'], $amazonFbaOrder->shopCancelFlg());
        $this->assertSame($this->properties['cancel_reason'], $amazonFbaOrder->cancelReason());
        $this->assertSame($this->properties['payment_method'], $amazonFbaOrder->paymentMethod());
        $this->assertSame($this->properties['item_tax_rate'], $amazonFbaOrder->itemTaxRate());
        $this->assertSame($this->properties['tax_div'], $amazonFbaOrder->taxDiv());
        $this->assertSame($this->properties['status'], $amazonFbaOrder->status());
    }

    public function testProperties()
    {
        $propertyNames = AmazonFbaOrder::properties();

        foreach ($this->properties as $propertyName => $value) {
            $this->assertTrue(in_array($propertyName, $propertyNames));
        }
    }
}