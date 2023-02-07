<?php

namespace App\Models;

use GoldSpecDigital\LaravelEloquentUUID\Database\Eloquent\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Solicitud extends Model
{
    use HasFactory, Uuid;
    protected $keyType = 'string';
    protected $dateFormat = 'Y-m-d';
    protected $casts = [
        'date_solicitud' => 'datetime:Y-m-d',
        'date_payment' => 'datetime:Y-m-d',
    ];
    public $incrementing = false;

    public static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->folio = Solicitud::max('folio') + 1;
        });
    }

    public function partner()
    {
        return $this->belongsTo(Partner::class);
    }
}
