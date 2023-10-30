<?php

namespace App\Http\Controllers\API\Consultant;

use App\Http\Controllers\Controller;
use App\Http\Services\GoodService;
use App\Http\Services\TypeService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TypeController extends Controller
{
    private TypeService $typeService;

    public function __construct(TypeService $typeService)
    {
        $this->typeService = $typeService;
    }

    public function index($page) : JsonResponse {
        $products = $this->typeService->index($page);

        return response()->json([
            'status' => true,
            'products' => $products
        ]);
    }
}
