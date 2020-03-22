@extends('layouts.app')
@section('content')
<div class="container">
    <form action="{{ route('myPageAdd') }}" method="post">
        @csrf
        <table class="table table-striped">
            <tr>
                <th>氏名</th>
                <td><input type="text" name="userInfo[name]" value="{{ old('userInfo.name', $userInfo->name) }}"></td>
            </tr>
            <tr>
                <th>郵便番号</th>
                <td><input type="text" name="userInfo[zip]" value="{{ old('userInfo.zip', $userInfo->zip) }}"></td>
            </tr>
            <tr>
                <th>住所</th>
                <td><input type="text" name="userInfo[address]" value="{{ old('userInfo.address', $userInfo->address) }}"></td>
            </tr>
            <tr>
                <th>電話番号</th>
                <td><input type="text" name="userInfo[tel]" value="{{ old('userInfo.tel', $userInfo->tel) }}"></td>
            </tr>
        </table>
        <input type="hidden" name="userInfo[user_id]" value="{{ $user_id }}">
        <button class="btn btn-primary btn-sm" type="submit">登録</button>
    </form>
    <a href="{{ route('myPage') }}"><button class="btn btn-primary btn-sm">マイページへ戻る</button></a>
</div>
@endsection