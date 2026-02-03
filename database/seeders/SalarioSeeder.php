<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SalarioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $salarios = [
            ['salario' => 'S/ 1,000 - S/ 2,500'],
            ['salario' => 'S/ 2,501 - S/ 4,000'],
            ['salario' => 'S/ 4,001 - S/ 6,000'],
            ['salario' => 'S/ 6,001 - S/ 9,000'],
            ['salario' => 'S/ 9,001 - S/ 12,000'],
            ['salario' => 'S/ 12,001 - S/ 18,000'],
            ['salario' => '+ S/ 18,000'],
            ['salario' => 'A convenir'],
        ];

        foreach ($salarios as $salario) {
            DB::table('salarios')->insert([
                'salario' => $salario['salario'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}