<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        \App\Models\User::factory(10)->create();

        \App\Models\User::factory()->create([
            'nome' => 'Carlos Sergio',
            'cpf' => '12312312356',
            'data_nasc' => '2020-10-12',
            'tipo' => 'admin'
        ]);
    }
}
