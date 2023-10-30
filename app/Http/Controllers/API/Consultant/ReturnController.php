<?php

namespace App\Http\Controllers\API\Consultant;

use App\Http\Controllers\Controller;
use App\Http\Requests\RealizationClientRequest;
use App\Http\Requests\RealizationRequest;
use App\Http\Resources\Consultant\ReturnResource;
use App\Http\Services\Consultant\ReturnService;
use App\Models\RealizationHistory;
use Illuminate\Http\JsonResponse;
use App\Http\Services\RealizationService as RealizationStoreService;

class ReturnController extends Controller
{

    private ReturnService $returnService;
    private RealizationStoreService $realizationService;

    public function __construct(ReturnService $returnService, RealizationStoreService $realizationService)
    {
        $this->returnService = $returnService;
        $this->realizationService = $realizationService;
    }

    public function getDocumentOfReturnToStorage(): JsonResponse
    {
        $returns = $this->returnService->getDocumentOfReturnToStorage();

        return response()->json([
            'status' => true,
            'realizations' => ReturnResource::collection($returns)
        ]);
    }

    public function getGoodForReturn(string $imei): JsonResponse
    {
        $good = $this->returnService->getGoodForReturn($imei);

        return response()->json([
            'status' => true,
            'good' => $good
        ]);
    }

    public function getDocumentOfReturnToStorageByDocNumber($docNumber): JsonResponse
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

    public function store(RealizationRequest $request): JsonResponse
    {
        $data = $request->validated();

        $res = $this->returnService->returnToStorage($data);

        return response()->json([
            'status' => $res
        ]);
    }


    public function getDocumentsOfReturnClientToStore(): JsonResponse
    {
        $returns = $this->returnService->getDocumentsOfReturnClientToStore();

        return response()->json([
            'status' => true,
            'realizations' => ReturnResource::collection($returns)
        ]);
    }


    public function clientReturn(RealizationClientRequest $request): JsonResponse
    {
       $data = $request->validated();

       $res = $this->returnService->clientReturn($data);

        return response()->json([
            'status' => $res
        ]);
    }

    public function getDocumentOfReturnToStoreByDocNumber($docNumber): JsonResponse
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
