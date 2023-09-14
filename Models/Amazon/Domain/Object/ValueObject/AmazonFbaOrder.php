<?php

namespace App\Models\Amazon\Domain\Object\ValueObject;

use Carbon\Carbon;
use ReflectionClass;
use ReflectionProperty;
class AmazonFbaOrder implements DtoInterface
{
    const RESERVE_CODE = "002";

    private ?int $oi_id = null;
    private ?int $mkr_id = null;
    private ?int $brd_id = null;
    private ?int $shop_pro_id = null;
    private ?int $shop_clr_id = null;
    private ?int $shop_size_id = null;
    private ?int $akakuro_div = null;
    private ?Carbon $proc_date = null;
    private ?string $order_id = null;
    private ?string $shop_code = null;
    private ?string $shop_sku_code = null;
    private ?string $jan_code = null;
    private ?int $sale_div = null;
    private ?int $sale_price_exc_tax = null;
    private ?int $sale_price_inc_tax = null;
    private ?int $sale_method_div = null;
    private ?int $share_stock_dispatch_flg = null;
    private ?int $amount = null;
    private ?string $assign_no = null;
    private ?Carbon $reg_date = null;
    private ?string $asin = null;
    private ?string $purchase_date = null;
    private ?string $title = null;
    private ?int $quantity_ordered = null;
    private ?int $quantity_shipped = null;
    private ?string $gift_message_text = null;
    private ?int $gift_wrap_level = null;
    private ?int $item_price = null;
    private ?int $shipping_amount = null;
    private ?int $gift_wrap_price_amount = null;
    private ?int $item_tax_amount = null;
    private ?int $shipping_tax_amount = null;
    private ?int $gift_wrap_tax_amount = null;
    private ?int $shipping_discount_amount = null;
    private ?int $promotion_discount_amount = null;
    private ?int $shop_cancel_flg = null;
    private ?string $cancel_reason = null;
    private ?string $payment_method = null;
    private ?string $item_tax_rate = null;
    private ?int $tax_div = null;
    private ?string $status = null;


    private function __construct(){}

    public static function properties() :array
    {
        $reflector = new ReflectionClass(self::class);
        $properties = $reflector->getProperties(ReflectionProperty::IS_PRIVATE);

        return array_map(function ($property) {
            return $property->getName();
        }, $properties);
    }

    public static function createByArrayObject(array $arrayObject) :self
    {
        $instance = new self();

        $reflector = new ReflectionClass(self::class);
        foreach ($arrayObject as $prop_name => $value) {
            if ($reflector->hasProperty($prop_name)) {
                $property = $reflector->getProperty($prop_name);
                $property->setAccessible(true);
                $propertyType = (string)$property->getType();
                if(is_null($value)){
                    $property->setValue($instance, $value);
                    continue;
                }
                // Check if property type is Carbon\Carbon
                if ($propertyType === 'Carbon\Carbon') {
                    $value = Carbon::parse($value);
                }
                // Check if property type is int and value is string
                if ($propertyType === 'int' && is_string($value)) {
                    $value = (int)$value; // convert string to integer
                }
                $property->setValue($instance, $value);
            }
        }

        return $instance;
    }

    /**
     * @return int|null
     */
    public function oiId(): ?int
    {
        return $this->oi_id;
    }

    /**
     * @return int|null
     */
    public function mkrId(): ?int
    {
        return $this->mkr_id;
    }

    /**
     * @return int|null
     */
    public function brdId(): ?int
    {
        return $this->brd_id;
    }

    /**
     * @return int|null
     */
    public function shopProId(): ?int
    {
        return $this->shop_pro_id;
    }

    /**
     * @return int|null
     */
    public function shopClrId(): ?int
    {
        return $this->shop_clr_id;
    }

    /**
     * @return int|null
     */
    public function shopSizeId(): ?int
    {
        return $this->shop_size_id;
    }

    /**
     * @return int|null
     */
    public function akakuroDiv(): ?int
    {
        return $this->akakuro_div;
    }

    /**
     * @return Carbon|null
     */
    public function procDate(): ?Carbon
    {
        return $this->proc_date;
    }


    /**
     * @return string|null
     */
    public function procDateToPostgresFormat(): ?string
    {
        return $this->proc_date->format('Y-m-d H:i:s.u');
    }

