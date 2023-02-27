<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Colonia extends Model
{
    use HasFactory;
    protected $fillable = ['name'];

    public function partners()
    {
        return $this->hasMany(Partner::class);
    }
}
