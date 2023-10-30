<?php

namespace App\Http\Controllers\API\Storage;

use App\Http\Controllers\Controller;
use App\Http\Requests\RealizationClientRequest;
use App\Http\Requests\RealizationRequest;
use App\Http\Services\ReturnService;
use App\Models\Client;
use App\Models\Store;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use function abort;
use function response;

class ReturnController extends Controller
{
    private ReturnService $returnService;

    public function __construct(ReturnService $returnService)
    {
        $this->returnService = $returnService;
    }

    public function returnOfClient(int $param, string $from = '', string $to = '') : JsonResponse
    {
        $returns = $this->returnService->returnOfClient($param, $from, $to);

        return response()->json([
            'status' => true,
            'returnOfClient' => $returns
        ]);
    }

    public function returnOfClientByDocNumber($docNumber) : JsonResponse
    {
        $goods = $this->returnService->returnOfClientByDocNumber($docNumber);

        return response()->json([
            'status' => true,
            'goods' => $goods
        ]);
    }

    public function returnOfStore(int $param, string $from = '', string $to = '') : JsonResponse
    {
        $returns = $this->returnService->returnOfStore($param, $from, $to);

        return response()->json([
            'status' => true,
            'returnOfStore' => $returns
        ]);
    }

    public function returnOfStoreByDocNumber($docNumber) : JsonResponse
    {
        $goods = $this->returnService->returnOfClientByDocNumber($docNumber);

        return response()->json([
            'status' => true,
            'goods' => $goods
        ]);
    }

    public function returnStore($id, RealizationRequest $request) : JsonResponse {
        $data = $request->validated();

        $store = User::findStore($id)->first();

        if (!$store) {
            abort(200, "Такого магазина не существует");
        }

        $message =  $this->returnService->storeReturn($store, $data);

        return response()->json([
            'status' => $message
        ]);


    }

    public function returnClient(int $id, RealizationClientRequest $request) : JsonResponse {
        $data = $request->validated();

        $client = User::findClient($id)->first();

        if (!$client) {
            abort(200, "Такого клиента не существует");
        }

       $message = $this->returnService->clientReturn($id, $data);

       return response()->json([
           'status' => $message
       ]);
    }





}
