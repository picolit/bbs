<?php

namespace App\Providers;

use App\Orm\Interest;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * アプリケーションサービスの初期化処理
     *
     * @return void
     */
    public function boot()
    {
        $result = [];
        $result['interestsList'] = Interest::all();
        $result['keyword'] = $result['interestsList']->pluck('name')->toArray();
        $result['sexList'] = Config::get('const.sex');
        $result['ageList'] = Config::get('const.age');
        $result['areaList'] = Config::get('const.area');
        $result['prefecturesList'] = Config::get('const.prefectures');
        $result['thumbnail_img_path'] = Config::get('const.thumbnail_img_path');
        $result['original_img_path'] = Config::get('const.original_img_path');
        $result['affiliatesList'] = Config::get('const.affiliate');
        $result['links'] = Config::get('const.links');
        shuffle($result['affiliatesList']);

        foreach ($result as $key => $value) {
            view()->share($key, $value);
        }
    }

    /**
     * アプリケーションサービスの登録
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
