<?php

namespace Database\Seeders;

use App\Models\Marketing;
use App\Models\Sale;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Marketing::factory(10)->create()->each(function ($marketing) {
            sale::factory(3)->create(['marketing_id' => $marketing->id]);
        });;
    }
}
