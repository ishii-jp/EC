<?php

use Illuminate\Database\Seeder;

class MakersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // DB::table('makers')->delete();
        for ($i =1; $i < 5; $i++){
            DB::table('makers')->insert([
                'maker_name' => 'メーカー名'. $i,
                'created_at' => date('Y-m-d h:i:s'),
                'updated_at' => date('Y-m-d h:i:s')
            ]);
        }
    }
}
