<?php

namespace App\Jobs;

use App\Orm\Article;
use Illuminate\Contracts\Mail\Mailer;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;

/**
 * Class ReplySendEmail
 * @package App\Jobs
 */
class ReplySendEmail extends Job implements SelfHandling, ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    /** @var Article */
    protected $parentArticle;
    /** @var Article */
    protected $article;


    /**
     * Create a new job instance.
     * @param Article $parentArticle
     * @param Article $article
     */
    public function __construct(Article $parentArticle, Article $article)
    {
        $this->parentArticle = $parentArticle;
        $this->article = $article;
    }

    /**
     * Execute the job.
     * @param Mailer $mailer
     * @return void
     */
    public function handle(Mailer $mailer)
    {
        $parentArticle = $this->parentArticle;
        $article = $this->article;

        Log::info('replay mail send start. id:' . $article->{'id'});

        // 実行試行回数のチェック
        if ($this->attempts() < 3) {
            // 再実行可能にするまで待機する秒数を指定
            $this->release(10);
            $mailer->send(
                'mail.reply_mail',
                ['article' => $article, 'toName' => $parentArticle->{'name'}],
                function ($message) use ($article, $parentArticle) {
                    $message->to($parentArticle->{'mail'}, $parentArticle->{'name'})->subject($article->{'name'} . 'さんから返信が届きました');
                }
            );

            Log::info('replay mail send complete. id:' . $article->{'id'});
        }
    }
}
