<?php

namespace Database\Seeders;

use App\Models\Title as ModelsTitle;
use Illuminate\Database\Seeder;

class Title extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ModelsTitle::factory()
        ->count(30)
        ->create();
    }
}
