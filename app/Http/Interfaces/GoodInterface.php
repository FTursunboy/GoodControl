<?php


namespace App\Http\Interfaces;

interface  GoodInterface {

    public function index();

    public function searchByIMEI( string $imei);

    public function searchByBarcode(string $barcode);
}
