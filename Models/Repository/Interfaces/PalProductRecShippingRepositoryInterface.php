<?php

namespace App\Models\Repository\Interfaces;

use App\Common\DB;
use App\Models\Entity\PalProductRecShipping;
use App\Models\Entity\PalSku;

interface PalProductRecShippingRepositoryInterface
{
    public function insertPalProductRecShippingFba(PalProductRecShipping $palProductRecShipping) :bool;
    public function findByUnapproved(PalSku $palSku) :?PalProductRecShipping;
}