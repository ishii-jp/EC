<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\UserInfo;

class MyPageController extends Controller
{
    public $userInfo;
    public function __construct(UserInfo $userInfo)
    {
        $this->userInfo = $userInfo;
    }

    public function index()
    {
        $ret['userInfo'] = $this->userInfo->getUserInfo(Auth::user()->id);
        return view('ec.mypages.index', $ret);
    }

    public function edit(Request $request)
    {
        if ($request->isMethod('post')){
            $formValue = $request->except('_token');

            $this->userInfo->editUserInfo($formValue['userInfo']);

            return redirect()->route('myPage')->with('msg', 'ユーザー情報を更新しました');
        } else {
            $ret['userInfo'] = $this->userInfo->getUserInfo(Auth::user()->id);
            return view('ec.mypages.add', $ret);
        }
    }
}
