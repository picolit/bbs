<?php namespace App\Http\Controllers\Sp;

use App\Http\Controllers\Controller;
use App\Http\Requests\InquiryPostRequest;
use App\Orm\Article;
use App\Http\Requests\ArticlesPostCreateRequest;
use App\Orm\Interest;
use App\Orm\Nice;
use App\Orm\Photo;
use App\Service\ArticleService;
use App\Http\Requests\ArticleNicePost;
use App\Service\UserService;
use Illuminate\Http\Request;

/**
 * Class SpArticlesController
 * @Controller(prefix="/sp")
 * @package App\Http\Controllers\Sp
 */
class SpArticlesController extends Controller
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
     * @Get("/", as="sp.articles.getIndex")
     * @Middleware("analysis")
     * @param Request $request
     * @return string
     */
    public function getIndex(Request $request)
    {
        return view('sp/article/index');
    }

    /**
     * トップページ
     * @Get("/articles", as="sp.articles.getArticle")
     * @Middleware("analysis")
     * @param Request $request
     * @return string
     */
    public function getArticle(Request $request)
    {
        $param['conditions'] = $request->all();
        $param['userId'] = $this->userService->getUserId($request);
        $param['articles'] = $this->articleService->get($param['conditions'])->get();

        return response()->json($param['articles']);
    }

    /**
     * 記事登録
     * @Post("/", as="sp.articles.postArticle")
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
     * @Get("/delete/{id}/{password}", as="sp.articles.getDelete", where={"id": "[0-9]+"})
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
     * @Get("/help", as="sp.articles.getHelp")
     * @return \Illuminate\Http\Response
     */
    public function getHelp()
    {
        return view('article.help');
    }

    /**
     * 問い合わせ
     * @Get("/inquiry", as="sp.articles.getInquiry")
     * @return \Illuminate\Http\Response
     */
    public function getInquiry()
    {
        return view('article.inquiry');
    }

    /**
     * 問い合わせ登録
     * @Post("/inquiry", as="sp.articles.postInquiry")
     * @param InquiryPostRequest $request
     * @return \Illuminate\Http\Response
     */
    public function postInquiry(InquiryPostRequest $request)
    {
        $data = $request->all();
        $this->articleService->inquirySendMail($data);

        return view('article.inquiry', ['flg' => true]);
    }
}
