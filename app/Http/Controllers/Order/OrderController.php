<?php

namespace App\Http\Controllers\Order;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Order\OrderService;

class OrderController extends Controller
{
    protected $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    /**
     * @OA\Post(
     *     path="/placeOrder",
     *     summary="تأكيد الطلب",
     *     tags={"Orders"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response=201,
     *         description="تم طلب الأوردر بنجاح",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="تم طلب الأوردر بنجاح"),
     *             @OA\Property(property="order_id", type="integer", example=55)
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="الكارت فاضي أو منتج out of stock",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="الكارت فاضي")
     *         )
     *     ),
     *     @OA\Response(response=401, description="Unauthenticated")
     * )
     */
    public function placeOrder(Request $request)
    {
        return $this->orderService->placeOrder($request);
    }

    /**
     * @OA\Get(
     *     path="/getOrderDetails/{order_id}",
     *     summary="تفاصيل أوردر معين",
     *     tags={"Orders"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="order_id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer"),
     *         example=55
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="تفاصيل الأوردر",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="data",
     *                 type="object",
     *                 @OA\Property(property="order_id", type="integer", example=55),
     *                 @OA\Property(property="status", type="string", example="placed"),
     *                 @OA\Property(property="final_price", type="number", example=345.0),
     *                 @OA\Property(property="created_at", type="string", example="2024-01-01 10:00:00"),
     *                 @OA\Property(
     *                     property="items",
     *                     type="array",
     *                     @OA\Items(
     *                         type="object",
     *                         @OA\Property(property="image", type="string", nullable=true, example="http://example.com/storage/products/img.jpg"),
     *                         @OA\Property(property="product_id", type="integer", example=101),
     *                         @OA\Property(property="name", type="string", example="منتج A"),
     *                         @OA\Property(property="quantity", type="integer", example=2),
     *                         @OA\Property(property="unit_price", type="number", example=50.0),
     *                         @OA\Property(property="unit_tax", type="number", example=7.5),
     *                         @OA\Property(property="unit_price_after_tax", type="number", example=57.5),
     *                         @OA\Property(property="total_price", type="number", example=115.0)
     *                     )
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="الأوردر مش موجود",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="الأوردر مش موجود")
     *         )
     *     ),
     *     @OA\Response(response=401, description="Unauthenticated")
     * )
     */
    public function getOrderDetails(Request $request, $order_id)
    {
        return $this->orderService->getOrderDetails($request, $order_id);
    }

    /**
     * @OA\Get(
     *     path="/getUserOrdersHistory",
     *     summary="سجل الطلبات بتاع اليوزر",
     *     tags={"Orders"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="قائمة الطلبات",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="data",
     *                 type="array",
     *                 @OA\Items(
     *                     type="object",
     *                     @OA\Property(property="order_id", type="integer", example=55),
     *                     @OA\Property(property="status", type="string", example="placed"),
     *                     @OA\Property(property="total_price", type="number", example=345.0),
     *                     @OA\Property(property="created_at", type="string", example="2024-01-01 10:00:00"),
     *                     @OA\Property(
     *                         property="items",
     *                         type="array",
     *                         @OA\Items(
     *                             type="object",
     *                             @OA\Property(property="image", type="string", nullable=true),
     *                             @OA\Property(property="product_id", type="integer", example=101),
     *                             @OA\Property(property="name", type="string", example="منتج A"),
     *                             @OA\Property(property="quantity", type="integer", example=2),
     *                             @OA\Property(property="unit_price", type="number", example=50.0),
     *                             @OA\Property(property="unit_tax", type="number", example=7.5),
     *                             @OA\Property(property="unit_price_after_tax", type="number", example=57.5),
     *                             @OA\Property(property="total_price", type="number", example=115.0)
     *                         )
     *                     )
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(response=401, description="Unauthenticated")
     * )
     */
    public function getUserOrdersHistory(Request $request)
    {
        return $this->orderService->getUserOrdersHistory($request);
    }

    /**
     * @OA\Post(
     *     path="/cancelOrder/{order_id}",
     *     summary="إلغاء أوردر",
     *     tags={"Orders"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="order_id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer"),
     *         example=55
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="تم إلغاء الأوردر بنجاح",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="تم إلغاء الأوردر بنجاح")
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="مش ممكن تلغي الأوردر ده",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="مش ممكن تلغي الأوردر ده")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="الأوردر مش موجود",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="الأوردر مش موجود")
     *         )
     *     ),
     *     @OA\Response(response=401, description="Unauthenticated")
     * )
     */
    public function cancelOrder(Request $request, $order_id)
    {
        return $this->orderService->cancelOrder($request, $order_id);
    }
}