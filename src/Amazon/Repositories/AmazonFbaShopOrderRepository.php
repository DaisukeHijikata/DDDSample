<?php
namespace src\Amazon\Repositories;
use AmazonPHP\SellingPartner\Model\Orders\OrderItem;
use App\Commands\Libs\Api\SpApi\AmzNewSalesReturn\Model\SKU;
use App\Common\DB;
use Exception;
use src\Amazon\Domain\Object\Entity\AmazonFbaOrder;
use src\Amazon\Domain\Object\Entity\OrderDetail;
use src\Amazon\Exceptions\SQLException;
use src\Amazon\Repositories\Interfaces\AmazonFbaShopOrderRepositoryInterface;
use src\Entity\PalProduct;
use src\Entity\PalSku;
use const App\Models\Amazon\Repositories\PAL_MAKER_ID;

/**
 * pal_sku テーブルを操作するクラス<br>
 * 結合している場合は、メインとするテーブル操作
 */
class AmazonFbaShopOrderRepository implements AmazonFbaShopOrderRepositoryInterface
{
    const TABLE = "amzfba_shop_order_info";
    const SECOND_TABLE = "pal_product";
    const THIRD_TABLE = "pal_sku";

    private function __construct(){}

    public static function create() :AmazonFbaShopOrderRepository
    {
        $instance = new AmazonFbaShopOrderRepository();
        return $instance;
    }

    /**
     * @param OrderItem $orderItem
     * @param SKU $sku
     * @return AmazonFbaOrder|null
     * @throws Exception
     */
    public function findByOrderItem(OrderItem $orderItem) :?AmazonFbaOrder
    {
        $amazonFbaShopOrder = self::TABLE;
        $palProduct = self::SECOND_TABLE;
        $palSku= self::THIRD_TABLE;
        $sql = <<<SQL
            SELECT	
                $amazonFbaShopOrder.*,
                $palProduct.*
                $palSku.*
            FROM
                $amazonFbaShopOrder
            INNER JOIN
                $palProduct
                ON $amazonFbaShopOrder.mkr_id = $palProduct.mkr_id
                AND $amazonFbaShopOrder.brd_id = $palProduct.brd_id
                AND $amazonFbaShopOrder.pro_id = $palProduct.pro_id
            INNER JOIN
                $palSku                
                ON $palSku.mkr_id = $palProduct.mkr_id
                AND $palSku.brd_id = $palProduct.brd_id
                AND $palSku.pro_id = $palProduct.pro_id
                AND $palSku.clr_id = $palProduct.pro_id
                AND $palSku.size_id = $palProduct.pro_id
            WHERE
                $palSku.mkr_sku = :mkr_sku
                $palSku.mkr_id = :mkr_id
        SQL;

        $bindParam['mkr_sku'] = $orderItem->getSellerSku();
        $bindParam['mkr_id'] = PAL_MAKER_ID;
        $arrayObject = DB::select($sql, $bindParam);
        if($arrayObject === false){
            throw new SQLException(__CLASS__ .' : findByOrderItemSku Failed');
        }
        $palProduct = $this->createPalProduct($arrayObject);
        $amazonFbaShopOrder = $this->createAmazonFbaShopOrder($arrayObject);
        $palSku = $this->createPalSku($arrayObject);
        $amazonFbaShopOrder->setSku($palSku);
        $amazonFbaShopOrder->setPalProduct($palProduct);
        return $amazonFbaShopOrder;
    }


    private function createAmazonFbaShopOrder(array $arrayObject) :AmazonFbaOrder
    {
        $ArrayObject = [];
        foreach(AmazonFbaOrder::properties() as $propertyName){
            $ArrayObject[$propertyName] = $arrayObject[$propertyName];
        }
        return AmazonFbaOrder::createByArrayObject($ArrayObject);
    }


    private function createPalSku(array $arrayObject) :PalSku
    {
        $palSkuArrayObject = [];
        foreach(PalSku::properties() as $propertyName){
            $palSkuArrayObject[$propertyName] = $arrayObject[$propertyName];
        }
        return PalSku::createByArrayObject($palSkuArrayObject);
    }


    private function createPalProduct(array $arrayObject) :PalProduct
    {
        $palProductArrayObject = [];
        foreach(PalProduct::properties() as $propertyName){
            $palProductArrayObject[$propertyName] = $arrayObject[$propertyName];
        }
        return PalProduct::createByArrayObject($palProductArrayObject);
    }

