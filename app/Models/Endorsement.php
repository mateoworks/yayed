<?php

namespace App\Models;

use GoldSpecDigital\LaravelEloquentUUID\Database\Eloquent\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Endorsement extends Model
{

    use HasFactory, Uuid;

    protected $keyType = 'string';
    public $incrementing = false;

    public function solicituds()
    {
        return $this->belongsToMany(Solicitud::class);
    }
    public function getFullNameAttribute()
    {
        return $this->names . ' ' . $this->surnames;
    }
}
