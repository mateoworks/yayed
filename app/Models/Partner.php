<?php

namespace App\Models;

use Carbon\Carbon;
use GoldSpecDigital\LaravelEloquentUUID\Database\Eloquent\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Partner extends Model
{
    use HasFactory, Uuid;
    protected $keyType = 'string';
    protected $dateFormat = 'Y-m-d';
    protected $casts = [
        'birthday' => 'datetime:Y-m-d',
    ];

    public $incrementing = false;

    public function getFullNameAttribute()
    {
        return $this->names . ' ' . $this->surname_father . ' ' . $this->surname_mother;
    }

    public function trabajo()
    {
        return $this->belongsTo(Job::class, 'job_id');
    }

    public function colonia()
    {
        return $this->belongsTo(Colonia::class, 'colonia_id');
    }

    public function getJobAttribute()
    {
        return $this->trabajo->name;
    }

    public function getSuburbAttribute()
    {
        return $this->colonia->name ?? '';
    }

    public function getAgeAttribute()
    {
        return Carbon::parse($this->birthday)->age;
    }

    public function documents()
    {
        return $this->hasMany(Document::class);
    }

    public function solicituds()
    {
        return $this->hasMany(Solicitud::class);
    }

    public function loans()
    {
        return $this->hasMany(Loan::class);
    }
    public function getActiveAttribute()
    {
        $activo = false;
        foreach ($this->loans as $loan) {
            if ($loan->status == 'activo') {
                $activo = $loan;
            }
        }
        return $activo;
    }
    public function getSolicitudAutorizadoAttribute()
    {
        $activo = false;
        foreach ($this->solicituds as $solicitud) {
            if ($solicitud->condition == 'autorizado' && !$solicitud->loan()->exists()) {
                $activo = $solicitud;
            }
        }
        return $activo;
    }

    public function getSolicitudPendienteAttribute()
    {
        $pendiente = false;
        foreach ($this->solicituds as $solicitud) {
            if ($solicitud->condition == 'en proceso') {
                $pendiente = $solicitud;
            }
        }
        return $pendiente;
    }

    public function getPuedeSolicitarAttribute()
    {
        if ($this->active != true) {
            return true;
        }
    }
}
