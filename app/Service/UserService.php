<?php
/**
 * Created by PhpStorm.
 * User: picolit
 * Date: 2015/08/08
 * Time: 11:50
 */

namespace App\Service;

use Illuminate\Http\Request;
use App\User;

/**
 * Class UserService
 * @package App\Service
 */
class UserService
{
    /** @var User */
    protected $user;

    /**
     * Constractor
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * ユーザIDを取得
     * @param Request $request
     * @return mixed
     */
    public function getUserId(Request $request)
    {
        $userId = $request->session()->get('user_id');
        if ($userId) {
            return $userId;
        }

        $user= $this->user->create([
            'name' => 'unknown',
            'email' => sha1(microtime()),
            'password' => 'password',
        ]);

        $request->session()->set('user_id', $user->id);

        return $user->id;
    }
}