    /**
     * @return string|null
     */
    public function orderId(): ?string
    {
        return $this->order_id;
    }

    /**
     * @return string|null
     */
    public function shopCode(): ?string
    {
        return $this->shop_code;
    }

    /**
     * @return string|null
     */
    public function shopSkuCode(): ?string
    {
        return $this->shop_sku_code;
    }

    /**
     * @return string|null
     */
    public function janCode(): ?string
    {
        return $this->jan_code;
    }

    /**
     * @return int|null
     */
    public function saleDiv(): ?int
    {
        return $this->sale_div;
    }

    /**
     * @return int|null
     */
    public function salePriceExcTax(): ?int
    {
        return $this->sale_price_exc_tax;
    }

    /**
     * @return int|null
     */
    public function salePriceIncTax(): ?int
    {
        return $this->sale_price_inc_tax;
    }

    /**
     * @return int|null
     */
    public function saleMethodDiv(): ?int
    {
        return $this->sale_method_div;
    }

    /**
     * @return int|null
     */
    public function shareStockDispatchFlg(): ?int
    {
        return $this->share_stock_dispatch_flg;
    }

    /**
     * @return int|null
     */
    public function AMOUNT(): ?int
    {
        return $this->amount;
    }

    /**
     * @return string|null
     */
    public function assignNo(): ?string
    {
        return $this->assign_no;
    }

    /**
     * @return Carbon|null
     */
    public function regDate(): ?Carbon
    {
        return $this->reg_date;
    }

    /**
     * @return string|null
     */
    public function regDateToPostgresFormat(): ?string
    {
        return $this->reg_date->format('Y-m-d H:i:s.u');
    }

    /**
     * @return string|null
     */
    public function ASIN(): ?string
    {
        return $this->asin;
    }

    /**
     * @return string|null
     */
    public function purchaseDate(): ?string
    {
        return $this->purchase_date;
    }

    /**
     * @return string|null
     */
    public function TITLE(): ?string
    {
        return $this->title;
    }

    /**
     * @return int|null
     */
    public function quantityOrdered(): ?int
    {
        return $this->quantity_ordered;
    }

    /**
     * @return int|null
     */
    public function quantityShipped(): ?int
    {
        return $this->quantity_shipped;
    }

    /**
     * @return string|null
     */
    public function giftMessageText(): ?string
    {
        return $this->gift_message_text;
    }

    /**
     * @return int|null
     */
    public function giftWrapLevel(): ?int
    {
        return $this->gift_wrap_level;
    }

    /**
     * @return int|null
     */
    public function itemPrice(): ?int
    {
        return $this->item_price;
    }

    /**
     * @return int|null
     */
    public function shippingAmount(): ?int
    {
        return $this->shipping_amount;
    }

    /**
     * @return int|null
     */
    public function giftWrapPriceAmount(): ?int
    {
        return $this->gift_wrap_price_amount;
    }

    /**
     * @return int|null
     */
    public function itemTaxAmount(): ?int
    {
        return $this->item_tax_amount;
    }

    /**
     * @return int|null
     */
    public function shippingTaxAmount(): ?int
    {
        return $this->shipping_tax_amount;
    }

    /**
     * @return int|null
     */
    public function giftWrapTaxAmount(): ?int
    {
        return $this->gift_wrap_tax_amount;
    }

    /**
     * @return int|null
     */
    public function shippingDiscountAmount(): ?int
    {
        return $this->shipping_discount_amount;
    }

    /**
     * @return int|null
     */
    public function promotionDiscountAmount(): ?int
    {
        return $this->promotion_discount_amount;
    }

    /**
     * @return int|null
     */
    public function shopCancelFlg(): ?int
    {
        return $this->shop_cancel_flg;
    }

    /**
     * @return string|null
     */
    public function cancelReason(): ?string
    {
        return $this->cancel_reason;
    }

    /**
     * @return string|null
     */
    public function paymentMethod(): ?string
    {
        return $this->payment_method;
    }

    /**
     * @return string|null
     */
    public function itemTaxRate(): ?string
    {
        return $this->item_tax_rate;
    }

    /**
     * @return int|null
     */
    public function taxDiv(): ?int
    {
        return $this->tax_div;
    }

    /**
     * @return string|null
     */
    public function status(): ?string
    {
        return $this->status;
    }


}