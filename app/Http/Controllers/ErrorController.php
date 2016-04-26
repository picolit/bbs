<?php

namespace App\Http\Controllers;

use App\Http\Requests\Errors\ErrorPostRequest;
use App\Service\SlackBot;

/**
 * Class ErrorController
 * @Controller(prefix="/")
 * @package Http\Controllers
 */
class ErrorController extends Controller
{
    /** @var SlackBot */
    private $slackBot;

    /**
     * ErrorController constructor.
     * @param SlackBot $slackBot
     */
    public function __construct(SlackBot $slackBot)
    {
        $this->slackBot = $slackBot;
    }

    /**
     * エラーをSlackへ送信する
     * @Post("/error", as="error.postError")
     * @param ErrorPostRequest $request
     * @return \Illuminate\Http\Response
     */
    public function postError(ErrorPostRequest $request)
    {
        $text = sprintf('msg: %s, url: %s, col: %s', $request->msg, $request->url, $request->col);
        $this->slackBot->post($text);

        return response('');
    }
}