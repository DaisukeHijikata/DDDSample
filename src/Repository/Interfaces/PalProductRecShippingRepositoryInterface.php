<?php

namespace src\Repository\Interfaces;

use App\Common\DB;
use src\Entity\PalProductRecShipping;
use src\Entity\PalSku;

interface PalProductRecShippingRepositoryInterface
{
    public function insertPalProductRecShippingFba(PalProductRecShipping $palProductRecShipping) :bool;
    public function findByUnapproved(PalSku $palSku) :?PalProductRecShipping;
}