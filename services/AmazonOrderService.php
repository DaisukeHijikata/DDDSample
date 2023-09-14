<?php

namespace App\services;

use AmazonPHP\SellingPartner\AccessToken;
use AmazonPHP\SellingPartner\Api\OrdersV0Api\OrdersSDKInterface;
use AmazonPHP\SellingPartner\Model\Orders\Order;
use AmazonPHP\SellingPartner\Model\Orders\OrderItemsList;
use AmazonPHP\SellingPartner\Model\Orders\OrdersList;
use AmazonPHP\SellingPartner\Regions;
use AmazonPHP\SellingPartner\SellingPartnerSDK;
use App\Models\Amazon\Repositories\AmazonFbaShopOrderRepository;
use App\Models\Amazon\Repositories\AmazonFbaShopSkuRepository;
use App\Models\Amazon\Repositories\Interfaces\AmazonFbaShopOrderRepositoryInterface;
use App\Models\Amazon\Repositories\Interfaces\AmazonFbaShopSkuRepositoryInterface;
use Exception;
use App\Models\Amazon\Domain\Object\Entity\OrderDetail;
use App\Models\Amazon\Domain\Collection\OrderDetailList;
use App\Models\Amazon\Domain\Object\Entity\OrderItem;
use App\Models\Amazon\Domain\Object\Entity\OrderItem as OriginOrderItem;
use App\Models\Amazon\Domain\Collection\OrderItemsList as OriginOrderItemsList;
use App\Models\Amazon\Domain\Object\Entity\OrderRequestPeriod;

class AmazonOrderService
{
    const ORDER_STATUS = "Shipped";
    const START_DATE = "2023-06-01";
    const END_DATE = "2023-06-30";

    private OrdersSDKInterface $ordersSDK;
    private AccessToken $accessToken;
    private OrderRequestPeriod $orderRequestPeriod;
    private AmazonFbaShopOrderRepositoryInterface $amazonFbaShopOrderRepository;
    private AmazonFbaShopSkuRepositoryInterface $amazonFbaShopSkuRepository;
    private OrderDetailList $orderDetailList;

    private array $requestBody =[
        'report_type' => ALLOCATION_REPORT_TYPE,
        'marketplace_ids' => [MARKETPLACE_ID],
    ];

    private function __construct(
        OrdersSDKInterface $ordersSDK,
        AccessToken $accessToken,
        OrderRequestPeriod $orderRequestPeriod,
        AmazonFbaShopOrderRepositoryInterface $amazonFbaShopOrderRepository,
        AmazonFbaShopSkuRepositoryInterface $amazonFbaShopSkuRepository
    ){
        $this->ordersSDK = $ordersSDK;
        $this->accessToken = $accessToken;
        $this->orderRequestPeriod = $orderRequestPeriod;
        $this->amazonFbaShopOrderRepository = $amazonFbaShopOrderRepository;
        $this->amazonFbaShopSkuRepository = $amazonFbaShopSkuRepository;
        $this->orderDetailList = OrderDetailList::create();
    }


    public static function create(
        SellingPartnerSDK $sellingPartnerSDK,
        ?OrdersSDKInterface $ordersSDK = null,
        ?AccessToken $accessToken = null,
        ?OrderRequestPeriod $orderRequestPeriod = null,
        ?AmazonFbaShopOrderRepositoryInterface $amazonFbaShopOrderRepository = null,
        ?AmazonFbaShopSkuRepositoryInterface $amazonFbaShopSkuRepository = null,
    ) :AmazonOrderService
    {
        return new AmazonOrderService(
            $ordersSDK ?? $sellingPartnerSDK->orders(),
            $accessToken ?? $sellingPartnerSDK->oAuth()->exchangeRefreshToken(ACCA_REFRESH_TOKEN),
            $orderRequestPeriod ?? OrderRequestPeriod::create(self::START_DATE ,self::END_DATE),
            $amazonFbaShopOrderRepository ?? AmazonFbaShopOrderRepository::create(),
                $amazonFbaShopSkuRepository ?? AmazonFbaShopSkuRepository::create()
        );
    }
    public function orderItems() :OriginOrderItemsList
    {
        return $this->recursiveOrderItems();
    }

