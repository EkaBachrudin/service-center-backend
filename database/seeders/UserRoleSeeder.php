<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;


class UserRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //user_roles
        DB::table('user_roles')->insert(
            [
                [
                    'user_id' => 1,
                    'role_id' => 1,
                ],
                [
                    'user_id' => 2,
                    'role_id' => 2,
                ],
                [
                    'user_id' => 3,
                    'role_id' => 3,
                ],
            ],
        );
    }
}