    public function insert(OrderDetail $orderDetail) :bool
    {
        $amazonFbaShopOrder = self::TABLE;
        $sql = <<< SQL
        insert into $amazonFbaShopOrder(
            oi_id,
            mkr_id,
            brd_id,
            shop_pro_id,
            shop_clr_id,
            shop_size_id,
            akakuro_div,
            proc_date,
            order_id,
            shop_code,
            shop_sku_code,
            jan_code,
            sale_div,
            sale_price_exc_tax,
            sale_price_inc_tax,
            sale_method_div,
            share_stock_dispatch_flg,
            amount,
            assign_no,
            reg_date,
            asin,
            purchase_date,
            title,
            quantity_ordered,
            quantity_shipped,
            gift_message_text,
            gift_wrap_level,
            item_price,
            shipping_amount,
            gift_wrap_price_amount,
            item_tax_amount,
            shipping_tax_amount,
            gift_wrap_tax_amount,
            shipping_discount_amount,
            promotion_discount_amount,
            shop_cancel_flg,
            cancel_reason,
            payment_method,
            item_tax_rate,
            tax_div,
            status
        )
        values(
            nextval('oi_id'),
            :mkr_id,
            :brd_id,
            :shop_pro_id,
            :shop_clr_id,
            :shop_size_id,
            :akakuro_div,
            :proc_date,
            :order_id,
            :shop_code,
            :shop_sku_code,
            :jan_code,
            :sale_div,
            :sale_price_exc_tax,
            :sale_price_inc_tax,
            :sale_method_div,
            :share_stock_dispatch_flg,
            :amount,
            :assign_no,
            now(),
            :asin,
            :purchase_date,
            :title,
            :quantity_ordered,
            :quantity_shipped,
            :gift_message_text,
            :gift_wrap_level,
            :item_price,
            :shipping_amount,
            :gift_wrap_price_amount,
            :item_tax_amount,
            :shipping_tax_amount,
            :gift_wrap_tax_amount,
            :shipping_discount_amount,
            :promotion_discount_amount,
            :shop_cancel_flg,
            :cancel_reason,
            :payment_method,
            :item_tax_rate,
            :tax_div,
            :status
        )
SQL;

            $bindParam[':mkr_id'] = $orderDetail->amazonFbaOrder()->sku()->mkrId();
            $bindParam[':brd_id'] = $orderDetail->amazonFbaOrder()->sku()->brdId();
            $bindParam[':shop_pro_id'] = $orderDetail->amazonFbaOrder()->shopProId();
            $bindParam[':shop_clr_id'] = $orderDetail->amazonFbaOrder()->shopClrId();
            $bindParam[':shop_size_id'] = $orderDetail->amazonFbaOrder()->shopSizeId();
            $bindParam[':akakuro_div'] = $orderDetail->redBlack();
            $bindParam[':proc_date'] = $orderDetail->processDate();
            $bindParam[':order_id'] = $orderDetail->amazonOrderId();
            $bindParam[':shop_code'] = $orderDetail::SHOP_CODE;
            $bindParam[':shop_sku_code'] = $orderDetail->amazonFbaOrder()->sku()->mkrSku();
            $bindParam[':jan_code'] = $orderDetail->amazonFbaOrder()->sku()->jan();
            $bindParam[':sale_div'] = $orderDetail::SALE_DIV;
            $bindParam[':sale_price_exc_tax'] = $orderDetail->salePriceExcTax();
            $bindParam[':sale_price_inc_tax'] = $orderDetail->salePriceIncTax();
            $bindParam[':sale_method_div'] = $orderDetail::SALE_METHOD_DIV;
            $bindParam[':share_stock_dispatch_flg'] = $orderDetail::SHARE_STOCK_DISPATCH_FLG;
            $bindParam[':amount'] = $orderDetail->amount();
            $bindParam[':assign_no'] = $orderDetail->assignNo();
            $bindParam[':asin'] = $orderDetail->asin();
            $bindParam[':purchase_date'] = $orderDetail->processDate();
            $bindParam[':title'] = $orderDetail->title();
            $bindParam[':quantity_ordered'] = $orderDetail->quantityOrdered();
            $bindParam[':quantity_shipped'] = $orderDetail->quantityShipped();
            $bindParam[':gift_message_text'] = $orderDetail->giftMessageText();
            $bindParam[':gift_wrap_level'] = $orderDetail->giftWrapLevel();
            $bindParam[':item_price'] = $orderDetail->itemPrice();
            $bindParam[':shipping_amount'] = $orderDetail->shippingAmount();
            $bindParam[':gift_wrap_price_amount'] = $orderDetail->giftWrapPriceAmount();
            $bindParam[':item_tax_amount'] = $orderDetail->itemTaxAmount();
            $bindParam[':shipping_tax_amount'] = $orderDetail->shippingTaxAmount();
            $bindParam[':gift_wrap_tax_amount'] = $orderDetail->giftWrapTaxAmount();
            $bindParam[':shipping_discount_amount'] = $orderDetail->shippingDiscountAmount();
            $bindParam[':promotion_discount_amount'] = $orderDetail->promotionDiscountAmount();
            $bindParam[':shop_cancel_flg'] = $orderDetail->shopCancelFlg();
            $bindParam[':cancel_reason'] = $orderDetail->cancelReason();
            $bindParam[':payment_method'] = $orderDetail->paymentMethod();
            $bindParam[':item_tax_rate'] = $orderDetail->itemTaxRate();
            $bindParam[':tax_div'] = $orderDetail->taxDiv();
            $bindParam[':status'] = $orderDetail->status();

            $result = DB::update($sql, $bindParam);
            return is_bool($result) ? false : true;
        }

