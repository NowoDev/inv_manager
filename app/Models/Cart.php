<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static firstOrCreate(array $array)
 */
class Cart extends Model
{
    use HasFactory;

    protected $fillable = [
      'user_id',
      'inventory_id',
      'quantity',
    ];
}
