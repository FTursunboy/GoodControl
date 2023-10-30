<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
    use HasFactory;

    protected $guarded = false;

    public function goods() {
        return $this->hasMany(Good::class);
    }

    public function storeGoods() {
        return $this->hasMany(StoreGood::class);
    }

    public function scopeFindByBarcode($query, $barcode)
    {
        return $query->where('barcode', $barcode);
    }
}
