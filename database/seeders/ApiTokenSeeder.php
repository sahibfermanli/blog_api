<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ApiTokenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        if (config('app.debug')) {
            $token = 'dgGmtLCgSyJ9thBdZjHAzBaOvYUsXSJOb0dkAYLdQcdou7fVtz';
        } else {
            $token = Str::random(50);
        }

        DB::table('api_tokens')->insert([
            'name' => 'web',
            'token' => $token,
            'is_active' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
