<?php

namespace App\Jobs;

use App\Models\Client;
use App\Models\Good;
use App\Models\RealizationHistory;
use App\Models\Store;
use App\Models\Type;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class RealizationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $store;
    private $client;
    private string $type;
    private array $goods;


    /**
     * Create a new job instance.
     */
    public function __construct(array $goods, $store, $client, $type)
    {
        $this->goods = $goods;
        $this->store = $store;
        $this->type = $type;
        $this->client = $client;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $groupedGoods = [];

        foreach ($this->goods as $data) {
            $typeId = Good::findByIMEI($data['IMEI'])->first()->type_id;

            if (array_key_exists($typeId, $groupedGoods)) {
                $groupedGoods[$typeId]['amount'] += 1;
            } else {

                $groupedGoods[$typeId] = [
                    'type_id' => $typeId,
                    'amount' => 1,
                    'store_id' => $this->store ?? null,
                    'client_id' => $this->client ?? null,
                    'type' => $this->type,
                    'sent' => false
                ];
            }
        }




    }
}
