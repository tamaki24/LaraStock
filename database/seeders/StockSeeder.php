<?php

namespace Database\Seeders;

use App\Models\Stock;
use Illuminate\Database\Seeder;

class StockSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Stock::create([
            'id' => '1',
            'stock' => 12,
            'master_id' => '1',
            'deadline' => now()->addDays(14),
        ]);

        Stock::create([
            'id' => '2',
            'stock' => 30,
            'master_id' => '2',
            'deadline' => now()->addDays(14),
        ]);

        Stock::create([
            'id' => '3',
            'stock' => 150,
            'master_id' => '3',
            'deadline' => now()->addDays(14),
        ]);
    }
}
