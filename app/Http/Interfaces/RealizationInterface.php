<?php


namespace App\Http\Interfaces;

use App\Http\Requests\CheckRequest;
use App\Http\Requests\PurchaseRequest;
use App\Http\Requests\TypeRequest;
use App\Models\Client;
use App\Models\Store;
use App\Models\User;

interface  RealizationInterface {

    public function storeRealization(int $id, array $goods);

    public function clientRealization(User $store, array $goods);
}
