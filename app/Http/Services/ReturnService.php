<?php

namespace App\Http\Services;


use App\Jobs\RealizationJob;
use App\Models\Good;
use App\Models\RealizationHistory;
use App\Models\Status;
use App\Models\User;
use App\Traits\FilterTrait;
use App\Traits\RealizationHistoryTrait;
use Carbon\Carbon;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ReturnService  {

    use RealizationHistoryTrait, FilterTrait;

    public function returnOfClient(int $param, string $from, string $to) : Collection
    {
        $query = $this->getRealizationHistories(RealizationHistory::RETURN, User::ROLE_CLIENT, 'sender');

        $this->filter($param, $query, $from, $to);

        return $query->get();

    }


    public function returnOfStore(int $param, string $from, string $to) : Collection
    {
        $query = $this->getRealizationHistories(RealizationHistory::RETURN, User::ROLE_STORE, 'sender');

        $this->filter($param, $query, $from, $to);

        return $query->get();
    }


    public function returnOfClientByDocNumber($docNumber) : Collection
    {
        return DB::table('realization_histories as r')
            ->join('types as t', 't.id', 'r.type_id')
            ->where('doc_number', $docNumber)
            ->select('r.IMEI', 't.barcode', 't.name')
            ->get();

    }
    public function storeReturn(User $store, array $goods) : bool
    {
        try {

            $doc_number = time();
            $IMEIs = [];
            $realizationHistoryToInsert = [];

            foreach ($goods['goods'] as $data) {
                $good = Good::findByIMEI($data['IMEI'])->first();

                if ($good->amount == 1) {
                    throw new \Exception("Товар уже находится на складе");
                }

                $realizationHistoryToInsert[] = [
                    'IMEI' => $data['IMEI'],
                    'sender' => $store->id,
                    'recipient' => Auth::id(),
                    'type' => 'return',
                    'doc_number' => $doc_number,
                    'type_id' => $good->type_id,
                    'status_id' => Status::RETURN_STORE
                ];
            }
            foreach ($goods['goods'] as $imei) {
                $IMEIs[] = $imei['IMEI'];
            }

            Good::whereIn('IMEI', $IMEIs)->update(['amount' => 1]);
            RealizationHistory::insert($realizationHistoryToInsert);



            return true;
        } catch (\Exception $exception) {

            return $exception->getMessage();
        }
    }

    public function clientReturn($client, array $goods) : bool
    {
        try {
            DB::beginTransaction();
            $doc_number = time();
            $IMEIs = [];
            $realizationHistoryToInsert = [];

            foreach ($goods['goods'] as $data) {
                $good = Good::findByIMEI($data['IMEI'])->first();

                if ($good->amount == 1) {
                    throw new \Exception("Товар уже находится на складе");
                }

                $IMEIs[] = $data['IMEI'];

                $realizationHistoryToInsert[] = [
                    'IMEI' => $data['IMEI'],
                    'sender' => $client,
                    'recipient' => Auth::id(),
                    'type' => 'return',
                    'doc_number' => $doc_number,
                    'type_id' => $good->type_id,
                    'status_id' => Status::RETURN_CLIENT,
                ];
            }


            Good::whereIn('IMEI', $IMEIs)->update(['amount' => 1]);

            RealizationHistory::insert($realizationHistoryToInsert);

            DB::commit();

            RealizationJob::dispatch($goods['goods'], null, $client, 'return');

            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            return $e->getMessage();
        }
    }


}
