<?php

use Illuminate\Support\Facades\Route;

Route::get('getByBarcode/{barcode}', [\App\Http\Controllers\API\Storage\PurchaseController::class, 'check']);
Route::get('getByBarcode/WithoutGoods/{barcode}', [\App\Http\Controllers\API\Storage\PurchaseController::class, 'getByBarcode']);
Route::post('good/store/type/{id}', [\App\Http\Controllers\API\Storage\PurchaseController::class, 'addType']);
Route::get( 'getAllPurchase/good/{param}/{from?}/{to?}', [\App\Http\Controllers\API\Storage\PurchaseController::class, 'index']);
Route::get( 'purchaseByDocNumber/{docNumber}', [\App\Http\Controllers\API\Storage\PurchaseController::class, 'purchaseByDocNumber']);
Route::post('purchase', [\App\Http\Controllers\API\Storage\PurchaseController::class, 'purchase']);

Route::get('goods/realization/realizationOfClient/{param}/{from?}/{to?}', [\App\Http\Controllers\API\Storage\RealizationController::class, 'realizationOfClient']);
Route::get('goods/realization/realizationOfStore/{param}/{from?}/{to?}', [\App\Http\Controllers\API\Storage\RealizationController::class, 'realizationOfStore']);
Route::get('goods/realization/realizationOfClientByDocNumber/{docNumber}', [\App\Http\Controllers\API\Storage\RealizationController::class, 'realizationOfClientByDocNumber']);
Route::post('goods/realization/store/{id}', [\App\Http\Controllers\API\Storage\RealizationController::class, 'storeRealization']);
Route::post('goods/realization/client/{id}', [\App\Http\Controllers\API\Storage\RealizationController::class, 'clientRealization']);
Route::get('getHistoriesByBarcode/{barcode}', [\App\Http\Controllers\API\Storage\RealizationController::class, 'getHistoryByBarcode']);

Route::get('goods/return/returnOfClient/{param}/{from?}/{to?}', [\App\Http\Controllers\API\Storage\ReturnController::class, 'returnOfClient']);
Route::get('goods/return/returnOfStore/{param}/{from?}/{to?}', [\App\Http\Controllers\API\Storage\ReturnController::class, 'returnOfStore']);
Route::get('goods/return/returnOfStoreByDocNumber/{docNumber}', [\App\Http\Controllers\API\Storage\ReturnController::class, 'returnOfStoreByDocNumber']);
Route::post('goods/return/store/{id}', [\App\Http\Controllers\API\Storage\ReturnController::class, 'returnStore']);
Route::post('goods/return/client/{id}', [\App\Http\Controllers\API\Storage\ReturnController::class, 'returnClient']);

Route::get('searchByIMEI/{imei}', [\App\Http\Controllers\API\Storage\GoodController::class, 'searchByIMEI']);
Route::get('searchByBarcode/{barcode}', [\App\Http\Controllers\API\Storage\GoodController::class, 'searchByBarcode']);
Route::get( 'getAllGoods', [\App\Http\Controllers\API\Storage\GoodController::class, 'index']);

Route::get('historyByIMEI/{imei}', [\App\Http\Controllers\API\Storage\HistoryController::class, 'historyByIMEI']);
Route::get('goodsByBarcode', [\App\Http\Controllers\API\Storage\HistoryController::class, 'goodsByBarcode']);

Route::get('statuses/get', [\App\Http\Controllers\API\Storage\StatusController::class, 'index']);

