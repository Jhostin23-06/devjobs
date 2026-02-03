<?php

namespace Database\Seeders;

use App\Models\Modalidad;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ModalidadSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $modalidades = [
            ['nombre' => 'Presencial', 'slug' => 'presencial'],
            ['nombre' => 'Remoto', 'slug' => 'remoto'],
            ['nombre' => 'Híbrido', 'slug' => 'hibrido'],
            ['nombre' => 'Flexible', 'slug' => 'flexible'],
        ];

        foreach ($modalidades as $modalidad) {
            Modalidad::create($modalidad);
        }
    }
}
