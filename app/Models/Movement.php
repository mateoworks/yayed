<?php

namespace App\Models;

use GoldSpecDigital\LaravelEloquentUUID\Database\Eloquent\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Movement extends Model
{
    use HasFactory, Uuid;
    protected $keyType = 'string';
    protected $dateFormat = 'Y-m-d';
    protected $casts = [
        'date_movement' => 'datetime:Y-m-d',
    ];

    public function category()
    {
        return $this->belongsTo(CategoryMovement::class, 'category_movement_id');
    }
}
