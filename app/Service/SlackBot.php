<?php

namespace App\Service;

use Illuminate\Support\Facades\Log;

class SlackBot
{
    /** @var string */
    private $apiKey;
    /** @var string */
    private $channel;

    /**
     * SlackBot constructor.
     */
    public function __construct()
    {
        $this->apiKey = env('slack_api_key');

        if (env('APP_ENV') === 'production') {
            $this->channel = 'bbs';
        } else {
            $this->channel = 'random';
        }
    }

    /**
     * @param $text
     */
    public function post($text)
    {
        $text = urlencode($text);
        $url = "https://slack.com/api/chat.postMessage?token={$this->apiKey}&channel=%23{$this->channel}&text={$text}";
        $result = file_get_contents($url);

        $resultObject = json_decode($result);

        if ($resultObject->ok === false) {
            Log::error($url);
            Log::error($result);
        }
    }
}