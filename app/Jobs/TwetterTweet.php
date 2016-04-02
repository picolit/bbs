<?php

namespace App\Jobs;

use App\Orm\Article;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Support\Facades\Log;
use Thujohn\Twitter\Facades\Twitter;

class TwetterTweet extends Job implements SelfHandling
{
    const MAX_LENGTH = 140;

    /** @var Article */
    protected $article;

    /**
     * Create a new job instance.
     * @param Article $article
     */
    public function __construct(Article $article)
    {
        $this->article = $article;
    }

    /**
     * Execute the job.
     * @return void
     */
    public function handle()
    {
        if (env('APP_ENV') !== 'production') {
            Log::info(sprintf('this env is %s. tweet not publish.', env('APP_ENV')));
            return;
        }

        if (starts_with($this->article->name, 'test')) {
            Log::info('this article is test. tweet not publish.');
            return;
        }

        $body = "{$this->article->name} \n {$this->article->title} \n {$this->article->body}";
        if ((self::MAX_LENGTH - 30) < (mb_strlen($body))) {
            $body = mb_substr($body, 0, self::MAX_LENGTH - 30) . '…';
        }

        $body .= "\n" . env('SITE_URL');

        Log::info("tweet publish id:{$this->article->id}");

        try {
            Twitter::postTweet(['status' => $body, 'format' => 'json']);
            Log::info("tweet complete. id:{$this->article->id}");
        } catch(\Exception $e) {
            Log::error("tweet error. id:{$this->article->id}, message:{$e->getMessage()}, body_count:".mb_strlen($body));
        }
    }
}
