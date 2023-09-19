<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Bulan;
use App\Models\LearningActiviti;
use App\Models\Metode;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Metode::create([
            'metode'    => 'Workshop/Self Learning'
        ]);
        Metode::create([
            'metode'    => 'Sharing Practice'
        ]);

        Bulan::create([
            'bulan' => 'Januari'
        ]);
        Bulan::create([
            'bulan' => 'Februari'
        ]);
        Bulan::create([
            'bulan' => 'Maret'
        ]);

        LearningActiviti::create([
            'metode_id' => 1,
            'bulan_id'  => 1,
            'activity'  => 'Fundamental of Superintendence'
        ]);
        LearningActiviti::create([
            'metode_id' => 1,
            'bulan_id'  => 2,
            'activity'  => 'Ask the Expert'
        ]);
        LearningActiviti::create([
            'metode_id' => 2,
            'bulan_id'  => 2,
            'activity'  => 'Sharing Practice'
        ]);
    }
}
