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
 * Class InquirySendEmail
 * @package App\Jobs
 */
class InquirySendEmail extends Job implements SelfHandling, ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    /** @var array */
    protected $data;

    /**
     * Constructor
     * @param array $data
     */
    public function __construct(array $data)
    {
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

        // 実行試行回数のチェック
        if ($this->attempts() < 3) {
            // 再実行可能にするまで待機する秒数を指定
            $this->release(10);
            $mailer->send(
                'mail.inquiry_mail',
                ['data' => $data],
                function ($message) use ($data) {
                    $message->to(env('MAIL_FROM_ADDRESS'), '')->subject($data['name'] . 'さんから問い合わせが届きました');
                }
            );

            Log::info('inquiry mail send complete.');
        }
    }
}
