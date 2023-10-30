<?php

namespace App\Http\Services;


use App\Jobs\PurchaseJob;
use App\Models\Good;
use App\Models\Purchase;
use App\Models\RealizationHistory;
use App\Models\Status;
use App\Models\Type;
use App\Traits\FilterTrait;
use Carbon\Carbon;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PurchaseService {

    use FilterTrait;

    public function index($param, $from, $to)
    {
        $query = DB::table('realization_histories')
            ->select('realization_histories.doc_number',
                DB::raw('(SELECT SUM(1) FROM realization_histories AS subquery WHERE subquery.doc_number = realization_histories.doc_number) as count'),
                DB::raw('DATE_FORMAT(realization_histories.created_at, "%d-%m-%Y") as date'),
                'types.barcode', 'types.name', 'goods.provider_id')
            ->where('realization_histories.type', 'purchase')
            ->join('goods', 'realization_histories.IMEI', '=', 'goods.IMEI')
            ->join('types', 'goods.type_id', '=', 'types.id')
            ->orderBy('realization_histories.created_at', 'desc')
            ->groupBy('realization_histories.doc_number', 'types.barcode', 'types.name', 'realization_histories.created_at', 'goods.provider_id');


        $this->filter($param, $query, $from, $to);

        return $query->get();
    }

    public function purchaseByDocNumber($docNumber) : Collection
    {
        return RealizationHistory::where('doc_number', $docNumber)->get();
    }

    public function purchase($data, Type $type) : bool
    {
        try {
            DB::beginTransaction();
            $doc_number = time();
            $goodsToInsert = [];
            $realizationHistoryToInsert = [];

            foreach ($data['goods'] as $good) {
                $goodsToInsert[] = [
                    'IMEI' => $good['IMEI'],
                    'type_id' => $type->id,
                    'provider_id' => $data['provider_id']
                ];

                $realizationHistoryToInsert[] = [
                    'IMEI' => $good['IMEI'],
                    'sender' => $data['provider_id'],
                    'recipient' => Auth::id(),
                    'type' => 'purchase',
                    'doc_number' => $doc_number,
                    'type_id' => $type->id,
                    'status_id' => Status::PURCHASE
                ];
            }

            Good::insert($goodsToInsert);
            RealizationHistory::insert($realizationHistoryToInsert);

            DB::commit();

            return true;
        } catch (\Exception $e) {
            DB::rollback();
            return false;
        }
    }


}
