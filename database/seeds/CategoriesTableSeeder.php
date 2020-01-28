<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;    //追加：DBクラスを使うための設定
use Carbon\Carbon;   //追加：Carbonクラスを使うための設定

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    //カテゴリーテーブルへののinsert処理
    DB::table('categories')->insert([
        'name' => 'MINNANO NIHONGO',
        'created_at' => Carbon::now(),
        'updated_at' => Carbon::now(),
    ]);

    DB::table('categories')->insert([
        'name' => 'GENKI',
        'created_at' => Carbon::now(),
        'updated_at' => Carbon::now(),
    ]);
    }
}
