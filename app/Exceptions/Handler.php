<?php

namespace App\Exceptions;

use App\Jobs\ExceptionEmail;
use Exception;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

class Handler extends ExceptionHandler
{
    /**
     * レポートしない例外タイプのリスト
     *
     * @var array
     */
    protected $dontReport = [
        HttpException::class,
    ];

    /**
     * 例外をレポート、もしくはログ
     *
     * ここはSentryやBugsnagなどに例外を送るために良い場所
     *
     * @param  \Exception  $e
     * @return void
     */
    public function report(Exception $e)
    {
//        new ExceptionEmail($e);

        return parent::report($e);
    }

    /**
     * HTTPレスポンスに対応する例外をレンダー
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $e
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $e)
    {
        if (config('app.debug'))
        {
            $whoos = new \Whoops\Run;
            $whoos->pushHandler(new \Whoops\Handler\PrettyPageHandler());

            return new \Illuminate\Http\Response(
                $whoos->handleException($e),
                $e->getStatusCode(),
                $e->getHeaders()
            );
        }
        return parent::render($request, $e);
    }
}
