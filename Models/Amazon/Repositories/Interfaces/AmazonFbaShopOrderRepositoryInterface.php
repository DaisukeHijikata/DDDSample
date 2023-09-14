<?php

namespace App\Models\Amazon\Repositories\Interfaces;

use App\Models\Amazon\Domain\Object\Entity\OrderDetail;
use App\Models\Amazon\Domain\Object\Entity\AmazonFbaOrder;
use AmazonPHP\SellingPartner\Model\Orders\OrderItem;

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