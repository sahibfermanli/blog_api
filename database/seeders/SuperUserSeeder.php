<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class SuperUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        User::query()->create([
            'name' => 'Sahib',
            'surname' => 'Fermanli',
            'email' => 'sahibfermanli230@gmail.com',
            'password' => '12345678'
        ]);
    }
}
