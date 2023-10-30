<?php

namespace App\Http\Controllers\API\Storage;

use App\Http\Controllers\Controller;
use App\Http\Requests\RealizationClientRequest;
use App\Http\Requests\RealizationRequest;
use App\Http\Resources\HistoryResource_1;
use App\Http\Services\RealizationService;
use App\Models\RealizationHistory;
use App\Models\Type;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\JsonResponse;
use function abort;
use function response;

class RealizationController extends Controller
{
    private RealizationService $realizationService;


    public function __construct(RealizationService $realizationService)
    {
        $this->realizationService = $realizationService;
    }

    public function realizationOfClient(int $param, string $from = '', string $to = '') : JsonResponse {

        $realizations = $this->realizationService->realizationOfClient($param, $from, $to);

        return response()->json([
            'status' => true,
            'realizationOfClient' => $realizations,

        ]);
    }

    public function realizationOfStore(int $param, string $from = '', string $to = '') : JsonResponse
    {
        $realizations = $this->realizationService->realizationOfStore($param, $from, $to);

        return response()->json([
            'status' => true,
            'realizationOfStore' => $realizations
        ]);
    }


    public function storeRealization($id, RealizationRequest $request) : JsonResponse {
        $data = $request->validated();

        $store = User::findStore($id)->first();

        if(!$store) {
            abort(200, 'Такого магазина не сущесвует');
        }
        $message = $this->realizationService->storeRealization($id, $data);

        return response()->json([
            'status' => $message,
        ]);
    }

    public function realizationOfClientByDocNumber($docNumber) : JsonResponse
    {
        $history = RealizationHistory::findByDocNumber($docNumber)->get();

        if (!$history) {
            abort(200, 'Нет документов с этим номером документа');
        }

        $goods = $this->realizationService->realizationOfClientByDocNumber($docNumber);

        return response()->json([
            'status' => true,
            'recipient' => $history[0]->returnUser->name,
            'date' => $history[0]->created_at->format('d.m.Y'),
            'count' => $history->count(),
            'goods' => $goods,
        ]);
    }

    public function clientRealization($id, RealizationClientRequest $request) : JsonResponse {
        $data  = $request->validated();

        $client = User::findClient($id)->first();

        if (!$client) {
            abort(200, 'Такого клиента не существует');
        }

        $message = $this->realizationService->clientRealization($client, $data);

        return response()->json([
           'status' => $message
        ]);
    }


    public function getHistoryByBarcode(string $barcode) : JsonResponse {
        $type = Type::findByBarcode($barcode)->first();

        if (!$type) {
            abort(200, "Таког продукта не суҳествует");
        }

        $histories = RealizationHistory::where('type_id', $type->id)->get();

        return response()->json([
            'histories' => HistoryResource_1::collection($histories),
            'status' => true
        ]);

    }



}
