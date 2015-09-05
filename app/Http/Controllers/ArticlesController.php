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
        $conditions = $request->all();
        $interests = $this->interest->get();
        $sex = Config::get('const.sex');
        $age = Config::get('const.age');
        $prefectures = Config::get('const.prefectures');
        $thumbnail_img_path = Config::get('const.thumbnail_img_path');
        $original_img_path = Config::get('const.original_img_path');
        $affiliates = (Config::get('const.affiliate'));
        shuffle($affiliates);
        $userId = $this->userService->getUserId($request);

        // @todo resの降順にする
        // @todo res_id, update_at でindex
        //$article = $this->article->where('res_id', 0)->orderBy('updated_at', 'desc')->paginate(self::PAGENATE_PER_PAGE);
        $articles = $this->articleService->get($conditions);

        return view('article.index',
            compact('articles', 'userId', 'thumbnail_img_path', 'original_img_path', 'interests', 'sex', 'age', 'prefectures', 'conditions', 'affiliates'));
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
}
