<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StatusQueueSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('status_queues')->insert(
            [
                [
                    'name' => "Waiting",
                ],
                [
                    'name' => "Occure",
                ],
                [
                    'name' => "Done",
                ],
                [
                    'name' => "Skip",
                ]
            ]
        );
    }
}
