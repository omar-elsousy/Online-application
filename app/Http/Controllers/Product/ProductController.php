<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Product\ProductService;

class ProductController extends Controller
{
    protected $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    /**
     * @OA\Get(
     *     path="/getProducts/{family_id}",
     *     summary="جلب المنتجات بتاعت فاميلي معينة",
     *     tags={"Products"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="family_id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer"),
     *         example=10
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="قائمة المنتجات",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="data",
     *                 type="array",
     *                 @OA\Items(
     *                     type="object",
     *                     @OA\Property(property="image", type="string", nullable=true, example="http://example.com/storage/products/img.jpg"),
     *                     @OA\Property(property="product_id", type="integer", example=101),
     *                     @OA\Property(property="name", type="string", example="منتج A"),
     *                     @OA\Property(property="price", type="number", example=57.5),
     *                     @OA\Property(property="status", type="string", enum={"in stock","out of stock"}, example="in stock")
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(response=401, description="Unauthenticated")
     * )
     */
    public function getProducts($family_id)
    {
        return $this->productService->getProductsByFamily($family_id);
    }

    /**
     * @OA\Get(
     *     path="/getProductDetails/{product_id}",
     *     summary="تفاصيل منتج معين",
     *     tags={"Products"},
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
     *         description="تفاصيل المنتج",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="data",
     *                 type="object",
     *                 @OA\Property(property="image", type="string", nullable=true, example="http://example.com/storage/products/img.jpg"),
     *                 @OA\Property(property="name", type="string", example="منتج A"),
     *                 @OA\Property(property="code", type="integer", example=101),
     *                 @OA\Property(property="category", type="string", example="مشروبات"),
     *                 @OA\Property(property="price", type="number", example=50.0),
     *                 @OA\Property(property="tax", type="number", example=7.5),
     *                 @OA\Property(property="status", type="string", enum={"in stock","out of stock"}, example="in stock")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="المنتج مش موجود",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="المنتج مش موجود")
     *         )
     *     ),
     *     @OA\Response(response=401, description="Unauthenticated")
     * )
     */
    public function getProductDetails($product_id)
    {
        return $this->productService->getProductDetails($product_id);
    }
}