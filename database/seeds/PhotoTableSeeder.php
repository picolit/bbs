<?php

use Illuminate\Database\Seeder;
use App\Orm\Photo;
use \Carbon\Carbon;

class PhotoTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('photos')->delete();

        $id = 1;
        for ($i = 1; $i <= 2; $i++) {
            for ($r = 1; $r <= 2; $r++) {
                Photo::create(array(
                    'id' => $id,
                    'article_id' => $i,
                    'file_name' => '5b4a83611ac2a8aa4b480d1fd319e78da0b5ebf4.jpeg',
                    'file_date_time' => '2012:12:12 11:22:33',
                    'mime_type' => 'ddddd',
                    'width' => '1024',
                    'height' => '769',
                    'make' => 'aaa',
                    'model' => 'hhhhh',
                    'orientation' => 0,
                    'lat' => Carbon::today(),
                    'lng' => Carbon::today(),
                    'updated_at' => Carbon::today(),
                    'deleted_at' => null,
                ));

                $id++;
            }

        }
    }
}
