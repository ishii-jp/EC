@extends('layouts.app')
@section('content')
<div class="container">
@if (session('msg')) {{ session('msg') }} @endif
<p><a href="{{ route('myPageAdd') }}"><button class="btn btn-primary btn-sm">ユーザー情報編集</button></a>
<table class="table table-striped">
        <tr>
            <th>氏名</th>
            <td>{{ $userInfo->name }}</td>
        </tr>
        <tr>
            <th>郵便番号</th>
            <td>{{ $userInfo->zip }}</td>
        </tr>
        <tr>
            <th>住所</th>
            <td>{{ $userInfo->address }}</td>
        </tr>
        <tr>
            <th>電話番号</th>
            <td>{{ $userInfo->tel }}</td>
        </tr>
    </table>
</div>
@endsection