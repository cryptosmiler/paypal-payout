<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Setting;


class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        Setting::truncate();

        Setting::insert([
            [
                'key'       => 'welcome_gift', 
                'value'     => '10', 
                'describe'  => '$'
            ], 
            [
                'key'       => '5_bonus', 
                'value'     => '0', 
                'describe'  => '$'
            ], 
            [
                'key'       => '10_bonus', 
                'value'     => '1', 
                'describe'  => '$'
            ], 
            [
                'key'       => '20_bonus', 
                'value'     => '3', 
                'describe'  => '$'
            ], 
            [
                'key'       => '30_bonus', 
                'value'     => '5', 
                'describe'  => '$'
            ], 
            [
                'key'       => '40_bonus', 
                'value'     => '7', 
                'describe'  => '$'
            ], 
            [
                'key'       => '50_bonus', 
                'value'     => '9', 
                'describe'  => '$'
            ], 
            [
                'key'       => 'value_increase', 
                'value'     => '10', 
                'describe'  => '%'
            ], 
            [
                'key'       => 'max_file_size', 
                'value'     => '10', 
                'describe'  => 'mb'
            ], 
        ]);
    }
}
