<?php

namespace Database\Seeders;

use App\Models\Habilidad;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class HabilidadSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $habilidades = [
            // Frontend
            ['nombre' => 'HTML5', 'categoria' => 'frontend'],
            ['nombre' => 'CSS3', 'categoria' => 'frontend'],
            ['nombre' => 'JavaScript', 'categoria' => 'frontend'],
            ['nombre' => 'React', 'categoria' => 'frontend'],
            ['nombre' => 'Vue.js', 'categoria' => 'frontend'],
            ['nombre' => 'Angular', 'categoria' => 'frontend'],
            
            // Backend
            ['nombre' => 'PHP', 'categoria' => 'backend'],
            ['nombre' => 'Laravel', 'categoria' => 'backend'],
            ['nombre' => 'Python', 'categoria' => 'backend'],
            ['nombre' => 'Django', 'categoria' => 'backend'],
            ['nombre' => 'Node.js', 'categoria' => 'backend'],
            ['nombre' => 'Express.js', 'categoria' => 'backend'],
            ['nombre' => 'MySQL', 'categoria' => 'backend'],
            ['nombre' => 'PostgreSQL', 'categoria' => 'backend'],
            ['nombre' => 'MongoDB', 'categoria' => 'backend'],
            
            // Herramientas
            ['nombre' => 'Git', 'categoria' => 'herramientas'],
            ['nombre' => 'Docker', 'categoria' => 'herramientas'],
            ['nombre' => 'AWS', 'categoria' => 'herramientas'],
            ['nombre' => 'Linux', 'categoria' => 'herramientas'],
            
            // Habilidades blandas
            ['nombre' => 'Trabajo en equipo', 'categoria' => 'soft'],
            ['nombre' => 'Comunicación', 'categoria' => 'soft'],
            ['nombre' => 'Resolución de problemas', 'categoria' => 'soft'],
            ['nombre' => 'Gestión del tiempo', 'categoria' => 'soft'],
        ];

        foreach ($habilidades as $habilidad) {
            Habilidad::create($habilidad);
        }
    }
}
