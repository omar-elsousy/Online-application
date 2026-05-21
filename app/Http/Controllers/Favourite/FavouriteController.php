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

    /**
     * @OA\Post(
     *     path="/addToFavourites/{product_id}",
     *     summary="إضافة منتج للمفضلة",
     *     tags={"Favourites"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="product_id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer"),
     *         example=101
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="تم الإضافة للمفضلة بنجاح",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="تم الإضافة للمفضلة بنجاح")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="المنتج موجود بالفعل في المفضلة",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="المنتج موجود بالفعل في المفضلة")
     *         )
     *     ),
     *     @OA\Response(response=401, description="Unauthenticated")
     * )
     */
    public function addToFavourites(Request $request, $product_id)
    {
        return $this->favouriteService->addToFavourites($request, $product_id);
    }

    /**
     * @OA\Get(
     *     path="/getFavourites",
     *     summary="جلب المفضلة",
     *     tags={"Favourites"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="قائمة المفضلة",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="data",
     *                 type="array",
     *                 @OA\Items(
     *                     type="object",
     *                     @OA\Property(property="image", type="string", nullable=true, example="http://example.com/storage/products/img.jpg"),
     *                     @OA\Property(property="product_id", type="integer", example=101),
     *                     @OA\Property(property="name", type="string", example="منتج A"),
     *                     @OA\Property(property="price", type="number", example=57.5)
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(response=401, description="Unauthenticated")
     * )
     */
    public function getFavourites(Request $request)
    {
        return $this->favouriteService->getFavourites($request);
    }
    /**
     * @OA\Delete(
     *     path="/removeFromFavourites/{product_id}",
     *     summary="إزالة منتج من المفضلة",
     *     tags={"Favourites"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="product_id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer"),
     *         example=101
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="تمت إزالة المنتج من المفضلة بنجاح",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="تمت إزالة المنتج من المفضلة بنجاح")
     *         )
     *     ),
     *     @OA\Response(response=401, description="Unauthenticated")
     * )
     */
    public function removeFromFavourites(Request $request, $product_id)
    {
        return $this->favouriteService->removeFromFavourites($request, $product_id);
    }
}