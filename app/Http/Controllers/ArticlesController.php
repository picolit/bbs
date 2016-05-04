<?php

namespace App\Http\Controllers;

use App\Http\Requests\DirectMailPost;
use App\Http\Requests\InquiryPostRequest;
use App\Orm\Article;
use App\Http\Requests\ArticlesPostCreateRequest;
use App\Http\Requests\ArticlesNicePost;
use App\Orm\Interest;
use App\Orm\Nice;
use App\Orm\Photo;
use App\Service\ArticleService;
use App\Service\UserService;
use Illuminate\Http\Request;

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
     * @Get("/", as="articles.getIndex")
     * @Middleware("analysis")
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function getIndex(Request $request)
    {
        $param['conditions'] = $request->all();
        $param['userId'] = $this->userService->getUserId($request);
        $param['articles'] = $this->articleService->get($param['conditions']);

        //同じphpを起動している他のプロセスを探し
        exec("ps aux|grep [a]rtisan", $output, $result);

        $isActiveQueueListen = true;

        if(count($output) === 0){
            $isActiveQueueListen = false;
        }

        $param['isActiveQueueListen'] = $isActiveQueueListen;

        return view('article.index', $param);
    }

    /**
     * 記事登録
     * @Post("/", as="articles.postArticle")
     * @param ArticlesPostCreateRequest $request
     * @return \Illuminate\Http\Response
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
     * 記事削除
     * @Get("/delete/{id}/{password}", as="articles.getDelete", where={"id": "[0-9]+"})
     * @param string $id
     * @param string $password
     * @return  \Illuminate\Http\Response
     */
    public function getDelete($id, $password)
    {
        $data = [
            'id' => $id,
            'password' => $password
        ];

        $this->articleService->delete($data);

        return response()->redirectToRoute('articles.getIndex');
    }

    /**
     * ヘルプ
     * @Get("/help", as="articles.getHelp")
     * @return \Illuminate\Http\Response
     */
    public function getHelp()
    {
        return view('article.help');
    }

    /**
     * 問い合わせ
     * @Get("/inquiry", as="articles.getInquiry")
     * @return \Illuminate\Http\Response
     */
    public function getInquiry()
    {
        return view('article.inquiry');
    }

    /**
     * 問い合わせ登録
     * @Post("/inquiry", as="articles.postInquiry")
     * @param InquiryPostRequest $request
     * @return \Illuminate\Http\Response
     */
    public function postInquiry(InquiryPostRequest $request)
    {
        $data = $request->all();
        $this->articleService->inquirySendMail($data);

        return view('article.inquiry', ['flg' => true]);
    }

    /**
     * メールで連絡ページ
     * @Get("/mail_send/{id}", as="articles.getMailSend", where={"id": "[0-9]+"})
     * @param string $id
     * @return \Illuminate\Http\Response
     */
    public function getMailSend($id)
    {
        $article = $this->article->find($id);

        if (empty($article)) {
            abort(404);
        }

        return view('article.mail_send', ['article' => $article]);
    }

    /**
     * メールで連絡ページ
     * @Post("/mail_send/{id}", as="articles.postMailSend", where={"id": "[0-9]+"})
     * @param DirectMailPost $directMailPost
     * @param string $id
     * @return \Illuminate\Http\Response
     */
    public function postMailSend(DirectMailPost $directMailPost, $id)
    {
        $article = $this->article->find($id);

        if (empty($article)) {
            abort(404);
        }

        $data = $directMailPost->all();
        $this->articleService->directMailSend($article, $data);

        return view('article.mail_send', ['article' => $article, 'flg' => true]);
    }

    /**
     * エロいいねの作成
     * @Post("/ajax/nice/create", as="articles.postNice")
     * @param ArticlesNicePost $request
     * @return string
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
     * @param ArticlesNicePost $request
     * @return string
     */
    public function ajaxPostDeleteNice(ArticlesNicePost $request)
    {
        $article_id = $request->input('id');
        $user_id = $request->input('user_id');

        $nice = $this->nice->where('article_id', $article_id)->where('user_id', $user_id)->first();

        if ($nice) {
            $this->nice->delete();
        }

        return response('');
    }
}
