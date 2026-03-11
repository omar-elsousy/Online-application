<?php

namespace App\Services\Favourite;

use Illuminate\Http\Request;

interface FavouriteService
{
    public function addToFavourites(Request $request, $product_id);
    public function getFavourites(Request $request);
}