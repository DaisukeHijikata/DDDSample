<?php

namespace src\Amazon\Repositories\Interfaces;
use src\Amazon\Domain\Object\Entity\AmazonFbaShopSku;
use src\Amazon\Domain\Object\Entity\OrderDetail;

/**
 * pal_sku テーブルを操作するクラス<br>
 * 結合している場合は、メインとするテーブル操作
 */
interface AmazonFbaShopSkuRepositoryInterface
{
    public function findByOrderDetail(OrderDetail $orderDetail): ?AmazonFbaShopSku;

    public function update(AmazonFbaShopSku $amazonFbaShopSku): bool;

}