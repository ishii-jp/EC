@extends('layouts.app')
@section('content')
<div class="container">
    @if (session('msg')) {{ session('msg') }} @endif
    <table>
        <tr>
            <td><a href="{{ route('myPage.edit') }}"><button class="btn btn-primary btn-sm">ユーザー情報編集</button></a></td>
            <td><a href="{{ route('purchaseHistory') }}"><button class="btn btn-primary btn-sm">購入履歴</button></a></td>
        </tr>
    <table>
    <table class="table table-striped">
        <tr>
            <th>氏名</th>
            <td>{{ isset($user->userInfo->name) ? $user->userInfo->name : 'まだ名前が登録されていません' }}</td>
        </tr>
        <tr>
            <th>郵便番号</th>
            <td>{{ isset($user->userInfo->zip) ? $user->userInfo->zip : '郵便番号が登録されていません' }}</td>
        </tr>
        <tr>
            <th>住所</th>
            <td>{{ isset($user->userInfo->address) ? $user->userInfo->address : '住所が登録されていません' }}</td>
        </tr>
        <tr>
        <th>電話番号</th>
            <td>{{ isset($user->userInfo->tel) ? $user->userInfo->tel : '電話番号が登録されていません' }}</td>
        </tr>
        <th>ポイント</th>
            <td>{{ isset($user->point->point) ? "{$user->point->point}P" : '獲得したポイントはありません' }}</td>
        </tr>
    </table>
</div>
@endsection