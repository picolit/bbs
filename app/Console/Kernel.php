<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * アプリケーションで提供するArtisanコマンド
     *
     * @var array
     */
    protected $commands = [
        \App\Console\Commands\Inspire::class,
        \App\Console\Commands\BbsReports::class,
    ];

    /**
     * アプリケーションのコマンド実行スケジュール定義
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('slack:report_send')
            ->withoutOverlapping()
            ->dailyAt('8:00')
            ->appendOutputTo('/var/www/pw.peach-x/storage/logs/laravel.log');

    }
}
