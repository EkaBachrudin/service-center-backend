<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert(
            [
                [
                    'name' => "Eka Bachrudin",
                    'email' => 'superadmin@service.com',
                    'password' => Hash::make('password'),
                ],
                [
                    'name' => "Samsudin Bagdja",
                    'email' => 'admincounter@service.com',
                    'password' => Hash::make('password'),
                ],
                [
                    'name' => "Robot Meleleh",
                    'email' => 'usercounter@service.com',
                    'password' => Hash::make('password'),
                ]
            ]
        );
    }
}
