<?php

use Illuminate\Database\Seeder;

class GoodsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // DB::table('goods')->delete();
        $faker = Faker\Factory::create('ja_JP');
        for ($i = 21; $i <= 30; $i++){
            DB::table('goods')->insert([
                'name' => '商品'. $i,
                'kana' => 'しょうひん'. $i,
                'category_id' => 3,
                'maker_id' => 4,
                'price' => $faker->numberBetween(1000,10000),
                'stock' => $faker->randomNumber(2),
                'created_at' => '2019-09-18 21:07:31',
                'updated_at' => '2018-09-18 21:07:31'
            ]);
        }
    }
}
