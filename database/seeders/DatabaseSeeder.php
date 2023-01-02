<?php

namespace Database\Seeders;

use App\Models\StatusCounter;
use App\Models\StatusQueue;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            UserSeeder::class,
            RoleSeeder::class,
            UserRoleSeeder::class,
            StatusCounterSeeder::class,
            StatusQueueSeeder::class,
        ]);
    }
}
