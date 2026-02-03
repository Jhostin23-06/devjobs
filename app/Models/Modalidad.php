<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Modalidad extends Model
{
    use HasFactory;

    protected $table = 'modalidades';

    protected $fillable = ['nombre', 'slug', 'activo'];

    // Relación con vacantes
    public function vacantes()
    {
        return $this->hasMany(Vacante::class);
    }
}