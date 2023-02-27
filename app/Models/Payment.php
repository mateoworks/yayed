<?php

namespace App\Models;

use GoldSpecDigital\LaravelEloquentUUID\Database\Eloquent\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory, Uuid;
    protected $keyType = 'string';
    protected $dateFormat = 'Y-m-d';
    protected $casts = [
        'scheduled_date' => 'datetime:Y-m-d',
        'made_date' => 'datetime:Y-m-d',
    ];

    public $incrementing = false;

    public static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->number = Payment::max('number') + 1;
        });
    }

    public function loan()
    {
        return $this->belongsTo(Loan::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getNumeroAttribute()
    {
        return str_pad($this->number, 6, 0, STR_PAD_LEFT);
    }

    public function getNoDaysAttribute()
    {
        return $this->scheduled_date->diffInDays($this->made_date, false);
    }
    public function getClassColorAttribute()
    {
        $days = $this->scheduled_date->diffInDays($this->made_date, false);
        if ($days <= 4) {
            return 'pago1';
        } else if ($days >= 5 && $days <= 8) {
            return 'pago2';
        } else if ($days >= 9 && $days <= 12) {
            return 'pago3';
        } else if ($days >= 13 && $days <= 16) {
            return 'pago4';
        } else if ($days >= 17 && $days <= 20) {
            return 'pago5';
        } else {
            return 'pago6';
        }
    }
}
