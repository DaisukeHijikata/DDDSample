<?php

namespace App\Models\Repository\Interfaces;
use App\Models\Entity\Brand;
use App\Models\Entity\PalRecShipping;

interface PalRecShippingRepositoryInterface
{
    public function findNewRecShipNo(string $code_alice_prefix) :?string;
    public function findPalRecShippingByPeriod(string $rec_ship_no_tmp) :?PalRecShipping;

    public function insertPalRecShippingFba(PalRecShipping $palRecShipping ,Brand $brand) :bool;
}