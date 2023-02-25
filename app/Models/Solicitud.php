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

    public function getNumeroAttribute()
    {
        return str_pad($this->folio, 5, 0, STR_PAD_LEFT);
    }

    public function partner()
    {
        return $this->belongsTo(Partner::class);
    }

    public function loan()
    {
        return $this->hasOne(Loan::class);
    }

    public function endorsements()
    {
        return $this->belongsToMany(Endorsement::class);
    }

    public function warranties()
    {
        return $this->hasMany(Warranty::class);
    }
}
