<?php
/**
 * Created by PhpStorm.
 * User: picolit
 * Date: 2015/08/08
 * Time: 13:25
 */

namespace App\Service;


use App\Orm\Nice;

class NiceService
{
    /** @var Nice */
    protected $nice;

    /**
     * @param Nice $nice
     */
    public function __construct(Nice $nice)
    {
        $this->nice = $nice;
    }

    /**
     *
     * @param $userId
     * @param $articleId
     * @return bool
     */
    public function isNice($userId, $articleId)
    {
        return $this->nice->where('user_id', $userId)->where('article_id', $articleId)->first() ? true : false;
    }
}