<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static insert(array $realizationHistoryToInsert)
 */
class RealizationHistory extends Model
{
    use HasFactory;

    const SALE = 'sale';
    const RETURN = 'return';

    protected $guarded = false;

    public function scopeFindByIMEI($query, $imei)
    {
        return $query->where('IMEI', $imei);
    }

    public function good() {
        return $this->belongsTo(Good::class, 'IMEI', 'IMEI');
    }

    public function user() {
        return $this->belongsTo(User::class, 'recipient');
    }

    public function returnUser() {
        return $this->belongsTo(User::class, 'sender');
    }

    public function status() {
        return $this->belongsTo(Status::class, 'status_id');
    }

    public function types()
    {
        return $this->belongsTo(Type::class, 'type_id');
    }

    public function ScopeFindByDocNumber($query, $docNumber) {
       return $query->where('doc_number', $docNumber);
    }


}
