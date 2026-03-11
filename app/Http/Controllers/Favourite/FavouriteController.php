<?php

namespace App\Http\Controllers\Favourite;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Favourite\FavouriteService;

class FavouriteController extends Controller
{
    protected $favouriteService;

    public function __construct(FavouriteService $favouriteService)
    {
        $this->favouriteService = $favouriteService;
    }

    public function addToFavourites(Request $request, $product_id)
    {
        return $this->favouriteService->addToFavourites($request, $product_id);
    }

    public function getFavourites(Request $request)
    {
        return $this->favouriteService->getFavourites($request);
    }
}