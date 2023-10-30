<?php


namespace App\Http\Interfaces;

use App\Http\Requests\CheckRequest;
use App\Http\Requests\PurchaseRequest;
use App\Http\Requests\TypeRequest;

interface  PurchaseInterface {

    public function check(string $barcode);

    public function addType(TypeRequest $request, int $id);

    public function purchase(PurchaseRequest $request);

    public function getPurchaseHistory(int $id);
}
