<?php

use Illuminate\Database\Seeder;
use \App\Orm\Article;
use \Carbon\Carbon;

class ArticleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('articles')->delete();
        $id = 1;
        for ($i = 1; $i <= 1; $i++) {
            Article::create(array(
                'id' => $id,
                'res_id' => 0,
                'name' => '美羽miu'.$id,
                'age' => rand(1,7),
                'sex' => rand(1,2),
                'title' => '調教していただけるご主人様を探しています。:'.$i,
                'body' => '首輪や口枷をされ拘束されて身動きがとれない状態で、いやらしい姿を晒しながら、身体中隅々までねっとり執拗に責められ、辱められたいです。女の子みたいに扱われて身体も心も征服されたいです。少し胸がある真性包茎です。挿入には興味ないので、理解ある方お願いします。変態さんやおじさんも大歓迎です。',
                'password' => 'password',
                'ip_address' => '192.169.123.123',
                'created_at' => Carbon::today(),
                'updated_at' => Carbon::today(),
                'deleted_at' => null,
            ));

            $id++;

            Article::create(array(
                'id' => $id,
                'res_id' => $i,
                'name' => 'マッキー'.$id,
                'age' => rand(1,7),
                'sex' => rand(1,2),
                'title' => 'Re 調教していただけるご主人様を探しています。:'.$i,
                'body' => 'Re首輪や口枷をされ拘束されて身動きがとれない状態で、いやらしい姿を晒しながら、身体中隅々までねっとり執拗に責められ、辱められたいです。女の子みたいに扱われて身体も心も征服されたいです。少し胸がある真性包茎です。挿入には興味ないので、理解ある方お願いします。変態さんやおじさんも大歓迎です。',
                'password' => 'password',
                'ip_address' => '192.169.123.123',
                'created_at' => Carbon::today(),
                'updated_at' => Carbon::today(),
                'deleted_at' => null,
            ));
        }
    }
}
