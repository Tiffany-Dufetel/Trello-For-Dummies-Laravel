<?php

namespace Database\Seeders;

use App\Models\Card as ModelsCard;
use Illuminate\Database\Seeder;

class Card extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ModelsCard::factory()
        ->count(30)
        ->create();
    }
}
