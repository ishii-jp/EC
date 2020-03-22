<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\UserInfo;

class MyPageController extends Controller
{
    public $userInfo;
    private $user;

    public function __construct(UserInfo $userInfo, \App\User $user)
    {
        $this->userInfo = $userInfo;
        $this->user = $user;
    }

    public function index()
    {
        $ret['user'] = $this->user->getUser(Auth::id(), ['userInfo', 'point']);
        return view('ec.mypages.index', $ret);
    }

    public function edit(Request $request)
    {
        if ($request->isMethod('post')){
            $formValue = $request->except('_token');

            $this->userInfo->editUserInfo($formValue['userInfo']);

            return redirect()->route('myPage')->with('msg', 'ユーザー情報を更新しました');
        } else {
            $ret['user_id'] = Auth::id();
            $ret['userInfo'] = $this->userInfo->getUserInfo($ret['user_id']);
            return view('ec.mypages.add', $ret);
        }
    }
}
