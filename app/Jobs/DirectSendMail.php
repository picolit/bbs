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
 * Class DirectSendMail
 * @package App\Jobs
 */
class DirectSendMail extends Job implements SelfHandling, ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    /** @var array */
    protected $data;
    /** @var Article */
    protected $article;

    /**
     * Constructor
     * @param Article $article
     * @param array $data
     */
    public function __construct(Article $article, array $data)
    {
        $this->article = $article;
        $this->data = $data;
    }

    /**
     * Execute the job.
     * @param Mailer $mailer
     * @return void
     */
    public function handle(Mailer $mailer)
    {
        $data = $this->data;

        Log::info('direct mail send start.');

        // 実行試行回数のチェック
        if ($this->attempts() < 3) {
            // 再実行可能にするまで待機する秒数を指定
            $this->release(10);
            $title = $data['name'] . 'さんからメールが届きました';
            $replay = $data['mail'];

            $mailer->send(
                'mail.direct_send_mail',
                ['data' => $data],
                function ($message) use ($title, $replay) {

                    $message
                        ->to($this->article->mail)
                        ->subject($title)
                        ->bcc(env('MAIL_FROM_ADDRESS'))
                        ->replyTo($replay);
                }
            );

            Log::debug(sprintf('to:%s, title: %s, replyTo: %s, body: %s', $this->article->mail, $title, $replay, $data['body']));
            Log::info('direct mail send complete.');
        }
    }
}
