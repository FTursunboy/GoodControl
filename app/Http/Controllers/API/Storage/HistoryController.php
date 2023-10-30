<?php

namespace App\Http\Controllers\API\Storage;

use App\Http\Controllers\Controller;
use App\Http\Resources\GoodsByBarcodeResource;
use App\Http\Resources\HistoryResource;
use App\Models\RealizationHistory;
use App\Models\Type;
use Illuminate\Http\JsonResponse;
use function response;

class HistoryController extends Controller
{
    public function historyByIMEI(string $imei) : JsonResponse
    {
        $history = RealizationHistory::findByIMEI($imei)->get();
        return response()->json([
            'status' => true,
            'history' => HistoryResource::collection($history)
        ]);
    }

    public function goodsByBarcode() : JsonResponse
    {
        $types = Type::all();

        return response()->json([
            'status' => true,
            'products' => GoodsByBarcodeResource::collection($types)
        ]);
    }

}