    public function update(OrderDetail $orderDetail) :bool
    {
        $amazonFbaShopOrder = self::TABLE;
        $sql = <<< SQL
        update
            $amazonFbaShopOrder
        set
            akakuro_div = :akakuro_div,
            proc_date = :proc_date,
            sale_price_exc_tax = :sale_price_exc_tax,
            sale_price_inc_tax = :sale_price_inc_tax,
            amount = :amount,
            assign_no = :assign_no,
            purchase_date = :purchase_date,
            title = :title,
            quantity_ordered = :quantity_ordered,
            quantity_shipped = :quantity_shipped,
            gift_message_text = :gift_message_text,
            gift_wrap_level = :gift_wrap_level,
            item_price = :item_price,
            shipping_amount = :shipping_amount,
            gift_wrap_price_amount = :gift_wrap_price_amount,
            item_tax_amount = :item_tax_amount,
            shipping_tax_amount = :shipping_tax_amount,
            gift_wrap_tax_amount = :gift_wrap_tax_amount,
            shipping_discount_amount = :shipping_discount_amount,
            promotion_discount_amount = :promotion_discount_amount,
            payment_method = :payment_method,
            item_tax_rate = :item_tax_rate,
            tax_div = :tax_div,
            status = :status
        where
            mkr_id = :mkr_id
            and shop_sku_code = :shop_sku_code
            and order_id = :order_id
            and akakuro_div = :akakuro_div
SQL;

        $bindParam[':mkr_id'] = $orderDetail->amazonFbaOrder()->sku()->mkrId();
        $bindParam[':shop_sku_code'] = $orderDetail->amazonFbaOrder()->sku()->mkrSku();
        $bindParam[':order_id'] = $orderDetail->amazonOrderId();
        $bindParam[':akakuro_div'] = $orderDetail->redBlack();
        $bindParam[':proc_date'] = $orderDetail->processDate();
        $bindParam[':sale_price_exc_tax'] = $orderDetail->salePriceExcTax();
        $bindParam[':sale_price_inc_tax'] = $orderDetail->salePriceIncTax();
        $bindParam[':amount'] = $orderDetail->amount();
        $bindParam[':assign_no'] = $orderDetail->assignNo();
        $bindParam[':purchase_date'] = $orderDetail->processDate();
        $bindParam[':title'] = $orderDetail->title();
        $bindParam[':quantity_ordered'] = $orderDetail->quantityOrdered();
        $bindParam[':quantity_shipped'] = $orderDetail->quantityShipped();
        $bindParam[':gift_message_text'] = $orderDetail->giftMessageText();
        $bindParam[':gift_wrap_level'] = $orderDetail->giftWrapLevel();
        $bindParam[':item_price'] = $orderDetail->itemPrice();
        $bindParam[':shipping_amount'] = $orderDetail->shippingAmount();
        $bindParam[':gift_wrap_price_amount'] = $orderDetail->giftWrapPriceAmount();
        $bindParam[':item_tax_amount'] = $orderDetail->itemTaxAmount();
        $bindParam[':shipping_tax_amount'] = $orderDetail->shippingTaxAmount();
        $bindParam[':gift_wrap_tax_amount'] = $orderDetail->giftWrapTaxAmount();
        $bindParam[':shipping_discount_amount'] = $orderDetail->shippingDiscountAmount();
        $bindParam[':promotion_discount_amount'] = $orderDetail->promotionDiscountAmount();
        $bindParam[':payment_method'] = $orderDetail->paymentMethod();
        $bindParam[':item_tax_rate'] = $orderDetail->itemTaxRate();
        $bindParam[':tax_div'] = $orderDetail->taxDiv();
        $bindParam[':status'] = $orderDetail->status();

        $result = DB::update($sql, $bindParam);
        if($result === false){
            throw new SQLException("PAL_SKUテーブルの在庫数が更新できませんでした");
        }
        return is_bool($result) ? false : true;
    }
}