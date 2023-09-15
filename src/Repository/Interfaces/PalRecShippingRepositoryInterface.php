<?php

namespace src\Repository\Interfaces;
use src\Entity\Brand;
use src\Entity\PalRecShipping;

interface PalRecShippingRepositoryInterface
{
    public function findNewRecShipNo(string $code_alice_prefix) :?string;
    public function findPalRecShippingByPeriod(string $rec_ship_no_tmp) :?PalRecShipping;

    public function insertPalRecShippingFba(PalRecShipping $palRecShipping ,Brand $brand) :bool;
}