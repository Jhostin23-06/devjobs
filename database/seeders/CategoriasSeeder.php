<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categorias = [
            // TOP 10 más demandados en Perú
            ['categoria' => 'Full Stack Developer'],
            ['categoria' => 'Backend Developer'],
            ['categoria' => 'Frontend Developer'],
            ['categoria' => 'Mobile Developer'],
            ['categoria' => 'DevOps Engineer'],
            ['categoria' => 'Data Analyst'],
            ['categoria' => 'QA Engineer'],
            ['categoria' => 'UX/UI Designer'],
            ['categoria' => 'Tech Lead'],
            ['categoria' => 'Project Manager'],
            
            // Especialidades técnicas
            ['categoria' => 'Java Developer'],
            ['categoria' => 'Python Developer'],
            ['categoria' => '.NET Developer'],
            ['categoria' => 'React Developer'],
            ['categoria' => 'Node.js Developer'],
            ['categoria' => 'Android Developer'],
            ['categoria' => 'iOS Developer'],
            ['categoria' => 'Cloud Engineer'],
            ['categoria' => 'Database Administrator'],
            
            // Roles empresariales (muy demandados en corporaciones)
            ['categoria' => 'SAP Consultant'],
            ['categoria' => 'Business Intelligence'],
            ['categoria' => 'ERP Developer'],
            ['categoria' => 'IT Manager'],
            
            // Startups & Fintech peruanas
            ['categoria' => 'Fintech Developer'],
            ['categoria' => 'Blockchain Developer'],
            ['categoria' => 'API Developer'],
            
            // E-commerce (muy fuerte en Perú)
            ['categoria' => 'Magento Developer'],
            ['categoria' => 'Shopify Developer'],
            ['categoria' => 'WordPress Developer'],
            
            // Ciberseguridad (en crecimiento)
            ['categoria' => 'Cybersecurity Analyst'],
        ];

        foreach ($categorias as $categoria) {
            DB::table('categorias')->insert([
                'categoria' => $categoria['categoria'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}