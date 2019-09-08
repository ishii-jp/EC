<?php

use Illuminate\Database\Seeder;

class AdminsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('admins')->insert([
            'name' => 'administrator',
            'email' => 'admin@admin.ne.jp',
            'password' => bcrypt('password'),
        ]);
    }
}