    private function recursiveOrderItems(?OriginOrderItemsList $orderItemsList = null,?string $_nextToken = null) :OriginOrderItemsList
    {
        $orderItemsList = $orderItemsList ?? OriginOrderItemsList::create();
        $nextToken = null;
        foreach($this->orders() as $order){
            foreach($this->orderItemsList($order ,$_nextToken)->getOrderItems() as $orderItem){
                $orderItemsList->add(OrderItem::create($order ,$orderItem));
            }
            $nextToken = $this->orderItemsList($order)->getNextToken();
        }
        if (!empty($nextToken)) {
            $this->recursiveOrderItems($orderItemsList ,$nextToken);
        }
        return $orderItemsList;
    }

    public function orders() :array
    {
        return $this->recursiveOrders();
    }

    private function recursiveOrders(?string $_nextToken = null) :array
    {
        $orders = [];
        foreach($this->ordersList($_nextToken)->getOrders() as $order) {
            $orders[] = $order;
        }
        $nextToken = $this->ordersList()->getNextToken();
        if( ! empty($nextToken)){
            array_push($orders ,...$this->recursiveOrders($nextToken));
        }
        return $orders;
    }

    public function createOrderDetailList() :void
    {
        /* @var OriginOrderItem $orderItem */
        foreach($this->orderItems() as $orderItem){
            $amazonFbaShopOrder = $this->amazonFbaShopOrderRepository->findByOrderItem($orderItem->orderItem());
            $this->orderDetailList->add(OrderDetail::create($orderItem->order() ,$amazonFbaShopOrder));
        }
    }

    public function save() :void
    {
        /* @var OrderDetail $orderDetail*/
        foreach ($this->orderDetailList as $orderDetail){
            $this->saveOrder($orderDetail);
            $this->saveShopStock($orderDetail);
        }
    }

    public function saveOrder(OrderDetail $orderDetail) :void
    {
        if($orderDetail->isUpdate()){
            $this->amazonFbaShopOrderRepository->update($orderDetail);
        }
        if($orderDetail->isCreate()){
            $this->amazonFbaShopOrderRepository->insert($orderDetail);
        }
    }

    public function saveShopStock(OrderDetail $orderDetail) :void
    {
        $amazonFbaShopSku = $this->amazonFbaShopSkuRepository->findByOrderDetail($orderDetail);
        $amazonFbaShopSku->subFbaStock($orderDetail->quantityShipped());
        $this->amazonFbaShopSkuRepository->update($amazonFbaShopSku);
    }


    private function orderItemsList(Order $order ,?string $nextToken = null) :OrderItemsList
    {
        $orderItemsResponse = $this->ordersSDK->getOrderItems(
            $this->accessToken,
            Regions::FAR_EAST,
            $order->getAmazonOrderId(),
            $nextToken
        );
        return $orderItemsResponse->getPayload();
    }


    private function ordersList(?string $nextToken = null) :OrdersList
    {
        try {
            $response = $this->ordersSDK->getOrders
            (
                $this->accessToken,
                Regions::FAR_EAST,
                $this->requestBody['marketplace_ids'],
                $this->orderRequestPeriod->startAt()->format(OrderRequestPeriod::ISO8601_FORMAT), // createdAfter
                $this->orderRequestPeriod->endAt()->format(OrderRequestPeriod::ISO8601_FORMAT), // createdBefore
                null,
                null,
                [self::ORDER_STATUS],
                null,
                null,
                null,
                null,
                null,
                null,
                null,
                $nextToken
            );
        } catch (Exception $e) {
            // 例外処理を行います。ここではエラーメッセージを表示しています。
            echo "Error: " . $e->getMessage() . "\n";
        }
        return $response->getPayload();
    }
}