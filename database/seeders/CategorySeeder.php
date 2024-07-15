<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Database\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Category::create([
            'id' => '1',
            'name' => '要冷蔵',
            'storage' => '冷蔵倉庫',
        ]);

        Category::create([
            'id' => '2',
            'name' => '要冷凍',
            'storage' => '冷凍倉庫',
        ]);

        Category::create([
            'id' => '3',
            'name' => '常温',
            'storage' => '倉庫',
        ]);
    }
}
