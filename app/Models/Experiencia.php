<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Experiencia extends Model
{
    use HasFactory;

    protected $table = 'experiencias';

    protected $fillable = [
        'user_id', 'puesto', 'empresa', 'ubicacion',
        'fecha_inicio', 'fecha_fin', 'trabajo_actual', 'descripcion'
    ];

    protected $casts = [
        'fecha_inicio' => 'date',
        'fecha_fin' => 'date',
        'trabajo_actual' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
