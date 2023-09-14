<?php
namespace App\Models\Amazon\Domain\Object\Entity;

use AmazonPHP\SellingPartner\Model\Orders\Order;
use AmazonPHP\SellingPartner\Model\Orders\OrderItem;
use Carbon\Carbon;
use App\Models\Amazon\Domain\Object\ValueObject\OrderStatus as OrderStatusOrigin;

class OrderDetail
{

    /*謎の定数
    SHOP_CODE
    SALE_DIV
    SALE_METHOD_DIV
    SHARE_STOCK_DISPATCH_FLG
    */
    const SHOP_CODE = 'PAL';
    const SALE_DIV = 1;
    const SALE_METHOD_DIV  = '001';
    const SHARE_STOCK_DISPATCH_FLG = 0;
    const ISO8601_FORMAT = 'Y-m-d\TH:i:s\Z';
    const TIME_ZONE = "UTC";
    private ?Order $order = null;
    private ?OrderItem $orderItem = null;
    private ?AmazonFbaOrder $amazonFbaOrder = null;

    private function __construct(
        ?Order $order = null,
        ?OrderItem $orderItem = null,
        ?AmazonFbaOrder $amazonFbaOrder = null,
    ){
        $this->order = $order;
        $this->orderItem = $orderItem;
        $this->amazonFbaOrder = $amazonFbaOrder;
    }

    public static function create(
        ?Order $order = null,
        ?AmazonFbaOrder $amazonFbaOrder = null,
    ) :OrderDetail
    {
        $instance = new OrderDetail(
            $order ?? new Order(),
            $orderItem ?? new OrderItem(),
                $amazonFbaOrder ?? AmazonFbaOrder::createByArrayObject([]),
        );
        return $instance;
    }

    public function isUpdate() :bool
    {
        return $this->amazonFbaOrder()->isUpdate();
    }

    public function isCreate() :bool
    {
        return $this->amazonFbaOrder()->isCreate();
    }

    public function amazonOrderId() :?int
    {
        return $this->order->getAmazonOrderId();
    }

    private function isRedSlip() :bool
    {
        return $this->order->getOrderStatus() === OrderStatusOrigin::canceled()->get();
    }

    private function isReturn() :bool
    {
        return $this->order->getOrderStatus() === OrderStatusOrigin::canceled()->get();
    }

    public function processDate() :string
    {
        return $this->convertISO8601Format($this->order->getPurchaseDate());
    }

    public function status() :string
    {
        return $this->order->getOrderStatus();
    }

    private function convertISO8601Format(string $date) :string
    {
        return Carbon::parse($date)->setTimezone(self::TIME_ZONE)->toISOString();
    }

    public function redBlack() :int
    {
        return $this->isRedSlip() ? 1 : 2;
    }

    public function transactionType() :int
    {
        return $this->isReturn() ? 1 : 0;
    }

    public function salePriceExcTax() :?int
    {
        if(empty($this->orderItem->getItemPrice())){
            throw new \Exception("税金なしのためエラー発生 salePriceExcTax :" .__CLASS__);
        }
        return
        floor($this->orderItem->getItemPrice()->getAmount() /(int)$this->orderItem->getQuantityOrdered())
        - floor($this->orderItem->getItemPrice()->getAmount() /$this->order->getBuyerTaxInformation());
    }

    public function salePriceIncTax() :?int
    {
        if (empty($this->orderItem->getItemPrice())) {
            throw new \Exception("金額なしのためエラー発生 getListPrice :" .__CLASS__);
        }
        return floor($this->orderItem->getItemPrice()->getAmount()) / (int)$this->orderItem->getQuantityOrdered();
    }

    public function amount() :?int
    {
        return $this->orderItem->getItemPrice()->getAmount();
    }

    public function assignNo() :?string
    {
        // 出荷済 or キャンセル済なら次回連携時にリクエストを送信しないようにassign_noをセットする

        return ($this->order->getOrderStatus() == OrderStatusOrigin::shipped()->get()
            || $this->order->getOrderStatus() == OrderStatusOrigin::canceled()->get())
            ? date('ymdHis')
            : null;
    }

    public function asin() :?string
    {
        return $this->orderItem->getAsin();
    }

    public function title() :?string
    {
        return $this->orderItem->getTitle();
    }

    public function quantityOrdered() :?int
    {
        return $this->orderItem->getQuantityOrdered();
    }

    public function quantityShipped() :?int
    {
        return $this->orderItem->getQuantityShipped();
    }

    public function giftMessageText() :?string
    {
        return $this->orderItem->getBuyerInfo()->getGiftMessageText();
    }

    public function giftWrapLevel() :?string
    {
        return $this->orderItem->getBuyerInfo()->getGiftWrapLevel();
    }

    public function itemPrice() :?int
    {
        return $this->orderItem->getItemPrice()->getAmount();
    }

    public function shippingAmount() :?int
    {
        return $this->orderItem->getShippingPrice()->getAmount();
    }

    public function giftWrapPriceAmount() :?int
    {
        return $this->orderItem->getBuyerInfo()->getGiftWrapPrice()->getAmount();
    }

    public function itemTaxAmount() :?int
    {
        return $this->orderItem->getItemTax()->getAmount();
    }

    public function shippingTaxAmount() :?int
    {
        return $this->orderItem->getItemTax()->getAmount();
    }

    public function giftWrapTaxAmount() :?int
    {
        return $this->orderItem->getBuyerInfo()->getGiftWrapTax()->getAmount();
    }

    public function shippingDiscountAmount() :?int
    {
        return $this->orderItem->getShippingDiscount()->getAmount();
    }

    public function promotionDiscountAmount() :?int
    {
        return $this->orderItem->getPromotionDiscount()->getAmount();
    }

    public function paymentMethod() :?string
    {
        return $this->order->getPaymentMethod();
    }

    public function itemTaxRate() :?string
    {
        return null;
    }

    public function shopCancelFlg() :?int
    {
        return null;
    }

    public function taxDiv() :?string
    {
        return null;
    }

    public function cancelReason() :?string
    {
        return null;
    }

    /**
     * @return AmazonFbaOrder|null
     */
    public function amazonFbaOrder(): ?AmazonFbaOrder
    {
        return $this->amazonFbaOrder;
    }


}