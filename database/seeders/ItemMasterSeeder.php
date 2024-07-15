<?php

namespace Database\Seeders;

use App\Models\ItemMaster;
use Illuminate\Database\Seeder;

class ItemMasterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ItemMaster::create([
            'id' => '1',
            'name' => '牛肉',
            'place' => '冷蔵棚A-2',
            'category_id' => '1',
            'remarks' => '',
        ]);

        ItemMaster::create([
            'id' => '2',
            'name' => 'アイス',
            'place' => '冷凍庫B',
            'category_id' => '2',
            'remarks' => '',
        ]);

        ItemMaster::create([
            'id' => '3',
            'name' => 'スナック',
            'place' => 'お菓子コーナーC棚',
            'category_id' => '3',
            'remarks' => '',
        ]);
    }
}
