<?php

namespace Database\Seeders;

use App\Models\Marketplace;
use Illuminate\Database\Seeder;

class FillMarketplaces extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Marketplace::query()->create([
            'name' => 'Тренажеры.ру',
            'url' => 'http://www.trenazhery.ru/market2.xml',
        ]);
        Marketplace::query()->create([
            'name' => 'Radio-liga',
            'url' => 'http://www.radio-liga.ru/yml.php',
        ]);
    }
}
