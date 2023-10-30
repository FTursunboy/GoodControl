<?php

namespace App\Http\Controllers\API\Consultant;

use App\Http\Controllers\Controller;
use App\Http\Requests\RealizationRequest;
use App\Http\Resources\Consultant\RealizationResource;
use App\Http\Services\Consultant\RealizationService;
use App\Models\RealizationHistory;
use Illuminate\Http\JsonResponse;
use App\Http\Services\RealizationService as RealizationStoreService;


class RealizationController extends Controller
{

    private RealizationService $storeRealizationService;
    private RealizationStoreService $realizationService;

    public function __construct(RealizationService $storeRealizationService, RealizationStoreService $realizationService)
    {
        $this->storeRealizationService = $storeRealizationService;
        $this->realizationService = $realizationService;
    }

    public function index(): JsonResponse
    {
        $realizations = $this->storeRealizationService->index();

        return response()->json([
            'status' => true,
            'realizations' => RealizationResource::collection($realizations)
        ]);
    }

    public function getGoodForSale(string $imei): JsonResponse
    {
        $good = $this->storeRealizationService->getGoodForSale($imei);

        return response()->json([
            'status' => true,
            'good' => $good
        ]);
    }

    public function store(RealizationRequest $request): JsonResponse
    {
        $data = $request->validated();

        $res = $this->storeRealizationService->store($data);

        return response()->json([
            'status' => $res
        ]);
    }

    public function realizationByDocNumber($docNumber): JsonResponse
    {
        $history = RealizationHistory::findByDocNumber($docNumber)->get();

        if (!$history) {
            abort(200, 'Нет документов с этим номером документа');
        }

        $goods = $this->realizationService->realizationOfClientByDocNumber($docNumber);

        return response()->json([
            'status' => true,
            'doc_number' => $docNumber,
            'recipient' => $history[0]->user?->name,
            'date' => $history[0]->created_at->format('d.m.Y'),
            'count' => $history->count(),
            'goods' => $goods,
        ]);
    }
}
