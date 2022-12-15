<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            [
                'name'      => 'User',
                'username'  => 'user',
                'password'  => Hash::make('user'),
                'role'      => 'USER',
                'no_hp'     => '628231732112',
                'foto_profil'   => '628231732112',
                'rating'     => '3',
            ],
            [
                'name'      => 'Tec',
                'username'  => 'tec',
                'password'  => Hash::make('tec'),
                'role'      => 'TECHNICIAN',
                'no_hp'     => '628231733312',
                'foto_profil'   => '628232342112',
                'rating'     => '3',
            ],
            [
                'name'      => 'Man',
                'username'  => 'man',
                'password'  => Hash::make('man'),
                'role'      => 'MANAGER',
                'no_hp'     => '6282317322112',
                'foto_profil'   => '6282317732112',
                'rating'     => '3',
            ],
            [
                'name'      => 'Driver',
                'username'  => 'driver',
                'password'  => Hash::make('driver'),
                'role'      => 'DRIVER',
                'no_hp'     => '6248231732112',
                'foto_profil'   => '6248231732112',
                'rating'     => '3',
            ],
        ]);
    }
}
