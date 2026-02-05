<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Habilidad extends Model
{
    use HasFactory;

    protected $table = 'habilidades';

    protected $fillable = ['nombre', 'categoria', 'activo'];

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_habilidad')
                    ->withPivot('nivel', 'experiencia_meses')
                    ->withTimestamps();
    }

}
