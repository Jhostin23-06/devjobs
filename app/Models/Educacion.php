<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Educacion extends Model
{
    use HasFactory;

    protected $table = 'educaciones';

    protected $fillable = [
        'user_id', 'institucion', 'titulo', 'campo_estudio',
        'fecha_inicio', 'fecha_fin', 'estudiando_actualmente', 'descripcion'
    ];

    protected $casts = [
        'fecha_inicio' => 'date',
        'fecha_fin' => 'date',
        'estudiando_actualmente' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
