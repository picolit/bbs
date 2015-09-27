<?php namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Laravel\Socialite\Facades\Socialite;

/**
 * Class LoginController
 * @Controller(prefix="/social/login")
 * @package App\Http\Controllers
 */
class SocialLoginController extends Controller
{
    /**
     * ログインページ
     * @Get("/", as="social.login.getIndex")
     * @return \Illuminate\Http\Response
     */
    public function getIndex()
    {
        if (!Auth::check()) {
            return view('login.login');
        }

        return response()->redirectToRoute('articles.getIndex');
    }

    /**
     * ソーシャルログイン処理
     * @Get("/{provider}/authorize", as="social.login.getAuthorize")
     * @param string $provider
     * @return \Illuminate\Http\Response
     */
    public function getAuthorize($provider)
    {
        return Socialite::with($provider)->redirect();
    }

    /**
     * Store a newly created resource in storage.
     * @Get("/{provider}/callback", as="social.login.getLogin")
     * @param string $provider
     * @return \Illuminate\Http\Response
     */
    public function getLogin($provider)
    {
        $userData = Socialite::with($provider)->user();

        Log::debug(print_r($userData, true));

        $user = User::firstOrCreate([
            'username' => $userData->nickname,
            'email' => $userData->email,
//            'avatar' => $userData->avatar,
        ]);

        Auth::login($user);

        return response()->redirectToRoute('articles.getIndex');
    }
}
