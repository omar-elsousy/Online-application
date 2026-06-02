<?php

namespace App\Services\Dashboard\LatestOffers;

use Illuminate\Http\Request;

interface LatestOffersService
{
    public function latestOffers(Request $request);
    public function addLatestOffer(Request $request);
    public function removeLatestOffer(Request $request, $product_id);
}