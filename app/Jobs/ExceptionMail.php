<?php

namespace App\Jobs;

use Illuminate\Contracts\Mail\Mailer;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;

/**
 * ExceptionEmail
 * @package App\Jobs
 */
class ExceptionEmail extends Job implements SelfHandling, ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    /** @var \Exception */
    protected $e;


    /**
     * Create a new job instance.
     * @param \Exception $e
     */
    public function __construct(\Exception $e)
    {
        $this->e = $e;
    }

    /**
     * Execute the job.
     * @param Mailer $mailer
     * @return void
     */
    public function handle(Mailer $mailer)
    {
        Log::info('Exception mail start.');

        // 実行試行回数のチェック
        if ($this->attempts() < 3) {
            // 再実行可能にするまで待機する秒数を指定
            $this->release(10);
            $mailer->send(
                'mail.exception_mail',
                ['exception' => $this->e],
                function ($message) {
                    $message->to(env('MAIL_FROM_ADDRESS'), printf('Exception(%s)', date('Y/m/d:H:I:s')));
                }
            );
        }

        Log::info('Exception mail send.');
    }
}
