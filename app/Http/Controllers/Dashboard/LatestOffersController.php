<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Services\Dashboard\LatestOffers\LatestOffersService;
use Illuminate\Http\Request;

class LatestOffersController extends Controller
{
    private $latestOffersService;

    public function __construct(LatestOffersService $latestOffersService)
    {
        $this->latestOffersService = $latestOffersService;
    }

    public function latestOffers(Request $request)
    {
        return $this->latestOffersService->latestOffers($request);
    }

    public function addLatestOffer(Request $request)
    {
        return $this->latestOffersService->addLatestOffer($request);
    }

    public function removeLatestOffer(Request $request, $product_id)
    {
        return $this->latestOffersService->removeLatestOffer($request, $product_id);
    }
}
