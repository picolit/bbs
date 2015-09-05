<?php

use Illuminate\Database\Seeder;
use \App\Orm\Article;
use \Carbon\Carbon;

class InterestTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('interests')->delete();

        $interests = [
            ['女装', 'joso'],
            ['マゾ', 'mazo'],
            ['サド', 'sado'],
            ['露出', 'rosyutsu'],
            ['熟女', 'jukujo'],
            ['アナル', 'anal'],
            ['SM', 'sm'],
            ['コスプレ', 'kosupure'],
            ['痴女', 'chijo'],
            ['レズ', 'rezu'],
            ['ゲイ', 'gei'],
            ['オナニー', 'onani'],
            ['緊縛', 'kinbaku'],
            ['フェチ', 'fechi'],
            ['痴漢', 'chikan'],
        ];

        foreach ($interests as $key => $row)
            \App\Orm\Interest::create(array(
                'id' => $key + 1,
                'name' => $row[0],
                'name_tag' => $row[1],
                'created_at' => Carbon::today(),
                'updated_at' => Carbon::today(),
            ));
    }
}
