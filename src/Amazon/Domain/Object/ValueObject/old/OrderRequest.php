<?php

namespace src\Amazon\Domain\Object\ValueObject\old;
use AmazonOrderIdList;
use AmazonPHP\SellingPartner\AccessToken;
use Carbon\Carbon;
use EasyShipShipmentStatusList;
use ElectronicInvoiceStatusList;
use PaymentMethodList;
use ValueObject\OrderStatus;


class OrderRequest
{
    /**
     *
     */
    const RETRY_LIMIT = 3;

    /**
     * @var AccessToken
     */
    private AccessToken $accessToken;
    /**
     * @var string
     */
    private string $region;
    /**
     * @var array
     */
    private array $marketplace_ids;

    /**
     * 特定の時間前に作成されたオーダーを選択するために使用される日付。指定された時間前に発注されたオーダーのみが返されます。
     * @var Carbon|null
     */
    private ?Carbon $created_after;
    /**
     * 特定の時間前に作成されたオーダーを選択するために使用される日付。指定された時間前に発注されたオーダーのみが返されます。
     * @var Carbon|null
     */
    private ?Carbon $created_before;
    /**
     * 特定の時間後に最後に更新されたオーダーを選択するために使用される日付。
     * @var Carbon|null
     */
    private ?Carbon $last_updated_after;
    /**
     * 特定の時間前に最後に更新されたオーダーを選択するために使用される日付。
     * @var Carbon|null
     */
    private ?Carbon $last_updated_before;
    /**
     * OrderStatus値のリスト。結果をフィルタリングするために使用されます。
     * @var OrderStatus
     */
    private OrderStatus $order_status;

    /**
     * @var string|null
     */private ?string $paymentMethods;
    /**
     * オーダーがどのように履行されたかを示すリスト。結果を履行チャンネルでフィルタリングします。
     * @var string|null
     */
    private ?string $fulfillment_channels;
    /**
     * @var PaymentMethodList|null
     * 支払い方法の値のリスト。指定された支払い方法を使用して支払われたオーダーを選択するために使用されます。
     */private ?PaymentMethodList $paymentMethodList;
    /**
     *購入者のメールアドレス。指定されたメールアドレスを含むオーダーを選択するために使用されます。
     * @var Email|null
     */private ?Email $buyer_email;
    /**
     * 販売者によって指定されたオーダー識別子。オーダー識別子と一致するオーダーのみを選択するために使用されます。
     * @var string|null
     */private ?string $seller_order_id;
    /**
     * ページごとに返されるオーダーの最大数を示す数字。
     * @var MaxResultsPerPage|null
     */private ?MaxResultsPerPage $maxResultsPerPage;
    /**
     * EasyShipShipmentStatus値のリスト。指定されたステータスを持つEasy Shipオーダーを選択するため該当のメソッドは getOrders で、以下のパラメーターが必要またはオプショナルで用意されています：
     * @var EasyShipShipmentStatusList|null
     */private ?EasyShipShipmentStatusList $easy_ship_shipment_statuses;
    /**
     * ElectronicInvoiceStatus値のリスト。指定された値に一致する電子請求書ステータスの注文を選択するために使用されます。
     * @var ElectronicInvoiceStatusList|null
     */private ?ElectronicInvoiceStatusList $electronicInvoiceStatusList;
    /**
     * 前のリクエストのレスポンスで返される文字列トークン。
     * @var NextToken|null
     */private ?NextToken $nextToken;
    /**
     * AmazonOrderId値のリスト。AmazonOrderIdは、Amazonが定義する注文識別子で、3-7-7フォーマットです。
     * @var AmazonOrderIdList|null
     */private ?AmazonOrderIdList $amazonOrderIdList;
    /**
     * 注文が満たされるべき推奨sourceIdを示します。
     * @var string|null
     */private ?string $actualFulfillmentSupplySourceId;
    /**
     * この値が真の場合、この注文は配達ではなく、店舗からの受け取りを示します。
     * @var bool|null
     */private ?bool $is_ispu;
    /**
     * 店舗チェーン内の特定の店舗にリンクされた店舗チェーンの識別子。
     * @var string|null
     */private ?string $store_chain_store_id;
     private function __construct()
     {}

    public static function create() :self
    {
        return new OrderRequest();
    }
    /**
     * @return AccessToken
     */
    public function accessToken(): AccessToken
    {
        return $this->accessToken;
    }

    /**
     * @return string
     */
    public function region(): string
    {
        return $this->region;
    }

    /**
     * @return array
     */
    public function marketplaceIds(): array
    {
        return $this->marketplace_ids;
    }

    /**
     * @return Carbon|null
     */
    public function createdAfter(): ?Carbon
    {
        return $this->created_after;
    }

    /**
     * @return Carbon|null
     */
    public function createdBefore(): ?Carbon
    {
        return $this->created_before;
    }

    /**
     * @return Carbon|null
     */
    public function lastUpdatedAfter(): ?Carbon
    {
        return $this->last_updated_after;
    }

    /**
     * @return Carbon|null
     */
    public function lastUpdatedBefore(): ?Carbon
    {
        return $this->last_updated_before;
    }

    /**
     * @return OrderStatus
     */
    public function orderStatus(): OrderStatus
    {
        return $this->order_status;
    }

    /**
     * @return string|null
     */
    public function paymentMethods(): ?string
    {
        return $this->paymentMethods;
    }

    /**
     * @return string|null
     */
    public function fulfillmentChannels(): ?string
    {
        return $this->fulfillment_channels;
    }

    /**
     * @return PaymentMethodList|null
     */
    public function paymentMethodList(): ?PaymentMethodList
    {
        return $this->paymentMethodList;
    }

    /**
     * @return Email|null
     */
    public function buyerEmail(): ?Email
    {
        return $this->buyer_email;
    }

    /**
     * @return string|null
     */
    public function sellerOrderId(): ?string
    {
        return $this->seller_order_id;
    }

    /**
     * @return MaxResultsPerPage|null
     */
    public function maxResultsPerPage(): ?MaxResultsPerPage
    {
        return $this->maxResultsPerPage;
    }

    /**
     * @return EasyShipShipmentStatusList|null
     */
    public function easyShipShipmentStatuses(): ?EasyShipShipmentStatusList
    {
        return $this->easy_ship_shipment_statuses;
    }

    /**
     * @return ElectronicInvoiceStatusList|null
     */
    public function electronicInvoiceStatusList(): ?ElectronicInvoiceStatusList
    {
        return $this->electronicInvoiceStatusList;
    }

    /**
     * @return NextToken|null
     */
    public function nextToken(): ?NextToken
    {
        return $this->nextToken;
    }

    /**
     * @return AmazonOrderIdList|null
     */
    public function amazonOrderIdList(): ?AmazonOrderIdList
    {
        return $this->amazonOrderIdList;
    }

    /**
     * @return string|null
     */
    public function actualFulfillmentSupplySourceId(): ?string
    {
        return $this->actualFulfillmentSupplySourceId;
    }

    /**
     * @return bool|null
     */
    public function isIspu(): ?bool
    {
        return $this->is_ispu;
    }

    /**
     * @return string|null
     */
    public function storeChainStoreId(): ?string
    {
        return $this->store_chain_store_id;
    }




}