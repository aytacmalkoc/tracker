<?php

namespace seeders;

use App\Models\Tracking;
use Illuminate\Database\Seeder;

class TrackingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Tracking::factory(100)->create();
    }
}
