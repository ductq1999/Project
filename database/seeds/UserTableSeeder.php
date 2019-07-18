<?php

use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
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
            'role' => 1,
            'password' => bcrypt('admin123'),
            'active_flg' => 1
        ]);

        DB::table('users')->insert([
            'name' => 'ductq',
            'email' => 'ductq@gmail.com',
            'role' => 2,
            'password' => bcrypt('123456'),
            'active_flg' => 1
        ]);
    }
}
