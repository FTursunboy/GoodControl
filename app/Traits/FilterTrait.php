<?php

namespace App\Traits;

use Carbon\Carbon;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;

trait FilterTrait
{
    public function filter(int $param, Builder $query, string $from, string $to) : Builder {
        if ($param === 1) {
            $query->whereDate('realization_histories.created_at', Carbon::today());
        } elseif ($param === 2) {
            $query->whereBetween('realization_histories.created_at', [Carbon::now()->subWeek()->subDay(), Carbon::now()]);
        } elseif ($param === 3) {
            $query->whereBetween('realization_histories.created_at', [Carbon::now()->subMonth()->subDay(), Carbon::now()]);
        } elseif ($param === 4) {
            $query->whereBetween('realization_histories.created_at', [Carbon::now()->subMonths(3)->subDay(), Carbon::now()]);
        } elseif ($param === 5) {
            $query->whereBetween('realization_histories.created_at', [Carbon::now()->subYear(), Carbon::now()]);
        } elseif ($param === 7) {
            $query->whereBetween('realization_histories.created_at', [$from, $to]);
        }

        return $query;
    }
}
