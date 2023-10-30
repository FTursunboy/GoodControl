<?php

namespace App\Http\Services\Consultant;

use App\Models\Good;
use App\Models\RealizationHistory;
use App\Models\Status;
use App\Models\StoreGood;
use Illuminate\Support\Facades\Auth;

class ReturnService
{
    public function clientReturn(array $goods) : bool
    {
        $doc_number = time();
        $IMEIs = [];
        $realizationHistoryToInsert = [];

        foreach ($goods['goods'] as $data) {
            $good = Good::findByIMEI($data['IMEI'])->first();

            if ($good->amount == 1) {
                abort(200, "Этот товар уже продан");
            }

            $realizationHistoryToInsert[] = [
                'IMEI' => $data['IMEI'],
                'sender' => null,
                'recipient' => Auth::user()->stores()->first()->id,
                'type' => 'return',
                'doc_number' => $doc_number,
                'type_id' => $good->type_id,
                'status_id' => Status::RETURN_CLIENT_STORE,
                'created_at' => now(),
                'updated_at' => now()
            ];
            $IMEIs[] = $data['IMEI'];
        }

        StoreGood::whereIn('IMEI', $IMEIs)->update(['amount' => 1]);
        RealizationHistory::insert($realizationHistoryToInsert);

        return true;
    }

    public function getGoodForReturn($imei): array
    {
        $good = StoreGood::where('IMEI', $imei)->first();

        if (!$good) {
            abort(200, 'Такого товара не существует в магазине!');
        }

        if ($good->amount === 0) {
            abort(200, 'Этот товар уже продан или возвращен!');
        }

        return [
            'name' => $good->type?->name,
            'barcode' => $good->type?->barcode,
            'IMEI' => $good->IMEI
        ];
    }

    public function getDocumentOfReturnToStorage()
    {
        return RealizationHistory::where([
            ['status_id', Status::RETURN_STORE_STORAGE],
            ['sender',  Auth::user()->stores()->first()->id]
        ])->select('doc_number', 'created_at')->get();
    }

    public function getDocumentsOfReturnClientToStore() {
        return RealizationHistory::where([
            ['status_id', Status::RETURN_CLIENT_STORE],
            ['recipient', Auth::user()->stores()->first()->id]
        ])->get();
    }

    public function returnToStorage(array $goods)
    {
        try {
            $doc_number = time();
            $realizationHistory = [];
            $IMEIs = [];

            foreach ($goods['goods'] as $data) {
                $good = StoreGood::where('IMEI', $data['IMEI'])->first();

                if (!$good) {
                    abort(200, 'Такого товара не существует в магазине!');
                }
                if ($good?->amount === 0) {
                    abort(200, 'Этого товара невозможно возвращать!');
                }

                $IMEIs[] = $data['IMEI'];

                $realizationHistory[] =  [
                    'IMEI' => $data['IMEI'],
                    'sender' => Auth::user()->stores()->first()->id,
                    'recipient' => 1,
                    'type' => 'return',
                    'doc_number' => $doc_number,
                    'type_id' => $good->type_id,
                    'status_id' => Status::RETURN_STORE_STORAGE,
                    'created_at' => now(),
                    'updated_at' => now()
                ];
            }

            Good::whereIN('IMEI', $IMEIs)->update(['amount' => 1]);
            StoreGood::whereIN('IMEI', $IMEIs)->delete();
            RealizationHistory::insert($realizationHistory);

            return true;

        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }


}
