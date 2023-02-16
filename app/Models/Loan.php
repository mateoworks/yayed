<?php

namespace App\Models;

use GoldSpecDigital\LaravelEloquentUUID\Database\Eloquent\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Loan extends Model
{
    use HasFactory, Uuid;
    protected $keyType = 'string';
    protected $dateFormat = 'Y-m-d';
    protected $casts = [
        'date_made' => 'datetime:Y-m-d',
        'date_payment' => 'datetime:Y-m-d',
    ];

    public $incrementing = false;

    public function partner()
    {
        return $this->belongsTo(Partner::class);
    }

    public function solicitud()
    {
        return $this->belongsTo(Solicitud::class);
    }

    public function contribution()
    {
        return $this->belongsTo(Contribution::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class)->orderBy('scheduled_date', 'desc');
    }

    public function getUltimoPagoAttribute()
    {
        $ultimo = false;
        if ($this->payments->isNotEmpty()) {
            $ultimo = $this->payments->first();
        }
        return $ultimo;
    }
}
