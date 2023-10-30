<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    use HasFactory;

    const PURCHASE = 1;
    const REALIZATION_CLIENT = 2;
    const REALIZATION_STORE = 3;
    const RETURN_CLIENT = 4;
    const RETURN_STORE = 5;
    const REALIZATION_STORE_CLIENT = 6;
    const RETURN_STORE_STORAGE = 7;
    const RETURN_CLIENT_STORE = 8;
}
