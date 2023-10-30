<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static insert(array $storeGoodToInsert)
 * @method static whereIN(string $string, array $IMEIs)
 * @method static where(string $string, $imei)
 */
class StoreGood extends Model
{
    use HasFactory;

    protected $guarded = false;

    public function type() {
        return $this->belongsTo(Type::class);
    }
}
