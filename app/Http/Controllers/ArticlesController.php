<?php

namespace App\Http\Controllers;

use App\Orm\Article;
use App\Http\Requests\ArticlesPostCreateRequest;
use App\Http\Requests\ArticlesNicePost;
use App\Orm\Interest;
use App\Orm\Nice;
use App\Orm\Photo;
use App\Service\ArticleService;
use App\Http\Requests\ArticleNicePost;
use App\Service\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;

/**
 * Class ArticleController
 * @Controller(prefix="/")
 * @package App\Http\Controllers
 */
class ArticlesController extends Controller
{
    /** @var  Article */
    protected $article;
    /** @var  ArticleService */
    protected $articleService;
    /** @var UserService */
    protected $userService;
    /** @var  Photo */
    protected $photo;
    /** @var  Nice */
    protected $nice;

    protected $interest;

    /**
     * Constructor
     * @param Article $article
     * @param ArticleService $articleService
     * @param UserService $userService
     * @param Nice $nice
     * @param Interest $interest
     */
    public function __construct(Article $article, ArticleService $articleService, UserService $userService, Nice $nice, Interest $interest)
    {
        $this->article = $article;
        $this->articleService = $articleService;
        $this->userService = $userService;
        $this->nice = $nice;
        $this->interest = $interest;
    }

    /**
     * トップページ
     *
     * @Get("/", as="articles.getIndex")
     * @Middleware("analysis")
     * @param Request $request
     * @return Response
     */
    public function getIndex(Request $request)
    {
        $param = $this->getCommonDatas();
        $param['conditions'] = $request->all();
        $param['userId'] = $this->userService->getUserId($request);
        $param['articles'] = $this->articleService->get($param['conditions']);

        return view('article.index', $param
//            compact('articles', 'userId', 'thumbnail_img_path', 'original_img_path', 'interestsList', 'sexList', 'ageList', 'areaList',
//                'prefecturesList', 'conditions', 'affiliatesList'
//            )
        );
    }

    /**
     * Store a newly created resource in storage.
     * @Post("/", as="articles.postArticle")
     * @param ArticlesPostCreateRequest $request
     * @return Response
     */
    public function postArticle(ArticlesPostCreateRequest $request)
    {
        $uploadFileCount = 2;

        $data = $request->all();
        $data += [
            'client_ip' => $request->getClientIp(),
        ];

        for ($i = 1; $i <= $uploadFileCount; $i++) {
            if ($request->hasFile('file'.$i)) {
                $data['file'.$i] = $request->file('file'.$i);
            }
        }
        $this->articleService->create($data);

        return response()->redirectToRoute('articles.getIndex');
    }

    /**
     * ヘルプ
     * @Get("/help", as="articles.getHelp")
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function getHelp()
    {
        $param = $this->getCommonDatas();
        return view('article.help', $param);
    }

    /**
     * エロいいねの作成
     * @Post("/ajax/nice/create", as="articles.postNice")
     * @param ArticlesNicePost $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function ajaxPostCreateNice(ArticlesNicePost $request)
    {
        $article_id = $request->input('id');
        $user_id = $request->input('user_id');

        $nice = $this->nice->where('article_id', $article_id)->where('user_id', $user_id)->first();

        if (is_null($nice)) {
            $this->nice->create(['article_id' => $article_id, 'user_id' => $user_id]);
        }

        return response('');
    }

    /**
     * エロいいねの削除
     *
     * @Post("/ajax/nice/delete", as="articles.deleteNice")
     * @param ArticleNicePost $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function ajaxPostDeleteNice(ArticleNicePost $request)
    {
        $article_id = $request->input('id');
        $user_id = $request->input('user_id');

        $nice = $this->nice->where('article_id', $article_id)->where('user_id', $user_id)->first();

        if ($nice) {
            $this->nice->delete();
        }

        return response();
    }

    private function getCommonDatas()
    {
        $result = [];
        $result['interestsList'] = $this->interest->get();
        $result['sexList'] = Config::get('const.sex');
        $result['ageList'] = Config::get('const.age');
        $result['areaList'] = Config::get('const.area');
        $result['prefecturesList'] = Config::get('const.prefectures');
        $result['thumbnail_img_path'] = Config::get('const.thumbnail_img_path');
        $result['original_img_path'] = Config::get('const.original_img_path');
        $result['affiliatesList'] = (Config::get('const.affiliate'));
        shuffle($result['affiliatesList']);

        return $result;
    }
}
