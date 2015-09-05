<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{
    /**
     * データベース初期値設定実行
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        // $this->call(UserTableSeeder::class);
        $this->call('ArticleTableSeeder');
        $this->call('PhotoTableSeeder');
        $this->call('InterestTableSeeder');
        $this->call('InterestTableSeeder');

        Model::reguard();
    }
}
