<?php

namespace App\Http\Services;

use App\Http\Resources\GoodResource;
use App\Models\Type;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;

class TypeService
{

    public function index($page)
    {
        $pageSize = 20;

        return Type::paginate($pageSize, ['*'], 'page', $page);
    }

}
