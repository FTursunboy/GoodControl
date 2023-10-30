<?php

namespace App\Http\Controllers\API\Storage;

use App\Http\Controllers\Controller;
use App\Http\Resources\StatusResource;
use App\Models\Status;
use Illuminate\Http\JsonResponse;
use function response;

class StatusController extends Controller
{
    public function index() : JsonResponse
    {
        $history = Status::get();
        return response()->json([
            'status' => true,
            'statuses' => StatusResource::collection($history)
        ]);
    }

}
