<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static whereIn(string $string, array $IMEIs)
 * @method static insert(array $goodsToInsert)
 */
class Good extends Model
{
    use HasFactory;
    protected $guarded = false;

    public function scopeFindByIMEI($query, $imei)
    {
        return $query->where('IMEI', $imei);
    }

    public function provider() {
        return $this->belongsTo(User::class, 'provider_id');
    }

    public function type() {
        return $this->belongsTo(Type::class);
    }

    public function store() {
        return $this->belongsTo(User::class, '');
    }

    public function scopeInStock($query) {
       return $query->where('amount', 1);
    }

    public function scopeIsInStock($query, $good) : bool {
        if ($good->amount == 1) {
            return true;
        }
        return false;
    }


}
