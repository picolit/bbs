<?php

namespace App\Console\Commands;

use App\Orm\Analysis;
use App\Service\SlackBot;
use Illuminate\Console\Command;

class BbsReports extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'slack:report_send';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * @var SlackBot
     */
    protected $slackBot;

    /**
     * @var Analysis
     */
    protected $analysis;

    /**
     * Create a new command instance.
     *
     * @param SlackBot $slackBot
     * @param Analysis $analysis
     */
    public function __construct(SlackBot $slackBot, Analysis $analysis)
    {
        parent::__construct();

        $this->slackBot = $slackBot;
        $this->analysis = $analysis;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $text = 'report date: ';
        $analysis = $this->analysis->where('date', date('Ymd', strtotime('-1 day')))->first();

        if ($analysis) {
            $text .= date('Y/m/d', strtotime($analysis->created_at));
            $text .= PHP_EOL;
            $text .= "page_view: {$analysis->page_view}";
            $text .= PHP_EOL;
            $text .= "new_post: {$analysis->new_post}";
        } else {
            $text .= $text = date('Y/m/d', strtotime('-1 day'));
            $text .= PHP_EOL;
            $text .= "page_view: 0";
            $text .= PHP_EOL;
            $text .= "new_post: 0";
        }

        $this->slackBot->post($text);
    }
}
