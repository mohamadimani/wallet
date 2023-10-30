<?php

namespace Database\Seeders;

use App\Models\Currency;
use Database\Factories\CurrencyFactory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CurrencySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Currency::factory()->count(10)->create();
    }
}
