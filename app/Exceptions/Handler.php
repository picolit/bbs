<?php

namespace App\Exceptions;

use Exception;
use App\Service\SlackBot;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

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
        if (!$e instanceof NotFoundHttpException) {
            $slack = new SlackBot();
#            $slack->post($e->getMessage() . PHP_EOL . print_r($e->getTrace()[0], true));
            $slack->post($e->getMessage());
        }

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
        if (config('app.debug')) {
            $whoos = new \Whoops\Run;
            $whoos->pushHandler(new \Whoops\Handler\PrettyPageHandler());

            return new \Illuminate\Http\Response(
                $whoos->handleException($e),
                $e->getStatusCode(),
                $e->getHeaders()
            );
        } else if ($e->getCode() == Response::HTTP_INTERNAL_SERVER_ERROR) {
            return response()->view('errors.500', []);
        } else if ($e->getCode() == Response::HTTP_NOT_FOUND) {
            return response()->view('errors.404', []);
        }
        return parent::render($request, $e);
    }
}
