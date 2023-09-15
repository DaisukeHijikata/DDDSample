<?php

namespace src\Amazon\Repositories\Interfaces;

use AmazonPHP\SellingPartner\Model\Orders\OrderItem;
use src\Amazon\Domain\Object\Entity\AmazonFbaOrder;
use src\Amazon\Domain\Object\Entity\OrderDetail;

/**
 * pal_sku テーブルを操作するクラス<br>
 * 結合している場合は、メインとするテーブル操作
 */
interface AmazonFbaShopOrderRepositoryInterface
{
    public function findByOrderItem(OrderItem $orderItem): ?AmazonFbaOrder;

    public function update(OrderDetail $orderDetail): bool;

    public function insert(OrderDetail $orderDetail): bool;

}