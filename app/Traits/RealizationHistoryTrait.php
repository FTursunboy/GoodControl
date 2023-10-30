<?php

namespace App\Traits;

use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;

trait RealizationHistoryTrait
{
    public function getRealizationHistories($type, $role, $user_type = 'recipient') : Builder {

       return DB::table('realization_histories')
           ->select('realization_histories.doc_number',
               DB::raw('DATE_FORMAT(realization_histories.created_at, "%d-%m-%Y") as date'),
               'users.name as provider', 'types.barcode', 'types.name',
               DB::raw('(SELECT SUM(1) FROM realization_histories AS subquery WHERE subquery.doc_number = realization_histories.doc_number) as count'))
           ->where('realization_histories.type', $type)
           ->join('users', 'realization_histories.'.$user_type, '=', 'users.id')
           ->join('goods', 'realization_histories.IMEI', '=', 'goods.IMEI')
           ->join('types', 'goods.type_id', '=', 'types.id')
           ->join('model_has_roles', function ($join) use( $role ) {
               $join->on('users.id', '=', 'model_has_roles.model_id')
                   ->join('roles', 'model_has_roles.role_id', '=', 'roles.id')
                   ->where('roles.name', $role);
           })
           ->groupBy('realization_histories.doc_number', 'realization_histories.created_at', 'users.name', 'types.barcode', 'types.name')
           ->orderBy('realization_histories.created_at', 'desc');

    }
}
