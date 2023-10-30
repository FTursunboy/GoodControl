<?php

namespace App\Http\Services\Consultant;

use App\Models\Good;
use App\Models\RealizationHistory;
use App\Models\Status;
use App\Models\StoreGood;
use Illuminate\Support\Facades\Auth;

class RealizationService
{
    public function index()
    {
        return RealizationHistory::where([
            ['status_id', Status::REALIZATION_STORE_CLIENT],
            ['sender',  Auth::user()->stores->first()->id]
        ])->select('doc_number', 'created_at')->get();

    }

    public function getGoodForSale($imei)
    {
        $good = StoreGood::where('IMEI', $imei)->first();

        if ($good->amount === 0) {
            abort(200, 'Этот товар уже продан!');
        }

        return [
          'name' => $good->type?->name,
          'barcode' => $good->type?->barcode,
          'IMEI' => $good->IMEI
        ];
    }

    public function store(array $goods)
    {
        try {
            $doc_number = time();
            $realizationHistory = [];
            $IMEIs = [];

            foreach ($goods['goods'] as $data) {
                $good = StoreGood::where('IMEI', $data['IMEI'])->first();
                $IMEIs[] = $data['IMEI'];

                $realizationHistory[] = [
                    'IMEI' => $data['IMEI'],
                    'sender' => Auth::id(),
                    'recipient' => null,
                    'type' => 'sale',
                    'doc_number' => $doc_number,
                    'type_id' => $good->type_id,
                    'price' => $data['price'] ?? 0,
                    'status_id' => Status::REALIZATION_STORE_CLIENT,
                    'created_at' => now(),
                    'updated_at' => now()
                ];
            }

            StoreGood::whereIn('IMEI', $IMEIs)->update(['amount' => 0]);
            RealizationHistory::insert($realizationHistory);

            return true;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
}
