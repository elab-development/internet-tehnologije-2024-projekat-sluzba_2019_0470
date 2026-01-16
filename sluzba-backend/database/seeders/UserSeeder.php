<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'ime' => 'Marija',
            'prezime' => 'Marković',
            'email' => 'marija.m@fon.bg.ac.rs',
            'password' => Hash::make('admin'),
            'broj_indeksa' => null,
            'smer' => null,
            'godina_studija' => null,
            'role' => 'sluzbenik'
        ]);

        User::create([
            'ime' => 'Dusan',
            'prezime' => 'Simic',
            'email' => 'ds20190470@student.fon.bg.ac.rs',
            'password' => Hash::make('simkela470'),
            'broj_indeksa' => '2019/0470',
            'smer' => 'Informacione Tehnologije i Sistemi',
            'godina_studija' => 4,
            'role' => 'student'
        ]);

        User::factory(10)->create();

    }
}
