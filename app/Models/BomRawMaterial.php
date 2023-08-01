<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BomRawMaterial extends Model
{
    use HasFactory;

    public $fillable = [
        'raw_material_id',
        'quantity',
        'unit_price',
        'amount',
        'user_id',
        'bom_id'
    ];
}
