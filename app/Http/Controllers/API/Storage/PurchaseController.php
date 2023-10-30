<?php

namespace App\Http\Controllers\API\Storage;

use App\Http\Controllers\Controller;
use App\Http\Interfaces\PurchaseInterface;
use App\Http\Requests\CheckRequest;
use App\Http\Requests\PurchaseRequest;
use App\Http\Requests\TypeRequest;
use App\Http\Resources\PurByDocNumResource;
use App\Http\Resources\ShowPurchaseResource;
use App\Http\Resources\TypeResource;
use App\Http\Resources\TypeWithoutGoodsResource;
use App\Http\Services\PurchaseService;
use App\Models\Purchase;
use App\Models\RealizationHistory;
use App\Models\Type;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use function abort;
use function response;

class PurchaseController extends Controller implements PurchaseInterface
{

    private PurchaseService $purchaseService;

    public function __construct(PurchaseService $purchaseService)
    {
        $this->purchaseService = $purchaseService;
    }

    public function index(int $param, string $from = '', string $to = '') :JsonResponse
    {
        $purchases = $this->purchaseService->index($param, $from, $to);

        return response()->json([
            'status' => true,
            'purchases' => $purchases
        ]);
    }

    public function purchaseByDocNumber(string $docNumber) : JsonResponse
    {

        $purchases = $this->purchaseService->purchaseByDocNumber($docNumber);
        if ($purchases->count() < 1) {
            abort(200, 'Такого документа не существует');
        }

        $count = RealizationHistory::where('doc_number', $docNumber)->count();

        return response()->json([
            'status' => true,
            'doc_number' => $docNumber,
            'barcode' => $purchases[0]->types->barcode,
            'provider' => $purchases[0]->returnUser->name,
            'date' => $purchases[0]->created_at->format('d.m.Y'),
            'count' => $count,
            'goods' => PurByDocNumResource::collection($purchases)
        ]);
    }

    public function check(string $barcode)
    {
        $type = Type::findByBarcode($barcode)->first();

        $message = $type
            ? ['status' => true, 'product' => new TypeResource($type)]
            : ['status' => false, 'info' => 'Такого продукта не существует'];

        return response()->json($message);
    }

    public function getByBarcode(string $barcode)
    {
        $type = Type::findByBarcode($barcode)->first();

        $message = $type
            ? ['status' => true, 'product' => new TypeWithoutGoodsResource($type)]
            : ['status' => false, 'info' => 'Такого продукта не существует'];

        return response()->json($message);
    }




    public function addType(TypeRequest $request, int $id) : JsonResponse {
        $data = $request->validated();

        $type = Type::find($id);

        if (!$type){
            abort(200, 'Такого продукта не существует');
        }

        $type->update([
            'name' => $data['name'],
            'barcode' =>$data['barcode'],
        ]);

        return response()->json([
            'product' => new TypeResource($type),
            'status' => true
        ]);
    }

    public function purchase(PurchaseRequest $request) : JsonResponse {
        $data = $request->validated();

        $type = Type::findbyBarcode($data['barcode'])->first();
        $user = User::findProvider($data['provider_id'])->first();
        if (!$user) {
            abort(200, 'Такого поставщика не существует');
        }
        if (!$type) {
            abort(200, 'Такого продукта не существует');
        }


        $purchase = $this->purchaseService->purchase($data, $type);

        return response()->json([
            'status' => $purchase ? true : false,
            'info' => $purchase ? 'Товары успешно добавлены' : 'Ошибка, некоторые товары повторились'
        ]);
    }



    public function getPurchaseHistory(int $id) : JsonResponse {
        $purchase = Purchase::findOrfail($id);

        return response()->json([
            'status' => true,
            'purchases' => new ShowPurchaseResource($purchase)
        ]);
    }

}
