@extends('layouts.app')
@section('content')
<div class="container">
    <div class="alert alert-info" role="alert">
        これは学習用のサイトです。 本物のECサイトではありません。<br> This is a study site. No EC site.
    </div>

    <p>トップ画面</p>
    <p><a href="{{ route('show') }}"><button class="btn btn-primary btn-sm" type="button">商品一覧</button></a></p>
</div>
@endsection