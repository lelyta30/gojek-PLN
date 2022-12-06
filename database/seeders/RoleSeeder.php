<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
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
                'dept_code' => 3200,
                'role'      => 'USER'
            ],
        ]);
    }
}
