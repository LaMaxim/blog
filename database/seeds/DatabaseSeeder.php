<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('Qw123456'),
        ]);
        DB::table('roles')->insert([
            ['name' => 'user'], ['name' => 'admin',]
        ]);
        DB::table('role_user')->insert([
            'role_id' => '2',
            'user_id' => '1',
        ]);
    }
}
