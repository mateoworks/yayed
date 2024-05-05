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

    public function getNumeroAttribute()
    {
        return str_pad($this->number, 5, 0, STR_PAD_LEFT);
    }

    public function getUltimoPagoAttribute()
    {
        $ultimo = false;
        if ($this->payments->isNotEmpty()) {
            $ultimo = $this->payments->first();
        }
        return $ultimo;
    }

    public function getAtrazadoAttribute()
    {
        if ($this->ultimo_pago) {
            if ($this->ultimo_pago->made_date->diffInDays() > 35 && $this->status != 'liquidado') {
                return  true;
            }
        } else {
            if ($this->date_made->diffInDays() > 35) {
                return true;
            }
        }
        return false;
    }
}
