<?php

namespace App\Http\Services;


use App\Http\Interfaces\RealizationInterface;
use App\Jobs\RealizationJob;
use App\Models\Good;
use App\Models\RealizationHistory;
use App\Models\Status;
use App\Models\StoreGood;
use App\Models\User;
use App\Traits\FilterTrait;
use Carbon\Carbon;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Traits\RealizationHistoryTrait;


class RealizationService implements RealizationInterface
{

    use RealizationHistoryTrait, FilterTrait;

    public function realizationOfClient(int $param, string $from, string $to): Collection
    {
        $query = $this->getRealizationHistories(RealizationHistory::SALE, User::ROLE_CLIENT);

        $this->filter($param, $query, $from, $to);

        return $query->get();


    }

    public function realizationOfStore(int $param, string $from, string $to): Collection
    {
        $query = $this->getRealizationHistories(RealizationHistory::SALE, User::ROLE_STORE);

        $this->filter($param, $query, $from, $to);

        return $query->get();

    }

    public function realizationOfClientByDocNumber($docNumber): Collection
    {
        return DB::table('realization_histories as r')
            ->join('types as t', 't.id', 'r.type_id')
            ->where('doc_number', $docNumber)
            ->select('r.IMEI', 't.barcode', 't.name')
            ->get();
    }

    public function storeRealization($id, array $goods): bool
    {
        $doc_number = time();
        $realizationHistoryData = [];
        $IMEIs = [];
        $storeGood = [];

        $imeiList = array_column($goods['goods'], 'IMEI');
        $goodsMap = Good::whereIn('IMEI', $imeiList)->get()->keyBy('IMEI');

        foreach ($goods['goods'] as $data) {
            $imei = $data['IMEI'];
            $good = $goodsMap[$imei];

            if (!$good) {
                abort(200, 'Такого товара не существует');
            }
            if ($good->amount == 0) {
                abort(200, 'Этот товар уже продан');
            }

            $IMEIs[] = $data['IMEI'];

            $storeGood[] = [
                'IMEI' => $data['IMEI'],
                'store_id' => $id,
                'amount' => 1,
                'type_id' => $good->type_id,
                'created_at' => now(),
                'updated_at' => now()
            ];

            $realizationHistoryData[] = [
                'IMEI' => $data['IMEI'],
                'sender' => Auth::id(),
                'recipient' => $id,
                'type' => 'sale',
                'doc_number' => $doc_number,
                'type_id' => $good->type_id,
                'status_id' => Status::REALIZATION_STORE,
                'created_at' => now(),
                'updated_at' => now()
            ];
        }

        Good::whereIn('IMEI', $IMEIs)->update(['amount' => 0]);
        RealizationHistory::insert($realizationHistoryData);
        StoreGood::insert($storeGood);

        return true;
    }

    public function clientRealization(User $client, array $goods): bool
    {

        $doc_number = time();
        $realizationHistoryData = [];
        $IMEIs = [];

        $imeiList = array_column($goods['goods'], 'IMEI');
        $goodsMap = Good::whereIn('IMEI', $imeiList)->get()->keyBy('IMEI');

        foreach ($goods['goods'] as $data) {
            $imei = $data['IMEI'];
            $good = $goodsMap[$imei];

            if (!$good) {
                throw new \Exception('Такого продукта не существует');
            }
            if ($good->amount == 0) {
                throw new \Exception("$good->IMEI - Товар уже продан");
            }

            $realizationHistoryData[] = [
                'IMEI' => $imei,
                'sender' => Auth::id(),
                'recipient' => $client->id,
                'type' => 'sale',
                'doc_number' => $doc_number,
                'type_id' => $good->type_id,
                'status_id' => Status::REALIZATION_CLIENT
            ];
        }
        foreach ($goods['goods'] as $imei) {
            $IMEIs[] = $imei['IMEI'];
        }
        Good::whereIn('IMEI', $IMEIs)->update(['amount' => 0]);
        RealizationHistory::insert($realizationHistoryData);


        return true;

    }

}
