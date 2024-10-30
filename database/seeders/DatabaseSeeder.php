<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Seeders\UrlSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            UrlSeeder::class,
            MetricSeeder::class
        ]);
    }
}
