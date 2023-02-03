<?php

namespace App\Models;

use GoldSpecDigital\LaravelEloquentUUID\Database\Eloquent\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    use HasFactory, Uuid;
    protected $keyType = 'string';
    public $incrementing = false;

    public function partner()
    {
        return $this->belongsTo(Partner::class);
    }
}
