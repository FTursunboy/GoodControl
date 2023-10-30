<?php

use Illuminate\Support\Facades\Route;

    Route::get('get/products', [\App\Http\Controllers\API\Consultant\TypeController::class, 'index']);

    Route::get('get/realizations', [\App\Http\Controllers\API\Consultant\RealizationController::class, 'index']);
    Route::get('/getGoodForSale/{imei}', [\App\Http\Controllers\API\Consultant\RealizationController::class, 'getGoodForSale']);
    Route::get('/realizationByDocNumber/{docNumber}', [\App\Http\Controllers\API\Consultant\RealizationController::class, 'realizationByDocNumber']);
    Route::post('/storeRealization', [\App\Http\Controllers\API\Consultant\RealizationController::class, 'store']);


    Route::get('getDocumentOfReturnToStorage', [\App\Http\Controllers\API\Consultant\ReturnController::class, 'getDocumentOfReturnToStorage']);
    Route::get('getGoodForReturn/{imei}', [\App\Http\Controllers\API\Consultant\ReturnController::class, 'getGoodForReturn']);
    Route::get('getDocumentOfReturnToStorageByDocNumber/{docNumber}', [\App\Http\Controllers\API\Consultant\ReturnController::class, 'getDocumentOfReturnToStorageByDocNumber']);
    Route::post('returnToStorage', [\App\Http\Controllers\API\Consultant\ReturnController::class, 'store']);

    Route::get('getDocumentsOfReturnClientToStore', [\App\Http\Controllers\API\Consultant\ReturnController::class, 'getDocumentsOfReturnClientToStore']);
    Route::get('getDocumentOfReturnToStoreByDocNumber/{docNumber}', [\App\Http\Controllers\API\Consultant\ReturnController::class, 'getDocumentOfReturnToStoreByDocNumber']);
    Route::post('clientReturn', [\App\Http\Controllers\API\Consultant\ReturnController::class, 'clientReturn']);
