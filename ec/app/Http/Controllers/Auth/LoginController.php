<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Socialite;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * facebookの認証ページヘユーザーをリダイレクト
     *
     * @return \Illuminate\Http\Response
     */
    public function redirectToProvider()
    {
        return Socialite::driver('facebook')->redirect();
    }

    /**
     * facebookからユーザー情報を取得
     *
     * @return \Illuminate\Http\Response
     */
    public function handleProviderCallback()
    {
        // $facebookUser = Socialite::driver('facebook')->user();

        $facebookUser = Socialite::driver('facebook')->stateless()->user();
        // email が合致するユーザーを取得
        $user = User::where('email', $facebookUser->email)->first();
        // 見つからなければ新しくユーザーを作成
        if ($user == null) {
            $user = $this->createUserByfacebook($facebookUser);
        }
        // ログイン処理
        Auth::login($user);
        return redirect()->route('home');
        // $user->token;
    }

    public function createUserByfacebook($facebookUser)
    {
        $user = User::create([
            'name'     => $facebookUser->name,
            'email'    => $facebookUser->email,
            'password' => \Hash::make(uniqid()),
        ]);
        return $user;
    }
}
