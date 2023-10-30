<?php

namespace App\Http\Services;

use App\Http\Resources\GoodResource;
use App\Models\Type;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use PHPUnit\Framework\Constraint\Count;

class GoodService
{

    public function index() : Collection
    {
        $types = DB::table('types')
            ->select('id as product_id', 'barcode', 'name', 'category_id',
                DB::raw('(SELECT COUNT(*) FROM goods WHERE goods.type_id = types.id) as goods_count'))
            ->get();

        foreach ($types as $type) {
            $type->goods = DB::table('goods as g')
                ->join('users as u', 'u.id', '=', 'g.provider_id')
                ->where('g.type_id', $type->product_id)
                ->select('g.id', 'g.IMEI', 'g.price', 'u.name as provider')
                ->where('g.amount', 1)
                ->orderBy('g.created_at', 'desc')
                ->take(10)
                ->get();
        }

        return $types;
    }


}
