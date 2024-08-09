<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Admin;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Hash;

use App\Models\Language;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Admin::insert([
        //     [
        //         'first_name'        => 'Orlev', 
        //         'last_name'         => '', 
        //         'email'             => 'dali18center@gmail.com', 
        //         'phone'             => '', 
        //         'role'              => 'SuperAdmin', 
        //         'activated'         => 1, 
        //         'password'          => Hash::make('admin12345'), 
        //         'phone'             => "523313100", 
        //         'phone_prefix'      => "972", 
        //         'country_code'      => "IL"
        //     ], 
        //     [
        //         'first_name'        => 'Climax', 
        //         'last_name'         => '', 
        //         'email'             => 'climax.mgc@gmail.com', 
        //         'phone'             => '', 
        //         'role'              => 'SuperAdmin', 
        //         'activated'         => 1, 
        //         'password'          => Hash::make('admin12345'), 
        //         'phone'             => "523313100", 
        //         'phone_prefix'      => "972", 
        //         'country_code'      => "IL", 
        //         'phone_verified_at' => "2025-01-01"
        //     ]
        // ]);

        Language::truncate();

        $this->call([
            WebLanguageSeeder::class, 
            MessageLanguageSeeder::class, 
            AppLanguageSeeder::class, 
        ]);
    }
}
