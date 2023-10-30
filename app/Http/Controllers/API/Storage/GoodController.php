<?php

namespace App\Http\Controllers\API\Storage;

use App\Http\Controllers\Controller;
use App\Http\Interfaces\GoodInterface;
use App\Http\Resources\GoodResource;
use App\Http\Resources\TypeResource;
use App\Http\Services\GoodService;
use App\Models\Good;
use App\Models\Type;
use Illuminate\Http\JsonResponse;
use function abort;
use function response;

class GoodController extends Controller implements GoodInterface
{
    public function __construct(GoodService $goodService)
    {
        $this->goodService = $goodService;
    }

    public function index() : JsonResponse
    {
        $types = $this->goodService->index();

        return response()->json([
            'message' => true,
            'products' => $types
        ]);
    }


    public function searchByIMEI(string $imei) : JsonResponse
    {
        $good = Good::findByIMEI($imei)->first();

        if (!$good)
            abort(200, "Такого товара не существует");

        return response()->json([
            'status' => true,
            'in_stock' => $good->isInStock($good),
            'good' => GoodResource::make($good)
        ]);

    }

    public function searchByBarcode(string $barcode) : JsonResponse
    {
        $type = Type::findByBarcode($barcode)->first();

        if (!$type) {
            abort(200, "Такого продукта не существует");
        }

        return response()->json([
            'status' => true,
            'goods' => GoodResource::collection($type->goods()->inStock()->get())
        ]);
    }
}
